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


        if ($jenis_rekapitulasi_id == 4) {
            $kondisi_brg = 'B';
        } else if ($jenis_rekapitulasi_id == 5) {
            $kondisi_brg = 'RR';
        } else if ($jenis_rekapitulasi_id == 6) {
            $kondisi_brg = 'RB';
        }
        if ($jenis_rekapitulasi_id == 4 || $jenis_rekapitulasi_id == 5 || $jenis_rekapitulasi_id == 6) {
            $list_bmn = $this->masterBmnModel->getAllBmnByKondisi($satker_id, $kondisi_brg);
        }

        if ($jenis_rekapitulasi_id == 2) {
            $kbrdn_brg = 'BD';
        } else if ($jenis_rekapitulasi_id == 3) {
            $kbrdn_brg = 'BTD';
        } else if ($jenis_rekapitulasi_id == 7) {
            $kbrdn_brg = 'BR';
        }
        if ($jenis_rekapitulasi_id == 2 || $jenis_rekapitulasi_id == 3 || $jenis_rekapitulasi_id == 7) {
            $list_bmn = $this->masterBmnModel->getAllBmnByKeberadaan($satker_id, $kbrdn_brg);
        }
        foreach ($list_akun as $akun) {
            $data_akun[$akun['id']]['jumlah'] = 0;
            $data_akun[$akun['id']]['nilai'] = 0;
            $data_akun[$akun['id']]['nama_akun'] = $akun['ur_akun'];
        }
        $data_akun['total']['nama_jenis'] = $nama_jenis_rekapitulasi['jenis_rekapitulasi'];
        $data_akun['total']['jumlah'] = 0;
        $data_akun['total']['nilai'] = 0;

        if ($list_bmn != null) {
            foreach ($list_akun as $akun) {
                foreach ($list_bmn as $bmn) {
                    if ($akun['id'] == $bmn['akun_id']) {
                        $all[$akun['id']]['jumlah'][] = $bmn;
                        $all[$akun['id']]['nilai'][] = $bmn['nilai_bmn'];

                        if ($all[$akun['id']] != null) {
                            $data_akun[$akun['id']]['jumlah'] = count($all[$akun['id']]['jumlah']);
                            $data_akun[$akun['id']]['nilai'] = array_sum($all[$akun['id']]['nilai']);
                            $data_akun[$akun['id']]['nama_akun'] = $akun['ur_akun'];
                        } else {
                            $data_akun[$akun['id']]['jumlah'] = 0;
                            $data_akun[$akun['id']]['nilai'] = 0;
                            $data_akun[$akun['id']]['nama_akun'] = $akun['ur_akun'];
                        }
                    }
                }
            }
            foreach ($list_akun as $akun) {
                $jumlah[] =  $data_akun[$akun['id']]['jumlah'];
                $nilai[] =  $data_akun[$akun['id']]['nilai'];
                $data_akun['total']['jumlah'] = array_sum($jumlah);
                $data_akun['total']['nilai'] = array_sum($nilai);
            }
        } else {
            foreach ($list_akun as $akun) {
                $data_akun[$akun['id']]['jumlah'] = 0;
                $data_akun[$akun['id']]['nilai'] = 0;
                $data_akun[$akun['id']]['nama_akun'] = $akun['ur_akun'];
            }
            $data_akun['total']['nama_jenis'] = $nama_jenis_rekapitulasi['jenis_rekapitulasi'];
            $data_akun['total']['jumlah'] = 0;
            $data_akun['total']['nilai'] = 0;
        }





        echo json_encode($data_akun);
    }
}
