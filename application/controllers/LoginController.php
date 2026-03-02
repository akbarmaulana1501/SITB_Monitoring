<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoginController extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('M_tbc');
        $this->load->library('session');
    }
    public function index()
    {
        $this->load->view('login');
    }

    public function login()
    {
        // Ambil data dari form
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // Cek username dan password di database
        $user = $this->M_tbc->check_login($username, $password);

        if ($user) {
            if ($user->status_akun == 1) {
                // Jika akun aktif, buat session
                $session_id = session_id();
                $this->session->set_userdata('session_id', $session_id);
                $this->session->set_userdata('user_id', $user->id);
                $this->session->set_userdata('username', $user->username);
                $this->session->set_userdata('role', $user->role);
                $this->session->set_userdata('nama', $user->nama);
                $this->session->set_userdata('email', $user->email);

                // $akses_menu = $this->M_tbc->get_menu_by_user($user->id); // hasilnya array id_menu
                // $this->session->set_userdata('akses_menu', $akses_menu);

                // Simpan session_id ke database
                $this->M_tbc->update_session($user->id, $session_id);

                $this->M_tbc->log_activity($user->id, 'Login ke sistem');

                // Kirim respon sukses
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Login berhasil',
                    'role' => $user->role
                ]);
            } else {
                // Jika akun nonaktif
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Akun Anda tidak aktif. Silakan hubungi admin.'
                ]);
            }
        } else {
            // Jika user tidak ditemukan atau password salah
            echo json_encode([
                'status' => 'error',
                'message' => 'Username atau password salah.'
            ]);
        }
    }

    public function logout()
    {
        // Ambil session id dari session data
        $session_id = $this->session->userdata('session_id');
        $user_id = $this->session->userdata('user_id');

        if ($session_id && $user_id) {
            // Hapus session id dari database
            $this->M_tbc->clear_session($user_id);

            // Hapus session
            $this->session->unset_userdata('session_id');
            $this->session->unset_userdata('user_id');
            $this->session->sess_destroy();

            echo json_encode(['status' => 'success', 'message' => 'Logout berhasil']);
            redirect('LoginController');
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Anda tidak login']);
        }
    }

    public function update_password()
    {
        $password = $this->input->post('pass_baru');
        $nama = $this->input->post('nama');
        $email = $this->input->post('email');

        $data = array(
            'password' => $password,
            'email' => $email
        );

        $result = $this->M_tbc->update_pass($data, $nama);

        if ($result) {
            $user_id = $this->session->userdata('user_id');
            $this->M_tbc->log_activity($user_id, 'Mengubah password untuk akun: ' . $nama);

            $response = array('status' => 'success', 'message' => 'Password berhasil diupdate!');
        } else {
            $response = array('status' => 'error', 'message' => 'Gagal memperbarui Password!');
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function reset_password()
    {
        header('Content-Type: application/json');

        $username = $this->input->post('username');
        $target = $this->input->post('no_hp');

        $pesan = $this->M_tbc->reset_password($username);

        $curl = curl_init();

        $token = "NXA2LKAMfwhw7F9afon7";
        // $target = "083809808665";
        // $target = $this->input->post('no_hp');
        // $pesan = $this->input->post('pesan');

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
                'message' => 'Password anda adalah ' . $pesan->password,
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
            echo json_encode([
                'success' => false,
                'message' => $error_msg
            ]);
        } else {
            if ($httpCode == 200) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Pesan berhasil dikirim!',
                    'api_response' => $response
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Gagal kirim pesan!',
                    'api_response' => $response
                ]);
            }
        }
    }
}
