<?php

namespace App\Controllers;

class masterInventarisasi extends BaseController
{
    public function __construct()
    {
    }

    public function pmNonTik()
    {
        $data = [
            'halaman' => 'pmnontik'
        ];
        return view('inventarisasi/pmnontik', $data);
    }
    public function pmTik()
    {
        $data = [
            'halaman' => 'pmtik'
        ];
        return view('inventarisasi/pmtik', $data);
    }
    public function atb()
    {
        $data = [
            'halaman' => 'atb'
        ];
        return view('inventarisasi/atb', $data);
    }
    public function atl()
    {
        $data = [
            'halaman' => 'atl'
        ];
        return view('inventarisasi/atl', $data);
    }
    public function kertaskerja()
    {
        $data = [
            'halaman' => 'isikertaskerja'
        ];
        return view('inventarisasi/isikertaskerja', $data);
    }
}
