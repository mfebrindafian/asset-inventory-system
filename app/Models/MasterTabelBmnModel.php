<?php

namespace App\Models;

use CodeIgniter\Model;

class masterTabelBmnModel extends Model
{
    protected $table = 'tbl_bmn';
    protected $allowedFields = ['akun_id', 'barang_id', 'thn_perolehan', 'nup', 'merk_tipe', 'kuantitas', 'nilai_bmn', 'kondisi_brg', 'kbrdn_brg', 'label_kode', 'pegawai_id', 'gedung_id', 'ruangan_id', 'status_psp', 'subsatker_id', 'satker_id', 'ket', 'kd_batch', 'opUniv_id', 'opSatker_id'];
}
