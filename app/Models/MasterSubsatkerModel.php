<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterSubsatkerModel extends Model
{
    // protected $DBGroup = 'siakad';
    protected $table = 'tbl_subsatker';
    protected $allowedFields = ['nama_subsatker', 'satker_id'];


    public function getAllSubsatker()
    {
        return $this
            ->table($this->table)
            ->get()
            ->getResultArray();
    }

    public function getNamaSubsatker($id_subsatker)
    {
        return $this
            ->table('tbl_subsatker')
            ->where('id', $id_subsatker)
            ->get()
            ->getRowArray();
    }

    public function getAllSubsatkerBySatker($satker_id)
    {
        return $this
            ->table($this->table)
            ->where('satker_id', $satker_id)
            ->get()
            ->getResultArray();
    }
}
