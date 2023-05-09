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
        $data_user = session('data_user');

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
                if ($key == 0 || $key == 1) {
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
                    'opUniv_nip' => $data_user['nip']
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
        $data_user = session('data_user');
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
                    'opUniv_nip' => $data_user['nip']
                ]);
            }
        } else {
            //return kesalahan
        }
        return redirect()->to('/list-kki');
    }


    public function unduhTemplateImport()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getColumnDimension('A')->setWidth(17);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(50);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(25);

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],

        ];

        $sheet->setCellValue('A1', 'URAIAN AKUN');
        $sheet->setCellValue('B1', 'KODE BARANG');
        $sheet->setCellValue('C1', 'TAHUN PEROLEHAN');
        $sheet->setCellValue('D1', 'NUP');
        $sheet->setCellValue('E1', 'MEREK/TIPE');
        $sheet->setCellValue('F1', 'KUANTITAS');
        $sheet->setCellValue('G1', 'NILAI BMN');

        $sheet->setCellValue('A2', '1');
        $sheet->setCellValue('B2', '2');
        $sheet->setCellValue('C2', '3');
        $sheet->setCellValue('D2', '4');
        $sheet->setCellValue('E2', '5');
        $sheet->setCellValue('F2', '6');
        $sheet->setCellValue('G2', '7');

        $sheet->getStyle('A1:G2')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('A1:G2')->getFont()->setBold(true);

        $sheet->setCellValue('H6', 'PANDUAN : ');
        $sheet->setCellValue('H7', '1. Copy data dari dokumen Kertas Kerja dari setiap satuan kerja');
        $sheet->setCellValue('H8', '2. Input data dimulai pada cell A3 hingga G3 untuk awalan');
        $sheet->setCellValue('H9', '3. Kolom 1 (Uraian Akun) diisikan data Uraikan Akun pada kertas kerja (kolom 2) (Cth. PM_NON-TIK/PM_TIK/ATB/ATL)');
        $sheet->setCellValue('H10', '4. Kolom 2 (Kode Barang) diisikan data Kode Barang pada kertas kerja (kolom 3) (Cth. 3030301029)');
        $sheet->setCellValue('H11', '5. Kolom 3 (Tahun Perolehan) diisikan data Tahun Perolehan pada kertas kerja (kolom 5) (Cth. 2014)');
        $sheet->setCellValue('H12', '6. Kolom 4 (NUP) diisikan data NUP pada kertas kerja (kolom 6) (Cth. 12)');
        $sheet->setCellValue('H13', '7. Kolom 5 (Merek/Tipe) diisikan data Merek/Tipe pada kertas kerja (kolom 7) (Cth. BENCHTOP PH METER)');
        $sheet->setCellValue('H14', '8. Kolom 6 (Kuantitas) diisikan data Kuantitas pada kertas kerja (kolom 8) (Cth. 1)');
        $sheet->setCellValue('H15', '9. Kolom 7 (Nilai BMN) diisikan data Nilai BMN pada kertas kerja (kolom 9) (Cth. 202000)');
        $sheet->setCellValue('H16', '10. Pastikan semua data termuat pada kolom yang sesuai dengan panduan');
        $spreadsheet->getActiveSheet()->getStyle('H6')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('H6')->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED));

        // Set judul file excel nya
        $sheet->setTitle("Laporan Pegawai");
        $nama_file = 'TEMPLATE IMPORT';
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $nama_file . '.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        ob_end_clean();
        $writer->save('php://output');
        exit();
    }
}
