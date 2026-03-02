<?php
define('WS_FHIR', 'on');
define('WS_FHIR_API', "https://api-satusehat.kemkes.go.id/fhir-r4/v1/");
// define('WS_FHIR_API', "https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/");
define('WS_FHIR_ORG_ID', "100026901");
// define('WS_FHIR_ORG_ID', "0ebe1d69-1175-45ea-b640-644c47bf62dc");
define('WS_FHIR_AUTH_API', "https://api-satusehat.kemkes.go.id/oauth2/v1/");
// define('WS_FHIR_AUTH_API', "https://api-satusehat-stg.dto.kemkes.go.id/oauth2/v1/");
define('WS_FHIR_CUST_ID', "YU2f79TSzzmq3AUIaBnCg3jeJXRWN4auHaponcWeBKVQQxVw"); /*isi dengan client_id*/
// define('WS_FHIR_CUST_ID', "dbtRoSU1Cy4Qdu8Y6C1s94RX7EFbysluQa2x9WQTKi7hgO7r"); /*isi dengan client_id*/
define('WS_FHIR_CUST_KEY', "bMhzQUwSZpGtqOcyP9shT1BRgKDoDINikUbRAjFO5Xr332n97ElrskG7j5Ag1hty"); /*isi dengan client_secret*/
// define('WS_FHIR_CUST_KEY', "FA25bPlW6yb9n8GyeeLM5F83BQVSW7ko3AonWmdtjtGRTCxVES7Gib695UtBqXKH"); /*isi dengan client_secret*/

define('WS_FHIR_API_ID', "https://identity.prod.ihc.id/api/v1");

// function print_arr($arr) {
// 	echo "<h4>data : </h4>";
// 	echo "<pre>";
// 	print_r($arr);
// 	echo "</pre>";
// }

// $consid = "22632";
// $secretKey = "8sF48C3BD3";
//$base_url = "http://dvlp.bpjs-kesehatan.go.id:8888/";
// $base_url_vclaim = "https://new-api.bpjs-kesehatan.go.id:8080/";

