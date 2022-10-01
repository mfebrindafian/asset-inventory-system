<?php

namespace App\Controllers;




use App\Models\MasterUserModel;
use App\Models\MasterSatkerModel;
use CodeIgniter\I18n\Time;


class masterDashboard extends BaseController
{
    protected $masterUserModel;
    protected $masterSatkerModel;

    public function __construct()
    {

        $this->masterUserModel = new masterUserModel();
        $this->masterSatkerModel = new MasterSatkerModel();
    }

    public function index()
    {
        $data = [
            'halaman' => 'dashboard'
        ];
        return view('dashboard/dashboard', $data);
    }
}
