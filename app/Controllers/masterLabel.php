<?php

namespace App\Controllers;

class masterLabel extends BaseController
{
    public function __construct()
    {
    }

    public function label()
    {
        $data = [
            'halaman' => 'carilabel'
        ];
        return view('label/carilabel', $data);
    }
    public function detaillabel()
    {
        $data = [
            'halaman' => 'detaillabel'
        ];
        return view('label/detaillabel', $data);
    }
}
