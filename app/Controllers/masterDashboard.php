<?php

namespace App\Controllers;

use App\Models\MasterUserModel;
use App\Models\MasterSatkerModel;
use App\Models\masterTabelBmnModel;
use App\Models\masterTabelAkunModel;
use CodeIgniter\I18n\Time;

class masterDashboard extends BaseController
{
    protected $masterUserModel;
    protected $masterSatkerModel;
    protected $masterBmnModel;
    protected $masterAkunModel;

    public function __construct()
    {

        $this->masterUserModel = new masterUserModel();
        $this->masterSatkerModel = new MasterSatkerModel();
        $this->masterBmnModel = new MasterTabelBmnModel();
        $this->masterAkunModel = new MasterTabelAkunModel();
    }

    public function index()
    {
        $satker_choose = $this->request->getVar('satker_choose');
        d($satker_choose);
        $list_akun = $this->masterAkunModel->getAllAkun();
        $list_bmn = $this->masterBmnModel->getAllBmn();

        for ($i = 1; $i <= count($list_akun); $i++) {
        }
        $ke = 1;
        foreach ($list_akun as $akun) {

            foreach ($list_bmn as $bmn) {
                if ($bmn['akun_id'] == $ke) {
                    $all[$ke][] = $bmn;
                    if ($all[$ke] != null) {
                        $data_akun['all'][$ke] = count($all[$ke]);
                    }
                    if ($bmn['kondisi_brg'] == null) {
                        $belum[$ke][] = $bmn;
                        if ($belum[$ke] != null) {
                            $data_akun['belum'][$ke] = count($belum[$ke]);
                            if ($data_akun['belum'][$ke] == $data_akun['all'][$ke]) {
                                $data_akun['sudah'][$ke] = 0;
                            }
                        } else {
                            $data_akun['belum'][$ke] = 0;
                        }
                    } else {
                        $sudah[$ke][] = $bmn;
                        if ($sudah[$ke] != null) {
                            $data_akun['sudah'][$ke] = count($sudah[$ke]);
                            if ($data_akun['sudah'][$ke] == $data_akun['all'][$ke]) {
                                $data_akun['belum'][$ke] = 0;
                            }
                        } else {
                            $data_akun['sudah'][$ke] = 0;
                        }
                    }
                }
            }
            $ke++;
        }
        // dd($data_akun);
        $list_satker = $this->masterSatkerModel->getAllSatker();

        $data = [
            'halaman' => 'dashboard',
            'list_akun' => $list_akun,
            'list_bmn' => $list_bmn,
            'data_bmn' => $data_akun,
            'list_satker' => $list_satker
        ];

        return view('dashboard/dashboard', $data);
    }

    public function listBmnOnDashboard()
    {
        $data = [
            'halaman' => 'dashboard'
        ];
        return view('dashboard/listdetail', $data);
    }
    public function detailBmnOnDashboard()
    {
        $data = [
            'halaman' => 'dashboard'
        ];
        return view('dashboard/detail', $data);
    }
}
