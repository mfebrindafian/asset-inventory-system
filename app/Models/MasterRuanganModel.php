<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterRuanganModel extends Model
{
    // protected $DBGroup = 'siakad';
    protected $table = 'tbl_ruangan';
    protected $allowedFields = ['nama_ruang', 'kapasitas', 'id_gedung', 'satker_id'];


    public function getAllRuangan()
    {
        return $this
            ->table($this->table)
            ->get()
            ->getResultArray();
    }

    public function getNamaRuangan($id_ruangan)
    {
        return $this
            ->table('tbl_ruangan')
            ->where('id', $id_ruangan)
            ->get()
            ->getRowArray();
    }

    public function getAllRuanganBySatker($satker_id)
    {
        return $this
            ->table('tbl_ruangan')
            ->where('satker_id', $satker_id)
            ->get()
            ->getResultArray();
    }
}
