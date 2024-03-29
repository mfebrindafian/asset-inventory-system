<?php

namespace App\Controllers;

use App\Models\MasterUserModel;
use App\Models\MasterPegawaiModel;
use App\Models\MasterAksesUserLevelModel;
use App\Models\MasterUserLevelModel;


class masterAkses extends BaseController
{
    protected $masterUserModel;
    protected $masterPegawaiModel;
    protected $masterAksesUserLevelModel;
    protected $masterUserLevelModel;

    public function __construct()
    {
        $this->masterUserModel = new masterUserModel();
        $this->masterPegawaiModel = new masterPegawaiModel();
        $this->masterAksesUserLevelModel = new masterAksesUserLevelModel();
        $this->masterUserLevelModel = new masterUserLevelModel();
    }

    public function index()
    {
        return view('login/login');
    }

    public function open()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        //ini merupakan pengkondisian sementara yang digunakan untuk mengakses sistem pertama kali ketika belum ada pegawai yang ditunjuk akses nya menjadi super admin
        if ($username == '' && $password == '') {
            $level_id = '1';
            $list_menu = $this->masterUserLevelModel->getAksesMenu($level_id);
            $list_submenu = $this->masterUserLevelModel->getAksesSubmenu($level_id);
            $list_user_level[0] = [
                'id' => '0',
                'user_id' => '0',
                'level_id' => '1',
                'satker_id' => null,
                'nama_level' => 'super admin'
            ];
            $data = [
                'log' => TRUE,
                'user_id' => '0',
                'level_id' => $level_id,
                'list_user_level' => $list_user_level,
                'satker_id' => 0,
                'list_menu'  => $list_menu,
                'list_submenu' => $list_submenu,
                'data_user' => null,
                'nama_pegawai' => 'adminsementara'
            ];


            session()->set($data);
            session()->setFlashdata('pesan', 'berhasil login');
            return redirect()->to('/dashboard-sibamira');
        }
        //batas pengkondisian sementara

        $user = $this->masterUserModel->getUser($username);
        if ($user == NULL) {
            session()->setFlashdata('pesan', 'Username dan password tidak sesuai!');
            session()->setFlashdata('icon', 'error');
            return redirect()->to('/');
        }
        $list_user_level = $this->masterAksesUserLevelModel->getUserLevel($user['id']);
        $level_id = $list_user_level[count($list_user_level) - 1]['level_id'];
        if ($level_id == 3) {
            $satker_id = $this->masterAksesUserLevelModel->getSatkerId($user['id']);
        } else {
            $satker_id['satker_id'] = 0;
        }
        $list_menu = $this->masterAksesUserLevelModel->getAksesMenu($level_id, $user['id']);
        $list_submenu = $this->masterAksesUserLevelModel->getAksesSubmenu($level_id, $user['id']);

        $data_pegawai = $this->masterPegawaiModel->getDataPegawai($user['nip']);
        $nama_pegawai = $data_pegawai['gelar_depan'];
        if ($data_pegawai['gelar_depan'] != null) {
            $nama_pegawai .= ' ';
        }
        $nama_pegawai .= $data_pegawai['nama_pegawai'];
        if ($data_pegawai['gelar_belakang'] != null) {
            $nama_pegawai .= ' ';
        }
        $nama_pegawai .= $data_pegawai['gelar_belakang'];
        if (password_verify($password, $user['password'])) {
            $data = [
                'log' => TRUE,
                'user_id' => $user['id'],
                'level_id' => $level_id,
                'list_user_level' => $list_user_level,
                'satker_id' => $satker_id['satker_id'],
                'list_menu'  => $list_menu,
                'list_submenu' => $list_submenu,
                'data_user' => $user,
                'nama_pegawai' => $nama_pegawai
            ];
            session()->set($data);
            session()->setFlashdata('pesan', 'berhasil login');
            return redirect()->to('/dashboard-sibamira');
        }
        session()->setFlashdata('pesan', 'Username dan password tidak sesuai!');
        session()->setFlashdata('icon', 'error');
        return redirect()->to('/');
    }

    public function switchLevel()
    {
        $id = $this->request->getVar('id');
        $list_menu = $this->masterAksesUserLevelModel->getAksesMenu($id, session('user_id'));
        $list_submenu = $this->masterAksesUserLevelModel->getAksesSubmenu($id, session('user_id'));
        if ($id == 3) {
            $satker_id = $this->masterAksesUserLevelModel->getSatkerId(session('user_id'));
        } else {
            $satker_id['satker_id'] = 0;
        }
        $data1 = [
            'log' => TRUE,
            'user_id' => session('user_id'),
            'level_id' => $id,
            'list_user_level' => session('list_user_level'),
            'list_menu'  => $list_menu,
            'list_submenu' => $list_submenu,
            'fullname' => session('fullname'),
            'data_user' => session('data_user'),
            'satker_id' => $satker_id['satker_id'],

        ];

        session()->set($data1);


        return redirect()->to('/dashboard-sibamira');
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        session()->setFlashdata('pesan', 'Berhasil Logout');
        session()->setFlashdata('icon', 'success');
        return redirect()->to('/');
    }
}
