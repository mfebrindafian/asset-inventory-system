<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterLokasiModel extends Model
{

    protected $table = 'tbl_lokasi';
    protected $allowedFields = ['nama_lokasi'];


    public function getAllLokasi()
    {
        return $this
            ->table($this->table)
            ->get()
            ->getResultArray();
    }
}