// function base_url() {
// 	return "https://api-satusehat-dev.dto.kemkes.go.id/fhir-r4/v1";
// }
// function auth_url() {
// 	return "https://api-satusehat-dev.dto.kemkes.go.id/oauth2/v1";
// }
function generateHeaderFHIR($params = array())
{
	$header_with_token = array('Content-Type' => 'application/json');

	if (defined('WS_FHIR') && WS_FHIR != 'off') {
		if (defined('WS_FHIR_AUTH_API')) {
			$urlWS = WS_FHIR_AUTH_API . 'accesstoken?grant_type=client_credentials';
			$custId = WS_FHIR_CUST_ID;
			$custKey = WS_FHIR_CUST_KEY;
			try {
				$isUp = @get_headers($urlWS, 1);
				if ($isUp) {
					//  Initiate curl
					$ch = curl_init();

					// Attach encoded JSON string to the POST fields
					curl_setopt($ch, CURLOPT_POSTFIELDS, "client_id=$custId&client_secret=$custKey");

					// Set The Response Format to Json
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

					// Disable SSL verification
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

					// Will return the response, if false it print the response
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

					// Set the url
					curl_setopt($ch, CURLOPT_URL, $urlWS);

					// Execute
					$result = curl_exec($ch);

					// Closing
					curl_close($ch);

					if (!empty($result)) {
						$response = json_decode($result);
						$header_with_token['Authorization'] = 'Bearer ' . $response->access_token;
					}
				}
			} catch (Exception $e) {
				// $ret['msg'] = $e->getMessage();
			}
		}
	}
	return $header_with_token;
}
function fhirPost($params, $kategori, $tipe)
{
	$ret = array(
		'status' => 0,
		'msg' => '',
		'data' => array(),
	);

	if (defined('WS_FHIR_API')) {
		$urlWS = WS_FHIR_API . '/' . $kategori;
		try {
			$isUp = @get_headers($urlWS, 1);
			if ($isUp) {
				$header = generateHeaderFHIR();
				$payload = json_encode($params, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
				//  Initiate curl
				$ch = curl_init();

				// Attach encoded JSON string to the POST fields
				curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

				// Set The Response Format to Json
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: ' . $header['Authorization']));

				// Disable SSL verification
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $tipe);
				// Will return the response, if false it print the response
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				// Set the url
				curl_setopt($ch, CURLOPT_URL, $urlWS);

				// Execute
				$result = curl_exec($ch);

				// Closing
				curl_close($ch);
				if (!empty($result)) {
					$ret['status'] = 1;
					$response = json_decode($result);
					$ret['data'] = $response;
				} else {
					$ret['msg'] = 'Tidak dapat response dari server FHIR! (fhir)';
				}
			} else {
				$ret['msg'] = 'Tidak terkoneksi ke service FHIR! (fhir)';
			}
		} catch (Exception $e) {
			$ret['msg'] = $e->getMessage();
		}
	}
	return $ret;
}
function fhirPostID($params, $kategori, $tipe)
{
	$ret = array(
		'status' => 0,
		'msg' => '',
		'data' => array(),
	);

	if (defined('WS_FHIR_API_ID')) {
		$urlWS = WS_FHIR_API_ID . '/' . $kategori;
		$custKey = WS_FHIR_CUST_KEY;
		$custId = WS_FHIR_CUST_ID;

		try {
			$isUp = @get_headers($urlWS, 1);
			if ($isUp) {
				// $header = generateHeaderFHIR();
				$payload = json_encode($params, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
				//  Initiate curl
				$ch = curl_init();

				// Attach encoded JSON string to the POST fields
				curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

				// Set The Response Format to Json
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization:Basic ' . base64_encode($custId.":".$custKey.":")));

				// Disable SSL verification
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $tipe);
				// Will return the response, if false it print the response
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				// Set the url
				curl_setopt($ch, CURLOPT_URL, $urlWS);

				// Execute
				$result = curl_exec($ch);

				// Closing
				curl_close($ch);
				if (!empty($result)) {
					$response = json_decode($result);
					// print_arr($response);
					if(isset($response->payload->id)){
						$ret['msg'] = 'berhasil!!!';
						$ret['data'] = $response;
						$ret['status'] = 1;
					}else{
						$ret['msg'] = 'Tidak berhasil post';
						$ret['status'] = 0;
					}
					
				} else {
					$ret['msg'] = 'Tidak dapat response dari server FHIR! (fhir)';
					$ret['status'] = 0;
				}
				print_r($result);
			} else {
				$ret['msg'] = 'Tidak terkoneksi ke service FHIR! (fhir)';
				$ret['status'] = 0;
			}
		} catch (Exception $e) {
			$ret['msg'] = $e->getMessage();
			$ret['status'] = 0;
		}
	}
	return $ret;
}
function fhirPasienByNIK($params = array())
{
	$ret = array(
		'status' => 0,
		'msg' => '',
		'data' => array(),
	);

	if (defined('WS_FHIR') && WS_FHIR != 'off') {
		if (!empty($params['nik'])) {
			if (defined('WS_FHIR_API')) {
				$urlWS = WS_FHIR_API . "Patient?identifier=https://fhir.kemkes.go.id/id/nik|" . $params['nik'];
				try {
					$isUp = @get_headers($urlWS, 1);
					if ($isUp) {
						$header = generateHeaderFHIR();

						//  Initiate curl
						$ch = curl_init();

						// Set The Response Format to Json
						curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: ' . $header['Authorization']));

						// Disable SSL verification
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

						// Will return the response, if false it print the response
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

						// Set the url
						curl_setopt($ch, CURLOPT_URL, $urlWS);

						// Execute
						$result = curl_exec($ch);

						// Closing
						curl_close($ch);
						if (!empty($result)) {
							$ret['status'] = 1;
							$response = json_decode($result);
							$ret['data'] = $response;
						} else {
							$ret['msg'] = 'Tidak dapat response dari server FHIR! (fhir)';
						}
					} else {
						$ret['msg'] = 'Tidak terkoneksi ke service FHIR! (fhir)';
					}
				} catch (Exception $e) {
					$ret['msg'] = $e->getMessage();
				}
			}
		} else {
			$ret['msg'] = 'parameter NIK kosong';
		}
	} else {
		$ret['status'] = 1;
		$ret['msg'] = 'Fitur WS FHIR disabled!';
	}

	if (!empty($params['output_type']) && $params['output_type'] == 'echo') {
		echo json_encode($ret, JSON_UNESCAPED_SLASHES);
	} else {
		return $ret;
	}
}
function fhirNakesByNIK($params = array())
{
	$ret = array(
		'status' => 0,
		'msg' => '',
		'data' => array(),
	);

	if (defined('WS_FHIR') && WS_FHIR != 'off') {
		if (!empty($params['nik'])) {
			if (defined('WS_FHIR_API')) {
				$urlWS = WS_FHIR_API . "Practitioner?identifier=https://fhir.kemkes.go.id/id/nik|" . $params['nik'];
				try {
					$isUp = @get_headers($urlWS, 1);
					if ($isUp) {
						$header = generateHeaderFHIR();

						//  Initiate curl
						$ch = curl_init();

						// Set The Response Format to Json
						curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: ' . $header['Authorization']));

						// Disable SSL verification
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

						// Will return the response, if false it print the response
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

						// Set the url
						curl_setopt($ch, CURLOPT_URL, $urlWS);

						// Execute
						$result = curl_exec($ch);

						// Closing
						curl_close($ch);
						if (!empty($result)) {
							$ret['status'] = 1;
							$response = json_decode($result);
							$ret['data'] = $response;
						} else {
							$ret['msg'] = 'Tidak dapat response dari server FHIR! (fhir)';
						}
					} else {
						$ret['msg'] = 'Tidak terkoneksi ke service FHIR! (fhir)';
					}
				} catch (Exception $e) {
					$ret['msg'] = $e->getMessage();
				}
			}
		} else {
			$ret['msg'] = 'parameter NIK kosong';
		}
	} else {
		$ret['status'] = 1;
		$ret['msg'] = 'Fitur WS FHIR disabled!';
	}

	if (!empty($params['output_type']) && $params['output_type'] == 'echo') {
		echo json_encode($ret, JSON_UNESCAPED_SLASHES);
	} else {
		return $ret;
	}
}
function fhirBundle($params)
{
	$ret = array(
		'status' => 0,
		'msg' => '',
		'data' => array(),
	);

	if (defined('WS_FHIR_API')) {
		$urlWS = WS_FHIR_API;
		try {
			$isUp = @get_headers($urlWS, 1);
			if ($isUp) {
				$header = generateHeaderFHIR();
				$payload = json_encode($params, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
				//  Initiate curl
				$ch = curl_init();

				// Attach encoded JSON string to the POST fields
				curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

				// Set The Response Format to Json
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: ' . $header['Authorization']));

				// Disable SSL verification
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

				// Will return the response, if false it print the response
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				// Set the url
				curl_setopt($ch, CURLOPT_URL, $urlWS);

				// Execute
				$result = curl_exec($ch);

				// Closing
				curl_close($ch);
				if (!empty($result)) {
					$ret['status'] = 1;
					$response = json_decode($result);
					$ret['data'] = $response;
				} else {
					$ret['msg'] = 'Tidak dapat response dari server FHIR! (fhir)';
				}
			} else {
				$ret['msg'] = 'Tidak terkoneksi ke service FHIR! (fhir)';
			}
		} catch (Exception $e) {
			$ret['msg'] = $e->getMessage();
		}
	}
	return $ret;
}

function create_encounter()
{
	$CI = get_instance();

	$CI->load->library('uuid');
	$CI->load->model('M_Satusehat');

	$id_pelayanan = $CI->input->post('id_pelayanan');
	$id_history = $CI->input->post('id_history');
	$db_erm = $CI->db->get_where('form_assesmen_awal_rajal', ['id_pelayanan' => $id_pelayanan])->row();
	if (!empty($db_erm)) {
		
		$satusehat_encounter = $CI->db->get_where('satusehat_encounter', ['id_pelayanan' => $id_pelayanan])->row();
		if (empty($satusehat_encounter)) {


			$db_pasien = $CI->db->get_where('v_kunjungan', ['id_pelayanan' => $id_pelayanan, 'id_history' => $id_history])->row();
			$db_dokter = $CI->db->get_where('dokter', ['id_dokter' => $db_pasien->dpjp])->row();

			$nik = $db_pasien->no_ktp;
			$nik_nakes = $db_dokter->nik;
			// echo $nik_nakes;

			// echo '<h1>Respon Header</h1>';
			// echo '<pre>';
			// $header = generateHeaderFHIR();
			// print_r($header);
			// echo '</pre>';

			$data = fhirPasienByNIK(array('nik' => $nik));
			$data_nakes = fhirNakesByNIK(array('nik' => $nik_nakes));
			if ($data['status'] == 1 && isset($data['data']->entry[0]->resource->id)) {
				$id_patient = $data['data']->entry[0]->resource->id;
				$name_patient = $data['data']->entry[0]->resource->name[0]->text;
			} else {
				$out['status'] = $data['msg'];
			}
			// print_arr($data);
			// print_arr($data_nakes);
			if ($data_nakes['status'] == 1 && isset( $data_nakes['data']->entry[0]->resource->id)) {
				$id_nakes = $data_nakes['data']->entry[0]->resource->id;
				$name_nakes = $data_nakes['data']->entry[0]->resource->name[0]->text;
			} else {
				$out['status'] = $data_nakes['msg'];
			}

			if (isset($id_patient) && isset($id_nakes)) {
				$tgl_masuk = $db_pasien->tgl_masuk;
				$tgl_keluar = $db_pasien->tgl_keluar;

				// $db_erm = $CI->db->get_where('erm', ['id_pelayanan' => $id_pelayanan])->row();

				$tgl_dilayani = $db_erm->tanggal;

				$poli = $CI->db->get_where('satusehat_suborganisasi', ['id_list_poli' => $db_pasien->nama_poli])->row();

				$id_klinik = $poli->id_satusehat;
				$nama_klinik = $poli->nama;

				$db_diagnosa = $CI->db->get_where('diagnosa_utama', ['id_pelayanan' => $id_pelayanan, 'id_history' => $id_history])->row();

				$kode_diagnosa = $db_diagnosa->kode;
				$diagnosa = $db_diagnosa->nama_diagnosa;

				$uuid = $CI->uuid->v4();
				$uuid_1 = $CI->uuid->v4();

				$array_bundle = [
					"resourceType" => "Bundle",
					"type" => "transaction",
					"entry" => [
						[
							"fullUrl" => "urn:uuid:$uuid",
							"resource" => [
								"resourceType" => "Encounter",
								"status" => "finished",
								"class" => [
									"system" =>
									"http://terminology.hl7.org/CodeSystem/v3-ActCode",
									"code" => "AMB",
									"display" => "ambulatory",
								],
								"subject" => [
									"reference" => "Patient/$id_patient",
									"display" => $name_patient,
								],
								"participant" => [
									[
										"type" => [
											[
												"coding" => [
													[
														"system" =>
														"http://terminology.hl7.org/CodeSystem/v3-ParticipationType",
														"code" => "ATND",
														"display" => "attender",
													],
												],
											],
										],
										"individual" => [
											"reference" => "Practitioner/$id_nakes",
											"display" => $name_nakes,
										],
									],
								],
								"period" => [
									"start" => date('Y-m-d', strtotime($tgl_masuk)) . "T" . date('H:i:s', strtotime($tgl_masuk)) . "+07:00",
									"end" => date('Y-m-d', strtotime($tgl_keluar)) . "T" . date('H:i:s', strtotime($tgl_keluar)) . "+07:00"
								],
								"location" => [
									[
										"location" => [
											"reference" =>
											"Location/$id_klinik",
											"display" => $nama_klinik,
										],
									],
								],
								"statusHistory" => [
									[
										"status" => "arrived",
										"period" => [
											"start" => date('Y-m-d', strtotime($tgl_masuk)) . "T" . date('H:i:s', strtotime($tgl_masuk)) . "+07:00",
											"end" => date('Y-m-d', strtotime($tgl_dilayani)) . "T" . date('H:i:s', strtotime($tgl_dilayani)) . "+07:00"
										],
									],
									[
										"status" => "in-progress",
										"period" => [
											"start" => date('Y-m-d', strtotime($tgl_dilayani)) . "T" . date('H:i:s', strtotime($tgl_dilayani)) . "+07:00",
											"end" => date('Y-m-d', strtotime($tgl_keluar)) . "T" . date('H:i:s', strtotime($tgl_keluar)) . "+07:00"
										],
									],
									[
										"status" => "finished",
										"period" => [
											"start" => date('Y-m-d', strtotime($tgl_keluar)) . "T" . date('H:i:s', strtotime($tgl_keluar)) . "+07:00",
											"end" => date('Y-m-d', strtotime($tgl_keluar)) . "T" . date('H:i:s', strtotime($tgl_keluar)) . "+07:00"
										],
									],
								],
								"serviceProvider" => [
									"reference" =>
									"Organization/" . WS_FHIR_ORG_ID,
								],
								"identifier" => [
									[
										"system" =>
										"http://sys-ids.kemkes.go.id/encounter/" . WS_FHIR_ORG_ID,
										"value" => $id_pelayanan,
									],
								],
								"diagnosis" => [
									[
										"condition" => [
											"reference" =>
											"urn:uuid:$uuid_1",
											"display" => $diagnosa,
										],
										"use" => [
											"coding" => [
												[
													"system" =>
													"http://terminology.hl7.org/CodeSystem/diagnosis-role",
													"code" => 'DD',
													"display" => 'Discharge diagnosis',
												],
											],
										],
										"rank" => 1,
									],
								],
							],
							"request" => ["method" => "POST", "url" => "Encounter"],
						],
						[
							"fullUrl" => "urn:uuid:$uuid_1",
							"resource" => [
								"resourceType" => "Condition",
								"clinicalStatus" => [
									"coding" => [
										[
											"system" =>
											"http://terminology.hl7.org/CodeSystem/condition-clinical",
											"code" => "active",
											"display" => "Active",
										],
									],
								],
								"category" => [
									[
										"coding" => [
											[
												"system" =>
												"http://terminology.hl7.org/CodeSystem/condition-category",
												"code" => "encounter-diagnosis",
												"display" => "Encounter Diagnosis",
											],
										],
									],
								],
								"code" => [
									"coding" => [
										[
											"system" => "http://hl7.org/fhir/sid/icd-10",
											"code" => $kode_diagnosa,
											"display" => $diagnosa,
										],
									],
								],
								"subject" => [
									"reference" => "Patient/$id_patient",
									"display" => $name_patient,
								],
								"encounter" => [
									"reference" =>
									"urn:uuid:$uuid",
									"display" =>
									"Deskripsi bebas : Kunjungan $name_patient pada " . date('Y-m-d', strtotime($tgl_masuk)) . "T" . date('H:i:s', strtotime($tgl_masuk)) . "+07:00",
								],
							],
							"request" => ["method" => "POST", "url" => "Condition"],
						],
					],
				];


				// echo '<h1>JSON Bundle yang dikirim</h1>';
				// echo '<pre>';
				// echo json_encode($array_bundle, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
				// echo '</pre>';

				// echo '<h1>Response pengiriman Bundle</h1>';
				$response_bundle = fhirBundle($array_bundle);
				// echo '<pre>';
				// print_arr($response_bundle);
				// echo '</pre>';
				if ($response_bundle['status'] == 1 && isset($response_bundle['data']->entry[0]->response->resourceID)) {
					$inpud_data = [
						'id_pelayanan' => $id_pelayanan,
						'uuid' => $uuid,
						'id_encounter' => $response_bundle['data']->entry[0]->response->resourceID,
						'uuid_condition' => $uuid_1,
						'id_condition' => $response_bundle['data']->entry[1]->response->resourceID,
					];
					$CI->M_Satusehat->insert_data($inpud_data, 'satusehat_encounter');
					$out['status'] = 'success';
				} else {
					$out['status'] = "Data tidak berhasil disimpan";
				}
			} else {
				$out['status'] = 'Data Nakes dan Data Pasien Tidak Ditemukan';
			}
		}
	} else {
		$out['status'] = 'Asesmen Rawat Jalan Masih Kosong, silahkan diisi terlebih dahulu';
	}
	// print_r($out);

}
