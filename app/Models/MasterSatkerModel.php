<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterSatkerModel extends Model
{
    protected $DBGroup = 'sibamira2';
    protected $table = 'tbl_satker';
    protected $allowedFields = ['nama_satker'];

    public function getAllSatker()
    {
        return $this
            ->table('tbl_satker')
            ->get()
            ->getResultArray();
    }


    public function getNamaSatker($satker_id)
    {
        return $this
            ->table('tbl_satker')
            ->select('nama_satker')
            ->where('id', $satker_id)
            ->get()
            ->getRowArray();
    }
}
