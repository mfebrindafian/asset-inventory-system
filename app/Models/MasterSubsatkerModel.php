<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterSubsatkerModel extends Model
{
    // protected $DBGroup = 'siakad';
    protected $table = 'tbl_subsatker';
    protected $allowedFields = ['nama_subsatker', 'id_ref_unit_kerja'];


    public function getAllSubsatker()
    {
        return $this
            ->table($this->table)
            ->get()
            ->getResultArray();
    }
}