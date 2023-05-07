<?php

namespace App\Controllers;

use App\Models\masterGedungModel;
use App\Models\masterLokasiModel;


class masterData extends BaseController
{

    protected $masterGedungModel;
    protected $masterLokasiModel;
    public function __construct()
    {
        $this->masterGedungModel = new MasterGedungModel();
        $this->masterLokasiModel = new MasterLokasiModel();
    }

    public function gedung()
    {

        $list_gedung = $this->masterGedungModel->getAllGedung();

        $list_lokasi = $this->masterLokasiModel->getAllLokasi();

        $data = [
            'list_gedung' => $list_gedung,
            'list_lokasi' => $list_lokasi,
            'halaman' => 'masterData',
            'title' => 'Daftar Gedung',
            'menu' => 'Master Data',
            'subMenu' => 'Gedung',
            'list_level' => session('list_user_level'),

        ];

        return view('masterData/gedung', $data);
    }

    public function tambahGedung()
    {
        $nama_gedung = $this->request->getVar('nama_gedung');
        $id_lokasi = $this->request->getVar('id_lokasi');

        $this->masterGedungModel->save([
            'nama_gedung' => $nama_gedung,
            'id_lokasi' => $id_lokasi
        ]);
        return redirect()->to('/kelola-gedung');
    }

    public function editGedung()
    {
        $id_gedung = $this->request->getVar('id_gedung');
        $nama_gedung = $this->request->getVar('nama_gedung');
        $id_lokasi = $this->request->getVar('id_lokasi');

        $this->masterGedungModel->save([
            'id' => $id_gedung,
            'nama_gedung' => $nama_gedung,
            'id_lokasi' => $id_lokasi
        ]);
        return redirect()->to('/kelola-gedung');
    }

    public function hapusGedung()
    {
        $id_gedung = $this->request->getVar('id_gedung');
        $this->masterGedungModel->delete($id_gedung);
        return redirect()->to('/kelola-gedung');
    }


    public function ruangan()
    {

        $data = [
            'halaman' => 'masterData',
            'title' => 'Daftar Ruangan',
            'menu' => 'Master Data',
            'subMenu' => 'Ruangan',
            'list_level' => session('list_user_level'),

        ];

        return view('masterData/ruangan', $data);
    }

    public function satker()
    {

        $data = [
            'halaman' => 'masterData',
            'title' => 'Daftar Satuan Unit Kerja',
            'menu' => 'Master Data',
            'subMenu' => 'Satker',
            'list_level' => session('list_user_level'),

        ];

        return view('masterData/satker', $data);
    }
}
