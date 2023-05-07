<?php

namespace App\Controllers;

use App\Models\MasterUserModel;
use App\Models\MasterPegawaiModel;
use App\Models\MasterAksesUserLevelModel;
use App\Models\MasterSatkerModel;

class masterUser extends BaseController
{
    protected $masterUserModel;
    protected $masterPegawaiModel;
    protected $masterAksesUserLevelModel;
    protected $masterSatkerModel;

    public function __construct()
    {
        $this->masterUserModel = new masterUserModel();
        $this->masterPegawaiModel = new masterPegawaiModel();
        $this->masterAksesUserLevelModel = new masterAksesUserLevelModel();
        $this->masterSatkerModel = new masterSatkerModel();
    }

    public function masterUser()
    {
        $list_akses = $this->masterAksesUserLevelModel->getAllAkses();
        $unit_kerja = [];
        if ($list_akses != null) {
            foreach ($list_akses as $list) {
                if ($list['satker_id'] != null) {
                    $unit_kerja[] = implode($this->masterSatkerModel->getNamaSatker($list['satker_id']));
                } else {
                    $unit_kerja[] = '';
                }
            }
        }

        $list_user = [];
        if ($list_akses != null) {
            foreach ($list_akses as $list) {
                $list_user[] = $this->masterUserModel->getUserByUserId($list['user_id']);
            }
        }

        $data_unit_kerja = $this->masterSatkerModel->getAllSatker();

        $data = [
            'daftar_unit_kerja' => $data_unit_kerja,
            'list_akses' => $list_akses,
            'list_unit_kerja' => $unit_kerja,
            'list_user' => $list_user,
            'halaman' => 'user',
            'title' => 'Daftar User',
            'menu' => 'Role User',
            'subMenu' => '',
            'list_level' => session('list_user_level'),

        ];

        return view('kelolaMaster/masterUser', $data);
    }

    public function APIUser()

    {
        $nama_pegawai = $this->request->getPost('nama_pegawai');
        $list_pegawai = $this->masterPegawaiModel->getAllPegawaiByName($nama_pegawai);

        return json_encode($list_pegawai);
    }
}
