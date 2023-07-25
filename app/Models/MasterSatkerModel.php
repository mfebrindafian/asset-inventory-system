<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterSatkerModel extends Model
{
    protected $DBGroup = 'kepeg';
    protected $table = 'referensi_unit_kerja';
    // protected $allowedFields = ['nama_satker'];

    public function getAllSatker()
    {
        return $this
            ->table('referensi_unit_kerja')
            ->get()
            ->getResultArray();
    }


    public function getNamaSatker($satker_id)
    {
        return $this
            ->table('referensi_unit_kerja')
            ->select('nama_ref_unit_kerja_lengkap')
            ->where('id_ref_unit_kerja', $satker_id)
            ->get()
            ->getRowArray();
    }

    public function getSatker($satker_id)
    {
        return $this
            ->table('referensi_unit_kerja')
            ->select('id_ref_unit_kerja,nama_ref_unit_kerja_lengkap')
            ->where('id_ref_unit_kerja', $satker_id)
            ->get()
            ->getRowArray();
    }
    public function getIdSatker($nama_satker)
    {
        return $this
            ->table('referensi_unit_kerja')
            ->select('id_ref_unit_kerja')
            ->where('nama_ref_unit_kerja_lengkap', $nama_satker)
            ->get()
            ->getRowArray();
    }
}
