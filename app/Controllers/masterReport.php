<?php

namespace App\Controllers;

use App\Models\masterSatkerModel;
use App\Models\masterTabelBmnModel;
use App\Models\masterTabelJenisRekapitulasiModel;
use App\Models\masterTabelAkunModel;

class masterReport extends BaseController
{
    protected $masterBmnModel;
    protected $masterSatkerModel;
    protected $masterTabelJenisRekapitulasiModel;
    protected $masterAkunModel;
    public function __construct()
    {
        $this->masterBmnModel = new MasterTabelBmnModel();
        $this->masterSatkerModel = new masterSatkerModel();
        $this->masterTabelJenisRekapitulasiModel = new masterTabelJenisRekapitulasiModel();
        $this->masterAkunModel = new masterTabelAkunModel();
    }

    public function rekapitulasi()
    {
        $list_satker = $this->masterSatkerModel->getAllSatker();
        $list_rekapitulasi = $this->masterTabelJenisRekapitulasiModel->getAllJenisRekapitulasi();

        $data = [
            'title' => 'Rekapitulasi',
            'menu' => 'Report',
            'subMenu' => 'Rekapitulasi',
            'halaman' => 'rekapitulasi',
            'list_satker' => $list_satker,
            'list_jenis_rekapitulasi' => $list_rekapitulasi
        ];
        return view('report/rekapitulasi', $data);
    }
    public function inventarisasi()
    {
        $data = [
            'title' => 'Inventarisasi',
            'menu' => 'Report',
            'subMenu' => 'Inventarisasi',
            'halaman' => 'inventarisasi'
        ];
        return view('report/inventarisasi', $data);
    }

