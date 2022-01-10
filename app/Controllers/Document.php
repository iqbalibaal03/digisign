<?php

namespace App\Controllers;

use App\Libraries\Key;
use App\Models\Document as DocumentModel;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeNone;
use Endroid\QrCode\Writer\PngWriter;
use Exception;
use Myth\Auth\Authorization\GroupModel;
use Myth\Auth\Models\UserModel;
use ParagonIE\EasyRSA\EasyRSA;
use ParagonIE\EasyRSA\PublicKey;
use setasign\Fpdi\Fpdi;

class Document extends BaseController
{

    protected $documentModel;
    protected $userModel;
    protected $groupModel;


    public function __construct()
    {
        $this->documentModel = new DocumentModel();
        $this->userModel = new UserModel();
        $this->groupModel = new GroupModel();
    }

    public function index()
    {
        $sortBy = '';
        $sortFormat = '';

        if (session('sort_by')) {
            $sortBy = session('sort_by');
            $document = $this->documentModel->filter(user_id(), user_id(), $sortBy, $sortFormat);
        }

        if (session('sort_format')) {
            $sortFormat = session('sort_format');
            $document = $this->documentModel->filter(user_id(), user_id(), $sortBy, $sortFormat);
        }

        $currentPage = $this->request->getGet('page_documents') ?? 1;
        $document = $this->documentModel->where('from_id', user_id())->where('to_id', user_id());

        if ($this->request->getPost('keyword')) {
            $document = $this->documentModel->search(user_id(), user_id(), $this->request->getPost('keyword'));
        }

        if ($this->request->getPost('sort_by') && $this->request->getPost('sort_by') != "") {
            $sortBy = $this->request->getPost('sort_by');
            session()->set('sort_by', $sortBy);
            $document = $this->documentModel->filter(user_id(), user_id(), $sortBy, $sortFormat);
        }

        if ($this->request->getPost('sort_format')) {
            $sortFormat = $this->request->getPost('sort_format');
            session()->set('sort_format', $sortFormat);
            $document = $this->documentModel->filter(user_id(), user_id(), $sortBy, $sortFormat);
        }

        $data = [
            'title' => getenv('app.name') . ' | Dokumen Saya',
            // 'documents' => $this->documentModel->where('from_id', user_id())->where('to_id', user_id())->findAll()
            'documents' => $document->paginate(10, 'documents'),
            'pager' => $document->pager,
            'currentPage' => $currentPage
        ];

        return view('document/index', $data);
    }

    public function sentDocs()
    {
        $documents = new DocumentModel();
        $frommes = $documents->where([
            'from_id' => user_id(),
            'to_id !=' => user_id()
        ]);

        $tomes = $this->documentModel->where('from_id !=', user_id())->where('to_id', user_id());

        $data = [
            'title' => getenv('app.name') . ' | Disposisi Saya',
            'frommes' => $frommes->paginate(10, 'frommes'),
            'fromPager' => $frommes->pager,
            'tomes' => $this->documentModel->where('from_id !=', user_id())->where('to_id', user_id())->paginate(10, 'tomes'),
            'toPager' => $tomes->pager
        ];

        return view('document/sent_docs', $data);
    }

    public function reader()
    {
        $data = [
            'title' => getenv('app.name') . ' | Dokumen Reader'
        ];

        return view('document/reader', $data);
    }

    public function read()
    {
        $qrcodeinfo = $this->documentModel->where('qrcode_hash', $this->request->getPost('hash'))->first();

        $publicKey = new PublicKey(Key::PUBLIC);
        try {
            $ok = EasyRSA::verify($qrcodeinfo['rsa_encrypt'], base64_decode($qrcodeinfo['signature']), $publicKey);
        } catch (\Throwable $e) {
            throw new Exception($e);
        }

        if (!$ok) {
            return $this->response->setJSON([
                'error' => "Signature verification failed. Incorrect key or data has been tampered with\n",
                'data' => $qrcodeinfo['encrypted_data'],
            ]);
        }

        $signer = $this->userModel->where('id', $qrcodeinfo['to_id'])->first();
        $signerGroup = $this->groupModel->getGroupsForUser($qrcodeinfo['to_id']);

        return $this->response->setJSON([
            'id' => $qrcodeinfo['id'],
            'to_id' => $qrcodeinfo['to_id'],
            'from_id' => $qrcodeinfo['from_id'],
            'name' => $signer->name,
            'id_number' => $signer->id_number,
            'phone' => $signer->phone,
            'image' => $signer->image,
            'role' => $signerGroup[0]['name'],
            'email' => $signer->email,
            'document_title' => $qrcodeinfo['document_title'],
            'document_filename' => $qrcodeinfo['document_filename'],
            'qrcode_hash' => $qrcodeinfo['qrcode_hash'],
            'encrypted_data' => $qrcodeinfo['rsa_encrypt'],
            'signature' => $qrcodeinfo['signature'],
            'created_at' => $qrcodeinfo['created_at'],
            'updated_at' => $qrcodeinfo['updated_at']
        ]);
    }

    public function editor()
    {
        $data = $this->request->getGet();
        return view('document/editor', $data);
    }

    public function edited()
    {
        $jsPdf = $this->request->getFile('pdf');
        $data = $this->request->getPost();
        $jsPdf->move('uploads/documents/signed', $data['filename']);
        $chipperText = md5(user()->username);

        if (!openssl_sign($chipperText, $signature, Key::PRIVATE, OPENSSL_ALGO_SHA512)) {
            return $this->response->setJSON([
                'error' => openssl_error_string()
            ]);
        }

        hash('sha512', $data);

        // Create barcode
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($chipperText)
            ->margin(5)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(75)
            ->roundBlockSizeMode(new RoundBlockSizeModeNone())
            ->build();
        $result->saveToFile('uploads/qrcode/' . $chipperText . '.png');

        $fpdi = new Fpdi();
        $fpdi->setSourceFile('uploads/documents/signed/' . $data['filename']);


        for ($i = 1; $i < 100; $i++) {
            try {
                $tplIdx = $fpdi->importPage($i);
                $fpdi->addPage();
                $fpdi->useTemplate($tplIdx, 0, 0);
                $fpdi->SetFont('Arial');
                $fpdi->SetTextColor(255, 0, 0);
                if ($data['selectedPage'] == $i) {
                    $fpdi->Image('uploads/qrcode/' . $chipperText . '.png', 180, 270);
                }
            } catch (\InvalidArgumentException $exception) {
                break;
            }
        }

        $fpdi->Output("uploads/documents/qrcode/" . $data['filename'], 'F', true);

        if (!$this->documentModel->update($data['documentID'], [
            'signed' => 1,
            'qrcode_hash' => $chipperText,
            'signature' => base64_encode($signature)
        ])) {
            return $this->response->setJSON([
                'error' => 'Internal server error'
            ]);
        }

        session()->setFlashdata('success', 'Berhasil upload file');

        return $this->response->setJSON($data);
    }

    public function delete()
    {
        $ids = $this->request->getGet('id');
        $ids = explode(',', $ids);

        $this->documentModel->delete($ids);

        return redirect()->to('/mydocuments')->with('success', 'Berhasil menghapus dokumen');
    }

    public function reject()
    {
        $id = $this->request->getGet('id');

        if (!$this->documentModel->update($id, [
            'signed' => '2'
        ])) {
            return redirect()->back()->with('error', 'Internal server error');
        }

        return redirect()->back()->with('success', 'Dokumen ditolak');
    }
}
