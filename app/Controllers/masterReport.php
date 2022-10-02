<?php

namespace App\Controllers;

class masterReport extends BaseController
{
    public function __construct()
    {
    }

    public function rekapitulasi()
    {
        return view('report/rekapitulasi');
    }
    public function inventariasasi()
    {
        return view('report/inventarisasi');
    }
}
