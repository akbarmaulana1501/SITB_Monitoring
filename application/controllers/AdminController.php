<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_tbc');
        $this->load->library('session');
        $this->load->driver('cache');

        // Cek apakah user sudah login
        $this->check_login();
    }

    public function index()
    {
        $data['jumlah_kasus'] = $this->M_tbc->jumlah_kasus_tb_semua_poli();
        $data['jumlah_terdiagnosa'] = $this->M_tbc->jumlah_kasus_terdiagnosa_tbc();
        $data['jumlah_sembuh'] = $this->M_tbc->get_data_finish();
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
        $this->load->view('admin/Admin_dash', $data);
    }


    public function dashboard()
    {
        $data = $this->cache->file->get('dashboard_data');

        if (!$data) {
            // Jika tidak ada di cache, ambil dari database
            // $data['jumlah_kasus'] = $this->M_tbc->jumlah_kasus_tb_semua_poli();
            // $data['jumlah_terdiagnosa'] = $this->M_tbc->jumlah_kasus_terdiagnosa_tbc();
            // $data['jumlah_sembuh'] = $this->M_tbc->get_data_finish();
            $data['pasien_active'] = $this->M_tbc->get_pasien_active();
            $data['pasien_selesai'] = $this->M_tbc->get_pasien_selesai();
            $data['pasien_berhenti'] = $this->M_tbc->get_pasien_berhenti_pengobatan();
            $data['distribusi_usia'] = $this->M_tbc->get_data_umur_pasien();
            $data['resistensi'] = $this->M_tbc->get_data_resistensi();
            $data['recent_activity'] = $this->M_tbc->get_recent_activity();
            $data['gender'] = $this->M_tbc->get_data_gender();
            $data['poli_anak'] = $this->M_tbc->kasus_poli_anak();
            $data['poli_paru'] = $this->M_tbc->kasus_poli_paru();
            $data['poli_dalam'] = $this->M_tbc->kasus_poli_dalam();
            $data['poli_umum'] = $this->M_tbc->kasus_poli_umum();
            $data['poli_obgyne'] = $this->M_tbc->kasus_poli_obgyn();

            // Simpan ke cache selama 5 menit (300 detik)
            $this->cache->file->save('dashboard_data', $data, 10);
        }
        $this->load->view('admin/Admin_dash', $data);
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

    public function non_aktif_akun()
    {
        $id = $this->input->post('id');
        $success = $this->M_tbc->update_status_akun($id, 0);

        if ($success) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database gagal update.']);
        }
    }

    public function aktifkan_akun()
    {
        $id = $this->input->post('id');
        $success = $this->M_tbc->update_status_akun($id, 1);

        if ($success) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database gagal update.']);
        }
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

    public function jumlah_kasus()
    {
        $data['jumlah_kasus'] = $this->M_tbc->jumlah_kasus_tb_semua_poli();
        $this->load->view('admin/Admin_dash');
        // echo($data);
    }


    public function kelola_user()
    {
        $data['user'] = $this->M_tbc->get_all_user();
        $this->load->view('admin/kelola_user/kelola_user', $data);
    }

    public function tambah_akun()
    {
        $this->load->view('admin/kelola_user/tambah_user');
    }

    public function simpan_user()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $nama = $this->input->post('nama');
        $role     = $this->input->post('role');

        // Validasi simple
        if (empty($username) || empty($password) || empty($role) || empty($email) || empty($nama)) {
            echo json_encode(['status' => 'error', 'message' => 'Semua field harus diisi.']);
            return;
        }

        // Simpan ke database (contoh)
        $data = [
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'nama' => $nama,
            'role'     => $role,
            'status_akun'   => 1 // default aktif
        ];

        $simpan = $this->db->insert('user_sitb', $data);

        if ($simpan) {
            echo json_encode(['status' => 'success', 'message' => 'User berhasil disimpan.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan user.']);
        }
    }
}
