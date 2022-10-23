<?php

namespace App\Controllers;

class masterReport extends BaseController
{
    public function __construct()
    {
    }

    public function rekapitulasi()
    {
        $data = [
            'title' => 'Rekapitulasi',
            'menu' => 'Report',
            'subMenu' => 'Rekapitulasi',
            'halaman' => 'rekapitulasi'
        ];
        return view('report/rekapitulasi', $data);
    }
    public function inventarisasi()
    {
        $data = [
            'title' => 'Inventarisasi',
            'menu' => 'Report',
            'subMenu' => 'Inventarisasi',
            'halaman' => 'inventarisasi'
        ];
        return view('report/inventarisasi', $data);
    }
}
