<?php

namespace App\Controllers;

use App\Models\MasterUserModel;
use App\Models\MasterAksesUserLevelModel;


class masterAkses extends BaseController
{
    protected $masterUserModel;
    protected $masterAksesUserLevelModel;

    public function __construct()
    {
        $this->masterUserModel = new masterUserModel();
        $this->masterAksesUserLevelModel = new masterAksesUserLevelModel();
    }

    public function index()
    {
        return view('siphp/login');
    }

    public function open()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $user = $this->masterUserModel->getUser($username);


        $pass_default =  password_hash('123456', PASSWORD_DEFAULT);



        if ($user == NULL) {
            session()->setFlashdata('pesan', 'Username Anda Salah');
            session()->setFlashdata('icon', 'error');
            return redirect()->to('/');
        }


        $list_user_level = $this->masterAksesUserLevelModel->getUserLevel($user['id']);
        $level_id = $list_user_level[count($list_user_level) - 1]['level_id'];
        $list_menu = $this->masterAksesUserLevelModel->getAksesMenu($level_id, $user['id']);
        $list_submenu = $this->masterAksesUserLevelModel->getAksesSubmenu($level_id, $user['id']);
        if (password_verify($password, $user['password'])) {

            if (password_verify($password, $pass_default)) {
                $alert = false;
                $data = [
                    'alert' => $alert,
                    'data_user' => $user
                ];
                return view('siphp/gantiPassword', $data);
            }


            if ($user['is_active'] == 'Y') {
                $data = [
                    'log' => TRUE,
                    'user_id' => $user['id'],
                    'level_id' => $level_id,
                    'list_user_level' => $list_user_level,
                    'list_menu'  => $list_menu,
                    'list_submenu' => $list_submenu,
                    'fullname' => $user['fullname'],
                    'data_user' => $user
                ];
            } else {
                session()->setFlashdata('pesan', 'Akun Tidak Aktif');
                session()->setFlashdata('icon', 'error');
                return redirect()->to('/');
            }




            session()->set($data);
            session()->setFlashdata('pesan', 'berhasil login');
            return redirect()->to('/dashboard');
        }
        session()->setFlashdata('pesan', 'Password salah');
        session()->setFlashdata('icon', 'error');
        return redirect()->to('/');
    }

    public function switchLevel()
    {
        $id = $this->request->getVar('id');

        $list_menu = $this->masterAksesUserLevelModel->getAksesMenu($id, session('user_id'));
        $list_submenu = $this->masterAksesUserLevelModel->getAksesSubmenu($id, session('user_id'));

        $data1 = [
            'log' => TRUE,
            'user_id' => session('user_id'),
            'level_id' => $id,
            'list_user_level' => session('list_user_level'),
            'list_menu'  => $list_menu,
            'list_submenu' => $list_submenu,
            'fullname' => session('fullname'),
            'data_user' => session('data_user')

        ];

        session()->set($data1);


        return redirect()->to('/dashboard');
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
