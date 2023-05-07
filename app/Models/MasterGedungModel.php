<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterGedungModel extends Model
{
    // protected $DBGroup = 'siakad';
    protected $table = 'tbl_gedung';
    protected $allowedFields = ['nama_gedung', 'id_lokasi'];


    public function getAllGedung()
    {
        return $this
            ->table($this->table)
            ->get()
            ->getResultArray();
    }
}
