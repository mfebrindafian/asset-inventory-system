<?php

namespace App\Controllers;

use App\Models\MasterUserModel;
use App\Models\MasterPegawaiModel;

class masterUser extends BaseController
{
    protected $masterUserModel;
    protected $masterPegawaiModel;

    public function __construct()
    {
        $this->masterUserModel = new masterUserModel();
        $this->masterPegawaiModel = new masterPegawaiModel();
    }

    public function masterUser()
    {

        $data = [
            'halaman' => 'user',
            'title' => 'Daftar User',
            'menu' => 'Role User',
            'subMenu' => '',
            'list_level' => session('list_user_level'),

        ];

        return view('kelolaMaster/masterUser', $data);
    }
}
