<?php

namespace App\Models;

use CodeIgniter\Model;

class Document extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'documents';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['from_id', 'to_id', 'document_title', 'document_filename', 'signed', 'qrcode_hash', 'rsa_encrypt', 'signature', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function search($fromId, $toId, $keyword)
    {
        return $this->table('documents')->where('from_id', $fromId)->where('to_id', $toId)->like('document_title', $keyword);
    }

    public function filter($fromId, $toId, $sortBy, $sortFormat)
    {
        return $this->table('documents')->where('from_id', $fromId)->where('to_id', $toId)->orderBy($sortBy, $sortFormat ?? 'ASC');
    }

    public function toMe(int $userId)
    {
    }

    public function toOthers($userId)
    {
        $db = \Config\Database::connect();
        $sql = "SELECT * FROM documents WHERE from_id = :from_id: AND to_id != :to_id:";
        return $db->query($sql, [
            'from_id'     => $userId,
            'to_id'       => $userId,
        ]);
    }
}
