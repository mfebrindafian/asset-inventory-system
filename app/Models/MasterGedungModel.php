<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterGedungModel extends Model
{
    protected $DBGroup = 'siakad';
    protected $table = 'gedung';
    // protected $allowedFields = ['nip_lama', 'nip_baru', 'nama_pegawai', 'gol_kd', 'tmt', 'jabatan_kd', 'ket_jabatan', 'pendidikan_kd',  'tahun_pdd',  'jk', 'tgl_lahir', 'satker_kd', 'es3_kd', 'es4_kd', 'fungsional_kd'];


    public function getAllGedung()
    {
        return $this
            ->table('gedung')
            ->get()
            ->getResultArray();
    }
}
