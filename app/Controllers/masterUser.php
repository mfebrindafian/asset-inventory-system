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


        $data = [
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
        $nama_pegawai = $this->request->getVar("nama_pegamai");
        $list_pegawai = $this->masterPegawaiModel->getAllPegawaiByName($nama_pegawai);

        echo json_encode($list_pegawai);
    }

    public function APIEditUser($user_id)
    {

        $data_user['data_pegawai'] = $this->masterUserModel->getUserByUserId($user_id);
        $data_user['level'] = $this->masterAksesUserLevelModel->getAllAksesByUserId($user_id);

        echo json_encode($data_user);
    }

    public function tambahUser()
    {
        $level_id = $this->request->getVar('level_id');
        $user_id = $this->request->getVar('user_id');
        $id_ref_unit_kerja = $this->request->getVar('id_ref_unit_kerja');


        $this->masterAksesUserLevelModel->save([
            'user_id' => $user_id,
            'level_id' => $level_id,
            'satker_id' => $id_ref_unit_kerja
        ]);

        return redirect()->to('/user');
    }

    public function editUser()
    {
        $id_user = $this->request->getVar('id_user');
        $level_id = $this->request->getVar('level_id');
        $user_id = $this->request->getVar('user_id');
        $id_ref_unit_kerja = $this->request->getVar('id_ref_unit_kerja');


        $this->masterAksesUserLevelModel->save([
            'id' => $id_user,
            'user_id' => $user_id,
            'level_id' => $level_id,
            'satker_id' => $id_ref_unit_kerja
        ]);

        return redirect()->to('/user');
    }

    public function hapusUser()
    {
        $user_id = $this->request->getVar('id_user');



        return redirect()->to('/user');
    }
}
