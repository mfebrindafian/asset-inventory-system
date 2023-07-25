<?php

namespace App\Controllers;

use App\Models\masterSatkerModel;
use App\Models\masterTabelBmnModel;
use App\Models\masterTabelJenisRekapitulasiModel;
use App\Models\masterTabelAkunModel;
use App\Models\masterPegawaiModel;
use App\Models\masterGedungModel;
use App\Models\masterRuanganModel;
use App\Models\masterSubsatkerModel;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class masterReport extends BaseController
{
    protected $masterBmnModel;
    protected $masterSatkerModel;
    protected $masterTabelJenisRekapitulasiModel;
    protected $masterAkunModel;
    protected $masterPegawaiModel;
    protected $masterGedungModel;
    protected $masterRuanganModel;
    protected $masterSubsatkerModel;

    public function __construct()
    {
        $this->masterBmnModel = new MasterTabelBmnModel();
        $this->masterSatkerModel = new masterSatkerModel();
        $this->masterTabelJenisRekapitulasiModel = new masterTabelJenisRekapitulasiModel();
        $this->masterAkunModel = new masterTabelAkunModel();
        $this->masterPegawaiModel = new masterPegawaiModel();
        $this->masterGedungModel = new masterGedungModel();
        $this->masterRuanganModel = new masterRuanganModel();
        $this->masterSubsatkerModel = new masterSubsatkerModel();
    }

    public function rekapitulasi()
    {
        $list_satker = $this->masterSatkerModel->getAllSatker();
        $list_rekapitulasi = $this->masterTabelJenisRekapitulasiModel->getAllJenisRekapitulasi();

        $data = [
            'title' => 'Rekapitulasi',
            'menu' => 'Report',
            'subMenu' => 'Rekapitulasi',
            'halaman' => 'rekapitulasi',
            'list_satker' => $list_satker,
            'list_jenis_rekapitulasi' => $list_rekapitulasi
        ];
        return view('report/rekapitulasi', $data);
    }
    public function inventarisasi()
    {

        $list_satker = $this->masterSatkerModel->getAllSatker();
        $list_rekapitulasi = $this->masterTabelJenisRekapitulasiModel->getAllJenisRekapitulasi();
        $data = [
            'title' => 'Inventarisasi',
            'menu' => 'Report',
            'subMenu' => 'Inventarisasi',
            'halaman' => 'inventarisasi',
            'list_satker' => $list_satker,
            'list_jenis_rekapitulasi' => $list_rekapitulasi
        ];
        return view('report/inventarisasi', $data);
    }

    public function APIrekapitulasi($jenis_rekapitulasi_id, $satker_id)
    {
        $list_akun = $this->masterAkunModel->getAllAkun();
        $nama_jenis_rekapitulasi = $this->masterTabelJenisRekapitulasiModel->getJenisRekapitulasiById($jenis_rekapitulasi_id);

        //pegecekan jumlah dibagian "administrasi"
        $adm_list_bmn = $this->masterBmnModel->getAllBmnBySatker($satker_id);
        foreach ($list_akun as $akun) {
            $data_akun[$akun['id']]['adm_jumlah'] = 0;
            $data_akun[$akun['id']]['adm_nilai'] = 0;
        }
        $data_akun['total']['adm_jumlah'] = 0;
        $data_akun['total']['adm_nilai'] = 0;
        if ($adm_list_bmn != null) {
            foreach ($list_akun as $adm_akun) {
                foreach ($adm_list_bmn as $adm_bmn) {
                    if ($adm_akun['id'] == $adm_bmn['akun_id']) {
                        $all[$adm_akun['id']]['adm_jumlah'][] = $adm_bmn;
                        $all[$adm_akun['id']]['adm_nilai'][] = $adm_bmn['nilai_bmn'];

                        if ($all[$adm_akun['id']] != null) {
                            $data_akun[$adm_akun['id']]['adm_jumlah'] = count($all[$adm_akun['id']]['adm_jumlah']);
                            $data_akun[$adm_akun['id']]['adm_nilai'] = array_sum($all[$adm_akun['id']]['adm_nilai']);
                        } else {
                            $data_akun[$adm_akun['id']]['adm_jumlah'] = 0;
                            $data_akun[$adm_akun['id']]['adm_nilai'] = 0;
                        }
                    }
                }
            }
            foreach ($list_akun as $akun) {
                $adm_jumlah[] =  $data_akun[$akun['id']]['adm_jumlah'];
                $adm_nilai[] =  $data_akun[$akun['id']]['adm_nilai'];
                $data_akun['total']['adm_jumlah'] = array_sum($adm_jumlah);
                $data_akun['total']['adm_nilai'] = array_sum($adm_nilai);
            }
        } else {
            foreach ($list_akun as $akun) {
                $data_akun[$akun['id']]['adm_jumlah'] = 0;
                $data_akun[$akun['id']]['adm_nilai'] = 0;
            }

            $data_akun['total']['adm_jumlah'] = 0;
            $data_akun['total']['adm_nilai'] = 0;
            $data_akun['nama_jenis'] = $nama_jenis_rekapitulasi['jenis_rekapitulasi'];
        }
        //Batas pengecekan bagian administrasi

        //pengkondisian untuk tipe Baik, Rusak ringan, rusak berat
        if ($jenis_rekapitulasi_id == 4 || $jenis_rekapitulasi_id == 5 || $jenis_rekapitulasi_id == 6) {
            if ($jenis_rekapitulasi_id == 4) {
                $kondisi_brg = 'B';
            } else if ($jenis_rekapitulasi_id == 5) {
                $kondisi_brg = 'RR';
            } else if ($jenis_rekapitulasi_id == 6) {
                $kondisi_brg = 'RB';
            }
            $list_bmn = $this->masterBmnModel->getAllBmnByKondisi($satker_id, $kondisi_brg);
        }
        //batas pengecekan untuk tipe Baik, Rusak ringan, rusak berat

        //pengkondisian untuk tipe barang ditemukan, barang tidak ditemukan, barang berlebih
        if ($jenis_rekapitulasi_id == 2 || $jenis_rekapitulasi_id == 3 || $jenis_rekapitulasi_id == 7) {
            if ($jenis_rekapitulasi_id == 2) {
                $kbrdn_brg = 'BD';
            } else if ($jenis_rekapitulasi_id == 3) {
                $kbrdn_brg = 'BTD';
            } else if ($jenis_rekapitulasi_id == 7) {
                $kbrdn_brg = 'BR';
            }
            $list_bmn = $this->masterBmnModel->getAllBmnByKeberadaan($satker_id, $kbrdn_brg);
        }
        //batas pengkondisian untuk tipe barang ditemukan, barang tidak ditemukan, barang berlebih

        //pengkondisian untuk tipe barang sebelum dan sesudah inventarisasi
        if ($jenis_rekapitulasi_id == 1) {
            $list_bmn = $this->masterBmnModel->getAllBmnByDoneInven($satker_id);
        }
        //batas pengkondisian untuk tipe barang ditemukan, barang tidak ditemukan, barang berlebih

        //pegecekan jumlah dibagian "inventarisasi"
        foreach ($list_akun as $akun) {
            $data_akun[$akun['id']]['inv_jumlah'] = 0;
            $data_akun[$akun['id']]['inv_nilai'] = 0;
            $data_akun[$akun['id']]['nama_akun'] = $akun['ur_akun'];
        }
        $data_akun['total']['inv_jumlah'] = 0;
        $data_akun['total']['inv_nilai'] = 0;
        $data_akun['nama_jenis'] = $nama_jenis_rekapitulasi['jenis_rekapitulasi'];
        if ($list_bmn != null) {
            foreach ($list_akun as $akun) {
                foreach ($list_bmn as $bmn) {
                    if ($akun['id'] == $bmn['akun_id']) {
                        $all[$akun['id']]['inv_jumlah'][] = $bmn;
                        $all[$akun['id']]['inv_nilai'][] = $bmn['nilai_bmn'];

                        if ($all[$akun['id']] != null) {
                            $data_akun[$akun['id']]['inv_jumlah'] = count($all[$akun['id']]['inv_jumlah']);
                            $data_akun[$akun['id']]['inv_nilai'] = array_sum($all[$akun['id']]['inv_nilai']);
                            $data_akun[$akun['id']]['nama_akun'] = $akun['ur_akun'];
                        } else {
                            $data_akun[$akun['id']]['inv_jumlah'] = 0;
                            $data_akun[$akun['id']]['inv_nilai'] = 0;
                            $data_akun[$akun['id']]['nama_akun'] = $akun['ur_akun'];
                        }
                    }
                }
            }
            foreach ($list_akun as $akun) {
                $inv_jumlah[] =  $data_akun[$akun['id']]['inv_jumlah'];
                $inv_nilai[] =  $data_akun[$akun['id']]['inv_nilai'];
                $data_akun['total']['inv_jumlah'] = array_sum($inv_jumlah);
                $data_akun['total']['inv_nilai'] = array_sum($inv_nilai);
            }
        } else {
            foreach ($list_akun as $akun) {
                $data_akun[$akun['id']]['inv_jumlah'] = 0;
                $data_akun[$akun['id']]['inv_nilai'] = 0;
                $data_akun[$akun['id']]['nama_akun'] = $akun['ur_akun'];
            }
            $data_akun['total']['inv_jumlah'] = 0;
            $data_akun['total']['inv_nilai'] = 0;
            $data_akun['nama_jenis'] = $nama_jenis_rekapitulasi['jenis_rekapitulasi'];
        }
        //batas pengecekan "inventarisasi"

        //pengecekan "selisih"
        foreach ($list_akun as $akun) {
            $data_akun[$akun['id']]['selisih_jumlah'] = 0;
            $data_akun[$akun['id']]['selisih_nilai'] = 0;
        }
        $data_akun['total']['selisih_jumlah'] = 0;
        $data_akun['total']['selisih_nilai'] = 0;

        foreach ($list_akun as $akun) {
            $data_akun[$akun['id']]['selisih_jumlah'] = ($data_akun[$akun['id']]['adm_jumlah'] - $data_akun[$akun['id']]['inv_jumlah']);
            $data_akun[$akun['id']]['selisih_nilai'] =  $data_akun[$akun['id']]['adm_nilai'] - $data_akun[$akun['id']]['inv_nilai'];
        }
        $data_akun['total']['selisih_jumlah'] =  $data_akun['total']['adm_jumlah'] - $data_akun['total']['inv_jumlah'];
        $data_akun['total']['selisih_nilai'] = $data_akun['total']['adm_nilai'] - $data_akun['total']['inv_nilai'];
        //batas pengecekan selisih

        echo json_encode($data_akun);
    }


    public function cetakRekapitulasi()
    {
        $list_akun = $this->masterAkunModel->getAllAkun();
        if (session('level_id') != 3) {
            $satker_id = $this->request->getVar('satker');
        } else {
            $satker_id = session('satker_id');
        }

        if ($satker_id == 'all') {
            $nama_satker['nama_ref_unit_kerja_lengkap'] = 'Seluruh Unit Kerja';
        } else {
            $nama_satker = $this->masterSatkerModel->getNamaSatker($satker_id);
        }



        $all_bmn = $this->masterBmnModel->getAllBmnBySatker($satker_id);
        if ($all_bmn != null) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            //style tabel
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);
            $sheet->getColumnDimension('G')->setAutoSize(true);
            $sheet->getColumnDimension('H')->setAutoSize(true);
            $sheet->getColumnDimension('I')->setWidth(12);
            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],

            ];
            $styleArray2 = [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ];
            //batas style tabel

            $sheet->setCellValue('A1', 'Lampiran Berita Acara Hasil Inventarisasi BMN');
            $sheet->setCellValue('A2', 'Nomor :');
            $sheet->mergeCells('A2:B2');
            $sheet->setCellValue('A3', 'Tanggal :');
            $sheet->mergeCells('A3:B3');
            $sheet->setCellValue('C3', date('d-m-Y'));
            $sheet->setCellValue('A5', 'A. REKAPITULASI LAPORAN ASIL INVENTARISASI BMN');
            $sheet->setCellValue('A6', '1. REKAPITULASI HASIL IVENTARISASI SEBELUM DAN SESUDAH INVENTARISASI');
            //UNTUK TABEL SESUDAH DAN SEBELUM INVENTARISASI
            $tipe_kolom1 = ['adm', 'inv', 'diff'];

            foreach ($list_akun as $akun) {
                foreach ($tipe_kolom1 as $kolom1) {
                    $jml_sbsd[$kolom1]['jumlah'][$akun['ur_akun']] = 0;
                    $jml_sbsd[$kolom1]['nilai'][$akun['ur_akun']] = 0;
                }
            }

            ////bagian administrasi
            foreach ($list_akun as $akun) {
                foreach ($all_bmn as $all) {
                    if ($akun['id'] == $all['akun_id']) {
                        $jml['adm']['jumlah'][$akun['ur_akun']][] = $all;
                        $jml_sbsd['adm']['jumlah'][$akun['ur_akun']] = count($jml['adm']['jumlah'][$akun['ur_akun']]);
                        $jml['adm']['nilai'][$akun['ur_akun']][] = $all['nilai_bmn'];
                        $jml_sbsd['adm']['nilai'][$akun['ur_akun']] = array_sum($jml['adm']['nilai'][$akun['ur_akun']]);
                    }
                }
            }

            ////bagian inventarisasi
            $sbsd_bmn = $this->masterBmnModel->getAllBmnByDoneInven($satker_id);
            foreach ($list_akun as $akun) {
                foreach ($sbsd_bmn as $sbsd) {
                    if ($akun['id'] == $sbsd['akun_id']) {
                        $jml['inv']['jumlah'][$akun['ur_akun']][] = $sbsd;
                        $jml_sbsd['inv']['jumlah'][$akun['ur_akun']] = count($jml['inv']['jumlah'][$akun['ur_akun']]);
                        $jml['inv']['nilai'][$akun['ur_akun']][] = $sbsd['nilai_bmn'];
                        $jml_sbsd['inv']['nilai'][$akun['ur_akun']] = array_sum($jml['inv']['nilai'][$akun['ur_akun']]);
                    }
                }
            }

            ////bagian selisih
            foreach ($list_akun as $akun) {
                $jml_sbsd['diff']['jumlah'][$akun['ur_akun']] = $jml_sbsd['adm']['jumlah'][$akun['ur_akun']] - $jml_sbsd['inv']['jumlah'][$akun['ur_akun']];
                $jml_sbsd['diff']['nilai'][$akun['ur_akun']] = $jml_sbsd['adm']['nilai'][$akun['ur_akun']] - $jml_sbsd['inv']['nilai'][$akun['ur_akun']];
            }

            $letak_mulai = 7;
            $sheet->setCellValue('A7', 'No.');
            $sheet->mergeCells('A7:A8');
            $sheet->setCellValue('B7', 'Akun');
            $sheet->mergeCells('B7:B8');
            $sheet->setCellValue('C7', 'Administrasi');
            $sheet->mergeCells('C7:D7');
            $sheet->setCellValue('C8', 'Jumlah');
            $sheet->setCellValue('D8', 'Nilai');
            $sheet->setCellValue('E7', 'Inventarisasi');
            $sheet->mergeCells('E7:F7');
            $sheet->setCellValue('E8', 'Jumlah');
            $sheet->setCellValue('F8', 'Nilai');
            $sheet->setCellValue('G7', 'Selisih');
            $sheet->mergeCells('G7:H7');
            $sheet->setCellValue('G8', 'Jumlah');
            $sheet->setCellValue('H8', 'Nilai');
            $sheet->setCellValue('I7', 'Keterangan');
            $sheet->mergeCells('I7:I8');

            $column = 9; //kolom start

            $sbsd_no = 1;
            $mulai_akun = $column;
            foreach ($list_akun as $akun) {
                $sheet->setCellValue(('A' . $column), $sbsd_no);
                $sheet->setCellValue(('B' . $column), $akun['ket_akun']);
                $sheet->setCellValue(('C' . $column),  $jml_sbsd['adm']['jumlah'][$akun['ur_akun']]);
                $sheet->setCellValue(('D' . $column),  $jml_sbsd['adm']['nilai'][$akun['ur_akun']]);
                $sheet->setCellValue(('E' . $column),  $jml_sbsd['inv']['jumlah'][$akun['ur_akun']]);
                $sheet->setCellValue(('F' . $column),  $jml_sbsd['inv']['nilai'][$akun['ur_akun']]);
                $sheet->setCellValue(('G' . $column),  $jml_sbsd['diff']['jumlah'][$akun['ur_akun']]);
                $sheet->setCellValue(('H' . $column),  $jml_sbsd['diff']['nilai'][$akun['ur_akun']]);
                $column++;
                $sbsd_no++;
            }
            $akhir_akun = ($column - 1);
            $letak_jumlah = $column;
            $sheet->setCellValue(('A' . $column), 'JUMLAH');
            $sheet->mergeCells('A' . $column . ':B' . $column);
            $sheet->setCellValue(('C' . $column),  '=SUM(C' . $mulai_akun .  ':C' . $akhir_akun . ')');
            $sheet->setCellValue(('D' . $column), '=SUM(D' . $mulai_akun .  ':D' . $akhir_akun . ')');
            $sheet->setCellValue(('E' . $column), '=SUM(E' . $mulai_akun .  ':E' . $akhir_akun . ')');
            $sheet->setCellValue(('F' . $column), '=SUM(F' . $mulai_akun .  ':F' . $akhir_akun . ')');
            $sheet->setCellValue(('G' . $column),  '=SUM(G' . $mulai_akun .  ':G' . $akhir_akun . ')');
            $sheet->setCellValue(('H' . $column), '=SUM(H' . $mulai_akun .  ':H' . $akhir_akun . ')');

            $sheet->getStyle('A' . $letak_mulai . ':I' . $column)->applyFromArray($styleArray);
            $sheet->getStyle('A' . $letak_mulai . ':I' . ($letak_mulai + 1))->applyFromArray($styleArray2);
            $sheet->getStyle('A' . $letak_jumlah)->applyFromArray($styleArray2);
            //BATAS UNTUK TABEL SESUDAH DAN SEBELUM INVENTARISASI

            //UNTUK TABEL BARANG DITEMUKAN
            $column = $column + 2;

            $sheet->setCellValue('A' . $column, '2. REKAPITULASI HASIL IVENTARISASI BARANG DITEMUKAN');
            $column++;
            $letak_mulai = $column;
            $sheet->setCellValue('A' . $column, 'No.');
            $sheet->setCellValue('B' . $column, 'Akun');
            $sheet->setCellValue('C' . $column, 'Jumlah');
            $sheet->mergeCells('C' . $column . ':D' . $column);
            $sheet->setCellValue('E' . $column, 'Nilai');
            $sheet->mergeCells('E' . $column . ':F' . $column);
            $sheet->setCellValue('G' . $column, 'Keterangan');
            $sheet->mergeCells('G' . $column . ':I' . $column);

            $all_bd_bmn = $this->masterBmnModel->getAllBmnByDoneInven($satker_id);

            $bd_bmn = [];
            foreach ($all_bd_bmn as $all_bd) {
                if ($all_bd['kbrdn_brg'] == 'BD') {
                    $bd_bmn[] = $all_bd;
                }
            }
            foreach ($list_akun as $akun) {
                $jml_bd['jumlah'][$akun['ur_akun']] = 0;
                $jml_bd['nilai'][$akun['ur_akun']] = 0;
            }

            if (count($bd_bmn) != 0) {
                foreach ($list_akun as $akun) {
                    foreach ($bd_bmn as $bd) {
                        if ($akun['id'] == $bd['akun_id']) {
                            $jml2['jumlah'][$akun['ur_akun']][] = $bd;
                            $jml_bd['jumlah'][$akun['ur_akun']] = count($jml2['jumlah'][$akun['ur_akun']]);
                            $jml2['nilai'][$akun['ur_akun']][] = $bd['nilai_bmn'];
                            $jml_bd['nilai'][$akun['ur_akun']] = array_sum($jml2['nilai'][$akun['ur_akun']]);
                        }
                    }
                }
            }

            $column++; //kolom start

            $bd_no = 1;
            $mulai_akun = $column;
            foreach ($list_akun as $akun) {
                $sheet->setCellValue(('A' . $column), $bd_no);
                $sheet->setCellValue(('B' . $column), $akun['ket_akun']);
                $sheet->setCellValue(('C' . $column),  $jml_bd['jumlah'][$akun['ur_akun']]);
                $sheet->mergeCells('C' . $column . ':D' . $column);
                $sheet->setCellValue(('E' . $column),  $jml_bd['nilai'][$akun['ur_akun']]);
                $sheet->mergeCells('E' . $column . ':F' . $column);
                $sheet->mergeCells('G' . $column . ':I' . $column);
                $column++;
                $bd_no++;
            }
            $akhir_akun = ($column - 1);
            $letak_jumlah = $column;
            $sheet->setCellValue(('A' . $column), 'JUMLAH');
            $sheet->mergeCells('A' . $column . ':B' . $column);
            $sheet->setCellValue(('C' . $column),  '=SUM(C' . $mulai_akun .  ':C' . $akhir_akun . ')');
            $sheet->mergeCells('C' . $column . ':D' . $column);
            $sheet->setCellValue(('E' . $column), '=SUM(E' . $mulai_akun .  ':E' . $akhir_akun . ')');
            $sheet->mergeCells('E' . $column . ':F' . $column);
            $sheet->mergeCells('G' . $column . ':I' . $column);

            $sheet->getStyle('A' . $letak_mulai . ':I' . $column)->applyFromArray($styleArray);
            $sheet->getStyle('A' . $letak_mulai . ':I' . ($letak_mulai))->applyFromArray($styleArray2);
            $sheet->getStyle('A' . $letak_jumlah)->applyFromArray($styleArray2);
            //BATAS UNTUK TABEL BARANG DI TEMUKAN

            //UNTUK TABEL BARANG TIDAK DIKETEMUKAN
            $column = $column + 2;

            $sheet->setCellValue('A' . $column, '3. REKAPITULASI HASIL IVENTARISASI BARANG TIDAK DIKETEMUKAN');
            $column++;
            $letak_mulai = $column;
            $sheet->setCellValue('A' . $column, 'No.');
            $sheet->setCellValue('B' . $column, 'Akun');
            $sheet->setCellValue('C' . $column, 'Jumlah');
            $sheet->mergeCells('C' . $column . ':D' . $column);
            $sheet->setCellValue('E' . $column, 'Nilai');
            $sheet->mergeCells('E' . $column . ':F' . $column);
            $sheet->setCellValue('G' . $column, 'Keterangan');
            $sheet->mergeCells('G' . $column . ':I' . $column);

            $all_btd_bmn = $this->masterBmnModel->getAllBmnByDoneInven($satker_id);

            $btd_bmn = [];
            foreach ($all_btd_bmn as $all_btd) {
                if ($all_btd['kbrdn_brg'] == 'BTD') {
                    $btd_bmn[] = $all_btd;
                }
            }

            foreach ($list_akun as $akun) {
                $jml_btd['jumlah'][$akun['ur_akun']] = 0;
                $jml_btd['nilai'][$akun['ur_akun']] = 0;
            }


            if (count($btd_bmn) != 0) {
                foreach ($list_akun as $akun) {
                    foreach ($btd_bmn as $btd) {
                        if ($akun['id'] == $btd['akun_id']) {
                            $jml3['jumlah'][$akun['ur_akun']][] = $btd;
                            $jml_btd['jumlah'][$akun['ur_akun']] = count($jml3['jumlah'][$akun['ur_akun']]);
                            $jml3['nilai'][$akun['ur_akun']][] = $btd['nilai_bmn'];
                            $jml_btd['nilai'][$akun['ur_akun']] = array_sum($jml3['nilai'][$akun['ur_akun']]);
                        }
                    }
                }
            }

            $column++; //kolom start

            $btd_no = 1;
            $mulai_akun = $column;
            foreach ($list_akun as $akun) {
                $sheet->setCellValue(('A' . $column), $btd_no);
                $sheet->setCellValue(('B' . $column), $akun['ket_akun']);
                $sheet->setCellValue(('C' . $column),  $jml_btd['jumlah'][$akun['ur_akun']]);
                $sheet->mergeCells('C' . $column . ':D' . $column);
                $sheet->setCellValue(('E' . $column),  $jml_btd['nilai'][$akun['ur_akun']]);
                $sheet->mergeCells('E' . $column . ':F' . $column);
                $sheet->mergeCells('G' . $column . ':I' . $column);
                $column++;
                $btd_no++;
            }
            $akhir_akun = ($column - 1);
            $letak_jumlah = $column;
            $sheet->setCellValue(('A' . $column), 'JUMLAH');
            $sheet->mergeCells('A' . $column . ':B' . $column);
            $sheet->setCellValue(('C' . $column),  '=SUM(C' . $mulai_akun .  ':C' . $akhir_akun . ')');
            $sheet->mergeCells('C' . $column . ':D' . $column);
            $sheet->setCellValue(('E' . $column), '=SUM(E' . $mulai_akun .  ':E' . $akhir_akun . ')');
            $sheet->mergeCells('E' . $column . ':F' . $column);
            $sheet->mergeCells('G' . $column . ':I' . $column);

            $sheet->getStyle('A' . $letak_mulai . ':I' . $column)->applyFromArray($styleArray);
            $sheet->getStyle('A' . $letak_mulai . ':I' . ($letak_mulai))->applyFromArray($styleArray2);
            $sheet->getStyle('A' . $letak_jumlah)->applyFromArray($styleArray2);
            //BATAS UNTUK TABEL BARANG TIDAK DIKETEMUKAN

            //UNTUK TABEL BARANG BAIK
            $tipe_kolom1 = ['adm', 'inv', 'diff'];

            foreach ($list_akun as $akun) {
                foreach ($tipe_kolom1 as $kolom1) {
                    $jml_b[$kolom1]['jumlah'][$akun['ur_akun']] = 0;
                    $jml_b[$kolom1]['nilai'][$akun['ur_akun']] = 0;
                }
            }

            ////bagian administrasi
            foreach ($list_akun as $akun) {
                foreach ($all_bmn as $all) {
                    if ($akun['id'] == $all['akun_id']) {
                        $jml4['adm']['jumlah'][$akun['ur_akun']][] = $all;
                        $jml_b['adm']['jumlah'][$akun['ur_akun']] = count($jml4['adm']['jumlah'][$akun['ur_akun']]);
                        $jml4['adm']['nilai'][$akun['ur_akun']][] = $all['nilai_bmn'];
                        $jml_b['adm']['nilai'][$akun['ur_akun']] = array_sum($jml4['adm']['nilai'][$akun['ur_akun']]);
                    }
                }
            }

            ////bagian inventarisasi
            $all_b_bmn = $this->masterBmnModel->getAllBmnByDoneInven($satker_id);

            $b_bmn = [];
            foreach ($all_b_bmn as $all_b) {
                if ($all_b['kondisi_brg'] == 'B') {
                    $b_bmn[] = $all_b;
                }
            }

            if (count($b_bmn) != 0) {
                foreach ($list_akun as $akun) {
                    foreach ($b_bmn as $b) {
                        if ($akun['id'] == $b['akun_id']) {
                            $jml4['inv']['jumlah'][$akun['ur_akun']][] = $b;
                            $jml_b['inv']['jumlah'][$akun['ur_akun']] = count($jml4['inv']['jumlah'][$akun['ur_akun']]);
                            $jml4['inv']['nilai'][$akun['ur_akun']][] = $b['nilai_bmn'];
                            $jml_b['inv']['nilai'][$akun['ur_akun']] = array_sum($jml4['inv']['nilai'][$akun['ur_akun']]);
                        }
                    }
                }
            }

            ////bagian selisih
            foreach ($list_akun as $akun) {
                $jml_b['diff']['jumlah'][$akun['ur_akun']] = $jml_b['adm']['jumlah'][$akun['ur_akun']] - $jml_b['inv']['jumlah'][$akun['ur_akun']];
                $jml_b['diff']['nilai'][$akun['ur_akun']] = $jml_b['adm']['nilai'][$akun['ur_akun']] - $jml_b['inv']['nilai'][$akun['ur_akun']];
            }


            $column = $column + 2;

            $sheet->setCellValue('A' . $column, '4. REKAPITULASI HASIL IVENTARISASI BARANG BAIK');
            $column++;
            $letak_mulai = $column;
            $sheet->setCellValue('A' . $column, 'No.');
            $sheet->mergeCells('A' . $column . ':A' . ($column + 1));
            $sheet->setCellValue('B' . $column, 'Akun');
            $sheet->mergeCells('B' . $column . ':B' . ($column + 1));
            $sheet->setCellValue('C' . $column, 'Administrasi');
            $sheet->mergeCells('C' . $column . ':D' . $column);
            $sheet->setCellValue('C' . ($column + 1), 'Jumlah');
            $sheet->setCellValue('D' . ($column + 1), 'Nilai');
            $sheet->setCellValue('E' . $column, 'Inventarisasi');
            $sheet->mergeCells('E' . $column . ':F' . $column);
            $sheet->setCellValue('E' . ($column + 1), 'Jumlah');
            $sheet->setCellValue('F' . ($column + 1), 'Nilai');
            $sheet->setCellValue('G' . $column, 'Selisih');
            $sheet->mergeCells('G' . $column . ':H' . $column);
            $sheet->setCellValue('G' . ($column + 1), 'Jumlah');
            $sheet->setCellValue('H' . ($column + 1), 'Nilai');
            $sheet->setCellValue('I' . $column, 'Keterangan');
            $sheet->mergeCells('I' . $column . ':I' . ($column + 1));

            $column = $column + 2; //kolom start

            $b_no = 1;
            $mulai_akun = $column;
            foreach ($list_akun as $akun) {
                $sheet->setCellValue(('A' . $column), $b_no);
                $sheet->setCellValue(('B' . $column), $akun['ket_akun']);
                $sheet->setCellValue(('C' . $column),  $jml_b['adm']['jumlah'][$akun['ur_akun']]);
                $sheet->setCellValue(('D' . $column),  $jml_b['adm']['nilai'][$akun['ur_akun']]);
                $sheet->setCellValue(('E' . $column),  $jml_b['inv']['jumlah'][$akun['ur_akun']]);
                $sheet->setCellValue(('F' . $column),  $jml_b['inv']['nilai'][$akun['ur_akun']]);
                $sheet->setCellValue(('G' . $column),  $jml_b['diff']['jumlah'][$akun['ur_akun']]);
                $sheet->setCellValue(('H' . $column),  $jml_b['diff']['nilai'][$akun['ur_akun']]);
                $column++;
                $b_no++;
            }
            $akhir_akun = ($column - 1);
            $letak_jumlah = $column;
            $sheet->setCellValue(('A' . $column), 'JUMLAH');
            $sheet->mergeCells('A' . $column . ':B' . $column);
            $sheet->setCellValue(('C' . $column),  '=SUM(C' . $mulai_akun .  ':C' . $akhir_akun . ')');
            $sheet->setCellValue(('D' . $column), '=SUM(D' . $mulai_akun .  ':D' . $akhir_akun . ')');
            $sheet->setCellValue(('E' . $column), '=SUM(E' . $mulai_akun .  ':E' . $akhir_akun . ')');
            $sheet->setCellValue(('F' . $column), '=SUM(F' . $mulai_akun .  ':F' . $akhir_akun . ')');
            $sheet->setCellValue(('G' . $column),  '=SUM(G' . $mulai_akun .  ':G' . $akhir_akun . ')');
            $sheet->setCellValue(('H' . $column), '=SUM(H' . $mulai_akun .  ':H' . $akhir_akun . ')');

            $sheet->getStyle('A' . $letak_mulai . ':I' . $column)->applyFromArray($styleArray);
            $sheet->getStyle('A' . $letak_mulai . ':I' . ($letak_mulai + 1))->applyFromArray($styleArray2);
            $sheet->getStyle('A' . $letak_jumlah)->applyFromArray($styleArray2);
            // BATAS UNTUK TABEL BARANG BAIK


            //UNTUK TABEL BARANG RUSAK RINGAN
            $tipe_kolom1 = ['adm', 'inv', 'diff'];

            foreach ($list_akun as $akun) {
                foreach ($tipe_kolom1 as $kolom1) {
                    $jml_rr[$kolom1]['jumlah'][$akun['ur_akun']] = 0;
                    $jml_rr[$kolom1]['nilai'][$akun['ur_akun']] = 0;
                }
            }

            ////bagian administrasi
            foreach ($list_akun as $akun) {
                foreach ($all_bmn as $all) {
                    if ($akun['id'] == $all['akun_id']) {
                        $jml5['adm']['jumlah'][$akun['ur_akun']][] = $all;
                        $jml_rr['adm']['jumlah'][$akun['ur_akun']] = count($jml5['adm']['jumlah'][$akun['ur_akun']]);
                        $jml5['adm']['nilai'][$akun['ur_akun']][] = $all['nilai_bmn'];
                        $jml_rr['adm']['nilai'][$akun['ur_akun']] = array_sum($jml5['adm']['nilai'][$akun['ur_akun']]);
                    }
                }
            }

            ////bagian inventarisasi
            $all_rr_bmn = $this->masterBmnModel->getAllBmnByDoneInven($satker_id);

            $rr_bmn = [];
            foreach ($all_rr_bmn as $all_rr) {
                if ($all_rr['kondisi_brg'] == 'RR') {
                    $rr_bmn[] = $all_rr;
                }
            }

            if (count($rr_bmn) != 0) {
                foreach ($list_akun as $akun) {
                    foreach ($rr_bmn as $rr) {
                        if ($akun['id'] == $rr['akun_id']) {
                            $jml5['inv']['jumlah'][$akun['ur_akun']][] = $rr;
                            $jml_rr['inv']['jumlah'][$akun['ur_akun']] = count($jml5['inv']['jumlah'][$akun['ur_akun']]);
                            $jml5['inv']['nilai'][$akun['ur_akun']][] = $rr['nilai_bmn'];
                            $jml_rr['inv']['nilai'][$akun['ur_akun']] = array_sum($jml5['inv']['nilai'][$akun['ur_akun']]);
                        }
                    }
                }
            }

            ////bagian selisih
            foreach ($list_akun as $akun) {
                $jml_rr['diff']['jumlah'][$akun['ur_akun']] = $jml_rr['adm']['jumlah'][$akun['ur_akun']] - $jml_rr['inv']['jumlah'][$akun['ur_akun']];
                $jml_rr['diff']['nilai'][$akun['ur_akun']] = $jml_rr['adm']['nilai'][$akun['ur_akun']] - $jml_rr['inv']['nilai'][$akun['ur_akun']];
            }


            $column = $column + 2;

            $sheet->setCellValue('A' . $column, '5. REKAPITULASI HASIL IVENTARISASI BARANG RUSAK RINGAN');
            $column++;
            $letak_mulai = $column;
            $sheet->setCellValue('A' . $column, 'No.');
            $sheet->mergeCells('A' . $column . ':A' . ($column + 1));
            $sheet->setCellValue('B' . $column, 'Akun');
            $sheet->mergeCells('B' . $column . ':B' . ($column + 1));
            $sheet->setCellValue('C' . $column, 'Administrasi');
            $sheet->mergeCells('C' . $column . ':D' . $column);
            $sheet->setCellValue('C' . ($column + 1), 'Jumlah');
            $sheet->setCellValue('D' . ($column + 1), 'Nilai');
            $sheet->setCellValue('E' . $column, 'Inventarisasi');
            $sheet->mergeCells('E' . $column . ':F' . $column);
            $sheet->setCellValue('E' . ($column + 1), 'Jumlah');
            $sheet->setCellValue('F' . ($column + 1), 'Nilai');
            $sheet->setCellValue('G' . $column, 'Selisih');
            $sheet->mergeCells('G' . $column . ':H' . $column);
            $sheet->setCellValue('G' . ($column + 1), 'Jumlah');
            $sheet->setCellValue('H' . ($column + 1), 'Nilai');
            $sheet->setCellValue('I' . $column, 'Keterangan');
            $sheet->mergeCells('I' . $column . ':I' . ($column + 1));

            $column = $column + 2; //kolom start

            $b_no = 1;
            $mulai_akun = $column;
            foreach ($list_akun as $akun) {
                $sheet->setCellValue(('A' . $column), $b_no);
                $sheet->setCellValue(('B' . $column), $akun['ket_akun']);
                $sheet->setCellValue(('C' . $column),  $jml_rr['adm']['jumlah'][$akun['ur_akun']]);
                $sheet->setCellValue(('D' . $column),  $jml_rr['adm']['nilai'][$akun['ur_akun']]);
                $sheet->setCellValue(('E' . $column),  $jml_rr['inv']['jumlah'][$akun['ur_akun']]);
                $sheet->setCellValue(('F' . $column),  $jml_rr['inv']['nilai'][$akun['ur_akun']]);
                $sheet->setCellValue(('G' . $column),  $jml_rr['diff']['jumlah'][$akun['ur_akun']]);
                $sheet->setCellValue(('H' . $column),  $jml_rr['diff']['nilai'][$akun['ur_akun']]);
                $column++;
                $b_no++;
            }
            $akhir_akun = ($column - 1);
            $letak_jumlah = $column;
            $sheet->setCellValue(('A' . $column), 'JUMLAH');
            $sheet->mergeCells('A' . $column . ':B' . $column);
            $sheet->setCellValue(('C' . $column),  '=SUM(C' . $mulai_akun .  ':C' . $akhir_akun . ')');
            $sheet->setCellValue(('D' . $column), '=SUM(D' . $mulai_akun .  ':D' . $akhir_akun . ')');
            $sheet->setCellValue(('E' . $column), '=SUM(E' . $mulai_akun .  ':E' . $akhir_akun . ')');
            $sheet->setCellValue(('F' . $column), '=SUM(F' . $mulai_akun .  ':F' . $akhir_akun . ')');
            $sheet->setCellValue(('G' . $column),  '=SUM(G' . $mulai_akun .  ':G' . $akhir_akun . ')');
            $sheet->setCellValue(('H' . $column), '=SUM(H' . $mulai_akun .  ':H' . $akhir_akun . ')');

            $sheet->getStyle('A' . $letak_mulai . ':I' . $column)->applyFromArray($styleArray);
            $sheet->getStyle('A' . $letak_mulai . ':I' . ($letak_mulai + 1))->applyFromArray($styleArray2);
            $sheet->getStyle('A' . $letak_jumlah)->applyFromArray($styleArray2);
            // BATAS UNTUK TABEL BARANG RUSAK RINGAN

            //UNTUK TABEL BARANG RUSAK BERAT
            $tipe_kolom1 = ['adm', 'inv', 'diff'];

            foreach ($list_akun as $akun) {
                foreach ($tipe_kolom1 as $kolom1) {
                    $jml_rb[$kolom1]['jumlah'][$akun['ur_akun']] = 0;
                    $jml_rb[$kolom1]['nilai'][$akun['ur_akun']] = 0;
                }
            }

            ////bagian administrasi
            foreach ($list_akun as $akun) {
                foreach ($all_bmn as $all) {
                    if ($akun['id'] == $all['akun_id']) {
                        $jml6['adm']['jumlah'][$akun['ur_akun']][] = $all;
                        $jml_rb['adm']['jumlah'][$akun['ur_akun']] = count($jml6['adm']['jumlah'][$akun['ur_akun']]);
                        $jml6['adm']['nilai'][$akun['ur_akun']][] = $all['nilai_bmn'];
                        $jml_rb['adm']['nilai'][$akun['ur_akun']] = array_sum($jml6['adm']['nilai'][$akun['ur_akun']]);
                    }
                }
            }

            ////bagian inventarisasi
            $all_rb_bmn = $this->masterBmnModel->getAllBmnByDoneInven($satker_id);
            $rb_bmn = [];
            foreach ($all_rb_bmn as $all_rb) {
                if ($all_rb['kondisi_brg'] == 'RB') {
                    $rb_bmn[] = $all_rb;
                }
            }

            if (count($rb_bmn) != 0) {
                foreach ($list_akun as $akun) {
                    foreach ($rb_bmn as $rb) {
                        if ($akun['id'] == $rb['akun_id']) {
                            $jml6['inv']['jumlah'][$akun['ur_akun']][] = $rb;
                            $jml_rb['inv']['jumlah'][$akun['ur_akun']] = count($jml6['inv']['jumlah'][$akun['ur_akun']]);
                            $jml6['inv']['nilai'][$akun['ur_akun']][] = $rb['nilai_bmn'];
                            $jml_rb['inv']['nilai'][$akun['ur_akun']] = array_sum($jml6['inv']['nilai'][$akun['ur_akun']]);
                        }
                    }
                }
            }

            ////bagian selisih
            foreach ($list_akun as $akun) {
                $jml_rb['diff']['jumlah'][$akun['ur_akun']] = $jml_rb['adm']['jumlah'][$akun['ur_akun']] - $jml_rb['inv']['jumlah'][$akun['ur_akun']];
                $jml_rb['diff']['nilai'][$akun['ur_akun']] = $jml_rb['adm']['nilai'][$akun['ur_akun']] - $jml_rb['inv']['nilai'][$akun['ur_akun']];
            }

            $column = $column + 2;

            $sheet->setCellValue('A' . $column, '6. REKAPITULASI HASIL IVENTARISASI BARANG RUSAK BERAT');
            $column++;
            $letak_mulai = $column;
            $sheet->setCellValue('A' . $column, 'No.');
            $sheet->mergeCells('A' . $column . ':A' . ($column + 1));
            $sheet->setCellValue('B' . $column, 'Akun');
            $sheet->mergeCells('B' . $column . ':B' . ($column + 1));
            $sheet->setCellValue('C' . $column, 'Administrasi');
            $sheet->mergeCells('C' . $column . ':D' . $column);
            $sheet->setCellValue('C' . ($column + 1), 'Jumlah');
            $sheet->setCellValue('D' . ($column + 1), 'Nilai');
            $sheet->setCellValue('E' . $column, 'Inventarisasi');
            $sheet->mergeCells('E' . $column . ':F' . $column);
            $sheet->setCellValue('E' . ($column + 1), 'Jumlah');
            $sheet->setCellValue('F' . ($column + 1), 'Nilai');
            $sheet->setCellValue('G' . $column, 'Selisih');
            $sheet->mergeCells('G' . $column . ':H' . $column);
            $sheet->setCellValue('G' . ($column + 1), 'Jumlah');
            $sheet->setCellValue('H' . ($column + 1), 'Nilai');
            $sheet->setCellValue('I' . $column, 'Keterangan');
            $sheet->mergeCells('I' . $column . ':I' . ($column + 1));

            $column = $column + 2; //kolom start

            $b_no = 1;
            $mulai_akun = $column;
            foreach ($list_akun as $akun) {
                $sheet->setCellValue(('A' . $column), $b_no);
                $sheet->setCellValue(('B' . $column), $akun['ket_akun']);
                $sheet->setCellValue(('C' . $column),  $jml_rb['adm']['jumlah'][$akun['ur_akun']]);
                $sheet->setCellValue(('D' . $column),  $jml_rb['adm']['nilai'][$akun['ur_akun']]);
                $sheet->setCellValue(('E' . $column),  $jml_rb['inv']['jumlah'][$akun['ur_akun']]);
                $sheet->setCellValue(('F' . $column),  $jml_rb['inv']['nilai'][$akun['ur_akun']]);
                $sheet->setCellValue(('G' . $column),  $jml_rb['diff']['jumlah'][$akun['ur_akun']]);
                $sheet->setCellValue(('H' . $column),  $jml_rb['diff']['nilai'][$akun['ur_akun']]);
                $column++;
                $b_no++;
            }
            $akhir_akun = ($column - 1);
            $letak_jumlah = $column;
            $sheet->setCellValue(('A' . $column), 'JUMLAH');
            $sheet->mergeCells('A' . $column . ':B' . $column);
            $sheet->setCellValue(('C' . $column),  '=SUM(C' . $mulai_akun .  ':C' . $akhir_akun . ')');
            $sheet->setCellValue(('D' . $column), '=SUM(D' . $mulai_akun .  ':D' . $akhir_akun . ')');
            $sheet->setCellValue(('E' . $column), '=SUM(E' . $mulai_akun .  ':E' . $akhir_akun . ')');
            $sheet->setCellValue(('F' . $column), '=SUM(F' . $mulai_akun .  ':F' . $akhir_akun . ')');
            $sheet->setCellValue(('G' . $column),  '=SUM(G' . $mulai_akun .  ':G' . $akhir_akun . ')');
            $sheet->setCellValue(('H' . $column), '=SUM(H' . $mulai_akun .  ':H' . $akhir_akun . ')');

            $sheet->getStyle('A' . $letak_mulai . ':I' . $column)->applyFromArray($styleArray);
            $sheet->getStyle('A' . $letak_mulai . ':I' . ($letak_mulai + 1))->applyFromArray($styleArray2);
            $sheet->getStyle('A' . $letak_jumlah)->applyFromArray($styleArray2);
            // BATAS UNTUK TABEL BARANG RUSAK BERAT


            //UNTUK TABEL BARANG BERLEBIH
            $column = $column + 2;

            $sheet->setCellValue('A' . $column, '7. REKAPITULASI HASIL IVENTARISASI BARANG BERLEBIH');
            $column++;
            $letak_mulai = $column;
            $sheet->setCellValue('A' . $column, 'No.');
            $sheet->setCellValue('B' . $column, 'Akun');
            $sheet->setCellValue('C' . $column, 'Jumlah');
            $sheet->mergeCells('C' . $column . ':D' . $column);
            $sheet->setCellValue('E' . $column, 'Nilai');
            $sheet->mergeCells('E' . $column . ':F' . $column);
            $sheet->setCellValue('G' . $column, 'Keterangan');
            $sheet->mergeCells('G' . $column . ':I' . $column);

            $all_br_bmn = $this->masterBmnModel->getAllBmnByDoneInven($satker_id);

            $br_bmn = [];
            foreach ($all_br_bmn as $all_br) {
                if ($all_br['kbrdn_brg'] == 'BR') {
                    $br_bmn[] = $all_br;
                }
            }

            foreach ($list_akun as $akun) {
                $jml_br['jumlah'][$akun['ur_akun']] = 0;
                $jml_br['nilai'][$akun['ur_akun']] = 0;
            }


            if (count($br_bmn) != 0) {
                foreach ($list_akun as $akun) {
                    foreach ($br_bmn as $br) {
                        if ($akun['id'] == $br['akun_id']) {
                            $jml7['jumlah'][$akun['ur_akun']][] = $br;
                            $jml_br['jumlah'][$akun['ur_akun']] = count($jml7['jumlah'][$akun['ur_akun']]);
                            $jml7['nilai'][$akun['ur_akun']][] = $br['nilai_bmn'];
                            $jml_br['nilai'][$akun['ur_akun']] = array_sum($jml7['nilai'][$akun['ur_akun']]);
                        }
                    }
                }
            }

            $column++; //kolom start

            $br_no = 1;
            $mulai_akun = $column;
            foreach ($list_akun as $akun) {
                $sheet->setCellValue(('A' . $column), $br_no);
                $sheet->setCellValue(('B' . $column), $akun['ket_akun']);
                $sheet->setCellValue(('C' . $column),  $jml_br['jumlah'][$akun['ur_akun']]);
                $sheet->mergeCells('C' . $column . ':D' . $column);
                $sheet->setCellValue(('E' . $column),  $jml_br['nilai'][$akun['ur_akun']]);
                $sheet->mergeCells('E' . $column . ':F' . $column);
                $sheet->mergeCells('G' . $column . ':I' . $column);
                $column++;
                $br_no++;
            }
            $akhir_akun = ($column - 1);
            $letak_jumlah = $column;
            $sheet->setCellValue(('A' . $column), 'JUMLAH');
            $sheet->mergeCells('A' . $column . ':B' . $column);
            $sheet->setCellValue(('C' . $column),  '=SUM(C' . $mulai_akun .  ':C' . $akhir_akun . ')');
            $sheet->mergeCells('C' . $column . ':D' . $column);
            $sheet->setCellValue(('E' . $column), '=SUM(E' . $mulai_akun .  ':E' . $akhir_akun . ')');
            $sheet->mergeCells('E' . $column . ':F' . $column);
            $sheet->mergeCells('G' . $column . ':I' . $column);

            $sheet->getStyle('A' . $letak_mulai . ':I' . $column)->applyFromArray($styleArray);
            $sheet->getStyle('A' . $letak_mulai . ':I' . ($letak_mulai))->applyFromArray($styleArray2);
            $sheet->getStyle('A' . $letak_jumlah)->applyFromArray($styleArray2);
            //BATAS UNTUK TABEL BARANG TIDAK DIKETEMUKAN

            // Set judul file excel nya
            $sheet->setTitle("Laporan Pegawai");
            $nama_file = 'REKAPITULASI ' . $nama_satker['nama_ref_unit_kerja_lengkap'];
            // Proses file excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $nama_file . '.xlsx"'); // Set nama file excel nya
            header('Cache-Control: max-age=0');
            $writer = new Xlsx($spreadsheet);
            ob_end_clean();
            $writer->save('php://output');
            exit();
        } else {
            session()->setFlashdata('pesan', 'Rekapitulasi' . $nama_satker['nama_ref_unit_kerja_lengkap'] . ' Tidak Tersedia!');
            session()->setFlashdata('icon', 'error');
            return redirect()->to('/report-rekapitulasi');
        }
    }

    public function cetakInventarisasi()
    {
        if (session('level_id') != 3) {
            $satker_id = $this->request->getVar('satker');
        } else {
            $satker_id = session('satker_id');
        }

        if ($satker_id == 'all') {
            $nama_satker['nama_ref_unit_kerja_lengkap'] = 'Seluruh Unit Kerja';
        } else {
            $nama_satker = $this->masterSatkerModel->getNamaSatker($satker_id);
        }

        $all_bmn = $this->masterBmnModel->getAllBmnBySatker($satker_id);
        if ($all_bmn != null) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            //Style Table
            $styleArray = [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ];
            $styleArray2 = [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                ],
            ];
            $styleBorder = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ];
            $styleBorder2 = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ];



            //Batas Style Table
            $id_rekapitulasi = $this->request->getVar('jenis-inventarisasi');
            //pendeklarasian global array
            $arr_kuantitas_adm = [];
            $arr_nilai_bmn_adm = [];
            $arr_kuantitas_inv = [];
            $arr_nilai_bmn_inv = [];
            $arr_kuantitas_selisih = [];
            $arr_nilai_bmn_selisih = [];
            $kondisi_brg_b = [];
            $kondisi_brg_rr = [];
            $kondisi_brg_rb = [];
            $kbrdn_brg_bd = [];
            $kbrdn_brg_btd = [];
            $kbrdn_brg_br = [];
            $label_kode_s = [];
            $label_kode_b = [];
            $status_psp_s = [];
            $status_psp_b = [];
            $arr_nilai_bmn_minus = [];


            $jenis_inventarisasi = $this->masterTabelJenisRekapitulasiModel->getJenisRekapitulasiById($id_rekapitulasi);

            if ($id_rekapitulasi == 1) {
                //inventarisasi barang setelah dan sebelum
                $sheet->mergeCells('A1:AB1');
                $sheet->setCellValue('A1', 'DAFTAR BARANG HASIL INVENTARISASI');
                $sheet->mergeCells('A2:AB2');
                $sheet->setCellValue('A2', 'PADA SATUAN KERJA ' . strtoupper($nama_satker['nama_ref_unit_kerja_lengkap']));
                $sheet->getStyle('A1:AB2')->applyFromArray($styleArray);
                $sheet->setCellValue('A4', 'KODE SATKER :');
                $sheet->setCellValue('A5', 'NAMA SATKER :');
                $sheet->setCellValue('C5', $nama_satker['nama_ref_unit_kerja_lengkap']);
                $merge1 = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'V', 'W', 'X', 'AA', 'AB'];
                for ($me = 0; $me < count($merge1); $me++) {
                    $sheet->mergeCells($merge1[$me] . '7:' . $merge1[$me] . '8');
                }

                $sheet->mergeCells('H7:I7');
                $sheet->mergeCells('J7:K7');
                $sheet->mergeCells('L7:M7');
                $sheet->mergeCells('N7:P7');
                $sheet->mergeCells('Q7:S7');
                $sheet->mergeCells('T7:U7');
                $sheet->mergeCells('Y7:Z7');
                $sheet->getStyle('A7:AB9')->applyFromArray($styleArray);
                $sheet->setCellValue('A7', 'No');
                $sheet->setCellValue('B7', 'Uraian Akun');
                $sheet->setCellValue('C7', 'Kode Barang');
                $sheet->setCellValue('D7', 'Nama Barang');
                $sheet->setCellValue('E7', 'Tahun Perolehan');
                $sheet->setCellValue('F7', 'NUP');
                $sheet->setCellValue('G7', 'Merk/Tipe');
                $sheet->setCellValue('H7', 'Administrasi');
                $sheet->setCellValue('H8', 'Kuantitas');
                $sheet->setCellValue('I8', 'Nilai BMN');
                $sheet->setCellValue('J7', 'Hasil Inventarisasi');
                $sheet->setCellValue('J8', 'Kuantitas');
                $sheet->setCellValue('K8', 'Nilai BMN');
                $sheet->setCellValue('L7', 'Selisih');
                $sheet->setCellValue('L8', 'Kuantitas');
                $sheet->setCellValue('M8', 'Nilai BMN');
                $sheet->setCellValue('N7', 'Kondisi Barang');
                $sheet->setCellValue('N8', 'B');
                $sheet->setCellValue('O8', 'RR');
                $sheet->setCellValue('P8', 'RB');
                $sheet->setCellValue('Q7', 'Keberadaan Barang');
                $sheet->setCellValue('Q8', 'BD');
                $sheet->setCellValue('R8', 'BTD');
                $sheet->setCellValue('S8', 'Berlebih');
                $sheet->setCellValue('T7', 'Pelabelan Kodefikasi');
                $sheet->setCellValue('T8', 'Sudah');
                $sheet->setCellValue('U8', 'Belum');
                $sheet->setCellValue('V7', 'Nama Pegawai Pengguna Barang');
                $sheet->setCellValue('W7', 'Nama Gedung');
                $sheet->setCellValue('X7', 'Nama Ruangan');
                $sheet->setCellValue('Y7', 'Status PSP');
                $sheet->setCellValue('Y8', 'Sudah');
                $sheet->setCellValue('Z8', 'Belum');
                $sheet->setCellValue('AA7', 'Nama Sub Satker');
                $sheet->setCellValue('AB7', 'Keterangan');
                $sheet->getStyle('A7:AB9')->getAlignment()->setWrapText(true);
                $huruf = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB'];
                $angka = 1;
                for ($me2 = 0; $me2 < count($huruf); $me2++) {
                    $sheet->setCellValue($huruf[$me2] . '9', $angka);
                    $angka++;
                }

                $column = 10; //titik mulai

                $bmn_sebelum_sesudah = $this->masterBmnModel->getAllBmnBySatker($satker_id);


                if ($bmn_sebelum_sesudah != null) {
                    $no_baris = 1;
                    foreach ($bmn_sebelum_sesudah as $bmn) {
                        $sheet->setCellValue(('A' . $column), $no_baris);
                        if ($bmn['akun_id'] == '1') {
                            $ur_akun = 'PM_NON_TIK';
                        } elseif ($bmn['akun_id'] == '2') {
                            $ur_akun = 'PM_TIK';
                        } elseif ($bmn['akun_id'] == '3') {
                            $ur_akun = 'ATB';
                        } elseif ($bmn['akun_id'] == '4') {
                            $ur_akun = 'ATL';
                        }
                        $sheet->setCellValue(('B' . $column), $ur_akun);
                        $sheet->setCellValue(('C' . $column), $bmn['kd_barang']);
                        $sheet->setCellValue(('D' . $column),  $bmn['nama_barang']);
                        $sheet->setCellValue(('E' . $column), $bmn['thn_perolehan']);
                        $sheet->setCellValue(('F' . $column), $bmn['nup']);
                        $sheet->setCellValue(('G' . $column), $bmn['merk_tipe']);
                        $arr_kuantitas_adm[] = $bmn['kuantitas'];
                        $kuantitas_adm = $bmn['kuantitas'];
                        $arr_nilai_bmn_adm[] = $bmn['nilai_bmn'];
                        $nilai_bmn_adm = $bmn['nilai_bmn'];
                        $sheet->setCellValue(('H' . $column), $bmn['kuantitas']);
                        $sheet->setCellValue(('I' . $column), $bmn['nilai_bmn']);

                        //perhitungan barang teradministrasi (Ditemukan/Berlebih/telah diadministrasi)
                        if ($bmn['kbrdn_brg'] == 'BD' || $bmn['kbrdn_brg'] == 'BR') {
                            $arr_kuantitas_inv[] = $bmn['kuantitas'];
                            $kuantitas_inv = $bmn['kuantitas'];
                            $arr_nilai_bmn_inv[] = $bmn['nilai_bmn'];
                            $nilai_bmn_inv = $bmn['nilai_bmn'];
                        } else {
                            $arr_kuantitas_inv[] = 0;
                            $kuantitas_inv = 0;
                            $arr_nilai_bmn_inv[] = 0;
                            $nilai_bmn_inv = 0;
                        }
                        $sheet->setCellValue(('J' . $column), $kuantitas_inv);
                        $sheet->setCellValue(('K' . $column), $nilai_bmn_inv);
                        $sheet->setCellValue(('L' . $column), ($kuantitas_adm - $kuantitas_inv));
                        $arr_kuantitas_selisih[] = $kuantitas_adm - $kuantitas_inv;
                        $arr_nilai_bmn_selisih[] = $nilai_bmn_adm - $nilai_bmn_inv;
                        $sheet->setCellValue(('M' . $column), $nilai_bmn_adm - $nilai_bmn_inv);

                        if ($bmn['kondisi_brg'] != null) {
                            if ($bmn['kondisi_brg'] == 'B') {
                                $sheet->setCellValue(('N' . $column), 'B');
                                $kondisi_brg_b[] = 1;
                            } elseif ($bmn['kondisi_brg'] == 'RR') {
                                $sheet->setCellValue(('O' . $column), 'RR');
                                $kondisi_brg_rr[] = 1;
                            } elseif ($bmn['kondisi_brg'] == 'RB') {
                                $sheet->setCellValue(('P' . $column), 'RB');
                                $kondisi_brg_rb[] = 1;
                            }
                            if ($bmn['kbrdn_brg'] == 'BD') {
                                $sheet->setCellValue(('Q' . $column), 'BD');
                                $kbrdn_brg_bd[] = 1;
                            } elseif ($bmn['kbrdn_brg'] == 'BTD') {
                                if ($bmn['kategori_btd'] == '1') {
                                    $kategori_btd = 'Hilang';
                                } elseif ($bmn['kategori_btd'] == '2') {
                                    $kategori_btd = 'Salah Kodefikasi';
                                } elseif ($bmn['kategori_btd'] == '3') {
                                    $kategori_btd = 'pekerjaan renovasi/pengembangan BMN dicatat sebagai NUP baru';
                                } elseif ($bmn['kategori_btd'] == '4') {
                                    $kategori_btd = 'pencatatanganda/fiktif';
                                }
                                $sheet->setCellValue(('R' . $column), $kategori_btd);
                                $kbrdn_brg_btd[] = 1;
                            } elseif ($bmn['kbrdn_brg'] == 'BR') {
                                if ($bmn['kategori_br'] == '1') {
                                    $kategori_br = 'belum tercatat dalam laporan BMN';
                                } elseif ($bmn['kategori_br'] == '2') {
                                    $kategori_br = 'Salah Kodefikasi';
                                } elseif ($bmn['kategori_br'] == '3') {
                                    $kategori_br = 'pencatatan gelondongan';
                                }
                                $sheet->setCellValue(('S' . $column), $kategori_br);
                                $kbrdn_brg_br[] = 1;
                            }
                            if ($bmn['label_kode'] == 'S') {
                                $sheet->setCellValue(('T' . $column), 'Sudah');
                                $label_kode_s[] = 1;
                            } elseif ($bmn['label_kode'] == 'B') {
                                $sheet->setCellValue(('U' . $column), 'Belum');
                                $label_kode_b[] = 1;
                            }

                            $data_pegawai = $this->masterPegawaiModel->getNamaPegawai($bmn['pegawai_id']);
                            $nama_pegawai = $data_pegawai['gelar_depan'];
                            if ($data_pegawai['gelar_depan'] != null) {
                                $nama_pegawai .= ' ';
                            }
                            $nama_pegawai .= $data_pegawai['nama_pegawai'];
                            if ($data_pegawai['gelar_belakang'] != null) {
                                $nama_pegawai .= ' ';
                            }
                            $nama_pegawai .= $data_pegawai['gelar_belakang'];
                            $sheet->setCellValue(('V' . $column), $nama_pegawai);
                            $gedung = $this->masterGedungModel->getNamaGedung($bmn['gedung_id']);
                            $ruangan = $this->masterRuanganModel->getNamaRuangan($bmn['ruangan_id']);

                            if ($bmn['subsatker_id'] != null) {
                                $subsatker = $this->masterSubsatkerModel->getNamaSubsatker($bmn['subsatker_id']);
                            } else {
                                $subsatker['nama_subsatker'] = '';
                            }
                            $sheet->setCellValue(('W' . $column),  $gedung['nama_gedung']);
                            $sheet->setCellValue(('X' . $column), $ruangan['nama_ruang']);

                            if ($bmn['status_psp'] == 'S') {
                                $sheet->setCellValue(('Y' . $column), 'Sudah');
                                $status_psp_s[] = 1;
                            } elseif ($bmn['status_psp'] == 'B') {
                                $sheet->setCellValue(('Z' . $column), 'Belum');
                                $status_psp_b[] = 1;
                            }
                            $sheet->setCellValue(('AA' . $column), $subsatker['nama_subsatker']);
                            $sheet->setCellValue(('AB' . $column), $bmn['ket']);
                        }

                        $column++;
                        $no_baris++;
                    }
                }

                $sheet->mergeCells('A' . $column . ':G' . $column);
                $sheet->setCellValue('A' . $column, 'TOTAL');
                $sheet->getStyle('A' . $column)->applyFromArray($styleArray);

                $sheet->setCellValue('H' . $column, array_sum($arr_kuantitas_adm));
                $sheet->setCellValue('I' . $column, array_sum($arr_nilai_bmn_adm));
                $sheet->setCellValue('J' . $column, array_sum($arr_kuantitas_inv));
                $sheet->setCellValue('K' . $column, array_sum($arr_nilai_bmn_inv));
                $sheet->setCellValue('L' . $column, array_sum($arr_kuantitas_selisih));
                $sheet->setCellValue('M' . $column, array_sum($arr_nilai_bmn_selisih));
                $sheet->setCellValue('N' . $column, array_sum($kondisi_brg_b));
                $sheet->setCellValue('O' . $column, array_sum($kondisi_brg_rr));
                $sheet->setCellValue('P' . $column, array_sum($kondisi_brg_rb));
                $sheet->setCellValue('Q' . $column, array_sum($kbrdn_brg_bd));
                $sheet->setCellValue('R' . $column, array_sum($kbrdn_brg_btd));
                $sheet->setCellValue('S' . $column, array_sum($kbrdn_brg_br));
                $sheet->setCellValue('T' . $column, array_sum($label_kode_s));
                $sheet->setCellValue('U' . $column, array_sum($label_kode_b));
                $sheet->setCellValue('Y' . $column, array_sum($status_psp_s));
                $sheet->setCellValue('Z' . $column, array_sum($status_psp_b));


                $sheet->getStyle('V' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('W' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('X' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('AA' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('AB' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);

                $sheet->getStyle('A7:AB' . $column)->applyFromArray($styleBorder);
                $sheet->getStyle('A10:B' . $column - 1)->applyFromArray($styleArray);
                $sheet->getStyle('E10:E' . $column - 1)->applyFromArray($styleArray);
                $sheet->getStyle('N10:U' . $column - 1)->applyFromArray($styleArray);
                $sheet->getStyle('Y10:Z' . $column - 1)->applyFromArray($styleArray);

                $sheet->getStyle('C10:C' . $column)->applyFromArray($styleArray2);

                $sheet->getColumnDimension('C')->setWidth(12);
                $sheet->getColumnDimension('D')->setWidth(19);
                $sheet->getColumnDimension('G')->setWidth(11);
                $sheet->getColumnDimension('V')->setWidth(17);
                $sheet->getColumnDimension('W')->setWidth(16);
                $sheet->getColumnDimension('X')->setWidth(16);
                $sheet->getColumnDimension('AA')->setWidth(10);
                $sheet->getColumnDimension('R')->setAutoSize(true);
                $sheet->getColumnDimension('S')->setAutoSize(true);
                $sheet->getColumnDimension('AB')->setWidth(15);
                $sheet->getStyle('A7:AB9')->applyFromArray($styleBorder2);
                $sheet->getStyle('A1:AB9')->getFont()->setBold(true);
                $sheet->freezePane('A10');
                $column++;
                $sheet->setCellValue('A' . $column, 'Note : B=Baik, RR=Rusak Ringan, RB=Rusak Berat, BD= Barang Ditemukan, BTD=Barang Tidak Ditemukan');
                $column = $column + 2;
                $sheet->setCellValue('A' . $column, 'Keterangan :');

                //Bagian tanda tangan
                $sheet->setCellValue('Y' . $column, '................, .................... ' . date('Y'));
                $sheet->setCellValue('Y' . $column + 1, 'Tim Inventarisasi BMN');
                $sheet->setCellValue('Y' . $column + 4, '1. ...................................................');
                $sheet->setCellValue('Y' . $column + 6, '2. ...................................................');
                $sheet->setCellValue('Y' . $column + 8, '3. ...................................................');
                //batas tanda tangan

                $column++;
                $awal_ket = $column;
                for ($ket_no = 1; $ket_no <= 28; $ket_no++) {
                    $sheet->setCellValue('A' . $awal_ket, $ket_no);
                    $awal_ket++;
                }
                $sheet->setCellValue('B' . $column, 'Di isi dengan nomor urut');
                $sheet->setCellValue('B' . $column + 1, 'Di isi dengan uraian akun (PM_NON_TIK, PM_TIK, ATL, ATB)');
                $sheet->setCellValue('B' . $column + 2, 'Di isi dengan kodefikasi barang di SIMAK BMN');
                $sheet->setCellValue('B' . $column + 3, 'Di isi dengan nama Barang di SIMAK BMN');
                $sheet->setCellValue('B' . $column + 4, 'Di isi dengan tahun perolehan BMN');
                $sheet->setCellValue('B' . $column + 5, 'Di isi dengan nomor urut pendaftaran (NUP)');
                $sheet->setCellValue('B' . $column + 6, 'Di isi dengan merek/tipe barang');
                $sheet->setCellValue('B' . $column + 7, 'Di isi dengan jumlah barang sesuai data SIMAK BMN sebelum inventarisasi');
                $sheet->setCellValue('B' . $column + 8, 'Di isi dengan nilai BMN sesuai data SIMAK BMN sebelum inventarisasi');
                $sheet->setCellValue('B' . $column + 9, 'Di isi dengan jumlah barang setelah inventarisasi');
                $sheet->setCellValue('B' . $column + 10, 'Di isi dengan nilai BMN setelah inventarisasi');
                $sheet->setCellValue('B' . $column + 11, 'Di isi dengan jumlah selisih hasil inventarisasi kurangi administrasi');
                $sheet->setCellValue('B' . $column + 12, 'Di isi dengan nilai BMN selisih hasil inventarisasi kurangi administrasi');
                $sheet->setCellValue('B' . $column + 13, 'Di isi dengan huruf B');
                $sheet->setCellValue('B' . $column + 14, 'Di isi dengan huruf RR');
                $sheet->setCellValue('B' . $column + 15, 'Di isi dengan RB');
                $sheet->setCellValue('B' . $column + 16, 'Di isi dengan BD');
                $sheet->setCellValue('B' . $column + 17, 'Di isi dengan kategori BTD sesuai juknis (misalnya hilang, salah kodefikasi dll)');
                $sheet->setCellValue('B' . $column + 18, 'Di isi dengan kategori Barang berlebih sesuai juknis (misalnya belum tercatat, salah kodefikasi, gelondongan)');
                $sheet->setCellValue('B' . $column + 19, 'Di isi dengan kata sudah apabila barang yang didata telah dilebelisasi');
                $sheet->setCellValue('B' . $column + 20, 'Di isi dengan kata belum apabila barang yang didata belum dilebelisasi');
                $sheet->setCellValue('B' . $column + 21, 'Di isi dengan nama pegawai yang menggunakan barang');
                $sheet->setCellValue('B' . $column + 22, 'Di isi dengan nama gedung lokasi barang berada');
                $sheet->setCellValue('B' . $column + 23, 'Di isi dengan ama ruangan lokasi barang berada');
                $sheet->setCellValue('B' . $column + 24, 'Di isi dengan kata sudah apabila barang yang didata telah ada SK PSP');
                $sheet->setCellValue('B' . $column + 25, 'Di isi dengan kata belum apabila barang yang didata belum ada SK PSP');
                $sheet->setCellValue('B' . $column + 26, 'Di isi dengan nama Sub Satker (bagi yan memiliki Sub Satker)');
                $sheet->setCellValue('B' . $column + 27, 'Di isi dengan Keterangan yang belum terakomodasi');
            } elseif ($id_rekapitulasi == 2) {
                //inventarisasi barang ditemukan
                $sheet->mergeCells('A1:U1');
                $sheet->setCellValue('A1', 'DAFTAR BARANG HASIL INVENTARISASI BMN DITEMUKAN');
                $sheet->mergeCells('A2:U2');
                $sheet->setCellValue('A2', 'PADA SATUAN KERJA ' . strtoupper($nama_satker['nama_ref_unit_kerja_lengkap']));
                $sheet->getStyle('A1:U2')->applyFromArray($styleArray);
                $sheet->setCellValue('A4', 'KODE SATKER :');
                $sheet->setCellValue('A5', 'NAMA SATKER :');
                $sheet->setCellValue('C5', $nama_satker['nama_ref_unit_kerja_lengkap']);
                $merge1 = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'O', 'P', 'Q', 'T', 'U'];
                for ($me = 0; $me < count($merge1); $me++) {
                    $sheet->mergeCells($merge1[$me] . '7:' . $merge1[$me] . '8');
                }
                $sheet->mergeCells('J7:L7');
                $sheet->mergeCells('M7:N7');
                $sheet->mergeCells('R7:S7');
                $sheet->getStyle('A7:U9')->applyFromArray($styleArray);
                $sheet->setCellValue('A7', 'No');
                $sheet->setCellValue('B7', 'Uraian Akun');
                $sheet->setCellValue('C7', 'Kode Barang');
                $sheet->setCellValue('D7', 'Nama Barang');
                $sheet->setCellValue('E7', 'Tahun Perolehan');
                $sheet->setCellValue('F7', 'NUP');
                $sheet->setCellValue('G7', 'Merk/Tipe');
                $sheet->setCellValue('H7', 'Kuantitas');
                $sheet->setCellValue('I7', 'Nilai BMN');
                $sheet->setCellValue('J7', 'Kondisi Barang');
                $sheet->setCellValue('J8', 'B');
                $sheet->setCellValue('K8', 'RR');
                $sheet->setCellValue('L8', 'RB');
                $sheet->setCellValue('M7', 'Pelabelan Kodefikasi');
                $sheet->setCellValue('M8', 'Sudah');
                $sheet->setCellValue('N8', 'Belum');
                $sheet->setCellValue('O7', 'Nama Pegawai Pengguna Barang');
                $sheet->setCellValue('P7', 'Nama Gedung');
                $sheet->setCellValue('Q7', 'Nama Ruangan');
                $sheet->setCellValue('R7', 'Status PSP');
                $sheet->setCellValue('R8', 'Sudah');
                $sheet->setCellValue('S8', 'Belum');
                $sheet->setCellValue('T7', 'Nama Sub Satker');
                $sheet->setCellValue('U7', 'Keterangan');
                $sheet->getStyle('A7:U9')->getAlignment()->setWrapText(true);
                $huruf = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U'];
                $angka = 1;
                for ($me2 = 0; $me2 < count($huruf); $me2++) {
                    $sheet->setCellValue($huruf[$me2] . '9', $angka);
                    $angka++;
                }

                $column = 10; //titik mulai
                $bmn_ditemukan = $this->masterBmnModel->getAllBmnBySatkerDitemukan($satker_id);

                if ($bmn_ditemukan != null) {
                    $no_baris = 1;
                    foreach ($bmn_ditemukan as $bmn) {
                        $sheet->setCellValue(('A' . $column), $no_baris);
                        if ($bmn['akun_id'] == '1') {
                            $ur_akun = 'PM_NON_TIK';
                        } elseif ($bmn['akun_id'] == '2') {
                            $ur_akun = 'PM_TIK';
                        } elseif ($bmn['akun_id'] == '3') {
                            $ur_akun = 'ATB';
                        } elseif ($bmn['akun_id'] == '4') {
                            $ur_akun = 'ATL';
                        }
                        $sheet->setCellValue(('B' . $column), $ur_akun);
                        $sheet->setCellValue(('C' . $column), $bmn['kd_barang']);
                        $sheet->setCellValue(('D' . $column),  $bmn['nama_barang']);
                        $sheet->setCellValue(('E' . $column), $bmn['thn_perolehan']);
                        $sheet->setCellValue(('F' . $column), $bmn['nup']);
                        $sheet->setCellValue(('G' . $column), $bmn['merk_tipe']);
                        $arr_kuantitas_inv[] = $bmn['kuantitas'];
                        $kuantitas_inv = $bmn['kuantitas'];
                        $arr_nilai_bmn_inv[] = $bmn['nilai_bmn'];
                        $nilai_bmn_inv = $bmn['nilai_bmn'];
                        $sheet->setCellValue(('H' . $column), $bmn['kuantitas']);
                        $sheet->setCellValue(('I' . $column), $bmn['nilai_bmn']);

                        if ($bmn['kondisi_brg'] != null) {
                            if ($bmn['kondisi_brg'] == 'B') {
                                $sheet->setCellValue(('J' . $column), 'B');
                                $kondisi_brg_b[] = 1;
                            } elseif ($bmn['kondisi_brg'] == 'RR') {
                                $sheet->setCellValue(('K' . $column), 'RR');
                                $kondisi_brg_rr[] = 1;
                            } elseif ($bmn['kondisi_brg'] == 'RB') {
                                $sheet->setCellValue(('L' . $column), 'RB');
                                $kondisi_brg_rb[] = 1;
                            }
                            if ($bmn['label_kode'] != null) {
                                if ($bmn['label_kode'] == 'S') {
                                    $sheet->setCellValue(('M' . $column), 'Sudah');
                                    $label_kode_s[] = 1;
                                } elseif ($bmn['label_kode'] == 'B') {
                                    $sheet->setCellValue(('N' . $column), 'Belum');
                                    $label_kode_b[] = 1;
                                }
                            }
                            $data_pegawai = $this->masterPegawaiModel->getNamaPegawai($bmn['pegawai_id']);
                            $nama_pegawai = $data_pegawai['gelar_depan'];
                            if ($data_pegawai['gelar_depan'] != null) {
                                $nama_pegawai .= ' ';
                            }
                            $nama_pegawai .= $data_pegawai['nama_pegawai'];
                            if ($data_pegawai['gelar_belakang'] != null) {
                                $nama_pegawai .= ' ';
                            }
                            $nama_pegawai .= $data_pegawai['gelar_belakang'];
                            $sheet->setCellValue(('O' . $column), $nama_pegawai);
                            $gedung = $this->masterGedungModel->getNamaGedung($bmn['gedung_id']);
                            $ruangan = $this->masterRuanganModel->getNamaRuangan($bmn['ruangan_id']);

                            if ($bmn['subsatker_id'] != null) {
                                $subsatker = $this->masterSubsatkerModel->getNamaSubsatker($bmn['subsatker_id']);
                            } else {
                                $subsatker['nama_subsatker'] = '';
                            }
                            $sheet->setCellValue(('P' . $column),  $gedung['nama_gedung']);
                            $sheet->setCellValue(('Q' . $column), $ruangan['nama_ruang']);

                            if ($bmn['status_psp'] != null) {
                                if ($bmn['status_psp'] == 'S') {
                                    $sheet->setCellValue(('R' . $column), 'Sudah');
                                    $status_psp_s[] = 1;
                                } elseif ($bmn['status_psp'] == 'B') {
                                    $sheet->setCellValue(('S' . $column), 'Belum');
                                    $status_psp_b[] = 1;
                                }
                            }
                            $sheet->setCellValue(('T' . $column), $subsatker['nama_subsatker']);
                            $sheet->setCellValue(('U' . $column), $bmn['ket']);
                        }
                        $column++;
                        $no_baris++;
                    }
                }
                $sheet->mergeCells('A' . $column . ':G' . $column);
                $sheet->setCellValue('A' . $column, 'TOTAL');
                $sheet->getStyle('A' . $column)->applyFromArray($styleArray);

                $sheet->setCellValue('H' . $column, array_sum($arr_kuantitas_inv));
                $sheet->setCellValue('I' . $column, array_sum($arr_nilai_bmn_inv));
                $sheet->setCellValue('J' . $column, array_sum($kondisi_brg_b));
                $sheet->setCellValue('K' . $column, array_sum($kondisi_brg_rr));
                $sheet->setCellValue('L' . $column, array_sum($kondisi_brg_rb));
                $sheet->setCellValue('M' . $column, array_sum($label_kode_s));
                $sheet->setCellValue('N' . $column, array_sum($label_kode_b));
                $sheet->setCellValue('R' . $column, array_sum($status_psp_s));
                $sheet->setCellValue('S' . $column, array_sum($status_psp_b));

                $sheet->getStyle('O' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('P' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('Q' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('T' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('U' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);

                $sheet->getStyle('A7:U' . $column)->applyFromArray($styleBorder);
                $sheet->getStyle('A10:B' . $column - 1)->applyFromArray($styleArray);
                $sheet->getStyle('E10:E' . $column - 1)->applyFromArray($styleArray);
                $sheet->getStyle('J10:N' . $column - 1)->applyFromArray($styleArray);
                $sheet->getStyle('R10:S' . $column - 1)->applyFromArray($styleArray);

                $sheet->getStyle('C10:C' . $column)->applyFromArray($styleArray2);
                $sheet->getColumnDimension('C')->setWidth(12);
                $sheet->getColumnDimension('D')->setWidth(19);
                $sheet->getColumnDimension('G')->setWidth(11);
                $sheet->getColumnDimension('O')->setWidth(17);
                $sheet->getColumnDimension('P')->setWidth(16);
                $sheet->getColumnDimension('Q')->setWidth(16);
                $sheet->getColumnDimension('U')->setWidth(15);
                $sheet->getStyle('A7:U9')->applyFromArray($styleBorder2);
                $sheet->getStyle('A1:U9')->getFont()->setBold(true);
                $sheet->freezePane('A10');
                $column++;
                $sheet->setCellValue('A' . $column, 'Note : B=Baik, RR=Rusak Ringan, RB=Rusak Berat, BD= Barang Ditemukan, BTD=Barang Tidak Ditemukan');
                $column = $column + 2;
                $sheet->setCellValue('A' . $column, 'Keterangan :');

                //Bagian tanda tangan
                $sheet->setCellValue('R' . $column, '................, .................... ' . date('Y'));
                $sheet->setCellValue('R' . $column + 1, 'Tim Inventarisasi BMN');
                $sheet->setCellValue('R' . $column + 4, '1. ...................................................');
                $sheet->setCellValue('R' . $column + 6, '2. ...................................................');
                $sheet->setCellValue('R' . $column + 8, '3. ...................................................');
                //batas tanda tangan

                $column++;
                $awal_ket = $column;
                for ($ket_no = 1; $ket_no <= 21; $ket_no++) {
                    $sheet->setCellValue('A' . $awal_ket, $ket_no);
                    $awal_ket++;
                }
                $sheet->setCellValue('B' . $column, 'Di isi dengan nomor urut');
                $sheet->setCellValue('B' . $column + 1, 'Di isi dengan uraian akun (PM_NON_TIK, PM_TIK, ATL, ATB)');
                $sheet->setCellValue('B' . $column + 2, 'Di isi dengan kodefikasi barang di SIMAK BMN');
                $sheet->setCellValue('B' . $column + 3, 'Di isi dengan nama Barang di SIMAK BMN');
                $sheet->setCellValue('B' . $column + 4, 'Di isi dengan tahun perolehan BMN');
                $sheet->setCellValue('B' . $column + 5, 'Di isi dengan nomor urut pendaftaran (NUP)');
                $sheet->setCellValue('B' . $column + 6, 'Di isi dengan merek/tipe barang');
                $sheet->setCellValue('B' . $column + 7, 'Di isi dengan jumlah barang');
                $sheet->setCellValue('B' . $column + 8, 'Di isi dengan nilai perolehan BMN');
                $sheet->setCellValue('B' . $column + 9, 'Di isi dengan huruf B');
                $sheet->setCellValue('B' . $column + 10, 'Di isi dengan huruf RR');
                $sheet->setCellValue('B' . $column + 11, 'Di isi dengan RB');
                $sheet->setCellValue('B' . $column + 12, 'Di isi dengan kata sudah apabila barang yang didata telah dilebelisasi');
                $sheet->setCellValue('B' . $column + 13, 'Di isi dengan kata belum apabila barang yang didata belum dilebelisasi');
                $sheet->setCellValue('B' . $column + 14, 'Di isi dengan nama pegawai yang menggunakan barang');
                $sheet->setCellValue('B' . $column + 15, 'Di isi dengan nama gedung lokasi barang berada');
                $sheet->setCellValue('B' . $column + 16, 'Di isi dengan ama ruangan lokasi barang berada');
                $sheet->setCellValue('B' . $column + 17, 'Di isi dengan kata sudah apabila barang yang didata telah ada SK PSP');
                $sheet->setCellValue('B' . $column + 18, 'Di isi dengan kata belum apabila barang yang didata belum ada SK PSP');
                $sheet->setCellValue('B' . $column + 19, 'Di isi dengan nama Sub Satker (bagi yan memiliki Sub Satker)');
                $sheet->setCellValue('B' . $column + 20, 'Di isi dengan Keterangan yang belum terakomodasi');
            } elseif ($id_rekapitulasi == 3) {
                //inventarisasi barang ditemukan
                $sheet->mergeCells('A1:U1');
                $sheet->setCellValue('A1', 'DAFTAR BARANG HASIL INVENTARISASI BMN TIDAK DITEMUKAN');
                $sheet->mergeCells('A2:U2');
                $sheet->setCellValue('A2', 'PADA SATUAN KERJA ' . strtoupper($nama_satker['nama_ref_unit_kerja_lengkap']));
                $sheet->getStyle('A1:U2')->applyFromArray($styleArray);
                $sheet->setCellValue('A4', 'KODE SATKER :');
                $sheet->setCellValue('A5', 'NAMA SATKER :');
                $sheet->setCellValue('C5', $nama_satker['nama_ref_unit_kerja_lengkap']);
                $merge1 = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'P', 'Q'];
                for ($me = 0; $me < count($merge1); $me++) {
                    $sheet->mergeCells($merge1[$me] . '7:' . $merge1[$me] . '8');
                }
                $sheet->mergeCells('N7:O7');
                $sheet->getStyle('A7:Q9')->applyFromArray($styleArray);
                $sheet->setCellValue('A7', 'No');
                $sheet->setCellValue('B7', 'Uraian Akun');
                $sheet->setCellValue('C7', 'Kode Barang');
                $sheet->setCellValue('D7', 'Nama Barang');
                $sheet->setCellValue('E7', 'Tahun Perolehan');
                $sheet->setCellValue('F7', 'NUP');
                $sheet->setCellValue('G7', 'Merk/Tipe');
                $sheet->setCellValue('H7', 'Kuantitas');
                $sheet->setCellValue('I7', 'Nilai BMN');
                $sheet->setCellValue('J7', 'Kategori Tdk Ditemukan');
                $sheet->setCellValue('K7', 'Nama Pegawai Pengguna Barang');
                $sheet->setCellValue('L7', 'Nama Gedung');
                $sheet->setCellValue('M7', 'Nama Ruangan');
                $sheet->setCellValue('N7', 'Status PSP');
                $sheet->setCellValue('N8', 'Sudah');
                $sheet->setCellValue('O8', 'Belum');
                $sheet->setCellValue('P7', 'Nama Sub Satker');
                $sheet->setCellValue('Q7', 'Keterangan');
                $sheet->getStyle('A7:Q9')->getAlignment()->setWrapText(true);
                $huruf = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q'];
                $angka = 1;
                for ($me2 = 0; $me2 < count($huruf); $me2++) {
                    $sheet->setCellValue($huruf[$me2] . '9', $angka);
                    $angka++;
                }

                $column = 10; //titik mulai
                $bmn_tdk_ditemukan = $this->masterBmnModel->getAllBmnBySatkerTdkDitemukan($satker_id);

                if ($bmn_tdk_ditemukan != null) {
                    $no_baris = 1;
                    foreach ($bmn_tdk_ditemukan as $bmn) {
                        $sheet->setCellValue(('A' . $column), $no_baris);
                        if ($bmn['akun_id'] == '1') {
                            $ur_akun = 'PM_NON_TIK';
                        } elseif ($bmn['akun_id'] == '2') {
                            $ur_akun = 'PM_TIK';
                        } elseif ($bmn['akun_id'] == '3') {
                            $ur_akun = 'ATB';
                        } elseif ($bmn['akun_id'] == '4') {
                            $ur_akun = 'ATL';
                        }
                        $sheet->setCellValue(('B' . $column), $ur_akun);
                        $sheet->setCellValue(('C' . $column), $bmn['kd_barang']);
                        $sheet->setCellValue(('D' . $column),  $bmn['nama_barang']);
                        $sheet->setCellValue(('E' . $column), $bmn['thn_perolehan']);
                        $sheet->setCellValue(('F' . $column), $bmn['nup']);
                        $sheet->setCellValue(('G' . $column), $bmn['merk_tipe']);
                        $arr_kuantitas_inv[] = $bmn['kuantitas'];
                        $kuantitas_inv = $bmn['kuantitas'];
                        $arr_nilai_bmn_inv[] = $bmn['nilai_bmn'];
                        $nilai_bmn_inv = $bmn['nilai_bmn'];
                        $sheet->setCellValue(('H' . $column), $bmn['kuantitas']);
                        $sheet->setCellValue(('I' . $column), $bmn['nilai_bmn']);

                        if ($bmn['kondisi_brg'] != null) {
                            if ($bmn['kategori_btd'] == '1') {
                                $kategori_btd = 'Hilang';
                            } elseif ($bmn['kategori_btd'] == '2') {
                                $kategori_btd = 'Salah Kodefikasi';
                            } elseif ($bmn['kategori_btd'] == '3') {
                                $kategori_btd = 'pekerjaan renovasi/pengembangan BMN dicatat sebagai NUP baru';
                            } elseif ($bmn['kategori_btd'] == '4') {
                                $kategori_btd = 'pencatatanganda/fiktif';
                            }
                            $sheet->setCellValue(('J' . $column), $kategori_btd);
                            $kbrdn_brg_btd[] = 1;

                            $data_pegawai = $this->masterPegawaiModel->getNamaPegawai($bmn['pegawai_id']);
                            $nama_pegawai = $data_pegawai['gelar_depan'];
                            if ($data_pegawai['gelar_depan'] != null) {
                                $nama_pegawai .= ' ';
                            }
                            $nama_pegawai .= $data_pegawai['nama_pegawai'];
                            if ($data_pegawai['gelar_belakang'] != null) {
                                $nama_pegawai .= ' ';
                            }
                            $nama_pegawai .= $data_pegawai['gelar_belakang'];
                            $sheet->setCellValue(('K' . $column), $nama_pegawai);
                            $gedung = $this->masterGedungModel->getNamaGedung($bmn['gedung_id']);
                            $ruangan = $this->masterRuanganModel->getNamaRuangan($bmn['ruangan_id']);

                            if ($bmn['subsatker_id'] != null) {
                                $subsatker = $this->masterSubsatkerModel->getNamaSubsatker($bmn['subsatker_id']);
                            } else {
                                $subsatker['nama_subsatker'] = '';
                            }
                            $sheet->setCellValue(('L' . $column),  $gedung['nama_gedung']);
                            $sheet->setCellValue(('M' . $column), $ruangan['nama_ruang']);

                            if ($bmn['status_psp'] != null) {
                                if ($bmn['status_psp'] == 'S') {
                                    $sheet->setCellValue(('N' . $column), 'Sudah');
                                    $status_psp_s[] = 1;
                                } elseif ($bmn['status_psp'] == 'B') {
                                    $sheet->setCellValue(('O' . $column), 'Belum');
                                    $status_psp_b[] = 1;
                                }
                            }
                            $sheet->setCellValue(('P' . $column), $subsatker['nama_subsatker']);
                            $sheet->setCellValue(('Q' . $column), $bmn['ket']);
                        }
                        $column++;
                        $no_baris++;
                    }
                }
                $sheet->mergeCells('A' . $column . ':G' . $column);
                $sheet->setCellValue('A' . $column, 'TOTAL');
                $sheet->getStyle('A' . $column)->applyFromArray($styleArray);

                $sheet->setCellValue('H' . $column, array_sum($arr_kuantitas_inv));
                $sheet->setCellValue('I' . $column, array_sum($arr_nilai_bmn_inv));
                $sheet->setCellValue('J' . $column, array_sum($kbrdn_brg_btd));
                $sheet->setCellValue('N' . $column, array_sum($status_psp_s));
                $sheet->setCellValue('O' . $column, array_sum($status_psp_b));

                $sheet->getStyle('K' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('L' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('M' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('P' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('Q' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);

                $sheet->getStyle('A7:Q' . $column)->applyFromArray($styleBorder);
                $sheet->getStyle('A10:B' . $column - 1)->applyFromArray($styleArray);
                $sheet->getStyle('E10:E' . $column - 1)->applyFromArray($styleArray);
                $sheet->getStyle('N10:O' . $column - 1)->applyFromArray($styleArray);

                $sheet->getStyle('C10:C' . $column)->applyFromArray($styleArray2);
                $sheet->getColumnDimension('C')->setWidth(12);
                $sheet->getColumnDimension('D')->setWidth(19);
                $sheet->getColumnDimension('G')->setWidth(11);
                $sheet->getColumnDimension('G')->setAutoSize(true);
                $sheet->getColumnDimension('K')->setWidth(17);
                $sheet->getColumnDimension('L')->setWidth(16);
                $sheet->getColumnDimension('M')->setWidth(16);
                $sheet->getColumnDimension('Q')->setWidth(15);
                $sheet->getStyle('A7:Q9')->applyFromArray($styleBorder2);
                $sheet->getStyle('A1:Q9')->getFont()->setBold(true);
                $sheet->freezePane('A10');
                $column++;
                $sheet->setCellValue('A' . $column, 'Note : B=Baik, RR=Rusak Ringan, RB=Rusak Berat, BD= Barang Ditemukan, BTD=Barang Tidak Ditemukan');
                $column = $column + 2;
                $sheet->setCellValue('A' . $column, 'Keterangan :');

                //Bagian tanda tangan
                $sheet->setCellValue('N' . $column, '................, .................... ' . date('Y'));
                $sheet->setCellValue('N' . $column + 1, 'Tim Inventarisasi BMN');
                $sheet->setCellValue('N' . $column + 4, '1. ...................................................');
                $sheet->setCellValue('N' . $column + 6, '2. ...................................................');
                $sheet->setCellValue('N' . $column + 8, '3. ...................................................');
                //batas tanda tangan

                $column++;
                $awal_ket = $column;
                for ($ket_no = 1; $ket_no <= 17; $ket_no++) {
                    $sheet->setCellValue('A' . $awal_ket, $ket_no);
                    $awal_ket++;
                }
                $sheet->setCellValue('B' . $column, 'Di isi dengan nomor urut');
                $sheet->setCellValue('B' . $column + 1, 'Di isi dengan uraian akun (PM_NON_TIK, PM_TIK, ATL, ATB)');
                $sheet->setCellValue('B' . $column + 2, 'Di isi dengan kodefikasi barang di SIMAK BMN');
                $sheet->setCellValue('B' . $column + 3, 'Di isi dengan nama Barang di SIMAK BMN');
                $sheet->setCellValue('B' . $column + 4, 'Di isi dengan tahun perolehan BMN');
                $sheet->setCellValue('B' . $column + 5, 'Di isi dengan nomor urut pendaftaran (NUP)');
                $sheet->setCellValue('B' . $column + 6, 'Di isi dengan merek/tipe barang');
                $sheet->setCellValue('B' . $column + 7, 'Di isi dengan jumlah barang');
                $sheet->setCellValue('B' . $column + 8, 'Di isi dengan nilai perolehan BMN');
                $sheet->setCellValue('B' . $column + 9, 'Di isi dengan huruf kategori BTD sesuai .Juknis (misalnya hilang, salah kodefikasi dll)');
                $sheet->setCellValue('B' . $column + 10, 'Di isi dengan nama pegawai yang menggunakan barang');
                $sheet->setCellValue('B' . $column + 11, 'Di isi dengan nama gedung lokasi barang berada');
                $sheet->setCellValue('B' . $column + 12, 'Di isi dengan ama ruangan lokasi barang berada');
                $sheet->setCellValue('B' . $column + 13, 'Di isi dengan kata sudah apabila barang yang didata telah ada SK PSP');
                $sheet->setCellValue('B' . $column + 14, 'Di isi dengan kata belum apabila barang yang didata belum ada SK PSP');
                $sheet->setCellValue('B' . $column + 15, 'Di isi dengan nama Sub Satker (bagi yan memiliki Sub Satker)');
                $sheet->setCellValue('B' . $column + 16, 'Di isi dengan Keterangan yang belum terakomodasi');
            } elseif ($id_rekapitulasi == 4) {
                //inventarisasi barang kondisi baik
                $sheet->mergeCells('A1:U1');
                $sheet->setCellValue('A1', 'DAFTAR BARANG HASIL INVENTARISASI BMN KONDISI BAIK');
                $sheet->mergeCells('A2:U2');
                $sheet->setCellValue('A2', 'PADA SATUAN KERJA ' . strtoupper($nama_satker['nama_ref_unit_kerja_lengkap']));
                $sheet->getStyle('A1:U2')->applyFromArray($styleArray);
                $sheet->setCellValue('A4', 'KODE SATKER :');
                $sheet->setCellValue('A5', 'NAMA SATKER :');
                $sheet->setCellValue('C5', $nama_satker['nama_ref_unit_kerja_lengkap']);
                $merge1 = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'N', 'O', 'P', 'S', 'T'];
                for ($me = 0; $me < count($merge1); $me++) {
                    $sheet->mergeCells($merge1[$me] . '7:' . $merge1[$me] . '8');
                }
                $sheet->mergeCells('L7:M7');
                $sheet->mergeCells('Q7:R7');
                $sheet->getStyle('A7:T9')->applyFromArray($styleArray);
                $sheet->setCellValue('A7', 'No');
                $sheet->setCellValue('B7', 'Uraian Akun');
                $sheet->setCellValue('C7', 'Kode Barang');
                $sheet->setCellValue('D7', 'Nama Barang');
                $sheet->setCellValue('E7', 'Tahun Perolehan');
                $sheet->setCellValue('F7', 'NUP');
                $sheet->setCellValue('G7', 'Merk/Tipe');
                $sheet->setCellValue('H7', 'Kuantitas');
                $sheet->setCellValue('I7', 'Nilai BMN');
                $sheet->setCellValue('J7', 'Kondisi Barang Baik');
                $sheet->setCellValue('K7', 'Keberadaan Barang Ditemukan');
                $sheet->setCellValue('L7', 'Pelabelan Kodefikasi');
                $sheet->setCellValue('L8', 'Sudah');
                $sheet->setCellValue('M8', 'Belum');
                $sheet->setCellValue('N7', 'Nama Pegawai Pengguna Barang');
                $sheet->setCellValue('O7', 'Nama Gedung');
                $sheet->setCellValue('P7', 'Nama Ruangan');
                $sheet->setCellValue('Q7', 'Status PSP');
                $sheet->setCellValue('Q8', 'Sudah');
                $sheet->setCellValue('R8', 'Belum');
                $sheet->setCellValue('S7', 'Nama Sub Satker');
                $sheet->setCellValue('T7', 'Keterangan');
                $sheet->getStyle('A7:T9')->getAlignment()->setWrapText(true);
                $huruf = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T'];
                $angka = 1;
                for ($me2 = 0; $me2 < count($huruf); $me2++) {
                    $sheet->setCellValue($huruf[$me2] . '9', $angka);
                    $angka++;
                }

                $column = 10; //titik mulai
                $bmn_kondisi_baik = $this->masterBmnModel->getAllBmnBySatkerBaik($satker_id);
                if ($bmn_kondisi_baik != null) {
                    $no_baris = 1;
                    foreach ($bmn_kondisi_baik as $bmn) {
                        $sheet->setCellValue(('A' . $column), $no_baris);
                        if ($bmn['akun_id'] == '1') {
                            $ur_akun = 'PM_NON_TIK';
                        } elseif ($bmn['akun_id'] == '2') {
                            $ur_akun = 'PM_TIK';
                        } elseif ($bmn['akun_id'] == '3') {
                            $ur_akun = 'ATB';
                        } elseif ($bmn['akun_id'] == '4') {
                            $ur_akun = 'ATL';
                        }
                        $sheet->setCellValue(('B' . $column), $ur_akun);
                        $sheet->setCellValue(('C' . $column), $bmn['kd_barang']);
                        $sheet->setCellValue(('D' . $column),  $bmn['nama_barang']);
                        $sheet->setCellValue(('E' . $column), $bmn['thn_perolehan']);
                        $sheet->setCellValue(('F' . $column), $bmn['nup']);
                        $sheet->setCellValue(('G' . $column), $bmn['merk_tipe']);
                        $arr_kuantitas_inv[] = $bmn['kuantitas'];
                        $kuantitas_inv = $bmn['kuantitas'];
                        $arr_nilai_bmn_inv[] = $bmn['nilai_bmn'];
                        $nilai_bmn_inv = $bmn['nilai_bmn'];
                        $sheet->setCellValue(('H' . $column), $bmn['kuantitas']);
                        $sheet->setCellValue(('I' . $column), $bmn['nilai_bmn']);

                        if ($bmn['kondisi_brg'] != null) {
                            $sheet->setCellValue(('J' . $column), 'B');
                            $kondisi_brg_b[] = 1;
                            $sheet->setCellValue(('K' . $column), 'BD');
                            $kbrdn_brg_bd[] = 1;
                            if ($bmn['label_kode'] != null) {
                                if ($bmn['label_kode'] == 'S') {
                                    $sheet->setCellValue(('L' . $column), 'Sudah');
                                    $label_kode_s[] = 1;
                                } elseif ($bmn['label_kode'] == 'B') {
                                    $sheet->setCellValue(('M' . $column), 'Belum');
                                    $label_kode_b[] = 1;
                                }
                            }
                            $data_pegawai = $this->masterPegawaiModel->getNamaPegawai($bmn['pegawai_id']);
                            $nama_pegawai = $data_pegawai['gelar_depan'];
                            if ($data_pegawai['gelar_depan'] != null) {
                                $nama_pegawai .= ' ';
                            }
                            $nama_pegawai .= $data_pegawai['nama_pegawai'];
                            if ($data_pegawai['gelar_belakang'] != null) {
                                $nama_pegawai .= ' ';
                            }
                            $nama_pegawai .= $data_pegawai['gelar_belakang'];
                            $sheet->setCellValue(('N' . $column), $nama_pegawai);
                            $gedung = $this->masterGedungModel->getNamaGedung($bmn['gedung_id']);
                            $ruangan = $this->masterRuanganModel->getNamaRuangan($bmn['ruangan_id']);

                            if ($bmn['subsatker_id'] != null) {
                                $subsatker = $this->masterSubsatkerModel->getNamaSubsatker($bmn['subsatker_id']);
                            } else {
                                $subsatker['nama_subsatker'] = '';
                            }
                            $sheet->setCellValue(('O' . $column),  $gedung['nama_gedung']);
                            $sheet->setCellValue(('P' . $column), $ruangan['nama_ruang']);

                            if ($bmn['status_psp'] != null) {
                                if ($bmn['status_psp'] == 'S') {
                                    $sheet->setCellValue(('Q' . $column), 'Sudah');
                                    $status_psp_s[] = 1;
                                } elseif ($bmn['status_psp'] == 'B') {
                                    $sheet->setCellValue(('R' . $column), 'Belum');
                                    $status_psp_b[] = 1;
                                }
                            }
                            $sheet->setCellValue(('S' . $column), $subsatker['nama_subsatker']);
                            $sheet->setCellValue(('T' . $column), $bmn['ket']);
                        }
                        $column++;
                        $no_baris++;
                    }
                }
                $sheet->mergeCells('A' . $column . ':G' . $column);
                $sheet->setCellValue('A' . $column, 'TOTAL');
                $sheet->getStyle('A' . $column)->applyFromArray($styleArray);

                $sheet->setCellValue('H' . $column, array_sum($arr_kuantitas_inv));
                $sheet->setCellValue('I' . $column, array_sum($arr_nilai_bmn_inv));
                $sheet->setCellValue('J' . $column, array_sum($kondisi_brg_b));
                $sheet->setCellValue('K' . $column, array_sum($kbrdn_brg_bd));
                $sheet->setCellValue('L' . $column, array_sum($label_kode_s));
                $sheet->setCellValue('M' . $column, array_sum($label_kode_b));
                $sheet->setCellValue('Q' . $column, array_sum($status_psp_s));
                $sheet->setCellValue('R' . $column, array_sum($status_psp_b));

                $sheet->getStyle('N' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('O' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('P' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('S' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('T' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);

                $sheet->getStyle('A7:T' . $column)->applyFromArray($styleBorder);
                $sheet->getStyle('A10:B' . $column - 1)->applyFromArray($styleArray);
                $sheet->getStyle('E10:E' . $column - 1)->applyFromArray($styleArray);
                $sheet->getStyle('J10:M' . $column - 1)->applyFromArray($styleArray);
                $sheet->getStyle('Q10:R' . $column - 1)->applyFromArray($styleArray);

                $sheet->getStyle('C10:C' . $column)->applyFromArray($styleArray2);
                $sheet->getColumnDimension('C')->setWidth(12);
                $sheet->getColumnDimension('D')->setWidth(19);
                $sheet->getColumnDimension('G')->setWidth(11);
                $sheet->getColumnDimension('K')->setWidth(19);
                $sheet->getColumnDimension('N')->setWidth(17);
                $sheet->getColumnDimension('O')->setWidth(16);
                $sheet->getColumnDimension('P')->setWidth(16);
                $sheet->getColumnDimension('T')->setWidth(15);
                $sheet->getStyle('A7:T9')->applyFromArray($styleBorder2);
                $sheet->getStyle('A1:T9')->getFont()->setBold(true);
                $sheet->freezePane('A10');
                $column++;
                $sheet->setCellValue('A' . $column, 'Note : B=Baik, RR=Rusak Ringan, RB=Rusak Berat, BD= Barang Ditemukan, BTD=Barang Tidak Ditemukan');
                $column = $column + 2;
                $sheet->setCellValue('A' . $column, 'Keterangan :');

                //Bagian tanda tangan
                $sheet->setCellValue('Q' . $column, '................, .................... ' . date('Y'));
                $sheet->setCellValue('Q' . $column + 1, 'Tim Inventarisasi BMN');
                $sheet->setCellValue('Q' . $column + 4, '1. ...................................................');
                $sheet->setCellValue('Q' . $column + 6, '2. ...................................................');
                $sheet->setCellValue('Q' . $column + 8, '3. ...................................................');
                //batas tanda tangan

                $column++;
                $awal_ket = $column;
                for ($ket_no = 1; $ket_no <= 20; $ket_no++) {
                    $sheet->setCellValue('A' . $awal_ket, $ket_no);
                    $awal_ket++;
                }
                $sheet->setCellValue('B' . $column, 'Di isi dengan nomor urut');
                $sheet->setCellValue('B' . $column + 1, 'Di isi dengan uraian akun (PM_NON_TIK, PM_TIK, ATL, ATB)');
                $sheet->setCellValue('B' . $column + 2, 'Di isi dengan kodefikasi barang di SIMAK BMN');
                $sheet->setCellValue('B' . $column + 3, 'Di isi dengan nama Barang di SIMAK BMN');
                $sheet->setCellValue('B' . $column + 4, 'Di isi dengan tahun perolehan BMN');
                $sheet->setCellValue('B' . $column + 5, 'Di isi dengan nomor urut pendaftaran (NUP)');
                $sheet->setCellValue('B' . $column + 6, 'Di isi dengan merek/tipe barang');
                $sheet->setCellValue('B' . $column + 7, 'Di isi dengan jumlah barang');
                $sheet->setCellValue('B' . $column + 8, 'Di isi dengan nilai perolehan BMN');
                $sheet->setCellValue('B' . $column + 9, 'Di isi dengan huruf B');
                $sheet->setCellValue('B' . $column + 10, 'Di isi dengan huruf BD');
                $sheet->setCellValue('B' . $column + 11, 'Di isi dengan kata sudah apabila barang yang didata telah dilebelisasi');
                $sheet->setCellValue('B' . $column + 12, 'Di isi dengan kata belum apabila barang yang didata belum dilebelisasi');
                $sheet->setCellValue('B' . $column + 13, 'Di isi dengan nama pegawai yang menggunakan barang');
                $sheet->setCellValue('B' . $column + 14, 'Di isi dengan nama gedung lokasi barang berada');
                $sheet->setCellValue('B' . $column + 15, 'Di isi dengan ama ruangan lokasi barang berada');
                $sheet->setCellValue('B' . $column + 16, 'Di isi dengan kata sudah apabila barang yang didata telah ada SK PSP');
                $sheet->setCellValue('B' . $column + 17, 'Di isi dengan kata belum apabila barang yang didata belum ada SK PSP');
                $sheet->setCellValue('B' . $column + 18, 'Di isi dengan nama Sub Satker (bagi yan memiliki Sub Satker)');
                $sheet->setCellValue('B' . $column + 19, 'Di isi dengan Keterangan yang belum terakomodasi');
            } elseif ($id_rekapitulasi == 5) {
                //inventarisasi barang kondisi Rusak Ringan
                $sheet->mergeCells('A1:U1');
                $sheet->setCellValue('A1', 'DAFTAR BARANG HASIL INVENTARISASI BMN KONDISI RUSAK RINGAN');
                $sheet->mergeCells('A2:U2');
                $sheet->setCellValue('A2', 'PADA SATUAN KERJA ' . strtoupper($nama_satker['nama_ref_unit_kerja_lengkap']));
                $sheet->getStyle('A1:U2')->applyFromArray($styleArray);
                $sheet->setCellValue('A4', 'KODE SATKER :');
                $sheet->setCellValue('A5', 'NAMA SATKER :');
                $sheet->setCellValue('C5', $nama_satker['nama_ref_unit_kerja_lengkap']);
                $merge1 = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'N', 'O', 'P', 'S', 'T'];
                for ($me = 0; $me < count($merge1); $me++) {
                    $sheet->mergeCells($merge1[$me] . '7:' . $merge1[$me] . '8');
                }
                $sheet->mergeCells('L7:M7');
                $sheet->mergeCells('Q7:R7');
                $sheet->getStyle('A7:T9')->applyFromArray($styleArray);
                $sheet->setCellValue('A7', 'No');
                $sheet->setCellValue('B7', 'Uraian Akun');
                $sheet->setCellValue('C7', 'Kode Barang');
                $sheet->setCellValue('D7', 'Nama Barang');
                $sheet->setCellValue('E7', 'Tahun Perolehan');
                $sheet->setCellValue('F7', 'NUP');
                $sheet->setCellValue('G7', 'Merk/Tipe');
                $sheet->setCellValue('H7', 'Kuantitas');
                $sheet->setCellValue('I7', 'Nilai BMN');
                $sheet->setCellValue('J7', 'Kondisi Barang Rusak Ringan');
                $sheet->setCellValue('K7', 'Keberadaan Barang Ditemukan');
                $sheet->setCellValue('L7', 'Pelabelan Kodefikasi');
                $sheet->setCellValue('L8', 'Sudah');
                $sheet->setCellValue('M8', 'Belum');
                $sheet->setCellValue('N7', 'Nama Pegawai Pengguna Barang');
                $sheet->setCellValue('O7', 'Nama Gedung');
                $sheet->setCellValue('P7', 'Nama Ruangan');
                $sheet->setCellValue('Q7', 'Status PSP');
                $sheet->setCellValue('Q8', 'Sudah');
                $sheet->setCellValue('R8', 'Belum');
                $sheet->setCellValue('S7', 'Nama Sub Satker');
                $sheet->setCellValue('T7', 'Keterangan');
                $sheet->getStyle('A7:T9')->getAlignment()->setWrapText(true);
                $huruf = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T'];
                $angka = 1;
                for ($me2 = 0; $me2 < count($huruf); $me2++) {
                    $sheet->setCellValue($huruf[$me2] . '9', $angka);
                    $angka++;
                }

                $column = 10; //titik mulai
                $bmn_kondisi_rusak_ringan = $this->masterBmnModel->getAllBmnBySatkerRusakRingan($satker_id);

                if ($bmn_kondisi_rusak_ringan != null) {
                    $no_baris = 1;
                    foreach ($bmn_kondisi_rusak_ringan as $bmn) {
                        $sheet->setCellValue(('A' . $column), $no_baris);
                        if ($bmn['akun_id'] == '1') {
                            $ur_akun = 'PM_NON_TIK';
                        } elseif ($bmn['akun_id'] == '2') {
                            $ur_akun = 'PM_TIK';
                        } elseif ($bmn['akun_id'] == '3') {
                            $ur_akun = 'ATB';
                        } elseif ($bmn['akun_id'] == '4') {
                            $ur_akun = 'ATL';
                        }
                        $sheet->setCellValue(('B' . $column), $ur_akun);
                        $sheet->setCellValue(('C' . $column), $bmn['kd_barang']);
                        $sheet->setCellValue(('D' . $column),  $bmn['nama_barang']);
                        $sheet->setCellValue(('E' . $column), $bmn['thn_perolehan']);
                        $sheet->setCellValue(('F' . $column), $bmn['nup']);
                        $sheet->setCellValue(('G' . $column), $bmn['merk_tipe']);
                        $arr_kuantitas_inv[] = $bmn['kuantitas'];
                        $kuantitas_inv = $bmn['kuantitas'];
                        $arr_nilai_bmn_inv[] = $bmn['nilai_bmn'];
                        $nilai_bmn_inv = $bmn['nilai_bmn'];
                        $sheet->setCellValue(('H' . $column), $bmn['kuantitas']);
                        $sheet->setCellValue(('I' . $column), $bmn['nilai_bmn']);

                        if ($bmn['kondisi_brg'] != null) {
                            $sheet->setCellValue(('J' . $column), 'RR');
                            $kondisi_brg_rr[] = 1;
                            $sheet->setCellValue(('K' . $column), 'BD');
                            $kbrdn_brg_bd[] = 1;
                            if ($bmn['label_kode'] != null) {
                                if ($bmn['label_kode'] == 'S') {
                                    $sheet->setCellValue(('L' . $column), 'Sudah');
                                    $label_kode_s[] = 1;
                                } elseif ($bmn['label_kode'] == 'B') {
                                    $sheet->setCellValue(('M' . $column), 'Belum');
                                    $label_kode_b[] = 1;
                                }
                            }
                            $data_pegawai = $this->masterPegawaiModel->getNamaPegawai($bmn['pegawai_id']);
                            $nama_pegawai = $data_pegawai['gelar_depan'];
                            if ($data_pegawai['gelar_depan'] != null) {
                                $nama_pegawai .= ' ';
                            }
                            $nama_pegawai .= $data_pegawai['nama_pegawai'];
                            if ($data_pegawai['gelar_belakang'] != null) {
                                $nama_pegawai .= ' ';
                            }
                            $nama_pegawai .= $data_pegawai['gelar_belakang'];
                            $sheet->setCellValue(('N' . $column), $nama_pegawai);
                            $gedung = $this->masterGedungModel->getNamaGedung($bmn['gedung_id']);
                            $ruangan = $this->masterRuanganModel->getNamaRuangan($bmn['ruangan_id']);

                            if ($bmn['subsatker_id'] != null) {
                                $subsatker = $this->masterSubsatkerModel->getNamaSubsatker($bmn['subsatker_id']);
                            } else {
                                $subsatker['nama_subsatker'] = '';
                            }
                            $sheet->setCellValue(('O' . $column),  $gedung['nama_gedung']);
                            $sheet->setCellValue(('P' . $column), $ruangan['nama_ruang']);

                            if ($bmn['status_psp'] != null) {
                                if ($bmn['status_psp'] == 'S') {
                                    $sheet->setCellValue(('Q' . $column), 'Sudah');
                                    $status_psp_s[] = 1;
                                } elseif ($bmn['status_psp'] == 'B') {
                                    $sheet->setCellValue(('R' . $column), 'Belum');
                                    $status_psp_b[] = 1;
                                }
                            }
                            $sheet->setCellValue(('S' . $column), $subsatker['nama_subsatker']);
                            $sheet->setCellValue(('T' . $column), $bmn['ket']);
                        }
                        $column++;
                        $no_baris++;
                    }
                }
                $sheet->mergeCells('A' . $column . ':G' . $column);
                $sheet->setCellValue('A' . $column, 'TOTAL');
                $sheet->getStyle('A' . $column)->applyFromArray($styleArray);

                $sheet->setCellValue('H' . $column, array_sum($arr_kuantitas_inv));
                $sheet->setCellValue('I' . $column, array_sum($arr_nilai_bmn_inv));
                $sheet->setCellValue('J' . $column, array_sum($kondisi_brg_rr));
                $sheet->setCellValue('K' . $column, array_sum($kbrdn_brg_bd));
                $sheet->setCellValue('L' . $column, array_sum($label_kode_s));
                $sheet->setCellValue('M' . $column, array_sum($label_kode_b));
                $sheet->setCellValue('Q' . $column, array_sum($status_psp_s));
                $sheet->setCellValue('R' . $column, array_sum($status_psp_b));

                $sheet->getStyle('N' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('O' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('P' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('S' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('T' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);

                $sheet->getStyle('A7:T' . $column)->applyFromArray($styleBorder);
                $sheet->getStyle('A10:B' . $column - 1)->applyFromArray($styleArray);
                $sheet->getStyle('E10:E' . $column - 1)->applyFromArray($styleArray);
                $sheet->getStyle('J10:M' . $column - 1)->applyFromArray($styleArray);
                $sheet->getStyle('Q10:R' . $column - 1)->applyFromArray($styleArray);

                $sheet->getStyle('C10:C' . $column)->applyFromArray($styleArray2);
                $sheet->getColumnDimension('C')->setWidth(12);
                $sheet->getColumnDimension('D')->setWidth(19);
                $sheet->getColumnDimension('G')->setWidth(11);
                $sheet->getColumnDimension('K')->setWidth(19);
                $sheet->getColumnDimension('N')->setWidth(17);
                $sheet->getColumnDimension('O')->setWidth(16);
                $sheet->getColumnDimension('P')->setWidth(16);
                $sheet->getColumnDimension('T')->setWidth(15);
                $sheet->getStyle('A7:T9')->applyFromArray($styleBorder2);
                $sheet->getStyle('A1:T9')->getFont()->setBold(true);
                $sheet->freezePane('A10');
                $column++;
                $sheet->setCellValue('A' . $column, 'Note : B=Baik, RR=Rusak Ringan, RB=Rusak Berat, BD= Barang Ditemukan, BTD=Barang Tidak Ditemukan');
                $column = $column + 2;
                $sheet->setCellValue('A' . $column, 'Keterangan :');

                //Bagian tanda tangan
                $sheet->setCellValue('Q' . $column, '................, .................... ' . date('Y'));
                $sheet->setCellValue('Q' . $column + 1, 'Tim Inventarisasi BMN');
                $sheet->setCellValue('Q' . $column + 4, '1. ...................................................');
                $sheet->setCellValue('Q' . $column + 6, '2. ...................................................');
                $sheet->setCellValue('Q' . $column + 8, '3. ...................................................');
                //batas tanda tangan

                $column++;
                $awal_ket = $column;
                for ($ket_no = 1; $ket_no <= 20; $ket_no++) {
                    $sheet->setCellValue('A' . $awal_ket, $ket_no);
                    $awal_ket++;
                }
                $sheet->setCellValue('B' . $column, 'Di isi dengan nomor urut');
                $sheet->setCellValue('B' . $column + 1, 'Di isi dengan uraian akun (PM_NON_TIK, PM_TIK, ATL, ATB)');
                $sheet->setCellValue('B' . $column + 2, 'Di isi dengan kodefikasi barang di SIMAK BMN');
                $sheet->setCellValue('B' . $column + 3, 'Di isi dengan nama Barang di SIMAK BMN');
                $sheet->setCellValue('B' . $column + 4, 'Di isi dengan tahun perolehan BMN');
                $sheet->setCellValue('B' . $column + 5, 'Di isi dengan nomor urut pendaftaran (NUP)');
                $sheet->setCellValue('B' . $column + 6, 'Di isi dengan merek/tipe barang');
                $sheet->setCellValue('B' . $column + 7, 'Di isi dengan jumlah barang');
                $sheet->setCellValue('B' . $column + 8, 'Di isi dengan nilai perolehan BMN');
                $sheet->setCellValue('B' . $column + 9, 'Di isi dengan huruf RR');
                $sheet->setCellValue('B' . $column + 10, 'Di isi dengan huruf BD');
                $sheet->setCellValue('B' . $column + 11, 'Di isi dengan kata sudah apabila barang yang didata telah dilebelisasi');
                $sheet->setCellValue('B' . $column + 12, 'Di isi dengan kata belum apabila barang yang didata belum dilebelisasi');
                $sheet->setCellValue('B' . $column + 13, 'Di isi dengan nama pegawai yang menggunakan barang');
                $sheet->setCellValue('B' . $column + 14, 'Di isi dengan nama gedung lokasi barang berada');
                $sheet->setCellValue('B' . $column + 15, 'Di isi dengan ama ruangan lokasi barang berada');
                $sheet->setCellValue('B' . $column + 16, 'Di isi dengan kata sudah apabila barang yang didata telah ada SK PSP');
                $sheet->setCellValue('B' . $column + 17, 'Di isi dengan kata belum apabila barang yang didata belum ada SK PSP');
                $sheet->setCellValue('B' . $column + 18, 'Di isi dengan nama Sub Satker (bagi yan memiliki Sub Satker)');
                $sheet->setCellValue('B' . $column + 19, 'Di isi dengan Keterangan yang belum terakomodasi');
            } elseif ($id_rekapitulasi == 6) {
                //inventarisasi barang kondisi Rusak Berat
                $sheet->mergeCells('A1:U1');
                $sheet->setCellValue('A1', 'DAFTAR BARANG HASIL INVENTARISASI BMN KONDISI RUSAK BERAT');
                $sheet->mergeCells('A2:U2');
                $sheet->setCellValue('A2', 'PADA SATUAN KERJA ' . strtoupper($nama_satker['nama_ref_unit_kerja_lengkap']));
                $sheet->getStyle('A1:U2')->applyFromArray($styleArray);
                $sheet->setCellValue('A4', 'KODE SATKER :');
                $sheet->setCellValue('A5', 'NAMA SATKER :');
                $sheet->setCellValue('C5', $nama_satker['nama_ref_unit_kerja_lengkap']);
                $merge1 = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'N', 'O', 'P', 'S', 'T'];
                for ($me = 0; $me < count($merge1); $me++) {
                    $sheet->mergeCells($merge1[$me] . '7:' . $merge1[$me] . '8');
                }
                $sheet->mergeCells('L7:M7');
                $sheet->mergeCells('Q7:R7');
                $sheet->getStyle('A7:T9')->applyFromArray($styleArray);
                $sheet->setCellValue('A7', 'No');
                $sheet->setCellValue('B7', 'Uraian Akun');
                $sheet->setCellValue('C7', 'Kode Barang');
                $sheet->setCellValue('D7', 'Nama Barang');
                $sheet->setCellValue('E7', 'Tahun Perolehan');
                $sheet->setCellValue('F7', 'NUP');
                $sheet->setCellValue('G7', 'Merk/Tipe');
                $sheet->setCellValue('H7', 'Kuantitas');
                $sheet->setCellValue('I7', 'Nilai BMN');
                $sheet->setCellValue('J7', 'Kondisi Barang Rusak Berat');
                $sheet->setCellValue('K7', 'Keberadaan Barang Ditemukan');
                $sheet->setCellValue('L7', 'Pelabelan Kodefikasi');
                $sheet->setCellValue('L8', 'Sudah');
                $sheet->setCellValue('M8', 'Belum');
                $sheet->setCellValue('N7', 'Nama Pegawai Pengguna Barang');
                $sheet->setCellValue('O7', 'Nama Gedung');
                $sheet->setCellValue('P7', 'Nama Ruangan');
                $sheet->setCellValue('Q7', 'Status PSP');
                $sheet->setCellValue('Q8', 'Sudah');
                $sheet->setCellValue('R8', 'Belum');
                $sheet->setCellValue('S7', 'Nama Sub Satker');
                $sheet->setCellValue('T7', 'Keterangan');
                $sheet->getStyle('A7:T9')->getAlignment()->setWrapText(true);
                $huruf = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T'];
                $angka = 1;
                for ($me2 = 0; $me2 < count($huruf); $me2++) {
                    $sheet->setCellValue($huruf[$me2] . '9', $angka);
                    $angka++;
                }

                $column = 10; //titik mulai
                $bmn_kondisi_rusak_berat = $this->masterBmnModel->getAllBmnBySatkerRusakBerat($satker_id);

                if ($bmn_kondisi_rusak_berat != null) {
                    $no_baris = 1;
                    foreach ($bmn_kondisi_rusak_berat as $bmn) {
                        $sheet->setCellValue(('A' . $column), $no_baris);
                        if ($bmn['akun_id'] == '1') {
                            $ur_akun = 'PM_NON_TIK';
                        } elseif ($bmn['akun_id'] == '2') {
                            $ur_akun = 'PM_TIK';
                        } elseif ($bmn['akun_id'] == '3') {
                            $ur_akun = 'ATB';
                        } elseif ($bmn['akun_id'] == '4') {
                            $ur_akun = 'ATL';
                        }
                        $sheet->setCellValue(('B' . $column), $ur_akun);
                        $sheet->setCellValue(('C' . $column), $bmn['kd_barang']);
                        $sheet->setCellValue(('D' . $column),  $bmn['nama_barang']);
                        $sheet->setCellValue(('E' . $column), $bmn['thn_perolehan']);
                        $sheet->setCellValue(('F' . $column), $bmn['nup']);
                        $sheet->setCellValue(('G' . $column), $bmn['merk_tipe']);
                        $arr_kuantitas_inv[] = $bmn['kuantitas'];
                        $kuantitas_inv = $bmn['kuantitas'];
                        $arr_nilai_bmn_inv[] = $bmn['nilai_bmn'];
                        $nilai_bmn_inv = $bmn['nilai_bmn'];
                        $sheet->setCellValue(('H' . $column), $bmn['kuantitas']);
                        $sheet->setCellValue(('I' . $column), $bmn['nilai_bmn']);

                        if ($bmn['kondisi_brg'] != null) {
                            $sheet->setCellValue(('J' . $column), 'RB');
                            $kondisi_brg_rr[] = 1;
                            $sheet->setCellValue(('K' . $column), 'BD');
                            $kbrdn_brg_bd[] = 1;
                            if ($bmn['label_kode'] != null) {
                                if ($bmn['label_kode'] == 'S') {
                                    $sheet->setCellValue(('L' . $column), 'Sudah');
                                    $label_kode_s[] = 1;
                                } elseif ($bmn['label_kode'] == 'B') {
                                    $sheet->setCellValue(('M' . $column), 'Belum');
                                    $label_kode_b[] = 1;
                                }
                            }
                            $data_pegawai = $this->masterPegawaiModel->getNamaPegawai($bmn['pegawai_id']);
                            $nama_pegawai = $data_pegawai['gelar_depan'];
                            if ($data_pegawai['gelar_depan'] != null) {
                                $nama_pegawai .= ' ';
                            }
                            $nama_pegawai .= $data_pegawai['nama_pegawai'];
                            if ($data_pegawai['gelar_belakang'] != null) {
                                $nama_pegawai .= ' ';
                            }
                            $nama_pegawai .= $data_pegawai['gelar_belakang'];
                            $sheet->setCellValue(('N' . $column), $nama_pegawai);
                            $gedung = $this->masterGedungModel->getNamaGedung($bmn['gedung_id']);
                            $ruangan = $this->masterRuanganModel->getNamaRuangan($bmn['ruangan_id']);

                            if ($bmn['subsatker_id'] != null) {
                                $subsatker = $this->masterSubsatkerModel->getNamaSubsatker($bmn['subsatker_id']);
                            } else {
                                $subsatker['nama_subsatker'] = '';
                            }
                            $sheet->setCellValue(('O' . $column),  $gedung['nama_gedung']);
                            $sheet->setCellValue(('P' . $column), $ruangan['nama_ruang']);

                            if ($bmn['status_psp'] != null) {
                                if ($bmn['status_psp'] == 'S') {
                                    $sheet->setCellValue(('Q' . $column), 'Sudah');
                                    $status_psp_s[] = 1;
                                } elseif ($bmn['status_psp'] == 'B') {
                                    $sheet->setCellValue(('R' . $column), 'Belum');
                                    $status_psp_b[] = 1;
                                }
                            }
                            $sheet->setCellValue(('S' . $column), $subsatker['nama_subsatker']);
                            $sheet->setCellValue(('T' . $column), $bmn['ket']);
                        }
                        $column++;
                        $no_baris++;
                    }
                }
                $sheet->mergeCells('A' . $column . ':G' . $column);
                $sheet->setCellValue('A' . $column, 'TOTAL');
                $sheet->getStyle('A' . $column)->applyFromArray($styleArray);

                $sheet->setCellValue('H' . $column, array_sum($arr_kuantitas_inv));
                $sheet->setCellValue('I' . $column, array_sum($arr_nilai_bmn_inv));
                $sheet->setCellValue('J' . $column, array_sum($kondisi_brg_rr));
                $sheet->setCellValue('K' . $column, array_sum($kbrdn_brg_bd));
                $sheet->setCellValue('L' . $column, array_sum($label_kode_s));
                $sheet->setCellValue('M' . $column, array_sum($label_kode_b));
                $sheet->setCellValue('Q' . $column, array_sum($status_psp_s));
                $sheet->setCellValue('R' . $column, array_sum($status_psp_b));

                $sheet->getStyle('N' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('O' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('P' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('S' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('T' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);

                $sheet->getStyle('A7:T' . $column)->applyFromArray($styleBorder);
                $sheet->getStyle('A10:B' . $column - 1)->applyFromArray($styleArray);
                $sheet->getStyle('E10:E' . $column - 1)->applyFromArray($styleArray);
                $sheet->getStyle('J10:M' . $column - 1)->applyFromArray($styleArray);
                $sheet->getStyle('Q10:R' . $column - 1)->applyFromArray($styleArray);

                $sheet->getStyle('C10:C' . $column)->applyFromArray($styleArray2);
                $sheet->getColumnDimension('C')->setWidth(12);
                $sheet->getColumnDimension('D')->setWidth(19);
                $sheet->getColumnDimension('G')->setWidth(11);
                $sheet->getColumnDimension('K')->setWidth(19);
                $sheet->getColumnDimension('N')->setWidth(17);
                $sheet->getColumnDimension('O')->setWidth(16);
                $sheet->getColumnDimension('P')->setWidth(16);
                $sheet->getColumnDimension('T')->setWidth(15);
                $sheet->getStyle('A7:T9')->applyFromArray($styleBorder2);
                $sheet->getStyle('A1:T9')->getFont()->setBold(true);
                $sheet->freezePane('A10');
                $column++;
                $sheet->setCellValue('A' . $column, 'Note : B=Baik, RR=Rusak Ringan, RB=Rusak Berat, BD= Barang Ditemukan, BTD=Barang Tidak Ditemukan');
                $column = $column + 2;
                $sheet->setCellValue('A' . $column, 'Keterangan :');

                //Bagian tanda tangan
                $sheet->setCellValue('Q' . $column, '................, .................... ' . date('Y'));
                $sheet->setCellValue('Q' . $column + 1, 'Tim Inventarisasi BMN');
                $sheet->setCellValue('Q' . $column + 4, '1. ...................................................');
                $sheet->setCellValue('Q' . $column + 6, '2. ...................................................');
                $sheet->setCellValue('Q' . $column + 8, '3. ...................................................');
                //batas tanda tangan

                $column++;
                $awal_ket = $column;
                for ($ket_no = 1; $ket_no <= 20; $ket_no++) {
                    $sheet->setCellValue('A' . $awal_ket, $ket_no);
                    $awal_ket++;
                }
                $sheet->setCellValue('B' . $column, 'Di isi dengan nomor urut');
                $sheet->setCellValue('B' . $column + 1, 'Di isi dengan uraian akun (PM_NON_TIK, PM_TIK, ATL, ATB)');
                $sheet->setCellValue('B' . $column + 2, 'Di isi dengan kodefikasi barang di SIMAK BMN');
                $sheet->setCellValue('B' . $column + 3, 'Di isi dengan nama Barang di SIMAK BMN');
                $sheet->setCellValue('B' . $column + 4, 'Di isi dengan tahun perolehan BMN');
                $sheet->setCellValue('B' . $column + 5, 'Di isi dengan nomor urut pendaftaran (NUP)');
                $sheet->setCellValue('B' . $column + 6, 'Di isi dengan merek/tipe barang');
                $sheet->setCellValue('B' . $column + 7, 'Di isi dengan jumlah barang');
                $sheet->setCellValue('B' . $column + 8, 'Di isi dengan nilai perolehan BMN');
                $sheet->setCellValue('B' . $column + 9, 'Di isi dengan huruf RB');
                $sheet->setCellValue('B' . $column + 10, 'Di isi dengan huruf BD');
                $sheet->setCellValue('B' . $column + 11, 'Di isi dengan kata sudah apabila barang yang didata telah dilebelisasi');
                $sheet->setCellValue('B' . $column + 12, 'Di isi dengan kata belum apabila barang yang didata belum dilebelisasi');
                $sheet->setCellValue('B' . $column + 13, 'Di isi dengan nama pegawai yang menggunakan barang');
                $sheet->setCellValue('B' . $column + 14, 'Di isi dengan nama gedung lokasi barang berada');
                $sheet->setCellValue('B' . $column + 15, 'Di isi dengan ama ruangan lokasi barang berada');
                $sheet->setCellValue('B' . $column + 16, 'Di isi dengan kata sudah apabila barang yang didata telah ada SK PSP');
                $sheet->setCellValue('B' . $column + 17, 'Di isi dengan kata belum apabila barang yang didata belum ada SK PSP');
                $sheet->setCellValue('B' . $column + 18, 'Di isi dengan nama Sub Satker (bagi yan memiliki Sub Satker)');
                $sheet->setCellValue('B' . $column + 19, 'Di isi dengan Keterangan yang belum terakomodasi');
            } elseif ($id_rekapitulasi == 7) {
                //inventarisasi barang kondisi Berlebih
                $sheet->mergeCells('A1:U1');
                $sheet->setCellValue('A1', 'DAFTAR BARANG HASIL INVENTARISASI BMN BERLEBIH');
                $sheet->mergeCells('A2:U2');
                $sheet->setCellValue('A2', 'PADA SATUAN KERJA ' . strtoupper($nama_satker['nama_ref_unit_kerja_lengkap']));
                $sheet->getStyle('A1:U2')->applyFromArray($styleArray);
                $sheet->setCellValue('A4', 'KODE SATKER :');
                $sheet->setCellValue('A5', 'NAMA SATKER :');
                $sheet->setCellValue('C5', $nama_satker['nama_ref_unit_kerja_lengkap']);
                $merge1 = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'M', 'N', 'O', 'P', 'Q', 'R'];
                for ($me = 0; $me < count($merge1); $me++) {
                    $sheet->mergeCells($merge1[$me] . '7:' . $merge1[$me] . '8');
                }
                $sheet->mergeCells('J7:L7');
                $sheet->getStyle('A7:R9')->applyFromArray($styleArray);
                $sheet->setCellValue('A7', 'No');
                $sheet->setCellValue('B7', 'Uraian Akun');
                $sheet->setCellValue('C7', 'Kode Barang');
                $sheet->setCellValue('D7', 'Nama Barang');
                $sheet->setCellValue('E7', 'Tahun Perolehan');
                $sheet->setCellValue('F7', 'NUP');
                $sheet->setCellValue('G7', 'Merk/Tipe');
                $sheet->setCellValue('H7', 'Kuantitas');
                $sheet->setCellValue('I7', 'Nilai BMN');
                $sheet->setCellValue('J7', 'Kondisi Barang');
                $sheet->setCellValue('J8', 'B');
                $sheet->setCellValue('K8', 'RR');
                $sheet->setCellValue('L8', 'RB');
                $sheet->setCellValue('M7', 'Kategori Barang Berlebih');
                $sheet->setCellValue('N7', 'Nama Pegawai Pengguna Barang');
                $sheet->setCellValue('O7', 'Nama Gedung');
                $sheet->setCellValue('P7', 'Nama Ruangan');
                $sheet->setCellValue('Q7', 'Nama Sub Satker');
                $sheet->setCellValue('R7', 'Keterangan');
                $sheet->getStyle('A7:T9')->getAlignment()->setWrapText(true);
                $huruf = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R'];
                $angka = 1;
                for ($me2 = 0; $me2 < count($huruf); $me2++) {
                    $sheet->setCellValue($huruf[$me2] . '9', $angka);
                    $angka++;
                }

                $column = 10; //titik mulai
                $bmn_berlebih = $this->masterBmnModel->getAllBmnBySatkerBerlebih($satker_id);

                if ($bmn_berlebih != null) {
                    $no_baris = 1;
                    foreach ($bmn_berlebih as $bmn) {
                        $sheet->setCellValue(('A' . $column), $no_baris);
                        if ($bmn['akun_id'] == '1') {
                            $ur_akun = 'PM_NON_TIK';
                        } elseif ($bmn['akun_id'] == '2') {
                            $ur_akun = 'PM_TIK';
                        } elseif ($bmn['akun_id'] == '3') {
                            $ur_akun = 'ATB';
                        } elseif ($bmn['akun_id'] == '4') {
                            $ur_akun = 'ATL';
                        }
                        $sheet->setCellValue(('B' . $column), $ur_akun);
                        $sheet->setCellValue(('C' . $column), $bmn['kd_barang']);
                        $sheet->setCellValue(('D' . $column),  $bmn['nama_barang']);
                        $sheet->setCellValue(('E' . $column), $bmn['thn_perolehan']);
                        $sheet->setCellValue(('F' . $column), $bmn['nup']);
                        $sheet->setCellValue(('G' . $column), $bmn['merk_tipe']);
                        $arr_kuantitas_inv[] = $bmn['kuantitas'];
                        $kuantitas_inv = $bmn['kuantitas'];
                        $arr_nilai_bmn_inv[] = $bmn['nilai_bmn'];
                        $nilai_bmn_inv = $bmn['nilai_bmn'];
                        $sheet->setCellValue(('H' . $column), $bmn['kuantitas']);
                        $sheet->setCellValue(('I' . $column), $bmn['nilai_bmn']);

                        if ($bmn['kondisi_brg'] != null) {

                            if ($bmn['kondisi_brg'] == 'B') {
                                $sheet->setCellValue(('J' . $column), 'B');
                                $kondisi_brg_b[] = 1;
                            } elseif ($bmn['kondisi_brg'] == 'RR') {
                                $sheet->setCellValue(('K' . $column), 'RR');
                                $kondisi_brg_rr[] = 1;
                            } elseif ($bmn['kondisi_brg'] == 'RB') {
                                $sheet->setCellValue(('L' . $column), 'RB');
                                $kondisi_brg_rb[] = 1;
                            }

                            $sheet->setCellValue(('M' . $column), 'Berlebih');
                            $kbrdn_brg_br[] = 1;

                            $data_pegawai = $this->masterPegawaiModel->getNamaPegawai($bmn['pegawai_id']);
                            $nama_pegawai = $data_pegawai['gelar_depan'];
                            if ($data_pegawai['gelar_depan'] != null) {
                                $nama_pegawai .= ' ';
                            }
                            $nama_pegawai .= $data_pegawai['nama_pegawai'];
                            if ($data_pegawai['gelar_belakang'] != null) {
                                $nama_pegawai .= ' ';
                            }
                            $nama_pegawai .= $data_pegawai['gelar_belakang'];
                            $sheet->setCellValue(('N' . $column), $nama_pegawai);
                            $gedung = $this->masterGedungModel->getNamaGedung($bmn['gedung_id']);
                            $ruangan = $this->masterRuanganModel->getNamaRuangan($bmn['ruangan_id']);

                            if ($bmn['subsatker_id'] != null) {
                                $subsatker = $this->masterSubsatkerModel->getNamaSubsatker($bmn['subsatker_id']);
                            } else {
                                $subsatker['nama_subsatker'] = '';
                            }
                            $sheet->setCellValue(('O' . $column),  $gedung['nama_gedung']);
                            $sheet->setCellValue(('P' . $column), $ruangan['nama_ruang']);
                            $sheet->setCellValue(('Q' . $column), $subsatker['nama_subsatker']);
                            $sheet->setCellValue(('R' . $column), $bmn['ket']);
                        }
                        $column++;
                        $no_baris++;
                    }
                }
                $sheet->mergeCells('A' . $column . ':G' . $column);
                $sheet->setCellValue('A' . $column, 'TOTAL');
                $sheet->getStyle('A' . $column)->applyFromArray($styleArray);

                $sheet->setCellValue('H' . $column, array_sum($arr_kuantitas_inv));
                $sheet->setCellValue('I' . $column, array_sum($arr_nilai_bmn_inv));
                $sheet->setCellValue('J' . $column, array_sum($kondisi_brg_b));
                $sheet->setCellValue('K' . $column, array_sum($kondisi_brg_rr));
                $sheet->setCellValue('L' . $column, array_sum($kondisi_brg_rb));
                $sheet->setCellValue('M' . $column, array_sum($kbrdn_brg_br));

                $sheet->getStyle('N' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('O' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('P' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('Q' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('R' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);

                $sheet->getStyle('A7:R' . $column)->applyFromArray($styleBorder);
                $sheet->getStyle('A10:B' . $column - 1)->applyFromArray($styleArray);
                $sheet->getStyle('E10:E' . $column - 1)->applyFromArray($styleArray);
                $sheet->getStyle('J10:L' . $column - 1)->applyFromArray($styleArray);

                $sheet->getStyle('C10:C' . $column)->applyFromArray($styleArray2);
                $sheet->getColumnDimension('C')->setWidth(12);
                $sheet->getColumnDimension('D')->setWidth(19);
                $sheet->getColumnDimension('G')->setWidth(11);
                $sheet->getColumnDimension('N')->setWidth(17);
                $sheet->getColumnDimension('O')->setWidth(16);
                $sheet->getColumnDimension('P')->setWidth(16);
                $sheet->getColumnDimension('R')->setWidth(15);
                $sheet->getStyle('A7:R9')->applyFromArray($styleBorder2);
                $sheet->getStyle('A1:R9')->getFont()->setBold(true);
                $sheet->freezePane('A10');
                $column++;
                $sheet->setCellValue('A' . $column, 'Note : B=Baik, RR=Rusak Ringan, RB=Rusak Berat, BD= Barang Ditemukan, BTD=Barang Tidak Ditemukan');
                $column = $column + 2;
                $sheet->setCellValue('A' . $column, 'Keterangan :');

                //Bagian tanda tangan
                // $sheet->setCellValue('Q' . $column, '................, .................... ' . date('Y'));
                // $sheet->setCellValue('Q' . $column + 1, 'Tim Inventarisasi BMN');
                // $sheet->setCellValue('Q' . $column + 4, '1. ...................................................');
                // $sheet->setCellValue('Q' . $column + 6, '2. ...................................................');
                // $sheet->setCellValue('Q' . $column + 8, '3. ...................................................');
                // batas tanda tangan

                $column++;
                $awal_ket = $column;
                for ($ket_no = 1; $ket_no <= 18; $ket_no++) {
                    $sheet->setCellValue('A' . $awal_ket, $ket_no);
                    $awal_ket++;
                }
                $sheet->setCellValue('B' . $column, 'Di isi dengan nomor urut');
                $sheet->setCellValue('B' . $column + 1, 'Di isi dengan uraian akun (PM_NON_TIK, PM_TIK, ATL, ATB)');
                $sheet->setCellValue('B' . $column + 2, 'Di isi dengan kodefikasi barang di SIMAK BMN');
                $sheet->setCellValue('B' . $column + 3, 'Di isi dengan nama Barang di SIMAK BMN');
                $sheet->setCellValue('B' . $column + 4, 'Di isi dengan tahun perolehan BMN');
                $sheet->setCellValue('B' . $column + 5, 'Di isi dengan nomor urut pendaftaran (NUP)');
                $sheet->setCellValue('B' . $column + 6, 'Di isi dengan merek/tipe barang');
                $sheet->setCellValue('B' . $column + 7, 'Di isi dengan jumlah barang');
                $sheet->setCellValue('B' . $column + 8, 'Di isi dengan nilai perolehan BMN');
                $sheet->setCellValue('B' . $column + 9, 'Di isi dengan huruf B');
                $sheet->setCellValue('B' . $column + 10, 'Di isi dengan huruf RR');
                $sheet->setCellValue('B' . $column + 11, 'Di isi dengan huruf RB');
                $sheet->setCellValue('B' . $column + 12, 'Di isi dengan kata berlebih');
                $sheet->setCellValue('B' . $column + 13, 'Di isi dengan nama pegawai yang menggunakan barang');
                $sheet->setCellValue('B' . $column + 14, 'Di isi dengan nama gedung lokasi barang berada');
                $sheet->setCellValue('B' . $column + 15, 'Di isi dengan ama ruangan lokasi barang berada');
                $sheet->setCellValue('B' . $column + 16, 'Di isi dengan nama Sub Satker (bagi yan memiliki Sub Satker)');
                $sheet->setCellValue('B' . $column + 17, 'Di isi dengan Keterangan yang belum terakomodasi');
            } elseif ($id_rekapitulasi == 8) {
                //inventarisasi barang kondisi Berlebih
                $sheet->mergeCells('A1:U1');
                $sheet->setCellValue('A1', 'DAFTAR BARANG HASIL INVENTARISASI BMN NILAI MINUS');
                $sheet->mergeCells('A2:U2');
                $sheet->setCellValue('A2', 'PADA SATUAN KERJA ' . strtoupper($nama_satker['nama_ref_unit_kerja_lengkap']));
                $sheet->getStyle('A1:U2')->applyFromArray($styleArray);
                $sheet->setCellValue('A4', 'KODE SATKER :');
                $sheet->setCellValue('A5', 'NAMA SATKER :');
                $sheet->setCellValue('C5', $nama_satker['nama_ref_unit_kerja_lengkap']);
                $merge1 = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'R', 'S'];
                for ($me = 0; $me < count($merge1); $me++) {
                    $sheet->mergeCells($merge1[$me] . '7:' . $merge1[$me] . '8');
                }
                $sheet->mergeCells('H7:J7');
                $sheet->mergeCells('K7:M7');
                $sheet->mergeCells('N7:O7');
                $sheet->mergeCells('P7:Q7');
                $sheet->getStyle('A7:R9')->applyFromArray($styleArray);
                $sheet->setCellValue('A7', 'No');
                $sheet->setCellValue('B7', 'Uraian Akun');
                $sheet->setCellValue('C7', 'Kode Barang');
                $sheet->setCellValue('D7', 'Nama Barang');
                $sheet->setCellValue('E7', 'Tahun Perolehan');
                $sheet->setCellValue('F7', 'NUP');
                $sheet->setCellValue('G7', 'Merk/Tipe');
                $sheet->setCellValue('H7', 'Nilai Minus');
                $sheet->setCellValue('H8', 'Kuantitas');
                $sheet->setCellValue('I8', 'Nilai BMN');
                $sheet->setCellValue('J8', 'Nilai Buku');
                $sheet->setCellValue('K7', 'Kondisi Barang');
                $sheet->setCellValue('K8', 'B');
                $sheet->setCellValue('L8', 'RR');
                $sheet->setCellValue('M8', 'RB');
                $sheet->setCellValue('N7', 'Keberadaan Barang');
                $sheet->setCellValue('N8', 'BD');
                $sheet->setCellValue('O8', 'BTD');
                $sheet->setCellValue('P7', 'Status PSP');
                $sheet->setCellValue('P8', 'Sudah');
                $sheet->setCellValue('Q8', 'Belum');
                $sheet->setCellValue('R7', 'Nama Sub Satker');
                $sheet->setCellValue('S7', 'Keterangan');
                $sheet->getStyle('A7:T9')->getAlignment()->setWrapText(true);
                $huruf = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S'];
                $angka = 1;
                for ($me2 = 0; $me2 < count($huruf); $me2++) {
                    $sheet->setCellValue($huruf[$me2] . '9', $angka);
                    $angka++;
                }

                $column = 10; //titik mulai
                $bmn_nilai_minus = $this->masterBmnModel->getAllBmnBySatkerNilaiMinus($satker_id);
                if ($bmn_nilai_minus != null) {
                    $no_baris = 1;
                    foreach ($bmn_nilai_minus as $bmn) {
                        $sheet->setCellValue(('A' . $column), $no_baris);
                        if ($bmn['akun_id'] == '1') {
                            $ur_akun = 'PM_NON_TIK';
                        } elseif ($bmn['akun_id'] == '2') {
                            $ur_akun = 'PM_TIK';
                        } elseif ($bmn['akun_id'] == '3') {
                            $ur_akun = 'ATB';
                        } elseif ($bmn['akun_id'] == '4') {
                            $ur_akun = 'ATL';
                        }
                        $sheet->setCellValue(('B' . $column), $ur_akun);
                        $sheet->setCellValue(('C' . $column), $bmn['kd_barang']);
                        $sheet->setCellValue(('D' . $column),  $bmn['nama_barang']);
                        $sheet->setCellValue(('E' . $column), $bmn['thn_perolehan']);
                        $sheet->setCellValue(('F' . $column), $bmn['nup']);
                        $sheet->setCellValue(('G' . $column), $bmn['merk_tipe']);

                        $arr_kuantitas_inv[] = $bmn['kuantitas'];
                        $kuantitas_inv = $bmn['kuantitas'];
                        $arr_nilai_bmn_inv[] = $bmn['nilai_bmn'];
                        $nilai_bmn_inv = $bmn['nilai_bmn'];
                        $arr_nilai_bmn_minus[] = $bmn['nilai_bmn_minus'];
                        $nilai_bmn_minus = $bmn['nilai_bmn_minus'];
                        $sheet->setCellValue(('H' . $column), $bmn['kuantitas']);
                        $sheet->setCellValue(('I' . $column), $bmn['nilai_bmn']);
                        $sheet->setCellValue(('J' . $column), $bmn['nilai_bmn_minus']);


                        if ($bmn['kondisi_brg'] != null) {
                            if ($bmn['kondisi_brg'] == 'B') {
                                $sheet->setCellValue(('K' . $column), 'B');
                                $kondisi_brg_b[] = 1;
                            } elseif ($bmn['kondisi_brg'] == 'RR') {
                                $sheet->setCellValue(('L' . $column), 'RR');
                                $kondisi_brg_rr[] = 1;
                            } elseif ($bmn['kondisi_brg'] == 'RB') {
                                $sheet->setCellValue(('M' . $column), 'RB');
                                $kondisi_brg_rb[] = 1;
                            }

                            if ($bmn['kbrdn_brg'] == 'BD') {
                                $sheet->setCellValue(('N' . $column), 'BD');
                                $kbrdn_brg_bd[] = 1;
                            } elseif ($bmn['kbrdn_brg'] == 'BTD') {
                                if ($bmn['kategori_btd'] == '1') {
                                    $kategori_btd = 'Hilang';
                                } elseif ($bmn['kategori_btd'] == '2') {
                                    $kategori_btd = 'Salah Kodefikasi';
                                } elseif ($bmn['kategori_btd'] == '3') {
                                    $kategori_btd = 'pekerjaan renovasi/pengembangan BMN dicatat sebagai NUP baru';
                                } elseif ($bmn['kategori_btd'] == '4') {
                                    $kategori_btd = 'pencatatanganda/fiktif';
                                }
                                $sheet->setCellValue(('O' . $column), $kategori_btd);
                                $kbrdn_brg_btd[] = 1;
                            }
                            if ($bmn['status_psp'] == 'S') {
                                $sheet->setCellValue(('P' . $column), 'Sudah');
                                $status_psp_s[] = 1;
                            } elseif ($bmn['status_psp'] == 'B') {
                                $sheet->setCellValue(('Q' . $column), 'Belum');
                                $status_psp_b[] = 1;
                            }

                            if ($bmn['subsatker_id'] != null) {
                                $subsatker = $this->masterSubsatkerModel->getNamaSubsatker($bmn['subsatker_id']);
                            } else {
                                $subsatker['nama_subsatker'] = '';
                            }
                            $sheet->setCellValue(('R' . $column), $subsatker['nama_subsatker']);
                            $sheet->setCellValue(('S' . $column), $bmn['ket']);
                        }
                        $column++;
                        $no_baris++;
                    }
                }
                $sheet->mergeCells('A' . $column . ':G' . $column);
                $sheet->setCellValue('A' . $column, 'TOTAL');
                $sheet->getStyle('A' . $column)->applyFromArray($styleArray);

                $sheet->setCellValue('H' . $column, array_sum($arr_kuantitas_inv));
                $sheet->setCellValue('I' . $column, array_sum($arr_nilai_bmn_inv));
                $sheet->setCellValue('J' . $column, array_sum($arr_nilai_bmn_minus));
                $sheet->setCellValue('K' . $column, array_sum($kondisi_brg_b));
                $sheet->setCellValue('L' . $column, array_sum($kondisi_brg_rr));
                $sheet->setCellValue('M' . $column, array_sum($kondisi_brg_rb));
                $sheet->setCellValue('N' . $column, array_sum($kbrdn_brg_bd));
                $sheet->setCellValue('O' . $column, array_sum($kbrdn_brg_btd));
                $sheet->setCellValue('P' . $column, array_sum($status_psp_s));
                $sheet->setCellValue('Q' . $column, array_sum($status_psp_b));

                $sheet->getStyle('R' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);
                $sheet->getStyle('S' . $column)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_BLACK);

                $sheet->getStyle('A7:R' . $column)->applyFromArray($styleBorder);
                $sheet->getStyle('A10:B' . $column - 1)->applyFromArray($styleArray);
                $sheet->getStyle('E10:E' . $column - 1)->applyFromArray($styleArray);
                $sheet->getStyle('K10:Q' . $column - 1)->applyFromArray($styleArray);

                $sheet->getStyle('C10:C' . $column)->applyFromArray($styleArray2);
                $sheet->getColumnDimension('C')->setWidth(12);
                $sheet->getColumnDimension('D')->setWidth(19);
                $sheet->getColumnDimension('G')->setWidth(11);
                $sheet->getColumnDimension('S')->setWidth(15);
                $sheet->getStyle('A7:S9')->applyFromArray($styleBorder2);
                $sheet->getStyle('A1:S9')->getFont()->setBold(true);
                $sheet->freezePane('A10');
                $column++;
                $sheet->setCellValue('A' . $column, 'Note : B=Baik, RR=Rusak Ringan, RB=Rusak Berat, BD= Barang Ditemukan, BTD=Barang Tidak Ditemukan');
                $column = $column + 2;
                $sheet->setCellValue('A' . $column, 'Keterangan :');

                //Bagian tanda tangan
                $sheet->setCellValue('P' . $column, '................, .................... ' . date('Y'));
                $sheet->setCellValue('P' . $column + 1, 'Tim Inventarisasi BMN');
                $sheet->setCellValue('P' . $column + 4, '1. ...................................................');
                $sheet->setCellValue('P' . $column + 6, '2. ...................................................');
                $sheet->setCellValue('P' . $column + 8, '3. ...................................................');
                // batas tanda tangan

                $column++;
                $awal_ket = $column;
                for ($ket_no = 1; $ket_no <= 19; $ket_no++) {
                    $sheet->setCellValue('A' . $awal_ket, $ket_no);
                    $awal_ket++;
                }
                $sheet->setCellValue('B' . $column, 'Di isi dengan nomor urut');
                $sheet->setCellValue('B' . $column + 1, 'Di isi dengan uraian akun (PM_NON_TIK, PM_TIK, ATL, ATB)');
                $sheet->setCellValue('B' . $column + 2, 'Di isi dengan kodefikasi barang di SIMAK BMN');
                $sheet->setCellValue('B' . $column + 3, 'Di isi dengan nama Barang di SIMAK BMN');
                $sheet->setCellValue('B' . $column + 4, 'Di isi dengan tahun perolehan BMN');
                $sheet->setCellValue('B' . $column + 5, 'Di isi dengan nomor urut pendaftaran (NUP)');
                $sheet->setCellValue('B' . $column + 6, 'Di isi dengan merek/tipe barang');
                $sheet->setCellValue('B' . $column + 7, 'Di isi dengan jumlah barang');
                $sheet->setCellValue('B' . $column + 8, 'Di isi dengan nilai perolehan BMN');
                $sheet->setCellValue('B' . $column + 9, 'Di isi dengan nilai Buku Minus (nilai setelah penyusutan)');
                $sheet->setCellValue('B' . $column + 10, 'Di isi dengan huruf B');
                $sheet->setCellValue('B' . $column + 11, 'Di isi dengan huruf RR');
                $sheet->setCellValue('B' . $column + 12, 'Di isi dengan huruf RB');
                $sheet->setCellValue('B' . $column + 13, 'Di isi dengan huruf BD');
                $sheet->setCellValue('B' . $column + 14, 'Di isi dengan huruf Kategori BTD Sesuai Juknis (misalnya hilang, salah kodefikasi dll');
                $sheet->setCellValue('B' . $column + 15, 'Di isi dengan kata sudah apabila barang yang didata telah ada SK PSP');
                $sheet->setCellValue('B' . $column + 16, ' Di isi dengan kata belum untuk barang yang didata belum ada SK PSP');
                $sheet->setCellValue('B' . $column + 17, 'Di isi dengan nama Sub Satker (bagi yan memiliki Sub Satker)');
                $sheet->setCellValue('B' . $column + 18, 'Di isi dengan Keterangan yang belum terakomodasi');
            }


            // Set judul file excel nya
            $sheet->setTitle("Laporan Pegawai");
            $nama_file = 'Inventarisasi ' . $nama_satker['nama_ref_unit_kerja_lengkap'] . ' ' . $jenis_inventarisasi['jenis_rekapitulasi'];
            // Proses file excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $nama_file . '.xlsx"'); // Set nama file excel nya
            header('Cache-Control: max-age=0');
            $writer = new Xlsx($spreadsheet);
            ob_end_clean();
            $writer->save('php://output');
            exit();
        } else {
            session()->setFlashdata('pesan', 'Inventarisasi ' . $nama_satker['nama_ref_unit_kerja_lengkap'] . ' Tidak Tersedia!');
            session()->setFlashdata('icon', 'error');
            return redirect()->to('/report-inventarisasi');
        }
    }
}
