<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        \Myth\Auth\Authentication\Passwords\ValidationRules::class
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------
    public $signature = [
        ''
    ];

    public $profile = [
        'id_number' => [
            'label' => 'ID Number',
            'rules' => 'required|is_natural|trim',
            'errors' => [
                'required' => '{field} harus di isi.',
                'is_natural' => '{field} tidak valid'
            ]
        ],
        'name' => [
            'label' => 'Nama',
            'rules' => 'required|trim',
            'errors' => [
                'required' => '{field} tidak boleh kosong'
            ]
        ],
        'role' => [
            'label' => 'Role',
            'rules' => 'required|trim',
            'errors' => [
                'required' => 'Harap pilih {field}'
            ]
        ],
        'phone' => [
            'label' => 'Nomor Telepon',
            'rules' => 'required|trim',
            'errors' => [
                'required' => 'Harap isi {field}'
            ]
        ],
        'image' => [
            'label' => 'Foto Profil',
            'rules' => 'is_image[image]|trim',
            'errors' => [
                'is_image' => '{field} yang anda pilih bukan gambar'
            ]
        ],
        'signature' => [
            'label' => 'Tanda Tangan',
            'rules' => 'is_image[signature]|trim',
            'errors' => [
                'is_image' => '{field} yang anda pilih bukan gambar'
            ]
        ]
    ];

    public $document = [
        'document_title' => [
            'label' => 'Judul Dokumen',
            'rules' => 'required',
            'errors' => [
                'required' => '{field} tidak boleh kosong'
            ]
        ],
        'to_id' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Harap pilih user'
            ]
        ],
        'document' => [
            'label' => 'Berkas Dokumen',
            'rules' => 'uploaded[document]|mime_in[document,application/pdf]',
            'errors' => [
                'uploaded' => 'Harap upload {field}',
                'mime_in' => 'Ekstensi tidak diperbolehkan'
            ]
        ]
    ];

    public $attemptInviteFriend = [
        'document_title' => [
            'label' => 'Judul Dokumen',
            'rules' => 'required|min_length[3]|trim',
            'errors' => [
                'required' => '{field} harus di isi',
                'min_length' => '{field} tidak boleh kurang dari 3 karakter'
            ]
        ],
        'to_id' => [
            'label' => 'Penerima',
            'rules' => 'required|trim',
            'errors' => [
                'required' => '{field} harus di pilih'
            ]
        ],
        'document' => [
            'label' => 'Berkas',
            'rules' => 'uploaded[document]|',
            'errors' => [
                'uploaded' => '{field} harus diupload'
            ]
        ]
    ];

    public $changePassword = [
        'old_password' => [
            'label' => 'Kata Sandi Lama',
            'rules' => 'required|trim',
            'errors' => [
                'required' => 'Harap isi {field}',
            ]
        ],
        'new_password' => [
            'label' => 'Kata Sandi Baru',
            'rules' => 'required|trim',
            'errors' => [
                'required' => 'Harap isi {field}'
            ]
        ],
        'confirm_password' => [
            'label' => 'Konfirmasi Kata Sandi',
            'rules' => 'required|matches[new_password]|trim',
            'errors' => [
                'matches' => '{field} harus sama dengan Kata Sandi baru',
                'required' => 'Harap isi {field}'
            ]
        ]
    ];
}
