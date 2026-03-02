<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FcmController extends CI_Controller {

    public function index(){
        $this->load->view('token_fcm');
    }

    // Ganti dengan Server Key dari Firebase Console
    private $server_key = '917b4825ad2660cbca1e0de03170d190af357e96';

    public function send_notification()
    {
        $token = $this->input->post('token'); // Token dari device
        $title = $this->input->post('title');
        $body = $this->input->post('body');

        $message = [
            'to' => $token,
            'notification' => [
                'title' => $title,
                'body'  => $body,
                'sound' => 'default'
            ],
            'priority' => 'high'
        ];

        $headers = [
            'Authorization: key=' . $this->server_key,
            'Content-Type: application/json'
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));

        $result = curl_exec($ch);
        curl_close($ch);

        echo $result; // bisa didecode json untuk lihat status
    }
}

?>