<?php

namespace App\Models;

use CodeIgniter\Model;

class masterTabelBmnModel extends Model
{
    protected $table = 'tbl_bmn';
    protected $allowedFields = ['akun_id', 'barang_id', 'thn_perolehan', 'nup', 'merk_tipe', 'kuantitas', 'nilai_bmn', 'nilai_bmn_minus', 'kondisi_brg', 'kbrdn_brg', 'kategori_btd', 'kategori_br', 'label_kode', 'pegawai_id', 'gedung_id', 'ruangan_id', 'status_psp', 'subsatker_id', 'satker_id', 'ket', 'kd_batch', 'opUniv_id', 'opSatker_id'];

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

    public function getAllBmnBySatkerDitemukan($satker_id)
    {
        if ($satker_id == 'all') {
            return $this
                ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
                ->where('kbrdn_brg', 'BD')
                ->join('tbl_akun', 'tbl_akun.id = tbl_bmn.akun_id')
                ->join('tbl_barang', 'tbl_barang.id = tbl_bmn.barang_id')
                ->get()
                ->getResultArray();
        } else {
            return $this
                ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
                ->where('kbrdn_brg', 'BD')
                ->where('satker_id', $satker_id)
                ->join('tbl_akun', 'tbl_akun.id = tbl_bmn.akun_id')
                ->join('tbl_barang', 'tbl_barang.id = tbl_bmn.barang_id')
                ->get()
                ->getResultArray();
        }
    }
    public function getAllBmnBySatkerTdkDitemukan($satker_id)
    {
        if ($satker_id == 'all') {
            return $this
                ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
                ->where('kbrdn_brg', 'BTD')
                ->join('tbl_akun', 'tbl_akun.id = tbl_bmn.akun_id')
                ->join('tbl_barang', 'tbl_barang.id = tbl_bmn.barang_id')
                ->get()
                ->getResultArray();
        } else {
            return $this
                ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
                ->where('kbrdn_brg', 'BTD')
                ->where('satker_id', $satker_id)
                ->join('tbl_akun', 'tbl_akun.id = tbl_bmn.akun_id')
                ->join('tbl_barang', 'tbl_barang.id = tbl_bmn.barang_id')
                ->get()
                ->getResultArray();
        }
    }
    public function getAllBmnBySatkerBaik($satker_id)
    {
        if ($satker_id == 'all') {
            return $this
                ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
                ->where('kondisi_brg', 'B')
                ->where('kbrdn_brg', 'BD')
                ->join('tbl_akun', 'tbl_akun.id = tbl_bmn.akun_id')
                ->join('tbl_barang', 'tbl_barang.id = tbl_bmn.barang_id')
                ->get()
                ->getResultArray();
        } else {
            return $this
                ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
                ->where('kondisi_brg', 'B')
                ->where('kbrdn_brg', 'BD')
                ->where('satker_id', $satker_id)
                ->join('tbl_akun', 'tbl_akun.id = tbl_bmn.akun_id')
                ->join('tbl_barang', 'tbl_barang.id = tbl_bmn.barang_id')
                ->get()
                ->getResultArray();
        }
    }
    public function getAllBmnBySatkerRusakRingan($satker_id)
    {
        if ($satker_id == 'all') {
            return $this
                ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
                ->where('kondisi_brg', 'RR')
                ->where('kbrdn_brg', 'BD')
                ->join('tbl_akun', 'tbl_akun.id = tbl_bmn.akun_id')
                ->join('tbl_barang', 'tbl_barang.id = tbl_bmn.barang_id')
                ->get()
                ->getResultArray();
        } else {
            return $this
                ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
                ->where('kondisi_brg', 'RR')
                ->where('kbrdn_brg', 'BD')
                ->where('satker_id', $satker_id)
                ->join('tbl_akun', 'tbl_akun.id = tbl_bmn.akun_id')
                ->join('tbl_barang', 'tbl_barang.id = tbl_bmn.barang_id')
                ->get()
                ->getResultArray();
        }
    }
    public function getAllBmnBySatkerRusakBerat($satker_id)
    {
        if ($satker_id == 'all') {
            return $this
                ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
                ->where('kondisi_brg', 'RB')
                ->where('kbrdn_brg', 'BD')
                ->join('tbl_akun', 'tbl_akun.id = tbl_bmn.akun_id')
                ->join('tbl_barang', 'tbl_barang.id = tbl_bmn.barang_id')
                ->get()
                ->getResultArray();
        } else {
            return $this
                ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
                ->where('kondisi_brg', 'RB')
                ->where('kbrdn_brg', 'BD')
                ->where('satker_id', $satker_id)
                ->join('tbl_akun', 'tbl_akun.id = tbl_bmn.akun_id')
                ->join('tbl_barang', 'tbl_barang.id = tbl_bmn.barang_id')
                ->get()
                ->getResultArray();
        }
    }

