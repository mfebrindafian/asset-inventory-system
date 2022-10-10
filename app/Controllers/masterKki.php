<?php

namespace App\Controllers;

use App\Models\masterTabelBmnModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class masterKki extends BaseController
{
    protected $masterTabelBmnModel;
    public function __construct()
    {

        $this->masterTabelBmnModel = new masterTabelBmnModel();
    }

    public function listkki()
    {
        $data = [
            'halaman' => 'kki'
        ];
        return view('kki/importkki', $data);
    }
    public function detailkki()
    {
        $data = [
            'halaman' => 'kki'
        ];
        return view('kki/detailkki', $data);
    }

    public function importkki()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');

        $writer = new Xlsx($spreadsheet);
        $writer->save('hello world.xlsx');

        // echo "proses import";
        // $satker = $this->request->getVar('satker');
        // $file = $this->request->getFile('filekki');

        // new PHPExcel;
        // //mengambil lokasi tempat filenya
        // $filelocation = $file->getTempName();

        // //baca file excel
        // $objPHPExcel = PHPExcel_IOFactory::load($filelocation);
        // //ambil sheet aktif
        // $sheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

        // //melakukan perulangan untuk mengambil data
        // foreach ($sheet as $key => $data) {
        //     //skip baris 1 karena judul di table excel
        //     if ($key == 1) {
        //         continue;
        //     }
        //     $this->masterTabelBmnModel->save([
        //         'akun_id' => $data['A'],
        //         'barang_id' => $data['B'],
        //         'thn_perolehan' => $data['C'],
        //         'nup' => $data['D'],
        //         'merk_tipe' => $data['E'],
        //         'kuantitas' => $data['F'],
        //         'nilai_bmn' => $data['G']
        //     ]);
        // }
    }
}
