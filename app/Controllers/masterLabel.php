<?php

namespace App\Controllers;

class masterLabel extends BaseController
{
    public function __construct()
    {
    }

    public function label()
    {
        return view('label/carilabel');
    }
    public function detailkki()
    {
        return view('label/detaillabel');
    }
}
