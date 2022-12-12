<?php

namespace App\Controllers;


class masterData extends BaseController
{

    public function __construct()
    {
    }

    public function gedung()
    {

        $data = [
            'halaman' => 'masterData',
            'title' => 'Daftar Gedung',
            'menu' => 'Master Data',
            'subMenu' => 'Gedung',
            'list_level' => session('list_user_level'),

        ];

        return view('masterData/gedung', $data);
    }



    public function ruangan()
    {

        $data = [
            'halaman' => 'masterData',
            'title' => 'Daftar Ruangan',
            'menu' => 'Master Data',
            'subMenu' => 'Ruangan',
            'list_level' => session('list_user_level'),

        ];

        return view('masterData/ruangan', $data);
    }

    public function satker()
    {

        $data = [
            'halaman' => 'masterData',
            'title' => 'Daftar Satuan Unit Kerja',
            'menu' => 'Master Data',
            'subMenu' => 'Satker',
            'list_level' => session('list_user_level'),

        ];

        return view('masterData/satker', $data);
    }
}