    public function getAllBmnBySatkerBerlebih($satker_id)
    {
        if ($satker_id == 'all') {
            return $this
                ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
                ->where('kbrdn_brg', 'BR')
                ->join('tbl_akun', 'tbl_akun.id = tbl_bmn.akun_id')
                ->join('tbl_barang', 'tbl_barang.id = tbl_bmn.barang_id')
                ->get()
                ->getResultArray();
        } else {
            return $this
                ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
                ->where('kbrdn_brg', 'BR')
                ->where('satker_id', $satker_id)
                ->join('tbl_akun', 'tbl_akun.id = tbl_bmn.akun_id')
                ->join('tbl_barang', 'tbl_barang.id = tbl_bmn.barang_id')
                ->get()
                ->getResultArray();
        }
    }

    public function getAllBmnBySatkerNilaiMinus($satker_id)
    {
        if ($satker_id == 'all') {
            return $this
                ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
                ->where('kbrdn_brg', 'BD')
                ->orWhere('kbrdn_brg', 'BTD')
                ->where('nilai_bmn_minus IS NOT NULL')
                ->where('nilai_bmn_minus !=', 0)
                ->join('tbl_akun', 'tbl_akun.id = tbl_bmn.akun_id')
                ->join('tbl_barang', 'tbl_barang.id = tbl_bmn.barang_id')
                ->get()
                ->getResultArray();
        } else {
            return $this
                ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
                ->where('kbrdn_brg', 'BD')
                ->orWhere('kbrdn_brg', 'BTD')
                ->where('nilai_bmn_minus IS NOT NULL')
                ->where('nilai_bmn_minus !=', 0)
                ->where('satker_id', $satker_id)
                ->join('tbl_akun', 'tbl_akun.id = tbl_bmn.akun_id')
                ->join('tbl_barang', 'tbl_barang.id = tbl_bmn.barang_id')
                ->get()
                ->getResultArray();
        }
    }


    public function getAllBmnByDoneInven($satker_id)
    {
        if ($satker_id == 'all') {
            return $this
                ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
                ->where('tbl_bmn.kondisi_brg !=', null)
                ->join('tbl_akun', 'tbl_akun.id = tbl_bmn.akun_id')
                ->join('tbl_barang', 'tbl_barang.id = tbl_bmn.barang_id')
                ->get()
                ->getResultArray();
        } else {
            return $this
                ->select('tbl_bmn.*,tbl_akun.ur_akun,tbl_akun.ket_akun,tbl_barang.kd_barang,tbl_barang.nama_barang')
                ->where('satker_id', $satker_id)
                ->where('tbl_bmn.kondisi_brg !=', null)
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
        if ($satker_id == 'all') {
            return $this
                ->table('tbl_bmn')
                ->where('kbrdn_brg', $kbrdn_brg)
                ->get()
                ->getResultArray();
        } else {
            return $this
                ->table('tbl_bmn')
                ->where('satker_id', $satker_id)
                ->where('kbrdn_brg', $kbrdn_brg)
                ->get()
                ->getResultArray();
        }
    }

    public function getAllBmnByKondisi($satker_id, $kondisi_brg)
    {
        if ($satker_id == 'all') {
            return $this
                ->table('tbl_bmn')
                ->where('kondisi_brg', $kondisi_brg)
                ->get()
                ->getResultArray();
        } else {
            return $this
                ->table('tbl_bmn')
                ->where('satker_id', $satker_id)
                ->where('kondisi_brg', $kondisi_brg)
                ->get()
                ->getResultArray();
        }
    }

    public function getListBmnApi($page, $perPage)
    {
        $offset = ($page - 1) * $perPage;

        return $this
            ->table('tbl_bmn')
            ->groupBy('kd_batch')
            ->limit($perPage, $offset)
            ->get()
            ->getResultArray();
    }
    public function getListBmnApiSatker($page, $perPage, $satker)
    {
        $offset = ($page - 1) * $perPage;

        return $this
            ->table('tbl_bmn')
            ->where('satker_id', $satker)
            ->groupBy('kd_batch')
            ->limit($perPage, $offset)
            ->get()
            ->getResultArray();
    }
}
