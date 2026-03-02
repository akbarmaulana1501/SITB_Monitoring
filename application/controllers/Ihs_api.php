<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ihs_api extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->helper('satusehat');
        $this->load->model('M_Satusehat');
        $this->load->model('M_tbc');
        $this->load->helper('usaid');
        $this->api = "http://192.168.87.2:8181/";
        $this->load->library('curl');
    }
    // public function print_labor()
    // {
    //     $id_pel = "pl_435564";
    //     // $id = "102914";
    //     $id = "112662";
    //     $param = array('ono' => 'A' . $id);
    //     $labor = json_decode($this->curl->simple_get($this->api . 'RESULTS', $param));

    //     if ($labor != "") {
    //         $data['labor'] = $labor;
    //         return $data;
    //     } else {
    //         echo "gagal!";
    //     }
    // }

    // public function print_labor()
    // {
    //     $id = "112662";
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
    //                     // Cek jika GROUP adalah "MIKROBIOLOGI"
    //                     if (isset($result->GROUP)) {
    //                         $typeObservation = ($result->GROUP === "MIKROBIOLOGI") ? "microscopic" : $result->GROUP;

    //                         // Tentukan value berdasarkan hasil
    //                         $value = (isset($result->VALUE) && $result->VALUE === "Negatif") ? "neg" : (isset($result->VALUE) ? $result->VALUE : null);
    //                         $fromat_tgl = date('Y-m-d\TH:i:s\Z', strtotime($observ->TGLORDER));

    //                         // Ambil GROUP dan VALUE dari elemen RESULT
    //                         $observations[] = array(
    //                             'local_id' => $observ->LABNO,
    //                             'type_observation' => $typeObservation,
    //                             'issued' => $fromat_tgl,
    //                             'value' => $value,
    //                             'episode_number' => strval($episodeCounter),
    //                         );
    //                         $episodeCounter++; // Increment counter untuk episode_number
    //                     }
    //                 }
    //             } else {
    //                 // Tangani kasus di mana RESULT tidak ada atau bukan array
    //                 $observations[] = array(
    //                     'local_id' => $observ->LABNO,
    //                     'type_observation' => null,
    //                     'issued' => $observ->TGLORDER,
    //                     'value' => null,
    //                     'episode_number' => strval($episodeCounter),
    //                 );
    //             }
    //         }

    //         // Kembalikan hanya observasi
    //         return $observations;
    //     } else {
    //         echo "gagal!";
    //         return []; // Kembalikan array kosong jika gagal
    //     }
    // }

    public function collection_data()
    {
        // Mendapatkan data mentah dari body permintaan
        // $raw_data = $this->input->raw_input_stream;
        header('Content-Type: application/json');

        $id_pelayanan = "pl_389278";
        $no_rm = "8085";
        $pasien = $this->M_tbc->get_Pasien($id_pelayanan);
        $kode_icd = $this->kode_icd($id_pelayanan);
        $active = $this->active($id_pelayanan);
        $jk = $this->gender();
        $klasisfikasi = $this->clasification($id_pelayanan);
        $clasifi = $this->M_tbc->classifications($no_rm);
        $quitioner = $this->quitioners($id_pelayanan);
        $tgl_masuk = $clasifi->tgl_masuk;
        $tgl_prog = $clasifi->tanggal;
        $tgl_selesai = $clasifi->tgl_keluar;
        $id_tb = $this->id_tb($id_pelayanan);
        $fromat1 = date('Y-m-d\TH:i:s\Z', strtotime($tgl_masuk));
        $fromat2 = date('Y-m-d\TH:i:s\Z', strtotime($tgl_prog));
        $fromat3 = date('Y-m-d\TH:i:s\Z', strtotime($tgl_selesai));
        // $observ = $this->print_labor();


        // $tgl = $this->M_tbc->get_tgl($no_rm);
        // var_dump($pasien);
        // $code = "93000147";
        // $kfa = $this->M_tbc->kfa_code($id_pelayanan);
        $kfa = $this->get_kfa_code($id_pelayanan);

        if ($pasien) {
            $medication_data = [];
            if ($kfa !== "-") {
                $medication_data = [
                    [
                        'kfa_code' => $kfa['kode'],
                        'kfa_name' => $kfa['nama'],
                        'form_code' => $kfa['id_logistik'],
                    ]
                ];
            } else {
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
                'location_id' => $pasien->id_satusehat,
                'practitioner_nik' => $pasien->no_ktp,
                'patient' => array(
                    'nik' => $pasien->no_ktp,
                    'name' => $pasien->nama,
                    'gender' => $jk,
                    'dob' => $pasien->tgl_lahir,
                    'province' => "19",
                    'district' => "1901",
                    'address' => $pasien->alamat,
                ),
                'encounter' => array(
                    'local_id' => $no_rm, //bisa menggunakan id_pelayanan
                    'classification' => $klasisfikasi,
                    'period_start' => $fromat1,
                    'period_in_progress' => $fromat2,
                    'period_end' => $fromat3,
                ),
                'questionnaire_response' => array(
                    'type_diagnosis' => $quitioner['tipe_diagnosis'],
                    'location_anatomi' => $quitioner['lokasi_anatomi'],
                    'treatment_history' => "new",
                    'end_result_treatment' => "",
                ),
                'condition' => array(
                    array(
                        'icd_x_code_tb' => $kode_icd,
                        'clinical_status_tb' => $active,
                        // 'others' => array(
                        //     'icd_x_code'=>'A20.0',
                        //     ' icd_x_code_name'=>'Bubonic plague',
                        //     'clinical_status_tb'=>'active'
                        //)
                    )
                ),
                'medication' => $medication_data,
                'observation' => array(
                    array(
                        'local_id' => $no_rm,
                        'type_observation' => "microscopic",
                        'issued' => $fromat1,
                        'value' => "neg",
                        'episode_number' => "1",
                    ),
                ),
                // 'observation' => $observ,
                'episode_of_care' => array(
                    'ihs_id' => $id_tb['ihs_id'],
                    'id_tb_03' => $id_tb['id_tb'],
                    'status' => "active",
                    'type_code' => "TB-SO",
                    'period_start' => $fromat1,
                    // 'period_end' => "" //dilampirkan ketika sudah finish berdasarkan end result treatment
                )
            );
            $ekstraksi = array(
                'middleware_id' => $data['middleware_id'],
                'organization_id' => $data['organization_id'],
                'location_id' => $data['location_id'],
                'practitioner_nik' => $data['practitioner_nik'],
                'patient_nik' => $data['patient']['nik'],
                'patient_name' => $data['patient']['name'],
                'patient_gender' => $data['patient']['gender'],
                'patient_dob' => $data['patient']['dob'],
                'patient_province' => $data['patient']['province'],
                'patient_district' => $data['patient']['district'],
                'patient_address' => $data['patient']['address'],
                'encounter_local_id' => $data['encounter']['local_id'],
                'encounter_classification' => $data['encounter']['classification'],
                'encounter_period_start' => $data['encounter']['period_start'],
                'encounter_period_in_progress' => $data['encounter']['period_in_progress'],
                'encounter_period_end' => $data['encounter']['period_end'],
                'diagnosis_type' => $data['questionnaire_response']['type_diagnosis'],
                'diagnosis_location_anatomi' => $data['questionnaire_response']['location_anatomi'],
                'treatment_history' => $data['questionnaire_response']['treatment_history'],
                'end_result_treatment' => $data['questionnaire_response']['end_result_treatment'],
                'condition_clinical_status_tb' => $data['condition'][0]['clinical_status_tb'],
                'condition_icd_x_code' => $data['condition'][0]['icd_x_code_tb'],
                'medication_kfa_code' => $data['medication'][0]['kfa_code'],
                'medication_kfa_name' => $data['medication'][0]['kfa_name'],
                'medication_form_code' => $data['medication'][0]['form_code'], // Make sure medication data is in the correct format
                'observation_local_id' => $data['observation'][0]['local_id'],
                'observation_type' => $data['observation'][0]['type_observation'],
                'observation_issued' => $data['observation'][0]['issued'],
                'observation_value' => $data['observation'][0]['value'],
                'observation_episode_number' => $data['observation'][0]['episode_number'],
                'episode_of_care_ihs_id' => $data['episode_of_care']['ihs_id'],
                'episode_of_care_id_tb_03' => $data['episode_of_care']['id_tb_03'],
                'episode_of_care_status' => $data['episode_of_care']['status'],
                'episode_of_care_type_code' => $data['episode_of_care']['type_code'],
                'episode_of_care_period_start' => $data['episode_of_care']['period_start'],
            );
        }

        $response = $this->M_tbc->insert_data_duplicate($ekstraksi, 'tb_data');

        if ($response['status'] === false) {
            echo $response['message'];  // Shows "Duplicate entry found" or other errors
        } else {
            echo $response['message'];  // Success message
        }

        echo json_encode($response);
    }


    public function index_post()
    {

        // Mendapatkan data mentah dari body permintaan
        // $raw_data = $this->input->raw_input_stream;
        header('Content-Type: application/json');

        $id_pelayanan = "pl_389278";
        $no_rm = "8085";
        $pasien = $this->M_tbc->get_Pasien($id_pelayanan);
        $kode_icd = $this->kode_icd($id_pelayanan);
        $active = $this->active($id_pelayanan);
        $jk = $this->gender();
        $klasisfikasi = $this->clasification($id_pelayanan);
        $clasifi = $this->M_tbc->classifications($no_rm);
        $quitioner = $this->quitioners($id_pelayanan);
        $tgl_masuk = $clasifi->tgl_masuk;
        $tgl_prog = $clasifi->tanggal;
        $tgl_selesai = $clasifi->tgl_keluar;
        $id_tb = $this->id_tb($id_pelayanan);
        $fromat1 = date('Y-m-d\TH:i:s\Z', strtotime($tgl_masuk));
        $fromat2 = date('Y-m-d\TH:i:s\Z', strtotime($tgl_prog));
        $fromat3 = date('Y-m-d\TH:i:s\Z', strtotime($tgl_selesai));
        // $observ = $this->print_labor();


        // $tgl = $this->M_tbc->get_tgl($no_rm);
        // var_dump($pasien);
        // $code = "93000147";
        // $kfa = $this->M_tbc->kfa_code($id_pelayanan);
        $kfa = $this->get_kfa_code($id_pelayanan);

        if ($pasien) {
            $medication_data = [];
            if ($kfa !== "-") {
                $medication_data = [
                    [
                        'kfa_code' => $kfa['kode'],
                        'kfa_name' => $kfa['nama'],
                        'form_code' => $kfa['id_logistik'],
                    ]
                ];
            } else {
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
                'location_id' => $pasien->id_satusehat,
                'practitioner_nik' => $pasien->no_ktp,
                'patient' => array(
                    'nik' => $pasien->no_ktp,
                    'name' => $pasien->nama,
                    'gender' => $jk,
                    'dob' => $pasien->tgl_lahir,
                    'province' => "19",
                    'district' => "1901",
                    'address' => $pasien->alamat,
                ),
                'encounter' => array(
                    'local_id' => $no_rm, //bisa menggunakan id_pelayanan
                    'classification' => $klasisfikasi,
                    'period_start' => $fromat1,
                    'period_in_progress' => $fromat2,
                    'period_end' => $fromat3,
                ),
                'questionnaire_response' => array(
                    'type_diagnosis' => $quitioner['tipe_diagnosis'],
                    'location_anatomi' => $quitioner['lokasi_anatomi'],
                    'treatment_history' => "new",
                    'end_result_treatment' => "",
                ),
                'condition' => array(
                    array(
                        'icd_x_code_tb' => $kode_icd,
                        'clinical_status_tb' => $active,
                        // 'others' => array(
                        //     'icd_x_code'=>'A20.0',
                        //     ' icd_x_code_name'=>'Bubonic plague',
                        //     'clinical_status_tb'=>'active'
                        //)
                    )
                ),
                'medication' => $medication_data,
                'observation' => array(
                    array(
                        'local_id' => $no_rm,
                        'type_observation' => "microscopic",
                        'issued' => $fromat1,
                        'value' => "neg",
                        'episode_number' => "1",
                    ),
                ),
                // 'observation' => $observ,
                'episode_of_care' => array(
                    'ihs_id' => $id_tb['ihs_id'],
                    'id_tb_03' => $id_tb['id_tb'],
                    'status' => "active",
                    'type_code' => "TB-SO",
                    'period_start' => $fromat1,
                    // 'period_end' => "" //dilampirkan ketika sudah finish berdasarkan end result treatment
                )
            );

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
        }

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
        $ihs_id = $response_bundle['data']->id;

        $db = array(
            'id_tb' => $id_tb_03,
            'ihs_id' => $ihs_id,
            'status'=>$status,
            'id_pelayanan' => $id_pelayanan,
        );

        $result = $this->M_tbc->insert_data($db, 'ihs_encounter');

        $response = array();

        if ($result) {
            $response['status'] = 'success';
            $response['message'] = 'Data berhasil dimasukkan.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Terjadi kesalahan saat memasukkan data.';
            log_message('error','Terjadi kesalahan saat memasukkan data.');
            error_log("Gagal memasukkan data: " . print_r($db, true));
        }

        // Mengembalikan response sebagai JSON
        echo json_encode($response);


        // echo '<h1>Respon Header</h1>';
        // echo '<pre>';
        // $header = generateTokenUsaid();
        // print_r($header);
        // echo '</pre>';

        // echo '<h1>Response pengiriman Bundle</h1>';
        // $response_bundle = usaidPostData($data, 'data', 'POST');
        // echo '<pre>';
        // print_r($response_bundle);
        // echo '</pre>';

        // $data['patient'] = $patient;

        // $insert = $this->db->insert('testing_post', $data);
        // if ($insert) {
        //     // Jika penyisipan berhasil, ambil kembali data yang baru saja dimasukkan
        //     $inserted_id = $this->db->insert_id();
        //     $inserted_data = $this->db->get_where('testing_post', array('id' => $inserted_id))->row_array();

        //     // Mengembalikan data yang baru saja dimasukkan
        //     $json_response = json_encode(array('status' => 'success', 'data' => $inserted_data));

        //     $this->output
        //         ->set_content_type('application/json')
        //         ->set_status_header(200)
        //         ->set_output($json_response);
        // } else {
        //     $json_error_response = json_encode(array('status' => 'fail'));

        //     $this->output
        //         ->set_content_type('application/json')
        //         ->set_status_header(502)
        //         ->set_output($json_error_response);
        // }
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
}
