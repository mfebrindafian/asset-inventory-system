<?php

namespace App\Controllers;

use App\Models\masterTabelBmnModel;
use App\Models\masterTabelAkunModel;

class masterLabel extends BaseController
{
    protected $masterBmnModel;
    protected $masterAkunModel;
    public function __construct()
    {
        $this->masterBmnModel = new MasterTabelBmnModel();
        $this->masterAkunModel = new MasterTabelAkunModel();
    }

    public function label()
    {
        $list_bmn = $this->masterBmnModel->getAllBmnBySatker(session('satker_id'));

        $data = [
            'title' => 'Labelisasi',
            'menu' => 'Cetak Label',
            'subMenu' => '',
            'halaman' => 'carilabel',
            'list_bmn' => $list_bmn
        ];

        return view('label/carilabel', $data);
    }
    public function detaillabel($id_bmn)
    {
        $data_bmn = $this->masterBmnModel->getDataBmnById($id_bmn);
        $data = [
            'title' => 'Detail Label',
            'menu' => 'Cetak Label',
            'subMenu' => '',
            'halaman' => 'detaillabel',
            'bmn' => $data_bmn
        ];

        return view('label/detaillabel', $data);
    }
    public function updateStatusLabel($id_bmn)
    {
        $this->masterBmnModel->save([
            'id' => $id_bmn,
            'label_kode' => 'S',
        ]);
        return redirect()->to('/detail-label/' . $id_bmn);
    }
}
