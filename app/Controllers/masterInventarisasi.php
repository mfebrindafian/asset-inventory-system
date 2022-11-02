<?php

namespace App\Controllers;

use App\Models\masterTabelBmnModel;
use App\Models\masterSatkerModel;

class masterInventarisasi extends BaseController
{
    protected $masterBmnModel;
    protected $masterSatkerModel;

    public function __construct()
    {
        $this->masterBmnModel = new MasterTabelBmnModel();
        $this->masterSatkerModel = new MasterSatkerModel();
    }

    public function pmNonTik()
    {
        $satker_id = session('satker_id');
        $list_bmn = $this->masterBmnModel->getListBmnBySatkerId($satker_id);
        $pmnontik = null;
        foreach ($list_bmn as $bmn) {
            if ($bmn['akun_id'] == 1) {
                $pmnontik[] = $bmn;
            }
        }
        $data = [
            'title' => 'PM NON TIK',
            'menu' => 'Inventarisasi',
            'subMenu' => 'PM NON TIK',
            'halaman' => 'pmnontik',
            'list_pmnontik' => $pmnontik
        ];

        return view('inventarisasi/pmnontik', $data);
    }
    public function pmTik()
    {
        $satker_id = session('satker_id');
        $list_bmn = $this->masterBmnModel->getListBmnBySatkerId($satker_id);
        $pmtik = null;
        foreach ($list_bmn as $bmn) {
            if ($bmn['akun_id'] == 2) {
                $pmtik[] = $bmn;
            }
        }
        $data = [
            'title' => 'PM TIK',
            'menu' => 'Inventarisasi',
            'subMenu' => 'PM TIK',
            'halaman' => 'pmtik',
            'list_pmtik' => $pmtik
        ];

        return view('inventarisasi/pmtik', $data);
    }
    public function atb()
    {
        $satker_id = session('satker_id');
        $list_bmn = $this->masterBmnModel->getListBmnBySatkerId($satker_id);
        $atb = null;
        foreach ($list_bmn as $bmn) {
            if ($bmn['akun_id'] == 3) {
                $atb[] = $bmn;
            }
        }
        $data = [
            'title' => 'ATB',
            'menu' => 'Inventarisasi',
            'subMenu' => 'ATB',
            'halaman' => 'atb',
            'list_atb' => $atb
        ];

        return view('inventarisasi/atb', $data);
    }
    public function atl()
    {
        $satker_id = session('satker_id');
        $list_bmn = $this->masterBmnModel->getListBmnBySatkerId($satker_id);
        $atl = null;
        foreach ($list_bmn as $bmn) {
            if ($bmn['akun_id'] == 4) {
                $atl[] = $bmn;
            }
        }
        $data = [
            'title' => 'ATL',
            'menu' => 'Inventarisasi',
            'subMenu' => 'ATL',
            'halaman' => 'atl',
            'list_atl' => $atl
        ];
        return view('inventarisasi/atl', $data);
    }
    public function kertaskerja($id_bmn)
    {

        $data_bmn = $this->masterBmnModel->getDataBmnById($id_bmn);
        $nama_satker = $this->masterSatkerModel->getNamaSatker($data_bmn['satker_id']);

        $data = [
            'title' => 'Isi Kertas Kerja',
            'menu' => 'Inventarisasi',
            'subMenu' => '',
            'halaman' => 'isikertaskerja',
            'bmn' => $data_bmn,
            'nama_satker' => $nama_satker['nama_satker']
        ];
        return view('inventarisasi/isikertaskerja', $data);
    }

    public function editkertaskerja()
    {
        $id_bmn = $this->request->getVar('id_bmn');
        $tipe_akun = preg_replace('/[^A-Za-z0-9\-\(\) ]/', '', strtolower($this->request->getVar('tipe_akun')));

        $kondisi_brg = $this->request->getVar('kondisi-barang');
        $kbrdn_brg = $this->request->getVar('keberadaan-barang');
        $pelabelan = $this->request->getVar('pelabelan');
        $status_psp = $this->request->getVar('status-psp');

        $ket = $this->request->getVar('ket');

        $this->masterBmnModel->save([
            'id' => $id_bmn,
            'kondisi_brg' => $kondisi_brg,
            'kbrdn_brg' => $kbrdn_brg,
            'label_kode' => $pelabelan,
            'status_psp' => $status_psp,
            'ket' => $ket
        ]);

        return redirect()->to('/inv-' . $tipe_akun);
    }
}
