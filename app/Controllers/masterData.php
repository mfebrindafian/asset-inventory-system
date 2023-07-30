<?php

namespace App\Controllers;

use App\Models\masterGedungModel;
use App\Models\masterLokasiModel;
use App\Models\masterRuanganModel;
use App\Models\masterSatkerModel;
use App\Models\masterSubsatkerModel;



class masterData extends BaseController
{

    protected $masterGedungModel;
    protected $masterLokasiModel;
    protected $masterRuanganModel;
    protected $masterSatkerModel;
    protected $masterSubsatkerModel;


    public function __construct()
    {
        $this->masterGedungModel = new MasterGedungModel();
        $this->masterLokasiModel = new MasterLokasiModel();
        $this->masterRuanganModel = new MasterRuanganModel();
        $this->masterSatkerModel = new MasterSatkerModel();
        $this->masterSubsatkerModel = new MasterSubsatkerModel();
    }

    public function gedung()
    {

        $list_gedung = $this->masterGedungModel->getAllGedung();
        $list_lokasi = $this->masterLokasiModel->getAllLokasi();
        $list_satker = $this->masterSatkerModel->getAllSatker();

        $data = [
            'list_gedung' => $list_gedung,
            'list_lokasi' => $list_lokasi,
            'halaman' => 'masterData',
            'title' => 'Daftar Gedung',
            'menu' => 'Master Data',
            'subMenu' => 'Gedung',
            'list_level' => session('list_user_level'),
            'list_satker' => $list_satker,

        ];

        return view('masterData/gedung', $data);
    }

    public function tambahGedung()
    {
        $nama_gedung = $this->request->getVar('nama_gedung');
        $id_lokasi = $this->request->getVar('id_lokasi');
        $satker_id = $this->request->getVar('satker');

        $this->masterGedungModel->save([
            'nama_gedung' => $nama_gedung,
            'id_lokasi' => $id_lokasi,
            'satker_id' => $satker_id
        ]);
        return redirect()->to('/kelola-gedung');
    }

    public function editGedung()
    {
        $id_gedung = $this->request->getVar('id_gedung');
        $nama_gedung = $this->request->getVar('nama_gedung');
        $id_lokasi = $this->request->getVar('id_lokasi');
        $satker_id = $this->request->getVar('satker');

        $this->masterGedungModel->save([
            'id' => $id_gedung,
            'nama_gedung' => $nama_gedung,
            'id_lokasi' => $id_lokasi,
            'satker_id' => $satker_id
        ]);
        return redirect()->to('/kelola-gedung');
    }

    public function hapusGedung()
    {
        $id_gedung = $this->request->getVar('id_gedung_hapus');
        $this->masterGedungModel->delete($id_gedung);
        return redirect()->to('/kelola-gedung');
    }


    public function ruangan()
    {
        $nama_satker = $this->masterSatkerModel->getNamaSatker(session('satker_id'));
        $list_ruangan = $this->masterRuanganModel->getAllRuanganBySatker(session('satker_id'));
        $list_gedung = $this->masterGedungModel->getAllGedungBySatker(session('satker_id'));
        $data = [
            'list_gedung' => $list_gedung,
            'list_ruangan' => $list_ruangan,
            'halaman' => 'masterData',
            'title' => 'Daftar Ruangan',
            'menu' => 'Master Data',
            'subMenu' => 'Ruangan',
            'list_level' => session('list_user_level'),
            'nama_satker' => $nama_satker['nama_ref_unit_kerja_lengkap'],

        ];
        // dd($data);

        return view('masterData/ruangan', $data);
    }

    public function tambahRuangan()
    {
        $nama_ruangan = $this->request->getVar('nama_ruangan');
        $kapasitas = $this->request->getVar('kapasitas');
        $id_gedung = $this->request->getVar('id_gedung');


        $this->masterRuanganModel->save([
            'nama_ruang' => $nama_ruangan,
            'kapasitas' => $kapasitas,
            'id_gedung' => $id_gedung,
            'satker_id' => session('satker_id')
        ]);
        return redirect()->to('/kelola-ruangan');
    }

    public function editRuangan()
    {
        $id_ruangan = $this->request->getVar('id_ruangan');
        $nama_ruangan = $this->request->getVar('nama_ruangan');
        $kapasitas = $this->request->getVar('kapasitas');
        $id_gedung = $this->request->getVar('id_gedung');


        $this->masterRuanganModel->save([
            'id' => $id_ruangan,
            'nama_ruang' => $nama_ruangan,
            'kapasitas' => $kapasitas,
            'id_gedung' => $id_gedung,
            'satker_id' => session('satker_id')
        ]);
        return redirect()->to('/kelola-ruangan');
    }


    public function hapusRuangan()
    {
        $id_ruangan = $this->request->getVar('id_ruangan_hapus');
        $this->masterRuanganModel->delete($id_ruangan);
        return redirect()->to('/kelola-ruangan');
    }
    public function subsatker()
    {
        $nama_satker = $this->masterSatkerModel->getNamaSatker(session('satker_id'));
        $list_subsatker = $this->masterSubsatkerModel->getAllSubsatkerBySatker(session('satker_id'));

        $data = [
            'halaman' => 'masterData',
            'title' => 'Daftar Satuan Unit Kerja',
            'menu' => 'Master Data',
            'subMenu' => 'Satker',
            'list_level' => session('list_user_level'),
            // 'list_satker' => $list_satker,
            'list_subsatker' => $list_subsatker,
            'nama_satker' => $nama_satker['nama_ref_unit_kerja_lengkap'],
        ];

        return view('masterData/subsatker', $data);
    }

    public function tambahSubsatker()
    {
        $nama_subsatker = $this->request->getVar('nama_subsatker');
        $this->masterSubsatkerModel->save([
            'nama_subsatker' => $nama_subsatker,
            'satker_id' => session('satker_id')
        ]);

        return redirect()->to('/kelola-subsatker');
    }

    public function editSubsatker()
    {
        $nama_subsatker = $this->request->getVar('nama_subsatker');
        $id_subsatker = $this->request->getVar('id_subsatker');
        $this->masterSubsatkerModel->save([
            'id' => $id_subsatker,
            'nama_subsatker' => $nama_subsatker,
            'satker_id' => session('satker_id')
        ]);

        return redirect()->to('/kelola-subsatker');
    }

    public function hapusSubsatker()
    {
        $id_subsatker = $this->request->getVar('id_subsatker_hapus');
        $this->masterSubsatkerModel->delete($id_subsatker);
        return redirect()->to('/kelola-subsatker');
    }
}
