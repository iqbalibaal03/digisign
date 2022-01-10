<?php

namespace App\Controllers;

use App\Models\Document;
use Exception;
use Myth\Auth\Authorization\GroupModel;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Password;

class Home extends BaseController
{

    protected $userModel;
    protected $groupModel;
    protected $documentModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->groupModel = new GroupModel();
        $this->documentModel = new Document();
    }

    public function index()
    {
        $data = [
            'title' => getenv('app.name'),
            'validator' => $this->validator,
            'groups' => $this->groupModel->findAll()
        ];

        return view('home/index', $data);
    }

    // Profile
    public function profile()
    {
        $data = [
            'title' => getenv('app.name') . ' | Profile',
            'validator' => $this->validator,
            'groups' => $this->groupModel->findAll()
        ];

        return view('home/profile', $data);
    }

    public function updateProfile()
    {
        $data = $this->request->getPost();

        if (is_uploaded_file($_FILES['signature']['tmp_name'])) {
            $signatureFile = $this->request->getFile('signature');
            $data['signature'] = $signatureFile->getRandomName();
            $signatureFile->move('uploads/signature', $data['signature']);

            if (user()->signature != null) {
                unlink('uploads/signature/' . user()->signature);
            }
        }

        if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            $imageFile = $this->request->getFile('image');
            $data['image'] = $imageFile->getRandomName();
            $imageFile->move('uploads/users', $data['image']);

            if (user()->image != 'default.jpg') {
                unlink('uploads/users/' . user()->image);
            }
        }

        // if (!$this->validator->run($data, 'profile')) {
        //     return redirect()->to('/profile')->withInput();
        // }

        try {
            $this->userModel->update(user_id(), $data);
        } catch (\Throwable $th) {
            log_message('error', $th->getMessage());
            throw new Exception($th->getMessage());
            return redirect()->to('/profile')->with('error', 'Terjadi gangguan internal');
        }

        if (!in_groups([1, 2, 3])) {
            $this->groupModel->addUserToGroup(user_id(), $data['role']);
        }

        return redirect()->back()->with('success', 'Pofile telah di perbaharui');
    }

    public function changePassword()
    {
        $data = [
            'title' => getenv('app.name') . ' | Ubah Password',
        ];
        return view('home/password', $data);
    }

    public function attemptChangePassword()
    {
        $auth = service('authentication');

        $data = $this->request->getPost();

        if (!$this->validator->run($data, 'changePassword')) {
            return redirect()->back()->withInput();
        }

        $credentials = [
            'password' => $data['old_password'],
            'email' => user()->email
        ];

        if (!$auth->validate($credentials)) {
            return redirect()->back()->with('error', 'Kata Sandi Lama yang anda masukkan salah');
        }

        unset($data['old_password']);

        if (!$this->userModel->update(user_id(), [
            'password_hash' => Password::hash($data['new_password']),
        ])) {

            return redirect()->back()->with('error', $this->userModel->errors());
        }

        return redirect()->to('/profile')->with('success', 'Berhasil mengubah kata sandi');
    }

    public function document()
    {
        $data = [
            'title' => getenv('app.name') . ' | Upload Dokumen',
            'users' => $this->userModel->findAll(),
            'validator' => $this->validator
        ];

        return view('home/document', $data);
    }
}
