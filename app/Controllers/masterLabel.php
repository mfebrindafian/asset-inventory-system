<?php

namespace App\Controllers;

use App\Models\masterTabelBmnModel;
use App\Models\masterTabelAkunModel;
use App\Models\masterSatkerModel;

class masterLabel extends BaseController
{
    protected $masterBmnModel;
    protected $masterAkunModel;
    protected $masterSatkerModel;
    public function __construct()
    {
        $this->masterBmnModel = new MasterTabelBmnModel();
        $this->masterAkunModel = new MasterTabelAkunModel();
        $this->masterSatkerModel = new MasterSatkerModel();
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
        $satker = $this->masterSatkerModel->getNamaSatker($data_bmn['satker_id']);

        $data = [
            'title' => 'Detail Label',
            'menu' => 'Cetak Label',
            'subMenu' => '',
            'halaman' => 'detaillabel',
            'bmn' => $data_bmn,
            'nama_satker' => $satker['nama_satker']
        ];
        // dd($data);
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
