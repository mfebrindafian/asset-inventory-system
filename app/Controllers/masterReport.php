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
            'halaman' => 'rekapitulasi'
        ];
        return view('report/rekapitulasi', $data);
    }
    public function inventarisasi()
    {
        $data = [
            'halaman' => 'inventarisasi'
        ];
        return view('report/inventarisasi', $data);
    }
}