    public function APIrekapitulasi($jenis_rekapitulasi_id, $satker_id)
    {
        $list_akun = $this->masterAkunModel->getAllAkun();
        $nama_jenis_rekapitulasi = $this->masterTabelJenisRekapitulasiModel->getJenisRekapitulasiById($jenis_rekapitulasi_id);

        //pegecekan jumlah dibagian "administrasi"
        $adm_list_bmn = $this->masterBmnModel->getAllBmnBySatker($satker_id);
        foreach ($list_akun as $akun) {
            $data_akun[$akun['id']]['adm_jumlah'] = 0;
            $data_akun[$akun['id']]['adm_nilai'] = 0;
        }
        $data_akun['total']['adm_jumlah'] = 0;
        $data_akun['total']['adm_nilai'] = 0;
        if ($adm_list_bmn != null) {
            foreach ($list_akun as $adm_akun) {
                foreach ($adm_list_bmn as $adm_bmn) {
                    if ($adm_akun['id'] == $adm_bmn['akun_id']) {
                        $all[$adm_akun['id']]['adm_jumlah'][] = $adm_bmn;
                        $all[$adm_akun['id']]['adm_nilai'][] = $adm_bmn['nilai_bmn'];

                        if ($all[$adm_akun['id']] != null) {
                            $data_akun[$adm_akun['id']]['adm_jumlah'] = count($all[$adm_akun['id']]['adm_jumlah']);
                            $data_akun[$adm_akun['id']]['adm_nilai'] = array_sum($all[$adm_akun['id']]['adm_nilai']);
                        } else {
                            $data_akun[$adm_akun['id']]['adm_jumlah'] = 0;
                            $data_akun[$adm_akun['id']]['adm_nilai'] = 0;
                        }
                    }
                }
            }
            foreach ($list_akun as $akun) {
                $adm_jumlah[] =  $data_akun[$akun['id']]['adm_jumlah'];
                $adm_nilai[] =  $data_akun[$akun['id']]['adm_nilai'];
                $data_akun['total']['adm_jumlah'] = array_sum($adm_jumlah);
                $data_akun['total']['adm_nilai'] = array_sum($adm_nilai);
            }
        } else {
            foreach ($list_akun as $akun) {
                $data_akun[$akun['id']]['adm_jumlah'] = 0;
                $data_akun[$akun['id']]['adm_nilai'] = 0;
            }

            $data_akun['total']['adm_jumlah'] = 0;
            $data_akun['total']['adm_nilai'] = 0;
            $data_akun['nama_jenis'] = $nama_jenis_rekapitulasi['jenis_rekapitulasi'];
        }
        //Batas pengecekan bagian administrasi

        //pengkondisian untuk tipe Baik, Rusak ringan, rusak berat
        if ($jenis_rekapitulasi_id == 4 || $jenis_rekapitulasi_id == 5 || $jenis_rekapitulasi_id == 6) {
            if ($jenis_rekapitulasi_id == 4) {
                $kondisi_brg = 'B';
            } else if ($jenis_rekapitulasi_id == 5) {
                $kondisi_brg = 'RR';
            } else if ($jenis_rekapitulasi_id == 6) {
                $kondisi_brg = 'RB';
            }
            $list_bmn = $this->masterBmnModel->getAllBmnByKondisi($satker_id, $kondisi_brg);
        }
        //batas pengecekan untuk tipe Baik, Rusak ringan, rusak berat

        //pengkondisian untuk tipe barang ditemukan, barang tidak ditemukan, barang berlebih
        if ($jenis_rekapitulasi_id == 2 || $jenis_rekapitulasi_id == 3 || $jenis_rekapitulasi_id == 7) {
            if ($jenis_rekapitulasi_id == 2) {
                $kbrdn_brg = 'BD';
            } else if ($jenis_rekapitulasi_id == 3) {
                $kbrdn_brg = 'BTD';
            } else if ($jenis_rekapitulasi_id == 7) {
                $kbrdn_brg = 'BR';
            }
            $list_bmn = $this->masterBmnModel->getAllBmnByKeberadaan($satker_id, $kbrdn_brg);
        }
        //batas pengkondisian untuk tipe barang ditemukan, barang tidak ditemukan, barang berlebih

        //pengkondisian untuk tipe barang sebelum dan sesudah inventarisasi
        if ($jenis_rekapitulasi_id == 1) {
            $list_bmn = $this->masterBmnModel->getAllBmnBySatker($satker_id);
        }
        //batas pengkondisian untuk tipe barang ditemukan, barang tidak ditemukan, barang berlebih

        //pegecekan jumlah dibagian "inventarisasi"
        foreach ($list_akun as $akun) {
            $data_akun[$akun['id']]['inv_jumlah'] = 0;
            $data_akun[$akun['id']]['inv_nilai'] = 0;
            $data_akun[$akun['id']]['nama_akun'] = $akun['ur_akun'];
        }
        $data_akun['total']['inv_jumlah'] = 0;
        $data_akun['total']['inv_nilai'] = 0;
        $data_akun['nama_jenis'] = $nama_jenis_rekapitulasi['jenis_rekapitulasi'];
        if ($list_bmn != null) {
            foreach ($list_akun as $akun) {
                foreach ($list_bmn as $bmn) {
                    if ($akun['id'] == $bmn['akun_id']) {
                        $all[$akun['id']]['inv_jumlah'][] = $bmn;
                        $all[$akun['id']]['inv_nilai'][] = $bmn['nilai_bmn'];

                        if ($all[$akun['id']] != null) {
                            $data_akun[$akun['id']]['inv_jumlah'] = count($all[$akun['id']]['inv_jumlah']);
                            $data_akun[$akun['id']]['inv_nilai'] = array_sum($all[$akun['id']]['inv_nilai']);
                            $data_akun[$akun['id']]['nama_akun'] = $akun['ur_akun'];
                        } else {
                            $data_akun[$akun['id']]['inv_jumlah'] = 0;
                            $data_akun[$akun['id']]['inv_nilai'] = 0;
                            $data_akun[$akun['id']]['nama_akun'] = $akun['ur_akun'];
                        }
                    }
                }
            }
            foreach ($list_akun as $akun) {
                $inv_jumlah[] =  $data_akun[$akun['id']]['inv_jumlah'];
                $inv_nilai[] =  $data_akun[$akun['id']]['inv_nilai'];
                $data_akun['total']['inv_jumlah'] = array_sum($inv_jumlah);
                $data_akun['total']['inv_nilai'] = array_sum($inv_nilai);
            }
        } else {
            foreach ($list_akun as $akun) {
                $data_akun[$akun['id']]['inv_jumlah'] = 0;
                $data_akun[$akun['id']]['inv_nilai'] = 0;
                $data_akun[$akun['id']]['nama_akun'] = $akun['ur_akun'];
            }
            $data_akun['total']['inv_jumlah'] = 0;
            $data_akun['total']['inv_nilai'] = 0;
            $data_akun['nama_jenis'] = $nama_jenis_rekapitulasi['jenis_rekapitulasi'];
        }
        //batas pengecekan "inventarisasi"

        //pengecekan "selisih"
        foreach ($list_akun as $akun) {
            $data_akun[$akun['id']]['selisih_jumlah'] = 0;
            $data_akun[$akun['id']]['selisih_nilai'] = 0;
        }
        $data_akun['total']['selisih_jumlah'] = 0;
        $data_akun['total']['selisih_nilai'] = 0;

        foreach ($list_akun as $akun) {
            $data_akun[$akun['id']]['selisih_jumlah'] = ($data_akun[$akun['id']]['adm_jumlah'] - $data_akun[$akun['id']]['inv_jumlah']);
            $data_akun[$akun['id']]['selisih_nilai'] =  $data_akun[$akun['id']]['adm_nilai'] - $data_akun[$akun['id']]['inv_nilai'];
        }
        $data_akun['total']['selisih_jumlah'] =  $data_akun['total']['adm_jumlah'] - $data_akun['total']['inv_jumlah'];
        $data_akun['total']['selisih_nilai'] = $data_akun['total']['adm_nilai'] - $data_akun['total']['inv_nilai'];
        //batas pengecekan selisih

        echo json_encode($data_akun);
    }
}
