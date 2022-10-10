<?php

namespace App\Models;

use CodeIgniter\Model;

class masterTabelBarangModel extends Model
{
    protected $table = 'tbl_barang';
    protected $allowedFields = ['kd_barang', 'nama_barang'];

    public function getId($kd_barang)
    {
        return $this
            ->table($this->table)
            ->select('id')
            ->where('kd_barang', $kd_barang)
            ->get()
            ->getRowArray();
    }
}
