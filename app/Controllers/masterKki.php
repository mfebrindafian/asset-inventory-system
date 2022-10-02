<?php

namespace App\Controllers;

class masterKki extends BaseController
{
    public function __construct()
    {
    }

    public function listkki()
    {
        return view('kki/importkki');
    }
    public function detailkki()
    {
        return view('kki/detailkki');
    }
}
