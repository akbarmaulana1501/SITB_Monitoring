<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

defined('BASEPATH') or exit('No direct script access allowed');

class DirekturController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_tbc');
        $this->load->library('session');
        $this->load->driver('cache');
        $this->load->library('phpspreadsheet');

        // Cek apakah user sudah login
        $this->check_login();
    }

    public function index()
    {
        $data['pasien_active'] = $this->M_tbc->get_pasien_active();
        $data['pasien_selesai'] = $this->M_tbc->get_pasien_selesai();
        $data['pasien_berhenti'] = $this->M_tbc->get_pasien_berhenti_pengobatan();
        // $data['jumlah_kasus'] = $this->M_tbc->jumlah_kasus_tb_semua_poli();
        // $data['jumlah_terdiagnosa'] = $this->M_tbc->jumlah_kasus_terdiagnosa_tbc();
        // $data['jumlah_sembuh'] = $this->M_tbc->get_data_finish();
        $data['distribusi_usia'] = $this->M_tbc->get_data_umur_pasien();
        $data['resistensi'] = $this->M_tbc->get_data_resistensi();
        $data['gender'] = $this->M_tbc->get_data_gender();
        // var_dump( $data['gender']);
        // die;
        // var_dump($data['resistensi']);
        // die;
        $data['poli_anak'] = $this->M_tbc->kasus_poli_anak();
        $data['poli_paru'] = $this->M_tbc->kasus_poli_paru();
        $data['poli_dalam'] = $this->M_tbc->kasus_poli_dalam();
        $data['poli_umum'] = $this->M_tbc->kasus_poli_umum();
        $data['poli_obgyne'] = $this->M_tbc->kasus_poli_obgyn();
        $this->load->view('direktur/index_direktur', $data);
    }


    public function dashboard()
    {
        $data = $this->cache->file->get('dashboard_direktur');

        // Jika belum ada di cache, ambil dari database dan simpan ke cache
        if (!$data) {
            $data['pasien_active'] = $this->M_tbc->get_pasien_active();
            $data['pasien_selesai'] = $this->M_tbc->get_pasien_selesai();
            $data['pasien_berhenti'] = $this->M_tbc->get_pasien_berhenti_pengobatan();
            $data['distribusi_usia'] = $this->M_tbc->get_data_umur_pasien();
            $data['resistensi'] = $this->M_tbc->get_data_resistensi();
            $data['gender'] = $this->M_tbc->get_data_gender();
            $data['poli_anak'] = $this->M_tbc->kasus_poli_anak();
            $data['poli_paru'] = $this->M_tbc->kasus_poli_paru();
            $data['poli_dalam'] = $this->M_tbc->kasus_poli_dalam();
            $data['poli_umum'] = $this->M_tbc->kasus_poli_umum();
            $data['poli_obgyne'] = $this->M_tbc->kasus_poli_obgyn();

            // Simpan ke cache selama 5 menit (300 detik)
            $this->cache->file->save('dashboard_direktur', $data, 300);
        }
        $this->load->view('direktur/index_direktur', $data);
    }

    public function get_data_by_date()
    {
        $start = $this->input->post('start_date');
        $end = $this->input->post('end_date');

        $data = [
            'labels' => ["Poli Dalam", "Poli Anak", "Poli Umum", "Poli Paru", "Poli Obgyne"],
            'values' => [
                $this->M_tbc->kasus_poli_dalam_range($start, $end),
                $this->M_tbc->kasus_poli_anak_range($start, $end),
                $this->M_tbc->kasus_poli_umum_range($start, $end),
                $this->M_tbc->kasus_poli_paru_range($start, $end),
                $this->M_tbc->kasus_poli_obgyn_range($start, $end),
            ]
        ];

        echo json_encode($data);
    }

    public function rekap_data()
    {
        $this->load->view('direktur/rekap_data_direktur');
    }

    public function filter_data()
    {
        $mulai = $this->input->post('tanggal_mulai');
        $selesai = $this->input->post('tanggal_akhir');

        $data['tanggal_mulai'] = $this->input->post('tanggal_mulai');
        $data['tanggal_akhir'] = $this->input->post('tanggal_akhir');

        $data['hasil'] = $this->M_tbc->filtered_data_direktur($mulai, $selesai);
        $data['filtered'] = true;
        $data['tanggal_mulai'] = $mulai;
        $data['tanggal_akhir'] = $selesai;

        $this->load->view('direktur/rekap_data_direktur', $data);
    }

    public function extract_data()
    {
        $mulai = $this->input->post('tanggal_mulai');
        $selesai = $this->input->post('tanggal_akhir');

        if (!$mulai || !$selesai) {
            show_error('Parameter tidak lengkap', 400);
            return;
        }

        $data = $this->M_tbc->filtered_data_direktur($mulai, $selesai);

        if (empty($data)) {
            show_error('Data tidak ditemukan', 404);
        }

        // Mapping header ke bahasa Indonesia
        $headerMap = [
            'patient_name' => 'Nama Pasien',
            'patient_nik' => 'NIK',
            'patient_gender' => 'Jenis Kelamin',
            'patient_dob' => 'Tanggal Lahir',
            'patient_province' => 'Provinsi',
            'patient_district' => 'Kabupaten',
            'patient_address' => 'Alamat',
            'encounter_local_id' => 'ID Pelayanan',
            'no_rm' => 'No RM',
            'episode_of_care_id_tb_03' => 'ID TB 03',
            'episode_of_care_status' => 'Status Pengobatan',
            'episode_of_care_period_start' => 'Mulai Pengobatan',
            'period_end' => 'Akhir Pengobatan'
        ];

        // Siapkan header kolom (dengan "No" di awal)
        $finalHeaders = ['No'];
        foreach (array_keys((array)$data[0]) as $key) {
            $finalHeaders[] = $headerMap[$key] ?? $key;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Judul laporan
        $judul = "Data Pasien TBC (" . date('d-m-Y', strtotime($mulai)) . " s/d " . date('d-m-Y', strtotime($selesai)) . ")";
        $colCount = count($finalHeaders);
        $lastColumn = Coordinate::stringFromColumnIndex($colCount);

        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells("A1:{$lastColumn}1");
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Tulis header kolom
        $sheet->fromArray($finalHeaders, NULL, 'A2');
        $sheet->getStyle("A2:{$lastColumn}2")->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E0E0E0']
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Isi data
        $rowIndex = 3;
        $no = 1;
        foreach ($data as $row) {
            $colIndex = 1;
            $sheet->setCellValueByColumnAndRow($colIndex++, $rowIndex, $no++);

            foreach ((array)$row as $key => $value) {
                // Mapping provinsi & kabupaten
                if ($key === 'patient_province' && $value == '19') {
                    $value = 'Bangka Belitung';
                }
                if ($key === 'patient_district' && $value == '1901') {
                    $value = 'Pangkalpinang';
                }

                $cell = $sheet->getCellByColumnAndRow($colIndex, $rowIndex);

                if ($key === 'patient_nik') {
                    $cell->setValueExplicit((string)$value, DataType::TYPE_STRING);
                } elseif (in_array($key, ['patient_dob', 'episode_of_care_period_start', 'period_end'])) {
                    if (empty($value) || $value === '0000-00-00 00:00:00' || $value === '0000-00-00') {
                        $cell->setValueExplicit($value, DataType::TYPE_STRING);
                    } else {
                        $excelDate = Date::PHPToExcel(strtotime($value));
                        $cell->setValue($excelDate);

                        $formatCode = ($key === 'episode_of_care_period_start') ? 'DD-MM-YYYY HH:MM:SS' : 'DD-MM-YYYY';
                        $sheet->getStyleByColumnAndRow($colIndex, $rowIndex)
                            ->getNumberFormat()
                            ->setFormatCode($formatCode);
                    }
                } else {
                    $cell->setValue($value);
                }

                $colIndex++;
            }

            $rowIndex++;
        }

        // Border seluruh tabel
        $lastDataRow = $rowIndex - 1;
        $sheet->getStyle("A2:{$lastColumn}{$lastDataRow}")->applyFromArray([
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ]
        ]);

        // Auto width
        for ($i = 1; $i <= $colCount; $i++) {
            $sheet->getColumnDimensionByColumn($i)->setAutoSize(true);
        }

        // Output ke browser
        $filename = "Laporan_data_pasien_" . date('YmdHis') . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function laporan_direktur()
    {
        $status = $this->input->get('status');

        if ($status == 'finished') {
            $data['pasien'] = $this->M_tbc->get_data_finished_pasien();
        } else if ($status == 'canceled') {
            $data['pasien'] = $this->M_tbc->get_data_canceled_pasien();
        } else if ($status == "active") {
            $data['pasien'] = $this->M_tbc->get_data_active_pasien();
        } else {
            $data['pasien'] = $this->M_tbc->get_data_laporan_pasien();
        }

        $this->load->view('direktur/laporan_pasien', $data);
    }

    private function check_login()
    {
        $session_id = $this->session->userdata('session_id');
        $user_id = $this->session->userdata('user_id');

        if (!$session_id || !$user_id) {
            redirect('LoginController'); // Redirect ke halaman login jika belum login
        }

        // Cek session ID di database
        $this->db->where('id', $user_id);
        $this->db->where('session_id', $session_id);
        $query = $this->db->get('user_sitb');

        if ($query->num_rows() == 0) {
            redirect('LoginController'); // Jika session tidak valid, redirect ke login
        }
    }
}
