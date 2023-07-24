<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterPegawaiModel extends Model
{
    protected $DBGroup = 'kepeg';
    protected $table = 'pegawai';

    public function getDataPegawai($nip)
    {
        return $this
            ->table('pegawai')
            ->where('nip', $nip)
            ->get()
            ->getRowArray();
    }

    public function getAllPegawai()
    {
        return $this
            ->table('pegawai')
            ->get()
            ->getResultArray();
    }

    public function getAllPegawaiByName($nama_pegawai)
    {
        return $this
            ->table('pegawai')
            ->LIKE('nama_pegawai', $nama_pegawai)
            ->limit(10)
            ->get()
            ->getResultArray();
    }

    public function getNamaPegawai($id_pegawai)
    {
        return $this
            ->table('pegawai')
            ->where('id_pegawai', $id_pegawai)
            ->get()
            ->getRowArray();
    }
}
