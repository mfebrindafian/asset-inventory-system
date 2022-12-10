<?php

namespace App\Controllers;

use App\Models\masterSatkerModel;
use App\Models\masterTabelBmnModel;
use App\Models\masterTabelJenisRekapitulasiModel;
use App\Models\masterTabelAkunModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class masterReport extends BaseController
{
    protected $masterBmnModel;
    protected $masterSatkerModel;
    protected $masterTabelJenisRekapitulasiModel;
    protected $masterAkunModel;
    public function __construct()
    {
        $this->masterBmnModel = new MasterTabelBmnModel();
        $this->masterSatkerModel = new masterSatkerModel();
        $this->masterTabelJenisRekapitulasiModel = new masterTabelJenisRekapitulasiModel();
        $this->masterAkunModel = new masterTabelAkunModel();
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

            //BARANG TIDAK DITEMUKAN
            


            //BATAS BARANG TIDAK DITEMUKAN
        } else {
            session()->setFlashdata('pesan', 'Rekapitulasi' . $nama_satker['nama_ref_unit_kerja_lengkap'] . ' Tidak Tersedia!');
            session()->setFlashdata('icon', 'error');
            return redirect()->to('/report-rekapitulasi');
        }
    }
}
