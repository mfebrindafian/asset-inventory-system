<?php

namespace App\Controllers;

class masterKki extends BaseController
{
    public function __construct()
    {
    }

    public function listkki()
    {
        $data = [
            'halaman' => 'kki'
        ];
        return view('kki/importkki', $data);
    }
    public function detailkki()
    {
        $data = [
            'halaman' => 'kki'
        ];
        return view('kki/detailkki', $data);
    }
}
