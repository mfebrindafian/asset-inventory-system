<?php

namespace App\Models;

use CodeIgniter\Model;

class masterTabelAkunModel extends Model
{
    protected $table = 'tbl_akun';
    protected $allowedFields = ['ur_akun'];

    public function getId($ur_akun)
    {
        return $this
            ->table($this->table)
            ->select('id')
            ->where('ur_akun', $ur_akun)
            ->get()
            ->getRowArray();
    }
}
