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
            ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
            ->join('tbl_akun', 'tbl_akun.id = tbl_bmn.akun_id')
            ->join('tbl_barang', 'tbl_barang.id = tbl_bmn.barang_id')
            ->get()
            ->getResultArray();
    }


    public function getBmnByIdAkun($akun_id)
    {
        return $this
            ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
            ->where('akun_id', $akun_id)
            ->join('tbl_akun', 'tbl_akun.id = tbl_bmn.akun_id')
            ->join('tbl_barang', 'tbl_barang.id = tbl_bmn.barang_id')
            ->get()
            ->getResultArray();
    }


    public function getBmnByIdAkunBySatker($akun_id, $satker_id)
    {
        return $this
            ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
            ->where('akun_id', $akun_id)
            ->where('satker_id', $satker_id)
            ->join('tbl_akun', 'tbl_akun.id = tbl_bmn.akun_id')
            ->join('tbl_barang', 'tbl_barang.id = tbl_bmn.barang_id')
            ->get()
            ->getResultArray();
    }

    public function getBmnByIdAkunSatkerId($akun_id, $satker_id)
    {
        return $this
            ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
            ->where('akun_id', $akun_id)
            ->where('satker_id', $satker_id)
            ->join('tbl_akun', 'tbl_akun.id = tbl_bmn.akun_id')
            ->join('tbl_barang', 'tbl_barang.id = tbl_bmn.barang_id')
            ->get()
            ->getResultArray();
    }

    public function getAllBmnBySatker($satker_id)
    {
        if ($satker_id == 'all') {
            return $this
                ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
                ->join('tbl_akun', 'tbl_akun.id = tbl_bmn.akun_id')
                ->join('tbl_barang', 'tbl_barang.id = tbl_bmn.barang_id')
                ->get()
                ->getResultArray();
        } else {
            return $this
                ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
                ->where('satker_id', $satker_id)
                ->join('tbl_akun', 'tbl_akun.id = tbl_bmn.akun_id')
                ->join('tbl_barang', 'tbl_barang.id = tbl_bmn.barang_id')
                ->get()
                ->getResultArray();
        }
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

    public function getListBmnBySatkerId($satker_id)
    {
        return $this
            ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
            ->where('tbl_bmn.satker_id', $satker_id)
            ->join('tbl_akun', 'tbl_akun.id = tbl_bmn.akun_id')
            ->join('tbl_barang', 'tbl_barang.id = tbl_bmn.barang_id')
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
            ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
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

    public function getDataBmnById($id_bmn)
    {
        return $this
            ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
            ->where('tbl_bmn.id', $id_bmn)
            ->join('tbl_akun', 'tbl_akun.id = tbl_bmn.akun_id')
            ->join('tbl_barang', 'tbl_barang.id = tbl_bmn.barang_id')
            ->get()
            ->getRowArray();
    }

    public function getAllBmnByKeberadaan($satker_id, $kbrdn_brg)
    {
        return $this
            ->table('tbl_bmn')
            ->where('satker_id', $satker_id)
            ->where('kbrdn_brg', $kbrdn_brg)
            ->get()
            ->getResultArray();
    }

    public function getAllBmnByKondisi($satker_id, $kondisi_brg)
    {
        return $this
            ->table('tbl_bmn')
            ->where('satker_id', $satker_id)
            ->where('kondisi_brg', $kondisi_brg)
            ->get()
            ->getResultArray();
    }
}
