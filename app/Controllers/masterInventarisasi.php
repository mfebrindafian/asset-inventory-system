<?php

namespace App\Controllers;

class masterInventarisasi extends BaseController
{
    public function __construct()
    {
    }

    public function pmNonTik()
    {
        return view('inventarisasi/pmnontik');
    }
    public function pmTik()
    {
        return view('inventarisasi/pmtik');
    }
    public function atb()
    {
        return view('inventarisasi/atb');
    }
    public function atl()
    {
        return view('inventarisasi/atl');
    }
    public function kertaskerja()
    {
        return view('inventarisasi/isikertaskerja');
    }
}
