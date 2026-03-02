<?php
define('WS_USAID', 'on');
define('WS_ALTERNATE', 'on');
define('WS_SITB_API', "https://identity.prod.ihc.id/api/v1");
define('WS_SITB_ORG_ID', "1971043");
define('WS_USAID_AUTH_API', "https://usaid.ihc.id/api/users/token");
define('WS_USAID_POST', "https://usaid.ihc.id/api/v2/transaction");
define('WS_USAID_ALTERNATE_POST', "http://localhost:3000");
define('WS_USAID_ALTERNATE', 'http://localhost:3000/login');
define('WS_SITB_CUST_ID', "YU2f79TSzzmq3AUIaBnCg3jeJXRWN4auHaponcWeBKVQQxVw"); /*isi dengan client_id*/
define('WS_SITB_CUST_KEY', "bMhzQUwSZpGtqOcyP9shT1BRgKDoDINikUbRAjFO5Xr332n97ElrskG7j5Ag1hty"); /*isi dengan client_secret*/


function usaidPost($data, $kategori, $tipe)
{
    // Tambahkan data baru ke dalam array $params
    // $params['grant_type'] = 'client_credentials';

    $ret = array(
        'status' => 0,
        'msg' => '',
        'data' => array(),
    );
    // $email = "YU2f79TSzzmq3AUIaBnCg3jeJXRWN4auHaponcWeBKVQQxVw";
    // $pass = "bMhzQUwSZpGtqOcyP9shT1BRgKDoDINikUbRAjFO5Xr332n97ElrskG7j5Ag1hty";
    // $data = array(
    //     'email' => $email,
    //     'password' => $pass,
    // );


    if (defined('WS_USAID_AUTH_API')) {
        $urlWS = WS_USAID_AUTH_API . '/' . $kategori;
        try {
            $isUp = @get_headers($urlWS, 1);
            if ($isUp) {
                // $header = generateHeaderSITB();
                // $payload = $data;
                //  Initiate curl
                $ch = curl_init();

                // Attach encoded JSON string to the POST fields
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                // Set The Response Format to Json
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

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

// function generateTokenUsaid($params = array())
// {
//     $header_with_token = array('Content-Type' => 'application/json');

//     if (defined('WS_USAID') && WS_USAID != 'off') {
//         if (defined('WS_USAID_AUTH_API')) {
//             $urlWS = WS_USAID_AUTH_API;
//             $email = "akilnmuharram@gmail.com";
//             $pass = "p1np1np1n";
//             $data = array(
//                 'email' => $email,
//                 'password' => $pass,
//             );
//             try {
//                 $isUp = @get_headers($urlWS, 1);
//                 if ($isUp) {
//                     //  Initiate curl
//                     $ch = curl_init();

//                     // Attach encoded JSON string to the POST fields
//                     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

//                     // Set The Response Format to Json
//                     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

//                     // Disable SSL verification
//                     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

//                     // Will return the response, if false it print the response
//                     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//                     // Set the url
//                     curl_setopt($ch, CURLOPT_URL, $urlWS);

//                     // Execute
//                     $result = curl_exec($ch);

//                     // Closing
//                     curl_close($ch);

//                     if (!empty($result)) {
//                         $response = json_decode($result);
//                         echo 'response' . $result;
//                         // print_r($response);
//                         if (isset($response->access)) {
//                             // Jika token dihasilkan, tambahkan ke header
//                             $header_with_token['Authorization'] =  $response->access;
//                         }
//                     }
//                 }
//             } catch (Exception $e) {
//                 // $ret['msg'] = $e->getMessage();
//             }
//         }
//     }
//     return $header_with_token;
// }

function generateTokenUsaid($params = array())
{
    $header_with_token = array('Content-Type' => 'application/json');

    if (defined('WS_ALTERNATE') && WS_ALTERNATE != 'off') {
        if (defined('WS_USAID_ALTERNATE')) {
            $urlWS = WS_USAID_ALTERNATE;
            $email = "akilnmuharram@gmail.com";
            $pass = "p1np1np1n";
            $data = array(
                'email' => $email,
                'password' => $pass,
            );
            try {
                $isUp = @get_headers($urlWS, 1);
                if ($isUp) {
                    //  Initiate curl
                    $ch = curl_init();

                    // Attach encoded JSON string to the POST fields
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                    // Set The Response Format to Json
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

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
                        echo 'response' . $result;
                        // print_r($response);
                        if (isset($response->token)) {
                            // Jika token dihasilkan, tambahkan ke header
                            $header_with_token['Authorization'] =  $response->token;
                        }
                    }
                }
            } catch (Exception $e) {
                // $ret['msg'] = $e->getMessage();
            }
        }
    }
    return $header_with_token;
}

// function usaidPostData($params, $kategori, $tipe)
// {
//     $ret = array(
//         'status' => 0,
//         'msg' => '',
//         'data' => array(),
//     );

//     if (defined('WS_USAID_POST')) {
//         $urlWS = WS_USAID_POST . '/' . $kategori;
//         try {
//             $isUp = @get_headers($urlWS, 1);
//             if ($isUp) {
//                 $header = generateTokenUsaid();
//                 $payload = json_encode($params, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
//                 //  Initiate curl
//                 $ch = curl_init();

//                 // Attach encoded JSON string to the POST fields
//                 curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

//                 // Set The Response Format to Json
//                 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization:Bearer ' . $header['Authorization']));

//                 // Disable SSL verification
//                 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

//                 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $tipe);
//                 // Will return the response, if false it print the response
//                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//                 // Set the url
//                 curl_setopt($ch, CURLOPT_URL, $urlWS);

//                 // Execute
//                 $result = curl_exec($ch);

//                 // Closing
//                 curl_close($ch);
//                 if (!empty($result)) {
//                     $ret['status'] = 1;
//                     $response = json_decode($result);
//                     $ret['data'] = $response;
//                 } else {
//                     $ret['msg'] = 'Tidak dapat response dari server FHIR! (fhir)';
//                 }
//             } else {
//                 $ret['msg'] = 'Tidak terkoneksi ke service FHIR! (fhir)';
//             }
//         } catch (Exception $e) {
//             $ret['msg'] = $e->getMessage();
//         }
//     }
//     return $ret;
// }


function usaidPostData($params, $kategori, $tipe)
{
    $ret = array(
        'status' => 0,
        'msg' => '',
        'data' => array(),
    );

    if (defined('WS_USAID_ALTERNATE_POST')) {
        $urlWS = WS_USAID_ALTERNATE_POST . '/' . $kategori;
        try {
            $isUp = @get_headers($urlWS, 1);
            if ($isUp) {
                $header = generateTokenUsaid();
                $payload = json_encode($params, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                //  Initiate curl
                $ch = curl_init();

                // Attach encoded JSON string to the POST fields
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

                if (!isset($header['Authorization'])) {
                    $ret['msg'] = 'Gagal mendapatkan token Authorization dari generateTokenUsaid()';
                    return $ret;
                }
                // Set The Response Format to Json
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization:Bearer ' . $header['Authorization']));

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

// function usaidPostData($params, $kategori, $tipe)
// {
//     $ret = array(
//         'status' => 0,
//         'msg' => '',
//         'data' => array(),
//     );

//     if (defined('WS_USAID_ALTERNATE')) {
//         $urlWS = WS_USAID_ALTERNATE . '/' . $kategori;
//         try {
//             $isUp = @get_headers($urlWS, 1);
//             if ($isUp) {
//                 $header = generateTokenUsaid();
//                 $payload = json_encode($params, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
//                 //  Initiate curl
//                 $ch = curl_init();

//                 // Attach encoded JSON string to the POST fields
//                 curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

//                 // Set The Response Format to Json
//                 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization:Bearer ' . $header['Authorization']));

//                 // Disable SSL verification
//                 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

//                 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $tipe);
//                 // Will return the response, if false it print the response
//                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//                 // Set the url
//                 curl_setopt($ch, CURLOPT_URL, $urlWS);

//                 // Execute
//                 $result = curl_exec($ch);

//                 // Closing
//                 curl_close($ch);
//                 if (!empty($result)) {
//                     $ret['status'] = 1;
//                     $response = json_decode($result);
//                     $ret['data'] = $response;
//                 } else {
//                     $ret['msg'] = 'Tidak dapat response dari server FHIR! (fhir)';
//                 }
//             } else {
//                 $ret['msg'] = 'Tidak terkoneksi ke service FHIR! (fhir)';
//             }
//         } catch (Exception $e) {
//             $ret['msg'] = $e->getMessage();
//         }
//     }
//     return $ret;
// }

// function bhceGet($kategori, $tipe, $offset = 0, $limit = 10)
// {
//     $ret = array(
//         'status' => 0,
//         'msg' => '',
//         'data' => array(),
//     );

//     if (defined('WS_BHCE_API')) {
//         // Menggunakan URL dengan parameter offset dan limit
//         $urlWS = WS_BHCE_API . '/' . $kategori . '?offset=' . $offset . '&limit=' . $limit;
//         try {
//             $isUp = @get_headers($urlWS, 1);
//             if ($isUp) {
//                 $header = generateHeaderBHCE();

//                 // Initialize curl
//                 $ch = curl_init();

//                 // Set options for the GET request
//                 curl_setopt($ch, CURLOPT_HTTPHEADER, array('x-access-token: ' . $header['Authorization']));
//                 curl_setopt($ch, CURLOPT_URL, $urlWS);
//                 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $tipe);
//                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//                 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

//                 // Execute the GET request
//                 $result = curl_exec($ch);

//                 // Check for errors and handle response
//                 if (!empty($result)) {
//                     $ret['status'] = 1;
//                     $response = json_decode($result);
//                     $ret['data'] = $response;
//                 } else {
//                     $ret['msg'] = 'Tidak dapat response dari server FHIR! (fhir)';
//                 }
//                 //print_r($ret['data']);

//                 // Close curl
//                 curl_close($ch);
//             } else {
//                 $ret['msg'] = 'Tidak terkoneksi ke service FHIR! (fhir)';
//             }
//         } catch (Exception $e) {
//             $ret['msg'] = $e->getMessage();
//         }
//     }

//     return $ret;
// }
