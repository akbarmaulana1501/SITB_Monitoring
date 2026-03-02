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

class DataController extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->helper('satusehat');
        $this->load->model('M_Satusehat');
        $this->load->model('M_tbc');
        $this->load->helper('usaid');
        $this->load->helper('wa');
        $this->api = "http://192.168.87.2:8181/";
        $this->load->library('curl');
        $this->load->library('session');
        $this->check_login();
        $this->load->library('phpspreadsheet');
    }

    public function index()
    {
        check_login();
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

    public function schedule_data()
    {
        $data['data_schedule'] = $this->M_tbc->get_data_schedule();
        $this->load->view('admin/log_pengiriman/data_schedule', $data);
    }

    public function data_terkirim()
    {
        $status = $this->input->get('status');

        if ($status == 'finished') {
            $data['encounter'] = $this->M_tbc->get_data_finished_pasien();
        } else if ($status == 'canceled') {
            $data['encounter'] = $this->M_tbc->get_data_canceled_pasien();
        } else if ($status == "active") {
            $data['encounter'] = $this->M_tbc->get_data_active_pasien();
        } else {
            $data['encounter'] = $this->M_tbc->get_data_terkirim();
        }
        // $data['encounter'] = $this->M_tbc->get_data_terkirim();
        $this->load->view('admin/data_pasien/data_terkirim', $data);
    }

    public function data_gagal()
    {
        $data['data_gagal'] = $this->M_tbc->get_data_gagal();
        $this->load->view('admin/log_pengiriman/data_gagal', $data);
    }

    // public function role_list()
    // {
    //     $data['roles'] = $this->M_tbc->get_all_roles();
    //     $this->load->view('role_list', $data); // tampilkan daftar role
    // }

    public function access_control()
    {
        $data['menu'] = $this->M_tbc->get_all_menus();
        $data['user'] = $this->M_tbc->get_all_roles();
        $akses_data = $this->M_tbc->get_update_akses(); // harus return ['user_id', 'menu_id', 'allowed']

        $akses_user = [];

        foreach ($akses_data as $a) {
            $akses_user[$a['user_id']][$a['menu_id']] = [
                'allowed' => $a['status_menu']
            ];
        }

        $data['akses_user'] = $akses_user;
        $this->load->view('admin/akses_kontrol/menu_kontrol', $data);
    }

    public function update()
    {
        $akses_input = $this->input->post('akses'); // hanya yang dicentang
        $users = $this->M_tbc->get_all_roles();     // semua user
        $menus = $this->M_tbc->get_all_menus();     // semua menu

        // Ambil semua data akses dari database (user_id dan menu_id yang sudah ada)
        $akses_db = $this->M_tbc->get_all_akses(); // misal return array of ['user_id' => ..., 'menu_id' => ...]

        // Buat array indexed untuk perbandingan
        $akses_db_indexed = [];
        foreach ($akses_db as $row) {
            $akses_db_indexed[$row['user_id']][$row['menu_id']] = true;
        }

        // Loop untuk perbandingan dan update
        foreach ($users as $user) {
            foreach ($menus as $menu) {
                $id_user = $user->id;
                $id_menu = $menu['id_menu'];

                $input_checked = isset($akses_input[$id_user][$id_menu]);
                $db_exists = isset($akses_db_indexed[$id_user][$id_menu]);

                if ($input_checked && !$db_exists) {
                    // Dicentang tapi belum ada di DB → Tambah
                    $this->M_tbc->tambah([
                        'user_id' => $id_user,
                        'menu_id' => $id_menu,
                        'status_menu' => 1
                    ]);
                } elseif ($input_checked && $db_exists) {
                    // Sudah ada, dan dicentang → pastikan status aktif
                    $this->M_tbc->update([
                        'user_id' => $id_user,
                        'menu_id' => $id_menu
                    ], ['status_menu' => 1]);
                } elseif (!$input_checked && $db_exists) {
                    // Tidak dicentang tapi sudah ada → update jadi nonaktif
                    $this->M_tbc->update([
                        'user_id' => $id_user,
                        'menu_id' => $id_menu
                    ], ['status_menu' => 0]);
                }
            }
        }


        echo json_encode(['status' => 'success', 'message' => 'Hak akses berhasil diperbarui.']);
    }



    public function form_input()
    {
        $id_pelayanan = "pl_389278";
        $no_rm = "8085";
        // $norm = base64_decode($no_rm);
        $data['pasien'] = $this->M_tbc->get_Pasien($id_pelayanan);
        $data['icd'] = $this->kode_icd($id_pelayanan);
        $data['active'] = $this->active($id_pelayanan);
        $data['gender'] = $this->gender();
        $data['klasifikasi'] = $this->clasification($id_pelayanan);
        $clasifi = $this->M_tbc->classifications($no_rm);
        $data['quitioner'] = $this->quitioners($id_pelayanan);
        $tgl_masuk = $clasifi->tgl_masuk;
        $tgl_prog = $clasifi->tanggal;
        $tgl_selesai = $clasifi->tgl_keluar;
        $data['id_tb'] = $this->id_tb($id_pelayanan);
        $data['format1'] = date('Y-m-d\TH:i:s\Z', strtotime($tgl_masuk));
        $data['format2'] = date('Y-m-d\TH:i:s\Z', strtotime($tgl_prog));
        $data['format3'] = date('Y-m-d\TH:i:s\Z', strtotime($tgl_selesai));
        $data['kfa_code'] = $this->get_kfa_code($id_pelayanan);
        $this->load->view('form_pasien', $data);
    }

    public function index_post($id_pel)
    {
        // $id_pelayanan = "pl_346500";
        // Mendapatkan data mentah dari body permintaan
        // $raw_data = $this->input->raw_input_stream;
        header('Content-Type: application/json');
        $id_pelayanan = base64_decode($id_pel);
        $pasien = $this->M_tbc->get_all_data2($id_pelayanan);
        // $id_pelayanan = $pasien->encounter_local_id;
        $data_lab = $this->M_tbc->get_labor_all($id_pelayanan);
        // var_dump($data_lab);
        $tgl_masuk_pasien = date('Y-m-d\TH:i:s\Z', strtotime($pasien->encounter_period_start));
        $tgl_proses_pasien = date('Y-m-d\TH:i:s\Z', strtotime($pasien->encounter_period_in_progress));
        $tgl_akhir_pasien = date('Y-m-d\TH:i:s\Z', strtotime($pasien->encounter_period_end));
        // $tgl_issued = date('Y-m-d\TH:i:s\Z', strtotime($pasien->observation_issued));
        $tgl_epi_start = date('Y-m-d\TH:i:s\Z', strtotime($pasien->episode_of_care_period_start));
        $data_obat = $this->M_tbc->oat($id_pelayanan);

        if ($pasien) {
            $medication_data = [];
            // Cek apakah $data_obat tidak kosong
            if (!empty($data_obat)) {
                foreach ($data_obat as $row) {
                    if (empty($row->kfa_code) || empty($row->kfa_name) || empty($row->form_code)) {
                        continue;
                    }
                    // Tambahkan setiap elemen data obat ke dalam array $medication_data
                    $medication_data[] = [
                        'kfa_code' => $row->kfa_code,
                        'kfa_name' => $row->kfa_name,
                        'form_code' => $row->form_code
                    ];
                }
            } else {
                // Jika $data_obat kosong, set default data
                $medication_data = [
                    [
                        'kfa_code' => "93000147",
                        'kfa_name' => "92000150",
                        'form_code' => "BS077",
                    ]
                ];
            }

            $data = array(
                'middleware_id' => "",
                'organization_id' => "b348c55e-8c19-4890-ba73-6ec1d30c4c9c",
                'location_id' => $pasien->location_id,
                'practitioner_nik' => $pasien->practitioner_nik,
                'patient' => array(
                    'nik' => $pasien->patient_nik,
                    'name' => $pasien->patient_name,
                    'gender' => $pasien->patient_gender,
                    'dob' => $pasien->patient_dob,
                    'province' => $pasien->patient_province,
                    'district' => $pasien->patient_district,
                    'address' => $pasien->patient_address
                ),
                'encounter' => array(
                    'local_id' =>  substr($pasien->encounter_local_id, 3), //bisa menggunakan id_pelayanan
                    'classification' => (function ($classification) {
                        switch ($classification) {
                            case 'Rawat Jalan':
                                return 'AMB';  // Ambulatory
                            case 'IGD':
                                return 'EMER'; // Emergency
                            case 'home care':
                                return 'HH';   // Home Health
                            case 'rawat inap':
                                return 'IMP';
                            case 'virtual':
                                return 'VR';  // Inpatient
                            default:
                                return $classification; // Return original if no match
                        }
                    })($pasien->encounter_classification),
                    'period_start' =>  $tgl_masuk_pasien,
                    'period_in_progress' =>  $tgl_proses_pasien,
                    'period_end' =>  $tgl_akhir_pasien
                ),
                'questionnaire_response' => array(
                    'type_diagnosis' => $pasien->diagnosis_type,
                    'location_anatomi' => $pasien->diagnosis_location_anatomi,
                    'treatment_history' => $pasien->treatment_history,
                    'end_result_treatment' => $pasien->end_result_treatment
                ),
                'condition' => array(
                    array(
                        // Cek apakah ada tanda '|' dalam kode
                        'icd_x_code_tb' => (strpos($pasien->condition_icd_x_code, ' | ') !== false) ?
                            substr($pasien->condition_icd_x_code, 0, strpos($pasien->condition_icd_x_code, ' | ')) :
                            // Tambahkan titik setelah karakter ketiga
                            substr($pasien->condition_icd_x_code, 0, 3) . '.' . substr($pasien->condition_icd_x_code, 3),

                        'clinical_status_tb' => $pasien->condition_clinical_status_tb,

                        // Kondisional: hanya tambahkan others jika datanya ada
                        'others' => (empty($pasien->other_icd) && empty($pasien->nama_diagnosa)) ? array() : array(
                            array(
                                // Menyisipkan titik dalam other_icd jika diperlukan
                                'icd_x_code' => (strpos($pasien->other_icd, ' | ') !== false) ?
                                    substr($pasien->other_icd, 0, strpos($pasien->other_icd, ' | ')) :
                                    substr($pasien->other_icd, 0, 3) . '.' . substr($pasien->other_icd, 3),

                                'icd_x_code_name' => $pasien->nama_diagnosa,
                                'clinical_status' => 'active'
                            )
                        )
                    )
                ),


                'medication' => $medication_data,
                'observation' => [],
                // 'observation' => $observ,
                'episode_of_care' => array(
                    'ihs_id' => $pasien->episode_of_care_ihs_id,
                    'id_tb_03' => $pasien->episode_of_care_id_tb_03,
                    'status' => $pasien->episode_of_care_status,
                    'type_code' => $pasien->episode_of_care_type_code,
                    'period_start' => $tgl_epi_start,
                    // 'period_end' => "" //dilampirkan ketika sudah finish berdasarkan end result treatment
                )
            );

            if (is_null($data['condition'][0]['others'])) {
                unset($data['condition'][0]['others']);
            }
        }


        if (!empty($data_lab)) {
            // Looping untuk setiap observasi
            foreach ($data_lab as $obs) {
                // Hanya proses jika type_observation adalah MIKROBIOLOGI, TCM, atau culture-treatment
                if (in_array($obs['type_observation'], ['MIKROBIOLOGI', 'microscopic', 'tcm', 'culture-treatment'])) {
                    $type_observation = $obs['type_observation'] === 'MIKROBIOLOGI' ? 'microscopic' : $obs['type_observation'];

                    if ($obs['hasil'] === 'Rifampicin Sensitive') {
                        $value = 'rif-sen';
                    } elseif ($obs['hasil'] === 'Rifampicin Resistant') {
                        $value = 'rif-res';
                    } elseif ($obs['hasil'] === 'Rifampicin Indeterminate') {
                        $value = 'rif-indet';
                    } elseif ($obs['hasil'] === 'Negatif') {
                        $value = 'neg';
                    } else {
                        $value = $obs['hasil'];
                    }

                    $issued_formatted = date('Y-m-d\TH:i:s\Z', strtotime($obs['issued']));
                    $issued_rifampicin = date('Y-m-d\TH:i:s\Z', strtotime($obs['issued_rifampicin']));

                    if ($type_observation == 'tcm') {
                        if (in_array($value, ['rif-sen', 'rif-res', 'rif-ident','neg'])) {
                            $data['observation'][] = [
                                'local_id' => $obs['local_id'],
                                'type_observation' => $type_observation,
                                'issued' => $issued_formatted,
                                'value' => $value,
                                'issued_rifampicin' => $issued_rifampicin,
                                'episode_number' => $obs['episode_number']
                            ];
                        }
                    } else if ($type_observation == "culture-treatment") {
                        $data['observation'][] = [
                            'local_id' => $obs['local_id'],
                            'type_observation' => $type_observation,
                            'issued' => $issued_formatted,
                            'value' => $value,
                            'episode_number' => $obs['episode_number']
                        ];
                    } else {
                        $data['observation'][] = [
                            'local_id' => $obs['local_id'],
                            'type_observation' => $type_observation,
                            'issued' => $issued_formatted,
                            'value' => $value,
                            'episode_number' => $obs['episode_number']
                        ];
                    }
                }
            }
        }
        


        //     $this->output
        //         ->set_content_type('application/json')
        //         ->set_output(json_encode($data));
        // } else {
        //     // Mengembalikan respons JSON untuk kesalahan
        //     $error = array('error' => 'Data pasien tidak ditemukan');
        //     $this->output
        //         ->set_content_type('application/json')
        //         ->set_output(json_encode($error));
        // }


        echo '<h1>Respon Header</h1>';
        echo '<pre>';
        $header = generateTokenUsaid();
        print_r($header);
        echo '</pre>';

        echo '<h1>Response pengiriman Bundle</h1>';
        // $response_bundle = usaidPostData($data, 'data', 'POST');
        $response_bundle = usaidPostData($data, 'submit-data-tb', 'POST');
        echo '<pre>';
        print_r($response_bundle);
        echo '</pre>';

        // $id_tb_03 = $response_bundle['data']->details[0]->response_data->id_tb_03;
        // $status = $response_bundle['data']->details[0]->status_process;
        // // $status_process = $response_bundle['data']->details[0]->status_process;
        // // $keterangan = $response_bundle['data']->details[0]->response_data->keterangan;
        // $ihs_id = $response_bundle['data']->id;

        $id_tb_03 = $response_bundle['data']->id_tb_03;
        $status = $response_bundle['data']->status_process;
        // $status_process = $response_bundle['data']->details[0]->status_process;
        // $keterangan = $response_bundle['data']->details[0]->response_data->keterangan;
        $ihs_id = $response_bundle['data']->id;

        $db = array(
            'id_tb' => $id_tb_03,
            'ihs_id' => $ihs_id,
            'status' => $status,
            'id_pelayanan' => $pasien->encounter_local_id,
        );

        $this->M_tbc->insert_data($db, 'ihs_encounter');

        if ($status == 'success') {
            // Data yang akan di-update
            $data_update = array(
                'episode_of_care_ihs_id' => $ihs_id,
                'episode_of_care_id_tb_03' => $id_tb_03,
                'status_kirim' => 1,
                'update_at' => date('Y-m-d H:i:s')
            );

            // Cek apakah data ada di tb_data
            $this->db->where('encounter_local_id', $pasien->encounter_local_id);
            $exists_in_tb_data = $this->db->get('tb_data')->row();

            // Jika data ditemukan di tb_data, lakukan update
            if ($exists_in_tb_data) {
                $this->db->where('encounter_local_id', $pasien->encounter_local_id);
                $this->db->update('tb_data', $data_update);
            } else {
                // Jika data tidak ada di tb_data, cek di tb_data_schedule
                $this->db->where('encounter_local_id', $pasien->encounter_local_id);
                $exists_in_tb_data_schedule = $this->db->get('tb_data_schedule')->row();

                if ($exists_in_tb_data_schedule) {
                    // Update tb_data_schedule jika data ditemukan di sana
                    $this->db->where('encounter_local_id', $pasien->encounter_local_id);
                    $this->db->update('tb_data_schedule', $data_update);
                }
            }

            // Response jika berhasil
            $response = array(
                'status' => 'success',
                'message' => 'Data berhasil dikirim ke API dan id_tb telah diupdate!',
            );
        } else {
            // Data yang akan di-update untuk kasus gagal
            $data_update = array(
                'episode_of_care_ihs_id' => $ihs_id,
                'episode_of_care_id_tb_03' => $id_tb_03,
                'status_kirim' => 2,
                'update_at' => date('Y-m-d H:i:s')
            );

            // Cek apakah data ada di tb_data
            $this->db->where('encounter_local_id', $pasien->encounter_local_id);
            $exists_in_tb_data = $this->db->get('tb_data')->row();

            // Jika data ditemukan di tb_data, lakukan update
            if ($exists_in_tb_data) {
                $this->db->where('encounter_local_id', $pasien->encounter_local_id);
                $this->db->update('tb_data', $data_update);
            } else {
                // Jika data tidak ada di tb_data, cek di tb_data_schedule
                $this->db->where('encounter_local_id', $pasien->encounter_local_id);
                $exists_in_tb_data_schedule = $this->db->get('tb_data_schedule')->row();

                if ($exists_in_tb_data_schedule) {
                    // Update tb_data_schedule jika data ditemukan di sana
                    $this->db->where('encounter_local_id', $pasien->encounter_local_id);
                    $this->db->update('tb_data_schedule', $data_update);
                }
            }

            // Response jika gagal
            $response = array(
                'status' => 'error',
                'message' => 'Gagal dikirim ke API.!',
            );
        }

        ob_clean();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function bundle_post()
    {
        // Mendapatkan data mentah dari body permintaan
        // $raw_data = $this->input->raw_input_stream;
        header('Content-Type: application/json');
        $id_pel = $this->M_tbc->get_id_pelayanan();
        // var_dump($id_pel);
        // die;
        foreach ($id_pel as $row) {
            $id_pelayanan = $row->encounter_local_id;
            $pasien = $this->M_tbc->get_all_data2($id_pelayanan);
            // $id_pelayanan = $pasien->encounter_local_id;
            $data_lab = $this->M_tbc->get_labor_all($id_pelayanan);
            // var_dump($data_lab);
            $tgl_masuk_pasien = date('Y-m-d\TH:i:s\Z', strtotime($pasien->encounter_period_start));
            $tgl_proses_pasien = date('Y-m-d\TH:i:s\Z', strtotime($pasien->encounter_period_in_progress));
            $tgl_akhir_pasien = date('Y-m-d\TH:i:s\Z', strtotime($pasien->encounter_period_end));
            $tgl_issued = date('Y-m-d\TH:i:s\Z', strtotime($pasien->observation_issued));
            $tgl_epi_start = date('Y-m-d\TH:i:s\Z', strtotime($pasien->episode_of_care_period_start));
            $data_obat = $this->M_tbc->oat($id_pelayanan);

            if ($pasien) {
                $medication_data = [];
                // Cek apakah $data_obat tidak kosong
                if (!empty($data_obat)) {
                    foreach ($data_obat as $row) {
                        if (empty($row->kfa_code) || empty($row->kfa_name) || empty($row->form_code)) {
                            continue;
                        }
                        // Tambahkan setiap elemen data obat ke dalam array $medication_data
                        $medication_data[] = [
                            'kfa_code' => $row->kfa_code,
                            'kfa_name' => $row->kfa_name,
                            'form_code' => $row->form_code
                        ];
                    }
                } else {
                    // Jika $data_obat kosong, set default data
                    $medication_data = [
                        [
                            'kfa_code' => "93000147",
                            'kfa_name' => "92000150",
                            'form_code' => "BS077",
                        ]
                    ];
                }

                $data = array(
                    'middleware_id' => "",
                    'organization_id' => "b348c55e-8c19-4890-ba73-6ec1d30c4c9c",
                    'location_id' => $pasien->location_id,
                    'practitioner_nik' => $pasien->practitioner_nik,
                    'patient' => array(
                        'nik' => $pasien->patient_nik,
                        'name' => $pasien->patient_name,
                        'gender' => $pasien->patient_gender,
                        'dob' => $pasien->patient_dob,
                        'province' => $pasien->patient_province,
                        'district' => $pasien->patient_district,
                        'address' => $pasien->patient_address
                    ),
                    'encounter' => array(
                        'local_id' =>  substr($pasien->encounter_local_id, 3), //bisa menggunakan id_pelayanan
                        'classification' => (function ($classification) {
                            switch ($classification) {
                                case 'Rawat Jalan':
                                    return 'AMB';  // Ambulatory
                                case 'IGD':
                                    return 'EMER'; // Emergency
                                case 'home care':
                                    return 'HH';   // Home Health
                                case 'rawat inap':
                                    return 'IMP';
                                case 'virtual':
                                    return 'VR';  // Inpatient
                                default:
                                    return $classification; // Return original if no match
                            }
                        })($pasien->encounter_classification),
                        'period_start' =>  $tgl_masuk_pasien,
                        'period_in_progress' =>  $tgl_proses_pasien,
                        'period_end' =>  $tgl_akhir_pasien
                    ),
                    'questionnaire_response' => array(
                        'type_diagnosis' => $pasien->diagnosis_type,
                        'location_anatomi' => $pasien->diagnosis_location_anatomi,
                        'treatment_history' => $pasien->treatment_history,
                        'end_result_treatment' => $pasien->end_result_treatment
                    ),
                    'condition' => array(
                        array(
                            // Cek apakah ada tanda '|' dalam kode
                            'icd_x_code_tb' => (strpos($pasien->condition_icd_x_code, ' | ') !== false) ?
                                substr($pasien->condition_icd_x_code, 0, strpos($pasien->condition_icd_x_code, ' | ')) :
                                // Tambahkan titik setelah karakter ketiga
                                substr($pasien->condition_icd_x_code, 0, 3) . '.' . substr($pasien->condition_icd_x_code, 3),

                            'clinical_status_tb' => $pasien->condition_clinical_status_tb,

                            // Kondisional: hanya tambahkan others jika datanya ada
                            'others' => (empty($pasien->other_icd) && empty($pasien->nama_diagnosa)) ? array() : array(
                                array(
                                    // Menyisipkan titik dalam other_icd jika diperlukan
                                    'icd_x_code' => (strpos($pasien->other_icd, ' | ') !== false) ?
                                        substr($pasien->other_icd, 0, strpos($pasien->other_icd, ' | ')) :
                                        substr($pasien->other_icd, 0, 3) . '.' . substr($pasien->other_icd, 3),

                                    'icd_x_code_name' => $pasien->nama_diagnosa,
                                    'clinical_status' => 'active'
                                )
                            )
                        )
                    ),

                    'medication' => $medication_data,
                    'observation' => [],
                    // 'observation' => $observ,
                    'episode_of_care' => array(
                        'ihs_id' => $pasien->episode_of_care_ihs_id,
                        'id_tb_03' => $pasien->episode_of_care_id_tb_03,
                        'status' => $pasien->episode_of_care_status,
                        'type_code' => $pasien->episode_of_care_type_code,
                        'period_start' => $tgl_epi_start,
                        // 'period_end' => "" //dilampirkan ketika sudah finish berdasarkan end result treatment
                    )
                );

                if (is_null($data['condition'][0]['others'])) {
                    unset($data['condition'][0]['others']);
                }

                if (empty($data['observation'])) {
                    unset($data['observation']);
                }
            }



            if (!empty($data_lab)) {
                // Looping untuk setiap observasi
                foreach ($data_lab as $obs) {
                    // Hanya proses jika type_observation adalah MIKROBIOLOGI, TCM, atau culture-treatment
                    if (in_array($obs['type_observation'], ['MIKROBIOLOGI', 'tcm', 'culture-treatment'])) {
                        $type_observation = $obs['type_observation'] === 'MIKROBIOLOGI' ? 'microscopic' : $obs['type_observation'];

                        if ($obs['hasil'] === 'Rifampicin Sensitive') {
                            $value = 'rif-sen';
                        } elseif ($obs['hasil'] === 'Rifampicin Resistant') {
                            $value = 'rif-res';
                        } elseif ($obs['hasil'] === 'Rifampicin Indeterminate') {
                            $value = 'rif-indet';
                        } elseif ($obs['hasil'] === 'Negatif') {
                            $value = 'neg';
                        } else {
                            $value = $obs['hasil'];
                        }

                        $issued_formatted = date('Y-m-d\TH:i:s\Z', strtotime($obs['issued']));
                        $issued_rifampicin = date('Y-m-d\TH:i:s\Z', strtotime($obs['issued_rifampicin']));

                        if ($type_observation == 'tcm') {
                            if (in_array($value, ['rif-sen', 'rif-res', 'rif-ident'])) {
                                $data['observation'][] = [
                                    'local_id' => $obs['local_id'],
                                    'type_observation' => $type_observation,
                                    'issued' => $issued_formatted,
                                    'value' => $value,
                                    'issued_rifampicin' => $issued_rifampicin,
                                    'episode_number' => $obs['episode_number']
                                ];
                            }
                        } else if ($type_observation == "culture-treatment") {
                            $data['observation'][] = [
                                'local_id' => $obs['local_id'],
                                'type_observation' => $type_observation,
                                'issued' => $issued_formatted,
                                'value' => $value,
                                'episode_number' => $obs['episode_number']
                            ];
                        } else {
                            $data['observation'][] = [
                                'local_id' => $obs['local_id'],
                                'type_observation' => $type_observation,
                                'issued' => $issued_formatted,
                                'value' => $value,
                                'episode_number' => $obs['episode_number']
                            ];
                        }
                    }
                }
            }


            //     $this->output
            //         ->set_content_type('application/json')
            //         ->set_output(json_encode($data));
            // } else {
            //     // Mengembalikan respons JSON untuk kesalahan
            //     $error = array('error' => 'Data pasien tidak ditemukan');
            //     $this->output
            //         ->set_content_type('application/json')
            //         ->set_output(json_encode($error));
            // }

            echo '<h1>Respon Header</h1>';
            echo '<pre>';
            $header = generateTokenUsaid();
            print_r($header);
            echo '</pre>';

            echo '<h1>Response pengiriman Bundle</h1>';
            $response_bundle = usaidPostData($data, 'data', 'POST');
            echo '<pre>';
            print_r($response_bundle);
            echo '</pre>';

            $id_tb_03 = $response_bundle['data']->details[0]->response_data->id_tb_03;
            $status = $response_bundle['data']->details[0]->status_process;
            // $status_process = $response_bundle['data']->details[0]->status_process;
            // $keterangan = $response_bundle['data']->details[0]->response_data->keterangan;
            $ihs_id = $response_bundle['data']->id;

            $db = array(
                'id_tb' => $id_tb_03,
                'ihs_id' => $ihs_id,
                'status' => $status,
                'id_pelayanan' => $id_pelayanan,
            );

            $this->M_tbc->insert_data($db, 'ihs_encounter_2');

            if ($status == 'success') {
                // Data yang akan di-update
                $data_update = array(
                    'episode_of_care_ihs_id' => $ihs_id,
                    'episode_of_care_id_tb_03' => $id_tb_03,
                    'status_kirim' => 1
                );

                // Cek apakah data ada di tb_data
                $this->db->where('encounter_local_id', $pasien->encounter_local_id);
                $exists_in_tb_data = $this->db->get('tb_data')->row();

                // Jika data ditemukan di tb_data, lakukan update
                if ($exists_in_tb_data) {
                    $this->db->where('encounter_local_id', $pasien->encounter_local_id);
                    $this->db->update('tb_data', $data_update);
                } else {
                    // Jika data tidak ada di tb_data, cek di tb_data_schedule
                    $this->db->where('encounter_local_id', $pasien->encounter_local_id);
                    $exists_in_tb_data_schedule = $this->db->get('tb_data_schedule')->row();

                    if ($exists_in_tb_data_schedule) {
                        // Update tb_data_schedule jika data ditemukan di sana
                        $this->db->where('encounter_local_id', $pasien->encounter_local_id);
                        $this->db->update('tb_data_schedule', $data_update);
                    }
                }

                // Response jika berhasil
                $response = array(
                    'status' => 'success',
                    'message' => 'Data berhasil dikirim ke API dan id_tb telah diupdate!',
                );
            } else {
                // Data yang akan di-update untuk kasus gagal
                $data_update = array(
                    'episode_of_care_ihs_id' => $ihs_id,
                    'episode_of_care_id_tb_03' => $id_tb_03,
                    'status_kirim' => 2
                );

                // Cek apakah data ada di tb_data
                $this->db->where('encounter_local_id', $pasien->encounter_local_id);
                $exists_in_tb_data = $this->db->get('tb_data')->row();

                // Jika data ditemukan di tb_data, lakukan update
                if ($exists_in_tb_data) {
                    $this->db->where('encounter_local_id', $pasien->encounter_local_id);
                    $this->db->update('tb_data', $data_update);
                } else {
                    // Jika data tidak ada di tb_data, cek di tb_data_schedule
                    $this->db->where('encounter_local_id', $pasien->encounter_local_id);
                    $exists_in_tb_data_schedule = $this->db->get('tb_data_schedule')->row();

                    if ($exists_in_tb_data_schedule) {
                        // Update tb_data_schedule jika data ditemukan di sana
                        $this->db->where('encounter_local_id', $pasien->encounter_local_id);
                        $this->db->update('tb_data_schedule', $data_update);
                    }
                }

                // Response jika gagal
                $response = array(
                    'status' => 'error',
                    'message' => 'Gagal dikirim ke API.!',
                );
            }

            ob_clean();

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        }
    }

    // public function print_labor()
    // {
    //     // $id_pelayanan = "pl_412244";
    //     // $id_form = $this->M_tbc->get_form($id_pelayanan);
    //     // $id = strval($id_form->id_form_labor);
    //     $id = "102914";
    //     $param = array('ono' => 'A' . $id);
    //     $labor = json_decode($this->curl->simple_get($this->api . 'RESULTS', $param));

    //     if ($labor) {
    //         // Inisialisasi array untuk observasi
    //         $observations = [];
    //         $episodeCounter = 1; // Inisialisasi counter untuk episode_number

    //         foreach ($labor as $observ) {
    //             // Pastikan RESULT ada dan merupakan array
    //             if (isset($observ->RESULT) && is_array($observ->RESULT) && !empty($observ->RESULT)) {
    //                 foreach ($observ->RESULT as $result) {
    //                     // Ambil semua grup dari RESULT
    //                     if (isset($result->GROUP)) {
    //                         $typeObservation = $result->GROUP; // Gunakan grup apapun yang ada

    //                         // Tentukan value berdasarkan hasil
    //                         $value = isset($result->VALUE) ? $result->VALUE : null;
    //                         // $fromat_tgl = date('Y-m-d\TH:i:s\Z', strtotime($observ->TGLORDER));

    //                         // Ambil GROUP dan VALUE dari elemen RESULT
    //                         $observations[] = array(
    //                             'local_id' => $observ->LABNO,
    //                             'type_observation' => $typeObservation,
    //                             'issued' => $observ->TGLORDER,
    //                             'value' => $value,
    //                             'episode_number' => strval($episodeCounter),
    //                         );
    //                         $episodeCounter++; // Increment counter untuk episode_number
    //                     }
    //                 }
    //             } else {
    //                 // Tangani kasus di mana RESULT tidak ada atau bukan array
    //                 $tgl_hari = date('Y-m-d\TH:i:s\Z', strtotime('now'));
    //                 $observations[] = array(
    //                     'local_id' => $id,
    //                     'type_observation' => "microscopic",
    //                     'issued' => $tgl_hari,
    //                     'value' => "1",
    //                     'episode_number' => strval($episodeCounter),
    //                 );
    //             }
    //         }

    //         // Kembalikan hanya observasi
    //         echo json_encode($observations);
    //     } else {
    //         echo "gagal!";
    //         return []; // Kembalikan array kosong jika gagal
    //     }
    // }


    // public function print_labor()
    // {
    //     // $id_pel = "pl_412244";
    //     // $id = "102914";
    //     // $id_pelayanan = "pl_412244";
    //     // $id_form = $this->M_tbc->get_form($id_pelayanan);
    //     // $id = strval($id_form->id_form_labor);
    //     $id = "102914";
    //     $param = array('ono' => 'A' . $id);
    //     $labor = json_decode($this->curl->simple_get($this->api . 'RESULTS', $param));

    //     if ($labor != "") {
    //         $data['labor'] = $labor;
    //         echo json_encode($data);
    //     } else {
    //         echo "gagal!";
    //     }
    // }

    // public function get_obat_oat($id_pelayanan)
    // {
    //     // Panggil data dari model M_tbc
    //     $obat_oat = $this->M_tbc->oat($id_pelayanan);

    //     // Cek apakah $obat_oat tidak kosong
    //     if (empty($obat_oat)) {
    //         return "-";  // Jika tidak ada data
    //     } else {
    //         // Ambil data dari baris pertama
    //         $row = $obat_oat[0]; // Ambil baris pertama dari array hasil query

    //         return [
    //             'form_code' => $row->form_code,
    //             'kfa_code' => $row->kfa_code,
    //             'kfa_name' => $row->kfa_name,
    //         ];
    //     }
    // }



    public function update_data($encounter_id)
    {
        // Ambil data dari model berdasarkan ID tersebut
        // $encounter_id = "8085";
        // var_dump($encounter_id);
        $enc = base64_decode($encounter_id);
        // $data['labor'] = $this->print_labor($enc);
        $data['pasien'] = $this->M_tbc->get_pasien_by_id($enc);
        $data['obat'] = $this->M_tbc->get_obat($enc);
        $data['labor'] = $this->M_tbc->get_labor($enc);

        // Jika data ditemukan, kirimkan respons JSON kembali ke client
        $this->load->view('admin/data_pasien/form_pasien', $data);
    }


    public function kirim_pesan($encoded_data)
    {
        $decoded = base64_decode($encoded_data);
        list($encounter_id, $local_id) = explode('|', $decoded);
        $data['pasien'] = $this->M_tbc->get_pasien_by_id($encounter_id);
        $no_rm = $data['pasien']->no_rm;
        $data['no_hp'] = $this->M_tbc->get_no_hp_pasien($no_rm);
        $data['episode'] = $this->M_tbc->get_episode($local_id);
        $data['tanggal'] = $this->M_tbc->get_tanggal_observ($local_id);
        $this->load->view('admin/notifikasi_pasien/kirim_pesan', $data);
    }

    public function get_nama_diagnosa()
    {
        $id_diagnosa = $this->input->post('id_diagnosa'); // Ambil kode ICD dari request POST
        // Ambil nama_diagnosa berdasarkan id_diagnosa
        $diagnosa = $this->M_tbc->get_diagnosa_by_id($id_diagnosa);
        // var_dump($diagnosa);
        // die;

        // Kirim hasilnya sebagai response JSON
        echo json_encode($diagnosa);
    }

    public function getKodeDiagnosa()
    {
        $query = $this->input->get('q'); // Ambil query dari URL

        $results = $this->M_tbc->get_diag_dokter($query);
        echo json_encode($results);
    }

    public function getDiag()
    {
        $query = $this->input->get('q'); // Ambil query dari URL

        $results = $this->M_tbc->get_diagnosa($query);
        echo json_encode($results);
    }

    // misal di CodeIgniter, di dalam controller
    public function getHasilPemeriksaan()
    {
        $type_obs = $this->input->post('type_obs'); // Ambil jenis pemeriksaan dari AJAX request

        // Query ke database berdasarkan type_obs
        if ($type_obs == 'microscopic') {
            $data = ['neg', '1', '2', '3', '4', '5', '6', '7', '8', '9', '1+', '2+', '3+', 'tidak dilakukan'];
        } elseif ($type_obs == 'tcm') {
            $data = ['neg', 'rif-sen', 'rif-res', 'rif-indet', 'invalid', 'error', 'no result'];
        } elseif ($type_obs == 'culture-treatment') {
            $data = ['neg', '1', '2', '3', '4', '5', '6', '7', '8', '9', '1+', '2+', '3+', '4+', 'ntm', 'kontaminasi', 'tidak dilakukan'];
        }

        // Kirim hasil ke AJAX dalam bentuk JSON
        echo json_encode($data);
    }



    // public function update_data($encounter_id)
    // {
    //     // Dekode encounter_id
    //     $enc = base64_decode($encounter_id);

    //     // Ambil data pasien
    //     $data['pasien'] = $this->M_tbc->get_pasien_by_id($enc);

    //     // Ambil hasil labor
    //     $labor_results = $this->print_labor($enc);

    //     // Jika ada hasil labor, masukkan ke dalam objek $pasien
    //     if (!empty($labor_results)) {
    //         // Ambil hasil observasi pertama (misalkan hanya ambil satu)
    //         $first_observation = $labor_results[0];

    //         // Masukkan data observasi ke objek pasien
    //         $data['pasien']->observation_local_id = $first_observation['local_id'];
    //         $data['pasien']->observation_type = $first_observation['type_observation'];
    //         $data['pasien']->observation_issued = $first_observation['issued'];
    //         $data['pasien']->observation_value = $first_observation['value'];
    //         $data['pasien']->observation_episode_number = $first_observation['episode_number'];
    //     } else {
    //         // Jika tidak ada data labor, pastikan field tersebut null
    //         $data['pasien']->observation_local_id = null;
    //         $data['pasien']->observation_type = null;
    //         $data['pasien']->observation_issued = null;
    //         $data['pasien']->observation_value = null;
    //         $data['pasien']->observation_episode_number = null;
    //     }

    //     // Load view dan kirim data ke view
    //     $this->load->view('form_pasien', $data);
    // }


    public function info_data($encounter_id)
    {
        // Ambil data dari model berdasarkan ID tersebut
        // $encounter_id = "8085";
        $enc = base64_decode($encounter_id);
        $data['pasien'] = $this->M_tbc->get_pasien_by_id($enc);
        $data['obat'] = $this->M_tbc->get_info_obat($enc);
        $data['labor'] = $this->M_tbc->get_info_labor($enc);

        // Jika data ditemukan, kirimkan respons JSON kembali ke client
        $this->load->view('admin/data_pasien/info_pasien', $data);
    }

    // public function edit_data()
    // {
    //     // Ambil data dari POST tanpa validasi
    //     $prov = $this->input->post('prov');
    //     $province = "";
    //     if ($prov == "Bangka Belitung") {
    //         $province = "19";
    //     }
    //     $dist = $this->input->post('distrik');
    //     $kab = "";
    //     if ($dist == "RSBT Pangkalpinang") {
    //         $kab = "1901";
    //     }

    //     $t_diag = $this->input->post('type_diagnosis');

    //     $lokasi = $this->input->post('location_anatomi');


    //     $update_data = array(
    //         'patient_name' => $this->input->post('nama'),
    //         'patient_nik' => $this->input->post('nik'),
    //         'practitioner_nik' => $this->input->post('nik'),
    //         'patient_gender' => $this->input->post('gender'),
    //         'patient_dob' => $this->input->post('ttl'),
    //         'patient_province' => $province,
    //         'patient_district' => $kab,
    //         'patient_address' => $this->input->post('alamat'),
    //         'encounter_local_id' => $this->input->post('local_id'),
    //         'encounter_classification' => $this->input->post('klasifikasi'),
    //         'encounter_period_start' => $this->input->post('enc_period_start'),
    //         'encounter_period_in_progress' => $this->input->post('enc_period_in_progress'),
    //         'encounter_period_end' => $this->input->post('enc_period_end'),
    //         'diagnosis_type' => $t_diag,
    //         'other_icd' => $this->input->post('id_diag'),
    //         'nama_diagnosa' => $this->input->post('nama_diag'),
    //         'diagnosis_location_anatomi' => $lokasi,
    //         'treatment_history' => $this->input->post('treatment_history'),
    //         'end_result_treatment' => $this->input->post('end_result'),
    //         'condition_icd_x_code' => $this->input->post('kodeDiagPer'),
    //         'condition_clinical_status_tb' => $this->input->post('status'),
    //         'medication_kfa_code' => $this->input->post('kode_kfa'),
    //         'medication_kfa_name' => $this->input->post('nama_kfa'),
    //         'medication_form_code' => $this->input->post('kode_form'),
    //         'episode_of_care_ihs_id' => $this->input->post('ihs_id'),
    //         'episode_of_care_id_tb_03' => $this->input->post('id_tb'),
    //         'episode_of_care_status' => $this->input->post('status_berobat'),
    //         'episode_of_care_type_code' => $this->input->post('type_code'),
    //         'episode_of_care_period_start' => $this->input->post('period_start'),
    //         'period_end' => $this->input->post('period_end')
    //     );

    //     // Ambil ID dari local_id untuk referensi update
    //     $local_id = $this->input->post('local_id');

    //     $cara_input = empty($labor) ? 'manual' : 'labor';

    //     $data_labor_none = array(
    //         'id_pelayanan' => $local_id,
    //         'local_id' => $this->input->post('observ_id'),
    //         'type_observation' => $this->input->post('type_observ'),
    //         'issued' => $this->input->post('issued'),
    //         'hasil' => $this->input->post('hasil'),
    //         // 'issued_rifampicin'=>$this->input->post('issued_rifampicin_new'),
    //         'episode_number' => $this->input->post('period_number'),
    //         'cara_input' => $cara_input
    //     );

    //     $data_labor_update = array(
    //         'id_pelayanan' => $local_id,
    //         'local_id' => $this->input->post('manual_observ_id'),
    //         'type_observation' => $this->input->post('manual_type_obs'),
    //         'issued' => $this->input->post('manual_issued'),
    //         'hasil' => $this->input->post('manual_hasil'),
    //         'issued_rifampicin' => $this->input->post('issued_rifampicin_new'),
    //         'episode_number' => $this->input->post('manual_period_number'),
    //         'cara_input' => 'manual'
    //     );

    //     $data_labor_otomatis = array(
    //         'id_pelayanan' => $local_id,
    //         'local_id' => $this->input->post('lid'),
    //         'type_observation' => $this->input->post('type_obs'),
    //         'issued' => $this->input->post('issueds'),
    //         'hasil' => $this->input->post('hasils'),
    //         'issued_rifampicin' => $this->input->post('issued_rifampicin_new'),
    //         'episode_number' => $this->input->post('eps_numbers'),
    //         'cara_input' => 'labor'
    //     );

    //     // var_dump($data_labor_none);
    //     // die;

    //     $existing_labor = $this->M_tbc->get_labor_by_local_id($local_id);

    //     if ($existing_labor) {
    //         // Jika data labor sudah ada, lakukan update
    //         $labor_status = $this->M_tbc->update_data_lab($data_labor_update['local_id'], $data_labor_update);
    //     } else {
    //         // Jika data labor belum ada, lakukan insert
    //         // $update_status = $this->M_tbc->update_pasien($local_id, $update_data);
    //         $labor_status = $this->M_tbc->input_data_lab($data_labor_none, 'tb_observ_labor');
    //     }

    //     if (!empty($data_labor_otomatis['local_id'])) {
    //         // Pastikan data labor otomatis di-insert/update ke database
    //         foreach ($data_labor_otomatis['local_id'] as $key => $local_id_value) {
    //             $observation_data = array(
    //                 'id_pelayanan' => $local_id,
    //                 'local_id' => $data_labor_otomatis['local_id'][$key],
    //                 'type_observation' => $data_labor_otomatis['type_observation'][$key],
    //                 'issued' => $data_labor_otomatis['issued'][$key],
    //                 'hasil' => $data_labor_otomatis['hasil'][$key],
    //                 'episode_number' => $data_labor_otomatis['episode_number'][$key],
    //                 'cara_input' => 'labor'
    //             );

    //             // Simpan atau update data observasi labor otomatis
    //             $existing_auto_observation = $this->M_tbc->get_observation_by_local_id($local_id_value); // Check if the observation exists

    //             if ($existing_auto_observation) {
    //                 // Update existing observation
    //                 $this->M_tbc->update_observation($local_id_value, $observation_data);
    //             } else {
    //                 // Insert new observation
    //                 $this->M_tbc->input_data_lab($observation_data, 'tb_observ_labor');
    //             }
    //         }
    //     }

    //     // Update data di database
    //     $update_status = $this->M_tbc->update_pasien($local_id, $update_data);

    //     // $lid = $this->input->post('lid');
    //     // $type_obs = $this->input->post('type_obs');
    //     // $issued = $this->input->post('issued');
    //     // $hasil = $this->input->post('hasil');
    //     // $eps_number = $this->input->post('eps_number');

    //     // if (!empty($lid)) {
    //     //     foreach ($lid as $key => $value) {
    //     //         // Buat array untuk setiap pemeriksaan observasi
    //     //         $observation_data = array(
    //     //             'local_id' => $lid[$key],
    //     //             'type_observation' => $type_obs[$key],
    //     //             'issued' => $issued[$key],
    //     //             'value' => $hasil[$key],
    //     //             'episode_number' => $eps_number[$key],
    //     //             'id_pelayanan' => $local_id // Jika perlu menghubungkan ke pasien
    //     //         );

    //     //         // Simpan atau update data observasi di database
    //     //         $this->M_tbc->update_observation($local_id,$observation_data);
    //     //     }
    //     // }


    //     // Cek apakah update berhasil
    //     if ($update_status || $labor_status) {
    //         // Jika berhasil
    //         $response = array('status' => 'success', 'message' => 'Data berhasil diupdate');
    //     } else {
    //         // Jika gagal
    //         $response = array('status' => 'error', 'message' => 'Gagal memperbarui data pasien');
    //     }

    //     // Kembalikan respons JSON ke AJAX
    //     $this->output
    //         ->set_content_type('application/json')
    //         ->set_output(json_encode($response));
    // }


    public function edit_data()
    {
        // Ambil data dari POST tanpa validasi
        $prov = $this->input->post('prov');
        $province = "";
        if ($prov == "Bangka Belitung") {
            $province = "19";
        }
        $dist = $this->input->post('distrik');
        $kab = "";
        if ($dist == "RSBT Pangkalpinang") {
            $kab = "1901";
        }

        $t_diag = $this->input->post('type_diagnosis');

        $lokasi = $this->input->post('location_anatomi');


        $update_data = array(
            'patient_name' => $this->input->post('nama'),
            'patient_nik' => $this->input->post('nik'),
            'practitioner_nik' => $this->input->post('nik'),
            'patient_gender' => $this->input->post('gender'),
            'patient_dob' => $this->input->post('ttl'),
            'patient_province' => $province,
            'patient_district' => $kab,
            'patient_address' => $this->input->post('alamat'),
            'encounter_local_id' => $this->input->post('local_id'),
            'encounter_classification' => $this->input->post('klasifikasi'),
            'encounter_period_start' => $this->input->post('enc_period_start'),
            'encounter_period_in_progress' => $this->input->post('enc_period_in_progress'),
            'encounter_period_end' => $this->input->post('enc_period_end'),
            'diagnosis_type' => $t_diag,
            'other_icd' => $this->input->post('id_diag'),
            'nama_diagnosa' => $this->input->post('nama_diag'),
            'diagnosis_location_anatomi' => $lokasi,
            'treatment_history' => $this->input->post('treatment_history'),
            'end_result_treatment' => $this->input->post('end_result'),
            'condition_icd_x_code' => $this->input->post('kodeDiagPer'),
            'condition_clinical_status_tb' => $this->input->post('status'),
            'medication_kfa_code' => $this->input->post('kode_kfa'),
            'medication_kfa_name' => $this->input->post('nama_kfa'),
            'medication_form_code' => $this->input->post('kode_form'),
            'episode_of_care_ihs_id' => $this->input->post('ihs_id'),
            'episode_of_care_id_tb_03' => $this->input->post('id_tb'),
            'episode_of_care_status' => $this->input->post('status_berobat'),
            'episode_of_care_type_code' => $this->input->post('type_code'),
            'episode_of_care_period_start' => $this->input->post('period_start'),
            'period_end' => $this->input->post('period_end')
        );

        $local_id = $this->input->post('local_id');

        $result = $this->M_tbc->update_pasien($local_id, $update_data);

        // Cek apakah update berhasil
        if ($result) {
            // Jika berhasil
            $response = array('status' => 'success', 'message' => 'Data berhasil diupdate');
        } else {
            // Jika gagal
            $response = array('status' => 'error', 'message' => 'Gagal memperbarui data pasien');
        }

        // Kembalikan respons JSON ke AJAX
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }


    public function hapus_pemeriksaan()
    {
        $local_id = $this->input->post('local_id');  // Ambil local_id dari request POST

        if ($local_id) {
            // Load model dan hapus data berdasarkan local_id
            $result = $this->M_tbc->hapus_pemeriksaan($local_id);

            if ($result) {
                $response = ['success' => true, 'message' => 'Data berhasil dihapus'];
            } else {
                $response = ['success' => false, 'message' => 'Gagal menghapus data'];
            }
        } else {
            $response = ['success' => false, 'message' => 'ID tidak valid'];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }


    public function get_data_labor()
    {
        $id = $this->input->post('id');

        if (empty($id)) {
            echo json_encode(['error' => 'ID is required']);
            return;
        }

        $data = $this->M_tbc->get_labor_data($id); // Make sure to implement this method in your model

        // Check if data is found
        if ($data) {
            echo json_encode($data); // Return the data as JSON
        } else {
            echo json_encode(['error' => 'No data found for this ID']);
        }
    }

    public function update_data_labor()
    {
        $id = $this->input->post('modal_observ_id');
        $type_obs = $this->input->post('modal_type_obs');
        $modal_issued = $this->input->post('modal_issued');
        $modal_hasil = $this->input->post('modal_hasil');
        $modal_period_number = $this->input->post('modal_period_number');
        $issued_rifampicin_modal = $this->input->post('issued_rifampicin_modal');

        $data = array(
            'local_id' => $id,
            'type_observation' => $type_obs,
            'issued' => $modal_issued,
            'hasil' => $modal_hasil,
            'episode_number' => $modal_period_number,
            'issued_rifampicin' => $issued_rifampicin_modal
        );

        $result = $this->M_tbc->update_data_labor($id, $data); // Ensure this is the correct column name for your unique identifier
        if ($result) {
            // Handle success response
            $response = array('status' => 'success', 'message' => 'Data berhasil diupdate');
        } else {
            // Handle failure response and get detailed error information
            $response = array('status' => 'error', 'message' => 'Gagal memperbarui data labor');
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function edit_data_pemeriksaan()
    {
        // Ambil data yang dikirim melalui AJAX
        $manual_observ_id_new = $this->input->post('manual_observ_id_new');
        $manual_type_obs_new = $this->input->post('manual_type_obs_new');
        $manual_issued_new = $this->input->post('manual_issued_new');
        // $cara_input_new = $this->input->post('cara_input_new');
        $issued_rifampicin_new = $this->input->post('issued_rifampicin_new');
        $local_id_new = $this->input->post('local_id');
        $manual_hasil_new = $this->input->post('manual_hasil_new');
        $manual_period_number_new = $this->input->post('manual_period_number_new');

        // Buat array data untuk disimpan di database
        $data_to_save = array();

        // Loop data input dan susun menjadi array untuk disimpan
        foreach ($manual_observ_id_new as $key => $id_pemeriksaan) {
            $data_to_save[] = array(
                'id_pelayanan' => $local_id_new,
                'local_id' => $id_pemeriksaan,
                'type_observation' => $manual_type_obs_new[$key],
                'issued' => $manual_issued_new[$key],
                'cara_input' => 'manual',
                'issued_rifampicin' => $issued_rifampicin_new[$key],
                'hasil' => $manual_hasil_new[$key],
                'episode_number' => $manual_period_number_new[$key]
            );
        }

        // Kirim data ke model untuk disimpan
        $result = $this->M_tbc->update_data_pemeriksaan($data_to_save);

        // Cek hasil simpan data
        if ($result) {
            // Jika berhasil
            $response = array('status' => 'success', 'message' => 'Data berhasil diupdate');
        } else {
            // Jika gagal
            $response = array('status' => 'error', 'message' => 'Gagal memperbarui data pasien');
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function simpan_pemeriksaan_empty()
    {
        $local_id = $this->input->post('local_id');
        $observ_id = $this->input->post('observ_id');
        $type_observ = $this->input->post('type_observ');
        $issued = $this->input->post('issued');
        $hasil = $this->input->post('hasil');
        $issued_rifampicin = $this->input->post('issued_rifampicin');
        $period_number = $this->input->post('period_number');

        $data = array(
            'id_pelayanan' => $local_id,
            'local_id' => $observ_id,
            'type_observation' => $type_observ,
            'issued' => $issued,
            'hasil' => $hasil,
            'episode_number' => $period_number,
            'cara_input' => 'manual'
        );

        // Periksa apakah 'type_observ' dan 'hasil' memenuhi syarat
        if ($type_observ == 'tcm' && ($hasil == 'rif-sen' || $hasil == 'rif-res' || $hasil == 'rif-indet')) {
            $data['issued_rifampicin'] = $issued_rifampicin;
        }

        // Simpan data ke dalam tabel 'tb_observ_labor'
        $result = $this->M_tbc->insert_data($data, 'tb_observ_labor');

        // Menyiapkan respons JSON berdasarkan hasil penyimpanan
        if ($result) {
            $response = array('status' => 'success', 'message' => 'Data berhasil diupdate');
        } else {
            $response = array('status' => 'error', 'message' => 'Gagal memperbarui data pasien');
        }

        // Mengirim respons JSON
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }


    public function gender()
    {
        $id_pelayanan = "pl_389278";
        $pasien = $this->M_tbc->get_Pasien($id_pelayanan);
        if ($pasien->jenis_kelamin == "LAKI-LAKI") {
            return "L";
        } else if ($pasien->jenis_kelamin == "PEREMPUAN") {
            return "P";
        }
    }

    public function kode_icd($id_pelayanan)
    {
        $kode_icd = $this->M_tbc->get_kode_icd($id_pelayanan);
        if ($kode_icd == "ya") {
            return "A15.0";
        } else {
            return "A15.0";
        }
    }

    public function active($id_pelayanan)
    {
        if ($this->kode_icd($id_pelayanan) == "A15.0") {
            return "active";
        } else {
            return "inactive";
        }
    }

    public function clasification($id_pelayanan)
    {
        $class = $this->M_tbc->classifications2($id_pelayanan);
        if ($class->jenis_pelayanan == "RAWAT JALAN") {
            return "AMB";
        } else if ($class->jenis_pelayanan == "IGD") {
            return "EMER";
        } else if ($class->jenis_pelayanan == "RAWAT INAP") {
            return "IMP";
        } else if ($class->jenis_pelayanan == "POLI") {
            return "AMB";
        } else if ($class->jenis_pelayanan == "POLI PRIORITAS") {
            return "AMB";
        }
    }

    public function get_kfa_code($id_pelayanan)
    {
        $kfa = $this->M_tbc->kfa_code($id_pelayanan);
        if ($kfa == null) {
            return "-";
        } else {
            return [
                'id_logistik' => $kfa->id_logistik,
                'kode' => $kfa->kode,
                'nama' => $kfa->nama
            ];
        }
    }

    public function quitioners($id_pelayanan)
    {

        $array = array(
            'A15'   => array(
                'lokasi_anatomi' => '',
                'tipe_diagnosis' => ''
            ),
            'A15.0' => array(
                'lokasi_anatomi' => 'PTB',
                'tipe_diagnosis' => 'tb-bac'
            ),
            'A15.1' => array(
                'lokasi_anatomi' => 'PTB',
                'tipe_diagnosis' => 'tb-bac'
            ),
            'A15.2' => array(
                'lokasi_anatomi' => 'PTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A15.3' => array(
                'lokasi_anatomi' => 'PTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A15.4' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-bac'
            ),
            'A15.5' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-bac'
            ),
            'A15.6' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-bac'
            ),
            'A15.7' => array(
                'lokasi_anatomi' => 'PTB',
                'tipe_diagnosis' => 'tb-bac'
            ),
            'A15.8' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-bac'
            ),
            'A15.9' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-bac'
            ),
            'A16'   => array(
                'lokasi_anatomi' => '',
                'tipe_diagnosis' => ''
            ),
            'A16.0' => array(
                'lokasi_anatomi' => 'PTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A16.1' => array(
                'lokasi_anatomi' => 'PTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A16.2' => array(
                'lokasi_anatomi' => 'PTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A16.3' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A16.4' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A16.5' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A16.7' => array(
                'lokasi_anatomi' => 'PTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A16.8' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A16.9' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A17'   => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A17.0' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A17.1' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A17.8' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A17.9' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A18'   => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A18.0' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A18.1' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A18.2' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A18.3' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A18.4' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A18.5' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A18.6' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A18.7' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A18.8' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A18.9' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A19'   => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A19.0' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A19.1' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A19.2' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A19.3' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A19.8' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
            'A19.9' => array(
                'lokasi_anatomi' => 'EPTB',
                'tipe_diagnosis' => 'tb-clin'
            ),
        );
        // $id_pelayanan = "pl_389278";

        $kode_icd10 = $this->kode_icd($id_pelayanan);
        // var_dump($kode_icd10);

        // Mengecek apakah kode ICD10 ada di dalam array
        if (isset($array[$kode_icd10])) {
            $result = $array[$kode_icd10];

            // Memeriksa apakah array mengandung 'lokasi_anatomi' dan 'tipe_diagnosis'
            if (isset($result['lokasi_anatomi']) && isset($result['tipe_diagnosis'])) {
                return array(
                    'lokasi_anatomi' => $result['lokasi_anatomi'],
                    'tipe_diagnosis' => $result['tipe_diagnosis']
                );
            }
        }

        // Jika tidak ditemukan atau kode tidak sesuai, kembalikan nilai default (misal: null)
        return null;
    }

    public function treatment() {}

    public function id_tb($id_pelayanan)
    {
        $cek = $this->M_tbc->cek_data($id_pelayanan);
        if ($cek) {
            return array(
                'id_tb' => $cek->id_tb,
                'ihs_id' => $cek->ihs_id
            );
        } else {
            return "";
        }
    }

    public function get_log()
    {
        $data['log'] = $this->M_tbc->cat_log();
        // var_dump($data);
        $this->load->view('log_pengiriman', $data);
    }



    public function log_file()
    {
        // Path ke folder logs
        $log_path = APPPATH . 'logs/';

        // Dapatkan semua file log di folder logs
        $log_files = glob($log_path . 'log-*.php');

        $logs = [];
        foreach ($log_files as $file) {
            // Baca isi file log
            $logs[] = file_get_contents($file);
        }

        // Kirim data log ke view
        $data['logs'] = $logs;
        $this->load->view('Error_log', $data);
    }

    public function sendEmail()
    {
        // Load library email dan konfigurasi
        $this->load->library('email');
        $this->load->config('email');

        // Set data email
        $this->email->from('baktitimah@gmail.com', 'TIM IT RSBT'); // Ganti dengan email dan nama pengirim
        $this->email->to('amrilsyirel57@gmail.com'); // Email tujuan
        $this->email->subject('Testing');
        $this->email->message('Ini adalah isi email yang dikirim melalui CodeIgniter 3');

        // Kirim email dan periksa apakah berhasil
        if ($this->email->send()) {
            echo 'Email berhasil dikirim!';
        } else {
            // Tampilkan error jika gagal
            echo 'Email gagal dikirim!';
            echo $this->email->print_debugger();
        }
    }

    public function rekap_data()
    {
        $this->load->view('admin/rekap_data/rekap_data');
    }

    public function filter_data()
    {
        $mulai = $this->input->post('tanggal_mulai');
        $selesai = $this->input->post('tanggal_akhir');
        $jenis = $this->input->post('tipe_file');

        $data['tanggal_mulai'] = $mulai;
        $data['tanggal_akhir'] = $selesai;
        $data['tipe_file'] = $jenis;

        $data['hasil'] = $this->M_tbc->get_filtered_data($mulai, $selesai, $jenis);
        $data['filtered'] = true;

        $this->load->view('admin/rekap_data/rekap_data', $data);
    }



    // public function extract_data()
    // {
    //     $mulai = $this->input->post('tanggal_mulai');
    //     $selesai = $this->input->post('tanggal_akhir');
    //     $jenis = $this->input->post('tipe_file');

    //     if (!$mulai || !$selesai || !$jenis) {
    //         show_error('Parameter tidak lengkap', 400);
    //         return;
    //     }

    //     $data = $this->M_tbc->get_filtered_data($mulai, $selesai, $jenis);

    //     if (empty($data)) {
    //         show_error('Data tidak ditemukan', 404);
    //     }

    //     // Atur nama file
    //     $filename = "Laporan_{$jenis}_" . date('YmdHis') . ".xls";

    //     // Atur header browser
    //     header("Content-Description: File Transfer");
    //     header("Content-Disposition: attachment; filename={$filename}");
    //     header("Content-Type: application/csv; ");

    //     // Buka output stream
    //     $file = fopen('php://output', 'w');

    //     // Tulis header kolom
    //     fputcsv($file, array_keys((array)$data[0]));

    //     // Tulis data
    //     foreach ($data as $row) {
    //         fputcsv($file, (array)$row);
    //     }

    //     fclose($file);
    //     exit;
    // }


    public function extract_data()
    {
        $mulai = $this->input->post('tanggal_mulai');
        $selesai = $this->input->post('tanggal_akhir');
        $jenis = $this->input->post('tipe_file');

        if (!$mulai || !$selesai || !$jenis) {
            show_error('Parameter tidak lengkap', 400);
            return;
        }

        $data = $this->M_tbc->get_filtered_data($mulai, $selesai, $jenis);

        if (empty($data)) {
            show_error('Data tidak ditemukan', 404);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $judul = ($jenis == 'data_terkirim')
            ? "Data Terkirim (" . date('d-m-Y', strtotime($mulai)) . " s/d " . date('d-m-Y', strtotime($selesai)) . ")"
            : "Data Pasien TBC (" . date('d-m-Y', strtotime($mulai)) . " s/d " . date('d-m-Y', strtotime($selesai)) . ")";

        $rowIndex = 1;
        $colIndex = 1;

        // =========================
        // CONFIG HEADER & MAPPING
        // =========================
        $headers = ['No'];
        if ($jenis === 'data_terkirim') {
            $headerMap = [
                'id_tb' => 'ID TB',
                'id_pelayanan' => 'ID Pelayanan',
                'status' => 'Status',
                'tanggal' => 'Tanggal Kirim'
            ];
        } else {
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
        }

        $headers = array_merge($headers, array_values($headerMap));

        $colCount = count($headers);
        $lastColumn = Coordinate::stringFromColumnIndex($colCount);

        // =====================
        // Judul Laporan (A1)
        // =====================
        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells("A1:{$lastColumn}1");
        $sheet->getStyle("A1")->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // ======================
        // Header Kolom (A2...)
        // ======================
        $sheet->fromArray($headers, NULL, 'A2');
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

        // ===================
        // ISI DATA (Baris 3++)
        // ===================
        $rowIndex = 3;
        $no = 1;
        foreach ($data as $row) {
            $colIndex = 1;
            $sheet->setCellValueByColumnAndRow($colIndex++, $rowIndex, $no++);

            foreach ($headerMap as $key => $label) {
                $value = $row->$key ?? '';

                // Mapping khusus untuk provinsi dan kabupaten
                if ($key === 'patient_province' && $value == '19') {
                    $value = 'Bangka Belitung';
                }
                if ($key === 'patient_district' && $value == '1901') {
                    $value = 'Pangkalpinang';
                }

                $cell = $sheet->getCellByColumnAndRow($colIndex, $rowIndex);

                // Format khusus
                if ($key === 'patient_nik') {
                    $cell->setValueExplicit((string)$value, DataType::TYPE_STRING);
                } elseif (in_array($key, ['patient_dob', 'episode_of_care_period_start', 'period_end', 'tanggal'])) {
                    if (empty($value) || $value == '0000-00-00' || $value == '0000-00-00 00:00:00') {
                        $cell->setValueExplicit($value, DataType::TYPE_STRING);
                    } else {
                        $excelDate = Date::PHPToExcel(strtotime($value));
                        $cell->setValue($excelDate);
                        $formatCode = (strlen($value) > 10) ? 'DD-MM-YYYY HH:MM:SS' : 'DD-MM-YYYY';
                        $sheet->getStyleByColumnAndRow($colIndex, $rowIndex)->getNumberFormat()->setFormatCode($formatCode);
                    }
                } else {
                    $cell->setValue($value);
                }

                $colIndex++;
            }

            $rowIndex++;
        }

        // ============================
        // STYLE: Border seluruh tabel
        // ============================
        $lastDataRow = $rowIndex - 1;
        $sheet->getStyle("A2:{$lastColumn}{$lastDataRow}")->applyFromArray([
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ]
        ]);

        // ============================
        // WIDTH: Otomatis semua kolom
        // ============================
        for ($i = 1; $i <= $colCount; $i++) {
            $sheet->getColumnDimensionByColumn($i)->setAutoSize(true);
        }

        // ============================
        // OUTPUT
        // ============================
        $filename = "Laporan_{$jenis}_" . date('Ymd_His') . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }


    public function pemberitahuan_pasien()
    {
        $data['data_pasien_lanjut'] = $this->M_tbc->get_data_lanjut_pasien();
        $this->load->view('admin/notifikasi_pasien/notif_pasien', $data);
    }

    public function pemberitahuan_pasien2()
    {
        $data['data_pasien_lanjut2'] = $this->M_tbc->get_data_lanjut_pasien2();
        $this->load->view('admin/notifikasi_pasien/notif_pasien2', $data);
    }
    public function pemberitahuan_pasien3()
    {
        $data['data_pasien_lanjut3'] = $this->M_tbc->get_data_lanjut_pasien3();
        $this->load->view('admin/notifikasi_pasien/notif_pasien3', $data);
    }
    public function pemberitahuan_pasien4()
    {
        $data['data_pasien_lanjut4'] = $this->M_tbc->get_data_lanjut_pasien4();
        $this->load->view('admin/notifikasi_pasien/notif_pasien4', $data);
    }
    public function pemberitahuan_pasien6()
    {
        $data['data_pasien_lanjut6'] = $this->M_tbc->get_data_lanjut_pasien6();
        $this->load->view('admin/notifikasi_pasien/notif_pasien6', $data);
    }


    public function kirim_pesanwa()
    {
        $curl = curl_init();

        $token = "NXA2LKAMfwhw7F9afon7";
        $target = "083809808665";
        // $target = $this->input->post('no_hp');
        $pesan = $this->input->post('pesan');

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $target,
                'message' => $pesan,
                'delay' => '2',
            ),
            CURLOPT_HTTPHEADER => array(
                "Authorization: $token"
            ),
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error_msg = curl_error($curl);
        curl_close($curl);

        if ($error_msg) {
            echo json_encode(['status' => 'error', 'message' => $error_msg]);
        } else {
            if ($httpCode == 200) {
                echo json_encode(['status' => 'success', 'message' => 'Pesan berhasil dikirim!', 'api_response' => $response]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal kirim pesan!', 'api_response' => $response]);
            }
        }
    }

    public function validasi_pengobatan($encoded_id)
    {
        $local_id = base64_decode($encoded_id);

        // Update status jadi 1
        $this->db->where('local_id', $local_id);
        $this->db->update('tb_observ_labor', ['status_pengobatan' => 1]);

        // Redirect kembali ke halaman utama
        $this->session->set_flashdata('success', 'Status pengobatan berhasil divalidasi!');
        redirect('dataController/pemberitahuan_pasien2'); // Ganti dengan route view kamu
    }

    public function validasi_pengobatan2($encoded_id)
    {
        $local_id = base64_decode($encoded_id);

        // Update status jadi 1
        $this->db->where('local_id', $local_id);
        $this->db->update('tb_observ_labor', ['status_pengobatan' => 1]);

        // Redirect kembali ke halaman utama
        $this->session->set_flashdata('success', 'Status pengobatan berhasil divalidasi!');
        redirect('dataController/pemberitahuan_pasien3'); // Ganti dengan route view kamu
    }

    public function validasi_pengobatan3($encoded_id)
    {
        $local_id = base64_decode($encoded_id);

        // Update status jadi 1
        $this->db->where('local_id', $local_id);
        $this->db->update('tb_observ_labor', ['status_pengobatan' => 1]);

        // Redirect kembali ke halaman utama
        $this->session->set_flashdata('success', 'Status pengobatan berhasil divalidasi!');
        redirect('dataController/pemberitahuan_pasien4'); // Ganti dengan route view kamu
    }

    public function validasi_pengobatan5($encoded_id)
    {
        $local_id = base64_decode($encoded_id);

        // Update status jadi 1
        $this->db->where('local_id', $local_id);
        $this->db->update('tb_observ_labor', ['status_pengobatan' => 1]);

        // Redirect kembali ke halaman utama
        $this->session->set_flashdata('success', 'Status pengobatan berhasil divalidasi!');
        redirect('dataController/pemberitahuan_pasien6'); // Ganti dengan route view kamu
    }
}
