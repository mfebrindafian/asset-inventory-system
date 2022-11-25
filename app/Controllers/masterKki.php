<?php

namespace App\Controllers;

use App\Models\masterTabelBmnModel;
use App\Models\masterTabelAkunModel;
use App\Models\masterTabelBarangModel;
use App\Models\masterSatkerModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class masterKki extends BaseController
{
    protected $masterTabelBmnModel;
    protected $masterTabelAkunModel;
    protected $masterTabelBarangModel;
    protected $masterSatkerModel;
    public function __construct()
    {
        $this->masterTabelBmnModel = new masterTabelBmnModel();
        $this->masterTabelAkunModel = new masterTabelAkunModel();
        $this->masterTabelBarangModel = new masterTabelBarangModel();
        $this->masterSatkerModel = new masterSatkerModel();
    }

    public function listkki()
    {
        $list_satker = $this->masterSatkerModel->getAllSatker();
        $list_bmn = $this->masterTabelBmnModel->getListBmn();

        if ($list_bmn != null) {
            foreach ($list_bmn as $bmn) {
                $satker = $this->masterSatkerModel->getNamaSatker($bmn['satker_id']);
                $data_batch[] = [
                    'kd_batch' => $bmn['kd_batch'],
                    'jml_perKdBatch' => count($this->masterTabelBmnModel->getJmlBatch($bmn['kd_batch'])),
                    'nama_satker' => $satker['nama_ref_unit_kerja_lengkap']
                ];
            }
        } else {
            $data_batch = null;
        }

        $data = [
            'title' => 'Import KKI',
            'menu' => 'Import KKI',
            'subMenu' => '',
            'halaman' => 'kki',
            'list_kki' => $data_batch,
            'list_satker' => $list_satker
        ];
        return view('kki/importkki', $data);
    }
    public function detailkki($kd_batch)
    {
        $data_batch = $this->masterTabelBmnModel->getDataBatch($kd_batch);
        $list_akun = $this->masterTabelAkunModel->getAllAkun();
        $urBatch = 0;
        if ($data_batch != null) {
            $satker = $this->masterSatkerModel->getNamaSatker($data_batch[0]['satker_id']);
            foreach ($list_akun as $akun) {
                foreach ($data_batch as $batch) {
                    if ($akun['id'] == $batch['akun_id']) {
                        $bmn[$urBatch]['data'][] = $batch;
                        $bmn[$urBatch]['uraian_akun'] = $akun['ur_akun'];
                        $bmn[$urBatch]['akun_id'] = $akun['id'];
                    }
                }
                $urBatch++;
            }
        }
        $data = [
            'title' => 'Detail KKI',
            'menu' => 'Import KKI',
            'subMenu' => '',
            'halaman' => 'kki',
            'kd_batch' => $kd_batch,
            'nama_satker' => $satker['nama_ref_unit_kerja_lengkap'],
            'data_bmn' => $bmn

        ];
        return view('kki/detailkki', $data);
    }

    public function importkki()
    {
        $file = $this->request->getFile('filekki');
        $satker = $this->request->getVar('satker');
        dd($satker);
        $kd_batch = $this->masterTabelBmnModel->getKodeBatch();
        $extension = $file->getClientExtension();
        if ($extension == 'xlsx' || $extension == 'xls') {
            if ($extension == 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($file);
            $bmn = $spreadsheet->getActiveSheet()->toArray();

            foreach ($bmn as $key => $value) {
                if ($key == 0) {
                    continue;
                }
                $akun_id = $this->masterTabelAkunModel->getId($value['0']);
                if ($akun_id == null) {
                    $akun_id['id'] = 0;
                }
                $barang_id = $this->masterTabelBarangModel->getId($value['1']);
                if ($barang_id == null) {
                    $barang_id['id'] = 0;
                }
                $this->masterTabelBmnModel->save([
                    'akun_id' => $akun_id['id'],
                    'barang_id' => $barang_id['id'],
                    'thn_perolehan' => $value['2'],
                    'nup' => $value['3'],
                    'merk_tipe' => $value['4'],
                    'kuantitas' => $value['5'],
                    'nilai_bmn' => $value['6'],
                    'satker_id' => $satker,
                    'kd_batch' => $kd_batch,
                ]);
            }
        } else {
            //return kesalahan
        }
        return redirect()->to('/list-kki');
    }

    public  function hapuskki($kd_batch)
    {
        $this->masterTabelBmnModel->deleteBatch($kd_batch);
        return redirect()->to('/list-kki');
    }

    public function importupdatekki()
    {
        $nama_satker = $this->request->getVar('nama_satker');
        $id_satker = $this->masterSatkerModel->getIdSatker($nama_satker);
        $kd_batch = $this->request->getVar('kd_batch_update');

        $file = $this->request->getFile('filekki');

        $extension = $file->getClientExtension();
        if ($extension == 'xlsx' || $extension == 'xls') {
            if ($extension == 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($file);
            $bmn = $spreadsheet->getActiveSheet()->toArray();

            foreach ($bmn as $key => $value) {
                if ($key == 0) {
                    continue;
                }
                $akun_id = $this->masterTabelAkunModel->getId($value['0']);
                if ($akun_id == null) {
                    $akun_id['id'] = 0;
                }
                $barang_id = $this->masterTabelBarangModel->getId($value['1']);
                if ($barang_id == null) {
                    $barang_id['id'] = 0;
                }
                $this->masterTabelBmnModel->save([
                    'akun_id' => $akun_id['id'],
                    'barang_id' => $barang_id['id'],
                    'thn_perolehan' => $value['2'],
                    'nup' => $value['3'],
                    'merk_tipe' => $value['4'],
                    'kuantitas' => $value['5'],
                    'nilai_bmn' => $value['6'],
                    'satker_id' => $id_satker['id'],
                    'kd_batch' => $kd_batch,
                ]);
            }
        } else {
            //return kesalahan
        }
        return redirect()->to('/list-kki');
    }
}
