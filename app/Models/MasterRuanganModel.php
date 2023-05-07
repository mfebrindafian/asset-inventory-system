<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterRuanganModel extends Model
{
    // protected $DBGroup = 'siakad';
    protected $table = 'tbl_ruangan';
    protected $allowedFields = ['nama_ruang', 'kapasitas', 'id_gedung'];


    public function getAllRuangan()
    {
        return $this
            ->table($this->table)
            ->get()
            ->getResultArray();
    }
}
