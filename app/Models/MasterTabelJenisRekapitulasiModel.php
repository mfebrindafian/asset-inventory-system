<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterTabelJenisRekapitulasiModel extends Model
{
    protected $table = 'tbl_jenis_rekapitulasi';
    protected $allowedFields = ['jenis_rekapitulasi'];

    public function getAllJenisRekapitulasi()
    {
        return $this
            ->table($this->table)
            ->get()
            ->getResultArray();
    }

    public function getJenisRekapitulasiById($id)
    {
        return $this
            ->table($this->table)
            ->where('id', $id)
            ->get()
            ->getRowArray();
    }
}
