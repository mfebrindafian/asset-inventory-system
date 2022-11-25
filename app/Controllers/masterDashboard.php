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

        $list_akun = $this->masterAkunModel->getAllAkun();
        if (session('level_id') == 3) {
            $list_bmn = $this->masterBmnModel->getAllBmnBySatker(session('satker_id'));
        } else {
            $list_bmn = $this->masterBmnModel->getAllBmn();
        }


        $ke = 1;
        foreach ($list_akun as $akun) {
            foreach ($list_bmn as $bmn) {
                if ($bmn['akun_id'] == $ke) {
                    $all[$ke][] = $bmn;
                    if ($all[$ke] != null) {
                        $data_akun['all'][$ke] = count($all[$ke]);
                    } else {
                        $data_akun['all'][$ke] = 0;
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
            if (session('level_id') == 3) {
                $check_null_akun = $this->masterBmnModel->getBmnByIdAkunBySatker($ke, session('satker_id'));
            } else {
                $check_null_akun = $this->masterBmnModel->getBmnByIdAkun($ke);
            }


            if ($check_null_akun == null) {
                $data_akun['all'][$ke] = 0;
                $data_akun['belum'][$ke] = 0;
                $data_akun['sudah'][$ke] = 0;
            }
            $ke++;
        }

        $ke = 1;

        $list_satker = $this->masterSatkerModel->getAllSatker();

        if (session('level_id') == 3) {
            $nama_satker = $this->masterSatkerModel->getNamaSatker(session('satker_id'));
        } else {
            $nama_satker['nama_ref_unit_kerja_lengkap'] = 'Semua';
        }

        $data = [
            'title' => 'Dashboard',
            'menu' => 'Dashboard',
            'subMenu' => '',
            'halaman' => 'dashboard',
            'list_akun' => $list_akun,
            'list_bmn' => $list_bmn,
            'data_bmn' => $data_akun,
            'list_satker' => $list_satker,
            'nama_satker' => $nama_satker['nama_ref_unit_kerja_lengkap']
        ];
        // dd($data_akun);

        return view('dashboard/dashboard', $data);
    }

    public function APISatkerOnDashboard($satker_id)
    {

        $list_akun = $this->masterAkunModel->getAllAkun();
        $list_bmn = $this->masterBmnModel->getAllBmnBySatker($satker_id);

        if ($list_bmn == null) {
            $ke = 1;
            foreach ($list_akun as $akun) {
                $data_akun['all'][$ke] = 0;
                $data_akun['belum'][$ke] = 0;
                $data_akun['sudah'][$ke] = 0;
                $ke++;
            }
        }


        $ke = 1;
        foreach ($list_akun as $akun) {
            foreach ($list_bmn as $bmn) {
                if ($bmn['akun_id'] == $ke) {
                    $all[$ke][] = $bmn;
                    if ($all[$ke] != null) {
                        $data_akun['all'][$ke] = count($all[$ke]);
                    } else {
                        $data_akun['all'][$ke] = 0;
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



            if (session('level_id') == '3') {
                $check_null_akun = $this->masterBmnModel->getBmnByIdAkunBySatker($ke, session('satker_id'));
                if ($check_null_akun == null) {
                    $data_akun['all'][$ke] = 0;
                    $data_akun['belum'][$ke] = 0;
                    $data_akun['sudah'][$ke] = 0;
                }
            }

            $ke++;
        }
        // dd($data_akun);
        if ($satker_id == 'all') {
            $nama_satker['nama_ref_unit_kerja_lengkap'] = 'semua';
        } else {
            $nama_satker = $this->masterSatkerModel->getNamaSatker($satker_id);
        }


        $data = [
            'data_bmn' => $data_akun,
            'nama_satker' => $nama_satker['nama_ref_unit_kerja_lengkap']
        ];
        echo json_encode($data);
    }

    public function listBmnOnDashboard($tipe, $akun_id, $satker_id)
    {

        if ($satker_id == 'Semua') {
            $list_bmn = $this->masterBmnModel->getBmnByIdAkun($akun_id);
        } else {
            $list_bmn = $this->masterBmnModel->getBmnByIdAkunSatkerId($akun_id, $satker_id);
        }

        $data_bmn = null;
        if ($list_bmn != null) {
            if ($tipe == 'semua') {
                $data_bmn = $list_bmn;
            } else if ($tipe == 'belum') {
                foreach ($list_bmn as $bmn) {
                    if ($bmn['kondisi_brg'] == null) {
                        $data_bmn[] = $bmn;
                    }
                }
            } else if ($tipe == 'sudah') {
                foreach ($list_bmn as $bmn) {
                    if ($bmn['kondisi_brg'] != null) {
                        $data_bmn[] = $bmn;
                    }
                }
            }
        } else {
            $data_bmn = null;
        }

        $data = [
            'title' => 'List Barang',
            'menu' => 'Dashboard',
            'subMenu' => '',
            'halaman' => 'dashboard',
            'list_bmn' => $data_bmn,
            'satker_id' => $satker_id
        ];

        return view('dashboard/listdetail', $data);
    }
    public function detailBmnOnDashboard($id_bmn)
    {
        $data_bmn = $this->masterBmnModel->getDataBmnById($id_bmn);
        $data = [
            'title' => 'Detail Barang',
            'menu' => 'Dashboard',
            'subMenu' => '',
            'halaman' => 'dashboard',
            'bmn' => $data_bmn
        ];

        return view('dashboard/detail', $data);
    }
}
