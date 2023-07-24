<?php

namespace App\Controllers;

use App\Models\masterTabelBmnModel;
use App\Models\masterTabelAkunModel;
use App\Models\masterSatkerModel;
use App\Models\masterPegawaiModel;
use App\Models\masterGedungModel;
use App\Models\masterRuanganModel;
use App\Models\masterSubsatkerModel;

class masterLabel extends BaseController
{
    protected $masterBmnModel;
    protected $masterAkunModel;
    protected $masterSatkerModel;
    protected $masterPegawaiModel;
    protected $masterGedungModel;
    protected $masterRuanganModel;
    protected $masterSubsatkerModel;
    public function __construct()
    {
        $this->masterBmnModel = new MasterTabelBmnModel();
        $this->masterAkunModel = new MasterTabelAkunModel();
        $this->masterSatkerModel = new MasterSatkerModel();
        $this->masterPegawaiModel = new MasterPegawaiModel();
        $this->masterGedungModel = new MasterGedungModel();
        $this->masterRuanganModel = new MasterRuanganModel();
        $this->masterSubsatkerModel = new MasterSubsatkerModel();
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
        $list_pegawai = $this->masterPegawaiModel->getAllPegawai();
        $list_gedung = $this->masterGedungModel->getAllGedung();
        $list_ruangan = $this->masterRuanganModel->getAllRuangan();
        $list_subsatker = $this->masterSubsatkerModel->getAllSubsatker();
        $data_bmn = $this->masterBmnModel->getDataBmnById($id_bmn);
        $satker = $this->masterSatkerModel->getNamaSatker($data_bmn['satker_id']);

        $data = [
            'title' => 'Detail Label',
            'menu' => 'Cetak Label',
            'subMenu' => '',
            'halaman' => 'detaillabel',
            'bmn' => $data_bmn,
            'list_pegawai' => $list_pegawai,
            'list_gedung' => $list_gedung,
            'list_ruangan' => $list_ruangan,
            'list_subsatker' => $list_subsatker,
            'nama_satker' => $satker['nama_ref_unit_kerja_lengkap']
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
