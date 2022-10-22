<?php

namespace App\Controllers;

use App\Models\masterTabelBmnModel;
use App\Models\masterSatkerModel;

class masterInventarisasi extends BaseController
{
    protected $masterBmnModel;
    protected $masterSatkerModel;

    public function __construct()
    {
        $this->masterBmnModel = new MasterTabelBmnModel();
        $this->masterSatkerModel = new MasterSatkerModel();
    }

    public function pmNonTik()
    {
        $satker_id = session('satker_id');
        $list_bmn = $this->masterBmnModel->getListBmnBySatkerId($satker_id);

        foreach ($list_bmn as $bmn) {
            if ($bmn['akun_id'] == 1) {
                $pmnontik[] = $bmn;
            }
        }
        $data = [
            'halaman' => 'pmnontik',
            'list_pmnontik' => $pmnontik
        ];

        return view('inventarisasi/pmnontik', $data);
    }
    public function pmTik()
    {
        $satker_id = session('satker_id');
        $list_bmn = $this->masterBmnModel->getListBmnBySatkerId($satker_id);

        foreach ($list_bmn as $bmn) {
            if ($bmn['akun_id'] == 2) {
                $pmtik[] = $bmn;
            }
        }
        $data = [
            'halaman' => 'pmtik',
            'list_pmtik' => $pmtik
        ];

        return view('inventarisasi/pmtik', $data);
    }
    public function atb()
    {
        $satker_id = session('satker_id');
        $list_bmn = $this->masterBmnModel->getListBmnBySatkerId($satker_id);

        foreach ($list_bmn as $bmn) {
            if ($bmn['akun_id'] == 3) {
                $atb[] = $bmn;
            }
        }
        $data = [
            'halaman' => 'atb',
            'list_atb' => $atb
        ];

        return view('inventarisasi/atb', $data);
    }
    public function atl()
    {
        $satker_id = session('satker_id');
        $list_bmn = $this->masterBmnModel->getListBmnBySatkerId($satker_id);

        foreach ($list_bmn as $bmn) {
            if ($bmn['akun_id'] == 2) {
                $atl[] = $bmn;
            }
        }
        $data = [
            'halaman' => 'atl',
            'list_atl' => $atl
        ];
        return view('inventarisasi/atl', $data);
    }
    public function kertaskerja($id_bmn)
    {

        $data_bmn = $this->masterBmnModel->getDataBmnById($id_bmn);
        $nama_satker = $this->masterSatkerModel->getNamaSatker($data_bmn['satker_id']);

        $data = [
            'halaman' => 'isikertaskerja',
            'data_bmn' => $data_bmn,
            'nama_satker' => $nama_satker['nama_satker']
        ];
        return view('inventarisasi/isikertaskerja', $data);
    }
}
