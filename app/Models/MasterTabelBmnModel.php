<?php

namespace App\Models;

use CodeIgniter\Model;

class masterTabelBmnModel extends Model
{
    protected $table = 'tbl_bmn';
    protected $allowedFields = ['akun_id', 'barang_id', 'thn_perolehan', 'nup', 'merk_tipe', 'kuantitas', 'nilai_bmn', 'kondisi_brg', 'kbrdn_brg', 'label_kode', 'pegawai_id', 'gedung_id', 'ruangan_id', 'status_psp', 'subsatker_id', 'satker_id', 'ket', 'kd_batch', 'opUniv_id', 'opSatker_id'];

    public function getAllBmn()
    {
        return $this
        ->table('tbl_bmn')
        ->get()
        ->getResultArray();
    }


    public function getKodeBatch()
    {
        do {
            $kd_batch = "";
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
            $kd_batch = substr(str_shuffle($permitted_chars), 0, 10);
        } while ($this->where(['kd_batch' => $kd_batch])->get()->getRowArray());
        return $kd_batch;
    }


    public function getListBmn()
    {
        return $this
            ->table('tbl_bmn')
            ->groupBy('kd_batch')
            ->get()
            ->getResultArray();
    }

    public function getJmlBatch($kd_batch)
    {
        return $this
            ->table('tbl_bmn')
            ->where('kd_batch', $kd_batch)
            ->get()
            ->getResultArray();
    }
    public function getDataBatch($kd_batch)
    {
        return $this
            ->table('tbl_bmn')
            ->select('tbl_bmn.*,tbl_akun.*,tbl_barang.*')
            ->where('kd_batch', $kd_batch)
            ->join('tbl_akun', 'tbl_akun.id = tbl_bmn.akun_id')
            ->join('tbl_barang', 'tbl_barang.id = tbl_bmn.barang_id')
            ->get()
            ->getResultArray();
    }

    public function deleteBatch($kd_batch)
    {
        return $this
            ->table('tbl_bmn')
            ->where('kd_batch', $kd_batch)
            ->delete();
    }
}
