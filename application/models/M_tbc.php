<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_tbc extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        setlocale(LC_ALL, 'id_ID');
    }

    // public function get_pasien($no_rm)
    // {
    //     $this->db->select('nama, no_ktp, jenis_kelamin, tgl_lahir, provinsi, alamat');
    //     $this->db->from('pasien');
    //     $this->db->where('no_rm', $no_rm);
    //     $result = $this->db->get()->row();

    //     // Memeriksa apakah ada data yang ditemukan
    //     if (!empty($result)) {
    //         // Mengembalikan data pasien jika ditemukan
    //         return $result;
    //     } else {
    //         // Mengembalikan null jika tidak ada data yang ditemukan
    //         return null;
    //     }
    // }

    public function log_activity($user_id, $activity)
    {
        $data = [
            'user_id' => $user_id,
            'activity' => $activity,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('user_activity_log', $data);
    }

    public function get_recent_activity($limit = 5)
    {
        $this->db->select('user_activity_log.*, user_sitb.username');
        $this->db->from('user_activity_log');
        $this->db->join('user_sitb', 'user_sitb.id = user_activity_log.user_id');
        $this->db->order_by('user_activity_log.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    public function get_kode_icd($id_pelayanan)
    {
        $this->db->select("pasien_tbc");
        $this->db->from("pasien_TBC");
        $this->db->where("id_pelayanan", $id_pelayanan);
        return $this->db->get()->row();
    }

    public function get_all_user()
    {
        $this->db->select('*');
        $this->db->from('user_sitb');
        $this->db->where('username !=', 'edp');
        return $this->db->get()->result();
    }

    public function update_status_akun($id, $status)
    {
        $this->db->where('id', $id);
        return $this->db->update('user_sitb', ['status_akun' => $status]);
    }


    public function Labor_PrintById_Rajal($id_tindakan_labor)
    {
        $this->db->select('t.*, l.nama, pa.nama pasien, pa.jenis_kelamin, p.id_pasien, r.nama cara_bayar');
        $this->db->from('tindakan_labor t, list_tindakan_labor l, pelayanan p, pasien pa, cara_bayar r');
        $this->db->where('t.id_list_tindakan=l.id_daftar_tindakan');
        $this->db->where('pa.no_rm=p.id_pasien');
        $this->db->where('p.id_pelayanan=t.id_pelayanan');
        $this->db->where('p.cara_bayar=r.id_cara_bayar');
        $this->db->where('t.id_tindakan_labor', $id_tindakan_labor);
        $this->db->order_by('t.tanggal', 'desc');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_Pasien($id_pelayanan)
    {
        $this->db->select('p.id_pelayanan,p.id_pasien,pa.*,hp.nama_poli,ss.id_satusehat');
        $this->db->from('pelayanan p,history_pelayanan hp,satusehat_suborganisasi ss,pasien pa');
        $this->db->where('p.id_pelayanan=hp.id_pelayanan');
        $this->db->where('hp.nama_poli=ss.id_list_poli');
        $this->db->where('p.id_pasien=pa.no_rm');
        $this->db->where('p.id_pelayanan', $id_pelayanan);
        $query = $this->db->get();
        return $query->row();
    }

    public function classifications($no_rm)
    {
        $this->db->select("k.tgl_masuk,k.tgl_keluar,fa.tanggal");
        $this->db->from("v_kunjungan k,form_ass_per_igd fa");
        $this->db->where("k.no_rm = fa.no_rm");
        $this->db->where("k.no_rm", $no_rm);
        return $this->db->get()->row();
    }

    public function classifications2($id_pelayanan)
    {
        $this->db->select("jenis_pelayanan");
        $this->db->from("v_kunjungan");
        $this->db->where("id_pelayanan", $id_pelayanan);
        return $this->db->get()->row();
    }
    public function kfa_code($id_pelayanan)
    {
        $this->db->select("lg.*");
        $this->db->from("pelayanan p,tindakan_farmasi tf,list_logistik lg");
        $this->db->where('p.id_pelayanan = tf.id_pelayanan');
        $this->db->where('tf.id_list_tindakan = lg.id_logistik');
        $this->db->where("p.id_pelayanan", $id_pelayanan);
        return $this->db->get()->row();
    }

    public function insert_data($data, $table)
    {
        $insert = $this->db->insert($table, $data);

        if ($insert) {
            return true;
        } else {
            return false;
        }
    }

    public function insert_data_duplicate($data, $table)
    {
        // Example of checking for duplication by a unique field (e.g., 'nik' field)
        $this->db->where('practitioner_nik', $data['practitioner_nik']);  // Assuming 'nik' is the unique field in your table
        $query = $this->db->get($table);

        if ($query->num_rows() > 0) {
            // If a record with the same 'nik' exists, return false with a duplicate error message
            return array('status' => false, 'message' => 'Duplicate entry found');
        } else {
            // Otherwise, insert the data
            $insert = $this->db->insert($table, $data);

            if ($insert) {
                return array('status' => true, 'message' => 'Data inserted successfully');
            } else {
                return array('status' => false, 'message' => 'Failed to insert data');
            }
        }
    }


    public function cek_data($id_pelayanan)
    {
        $this->db->select('*');
        $this->db->from('ihs_encounter');
        $query = $this->db->where('id_pelayanan', $id_pelayanan);
        if ($query) {
            return $this->db->get()->row();
        } else {
            return false;
        }
    }

    public function cat_log()
    {
        $this->db->select('ihs_id,id_tb,status');
        $this->db->from('ihs_encounter');  // Assuming 'ihs_encounter' is your table name
        $query = $this->db->get();

        return $query->result_array();
    }

    // public function get_data_terkirim()
    // {
    //     $this->db->select('tb.*,ih.status');
    //     $this->db->from('tb_data tb,ihs_encounter ih');
    //     $this->db->where('tb.episode_of_care_id_tb_03 = ih.id_tb');
    //     $this->db->where('ih.status', 'success');
    //     return $this->db->get()->result();
    // }

    // public function get_data_terkirim()
    // {
    //     $this->db->select('*');
    //     $this->db->from('tb_data');
    //     return $this->db->get()->result();
    // }

    public function get_data_terkirim()
    {
        // Membuat query untuk UNION dengan ORDER BY
        $query = "
        SELECT * FROM (
            SELECT * FROM tb_data
            UNION
            SELECT * FROM tb_data_schedule
        ) AS combined_data
        GROUP BY patient_name
        ORDER BY encounter_period_start DESC
        ";
        // Jalankan query
        return $this->db->query($query)->result();
    }


    // public function cek_data_labor(){
    //     $this->db->select('*');
    //     $this->db->from('tb_observ_labor');
    //     return $this->db->get()->result();
    // }


    // public function get_pasien_by_id($id)
    // {
    //     $this->db->select('*');
    //     $this->db->from('tb_data');
    //     $this->db->where('encounter_local_id', $id);
    //     return $this->db->get()->row();
    // }


    public function get_pasien_by_id($id)
    {
        // Membuat query untuk UNION
        $query = "
        (SELECT * FROM tb_data WHERE encounter_local_id = ?)
        UNION
        (SELECT * FROM tb_data_schedule WHERE encounter_local_id = ?)
    ";

        // Mengganti tanda tanya dengan variabel $id
        return $this->db->query($query, array($id, $id))->row();
    }

    public function update_pass($data, $username)
    {
        $this->db->where('username', $username);
        return $this->db->update('user_sitb', $data);
    }





    // public function update_pasien($local_id, $data)
    // {
    //     $this->db->where('encounter_local_id', $local_id);
    //     $this->db->update('tb_data', $data); // 'pasien' adalah nama tabel
    //     if ($this->db->affected_rows() > 0) {
    //         // Jika ada baris yang terpengaruh, update berhasil
    //         return true;
    //     } else {
    //         // Jika tidak ada perubahan, atau gagal
    //         return false;
    //     }
    // }

    public function update_pasien($local_id, $data)
    {
        // Update tb_data
        $this->db->where('encounter_local_id', $local_id);
        $this->db->update('tb_data', $data);
        $affected_rows_tb_data = $this->db->affected_rows();

        // Update tb_data_schedule
        $this->db->where('encounter_local_id', $local_id);
        $this->db->update('tb_data_schedule', $data);
        $affected_rows_tb_data_schedule = $this->db->affected_rows();

        // Jika salah satu tabel ter-update, anggap berhasil
        if ($affected_rows_tb_data > 0 || $affected_rows_tb_data_schedule > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function update_observation($local_id, $observation_data)
    {
        // Lakukan pengecekan atau update data observasi
        $this->db->where('local_id', $local_id);
        $this->db->update('tb_observ_labor', $observation_data);
        return $this->db->affected_rows(); // Update data observasi
    }

    public function get_all_data($nama)
    {
        $this->db->select('tb.*,ih.id_pelayanan');
        $this->db->from('tb_data tb,ihs_encounter ih');
        $this->db->where('tb.episode_of_care_id_tb_03 = ih.id_tb');
        $this->db->where('tb.patient_name', $nama);
        return $this->db->get()->row();
    }

    public function get_all_data2($id)
    {
        // Membuat query untuk UNION dengan pengecekan nama
        $query = "
        (SELECT * FROM tb_data WHERE encounter_local_id = " . $this->db->escape($id) . ")
        UNION
        (SELECT * FROM tb_data_schedule WHERE encounter_local_id = " . $this->db->escape($id) . ")
        ";

        // Jalankan query
        return $this->db->query($query)->row();
    }

    // public function get_all_data2($id)
    // {
    //     $this->db->select('*');
    //     $this->db->from('tb_data_schedule');
    //     $this->db->where('encounter_local_id', $id);
    //     return $this->db->get()->row();
    // }

    public function get_all_data_by_id($id)
    {
        // Membuat query untuk UNION dengan pengecekan nama
        $query = "
         (SELECT * FROM tb_data WHERE encounter_local_id = " . $this->db->escape($id) . ")
         UNION
         (SELECT * FROM tb_data_schedule WHERE encounter_local_id = " . $this->db->escape($id) . ")
     ";

        // Jalankan query
        return $this->db->query($query)->result();
    }


    public function get_data_gagal()
    {
        $query = "
        SELECT tb.*, ih.status, ih.tanggal
        FROM tb_data_schedule tb
        JOIN ihs_encounter ih ON tb.episode_of_care_id_tb_03 = ih.id_tb
        WHERE ih.status IN ('success', 'error')

        UNION

        SELECT tb.*, ih.status, ih.tanggal
        FROM tb_data tb
        JOIN ihs_encounter ih ON tb.episode_of_care_id_tb_03 = ih.id_tb
        WHERE ih.status IN ('success', 'error')
    ";

        return $this->db->query($query)->result();
    }

    public function get_form($id_pelayanan)
    {
        $this->db->select('id_form_labor');
        $this->db->from('tindakan_labor');
        $this->db->where("CONVERT(id_pelayanan USING utf8mb4) = CONVERT('$id_pelayanan' USING utf8mb4)", null, false);
        $this->db->where_in('kode_lis', ['BTA1', 'BTAS3X']);
        return $this->db->get()->row();
    }

    public function get_labor($id_pelayanan)
    {
        $this->db->select('*');
        $this->db->from('tb_observ_labor');
        $this->db->where('id_pelayanan', $id_pelayanan);
        $this->db->where_in('type_observation', ['microscopic', 'MIKROBIOLOGI', 'tcm', 'culture-treatment']);
        return $this->db->get()->result();
    }

    public function get_info_labor($id_pelayanan)
    {
        $this->db->select('*');
        $this->db->from('tb_observ_labor');
        $this->db->where('id_pelayanan', $id_pelayanan);
        $this->db->where_in('type_observation', ['microscopic', 'MIKROBIOLOGI', 'tcm', 'culture-treatment']);
        return $this->db->get()->result();
    }


    public function get_data_labor()
    {
        $this->db->select('*');
        $this->db->from('tb_observ_labor');
        return $this->db->get()->result();
    }

    public function get_labor_all($id_pelayanan)
    {
        $this->db->select('*');
        $this->db->from('tb_observ_labor');
        $this->db->where('id_pelayanan', $id_pelayanan);
        return $this->db->get()->result_array();
    }

    public function check_login($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->where('password', $password); // Password harus di-hash (disarankan)
        $query = $this->db->get('user_sitb');

        if ($query->num_rows() == 1) {
            return $query->row(); // Return user data jika ditemukan
        } else {
            return false;
        }
    }

    public function reset_password($username)
    {
        $this->db->select('password');
        $this->db->from('user_sitb');
        $this->db->where('username', $username);
        return $this->db->get()->row();
    }

    public function get_menu_by_user($id_user)
    {
        $this->db->select('menu_id');
        $this->db->from('akses_kontrol');
        $this->db->where('user_id', $id_user);
        $query = $this->db->get();

        $result = $query->result_array();
        return array_column($result, 'menu_id'); // Mengembalikan array seperti [1, 2, 3]
    }


    public function get_all_menus()
    {
        return $this->db->get('menu_sitb')->result_array();
    }

    public function get_update_akses()
    {
        $this->db->select('ak.user_id as user_id, ak.menu_id as menu_id,ak.status_menu, user_sitb.username, menu_sitb.nama_menu');
        $this->db->from('akses_kontrol ak');
        $this->db->join('user_sitb', 'user_sitb.id = ak.user_id');
        $this->db->join('menu_sitb', 'menu_sitb.id_menu = ak.menu_id');
        return $this->db->get()->result_array();
    }

    // Ambil semua data akses
    public function get_all_akses()
    {
        return $this->db->get('akses_kontrol')->result_array(); // sesuaikan nama tabel
    }

    // Hapus satu per satu akses
    public function update($where, $data)
    {
        $this->db->where($where);
        return $this->db->update('akses_kontrol', $data);
    }

    public function get_all_roles()
    {
        $this->db->select('*');
        $this->db->where('username !=', 'edp');
        return $this->db->get('user_sitb')->result(); // ambil dari tabel user
    }

    public function tambah($data)
    {
        $this->db->insert('akses_kontrol', $data);
    }

    public function update_session($user_id, $session_id)
    {
        $data = array(
            'session_id' => $session_id
        );
        $this->db->where('id', $user_id);
        return $this->db->update('user_sitb', $data);
    }

    public function clear_session($user_id)
    {
        $data = array(
            'session_id' => NULL
        );
        $this->db->where('id', $user_id);
        return $this->db->update('user_sitb', $data);
    }


    public function input_data_lab($data, $table)
    {
        $insert = $this->db->insert($table, $data);

        if ($insert) {
            return true;
        } else {
            return false;
        }
    }

    public function update_data_lab($local_id, $data_labor)
    {
        $this->db->where('local_id', $local_id);
        $this->db->update('tb_observ_labor', $data_labor);
        return $this->db->affected_rows(); // Mengembalikan jumlah baris yang terpengaruh
    }


    public function get_labor_by_local_id($local_id)
    {
        $this->db->where('id_pelayanan', $local_id);
        $query = $this->db->get('tb_observ_labor');
        return $query->row(); // Mengembalikan data jika ada, atau null jika tidak ada
    }

    public function get_observation_by_local_id($local_id)
    {
        // Sanitize the local_id to prevent SQL injection
        $local_id = intval($local_id);

        // Query the database to find the observation
        $this->db->where('local_id', $local_id);
        $query = $this->db->get('tb_observ_labor'); // Replace with your actual table name

        // Check if any record found
        if ($query->num_rows() > 0) {
            return $query->row_array(); // Return the first row as an associative array
        }

        return null; // Return null if no observation is found
    }

    public function get_diagnosa($query)
    {
        $this->db->select('id_diagnosa, nama_diagnosa'); // Pilih kolom yang diperlukan
        $this->db->like('id_diagnosa', $query); // Mencari berdasarkan kode
        $this->db->or_like('nama_diagnosa', $query); // Mencari berdasarkan nama_diagnosa (opsional)
        $this->db->limit(10); // Batasi hasil
        $result = $this->db->get('list_diagnosa'); // Ganti 'nama_tabel' dengan tabel yang sesuai

        return $result->result(); // Mengembalikan hasil sebagai array
    }

    public function update_data_pemeriksaan($data)
    {
        // Gunakan batch insert untuk menyimpan beberapa data sekaligus
        $this->db->insert_batch('tb_observ_labor', $data);

        // Cek apakah query berhasil dijalankan
        if ($this->db->affected_rows() > 0) {
            return true; // Data berhasil disimpan
        } else {
            return false; // Gagal menyimpan data
        }
    }

    public function get_diagnosa_by_id($id_diagnosa)
    {
        $this->db->select('nama_diagnosa');
        $this->db->from('list_diagnosa');
        $this->db->where('id_diagnosa', $id_diagnosa);

        return $this->db->get()->row();
    }

    public function get_labor_data($id)
    {
        $this->db->select('*');
        $this->db->from('tb_observ_labor');
        $this->db->where('local_id', $id);
        return $this->db->get()->row();
    }

    public function update_data_labor($id, $data)
    {
        // Update the record in the database
        $this->db->where('local_id', $id); // Ensure this is the correct column name for your unique identifier
        $this->db->update('tb_observ_labor', $data); // Replace 'your_table_name' with your actual table name

        // Check if the update was successful
        if ($this->db->affected_rows() > 0) {
            return true; // Return true if the update was successful
        } else {
            return false; // Return false if no rows were affected (update failed)
        }
    }


    public function hapus_pemeriksaan($local_id)
    {
        $this->db->where('local_id', $local_id);
        return $this->db->delete('tb_observ_labor');  // Gantilah 'nama_tabel' dengan nama tabel Anda
    }

    public function get_obat($id_pelayanan)
    {
        $this->db->select('*');
        $this->db->from('tb_medication');
        $this->db->where('id_pelayanan', $id_pelayanan);
        return $this->db->get()->result();
    }

    public function get_info_obat($id_pelayanan)
    {
        $this->db->select('*');
        $this->db->from('tb_medication');
        $this->db->where('id_pelayanan', $id_pelayanan);
        return $this->db->get()->result();
    }

    public function oat($id_pelayanan)
    {
        $this->db->select('*');
        $this->db->from('tb_medication');
        $this->db->where('id_pelayanan', $id_pelayanan);
        return $this->db->get()->result();
    }

    public function get_id_pelayanan()
    {
        $this->db->select('encounter_local_id');
        $this->db->from('tb_data_schedule');
        $this->db->where('status_kirim', '0');
        // $this->db->order_by('encounter_period_start', 'ASC');
        // $this->db->limit(2);
        return $this->db->get()->result();
    }

    public function get_diag_dokter($query)
    {
        $this->db->select('id_diagnosa, nama_diagnosa'); // Pilih kolom yang diperlukan
        $this->db->like('id_diagnosa', $query); // Mencari berdasarkan kode
        $this->db->or_like('nama_diagnosa', $query); // Mencari berdasarkan nama_diagnosa (opsional)
        $this->db->limit(10); // Batasi hasil
        $result = $this->db->get('list_diagnosa'); // Ganti 'nama_tabel' dengan tabel yang sesuai

        return $result->result(); // Mengembalikan hasil sebagai array
    }

    public function get_data_schedule()
    {
        $this->db->select('tb.*,ih.status,ih.tanggal');
        $this->db->from('tb_data_schedule tb,ihs_encounter_2 ih');
        $this->db->where('tb.episode_of_care_id_tb_03 = ih.id_tb');
        $this->db->where_in('ih.status', ['success', 'error']);
        return $this->db->get()->result();
    }

    public function get_tables($id)
    {
        // Cek apakah encounter_local_id ada di tb_data
        $this->db->select('encounter_local_id');
        $this->db->from('tb_data');
        $this->db->where('encounter_local_id', $id);
        $query_tb_data = $this->db->get();

        if ($query_tb_data->num_rows() > 0) {
            return true; // Ditemukan di tb_data
        }

        // Jika tidak ditemukan di tb_data, cek di tb_data_schedule
        $this->db->select('encounter_local_id');
        $this->db->from('tb_data_schedule');
        $this->db->where('encounter_local_id', $id);
        $query_tb_data_schedule = $this->db->get();

        if ($query_tb_data_schedule->num_rows() > 0) {
            return false; // Ditemukan di tb_data_schedule
        }

        return null; // Tidak ditemukan di kedua tabel
    }

    public function get_data_pasien_tbc()
    {
        $this->db->select('*');
        $this->db->from('tb_data_schedule');
        return $this->db->get()->result();
    }

    // public function get_data_laporan_pasien()
    // {
    //     $query = "
    //     SELECT * FROM (
    //         SELECT * FROM tb_data 
    //         WHERE status_kirim = 1 OR episode_of_care_status = 'finished'
    //         UNION
    //         SELECT * FROM tb_data_schedule 
    //         WHERE status_kirim = 1 OR episode_of_care_status = 'finished'
    //     ) AS combined_data
    //     GROUP BY patient_name
    //     ORDER BY encounter_period_start DESC
    // ";
    //     return $this->db->query($query)->result();
    // }

    public function get_data_laporan_pasien()
    {
        $query = "
        SELECT * FROM (
            SELECT * FROM tb_data
            UNION
            SELECT * FROM tb_data_schedule
        ) AS combined_data
        GROUP BY patient_name
        ORDER BY encounter_period_start DESC
        ";
        return $this->db->query($query)->result();
    }

    public function get_data_finished_pasien()
    {
        $query = "
        SELECT * FROM (
            SELECT * FROM tb_data where episode_of_care_status = 'finished'
            UNION
            SELECT * FROM tb_data_schedule where episode_of_care_status ='finished'
        ) AS combined_data
        GROUP BY patient_name
        ORDER BY encounter_period_start DESC
        ";
        return $this->db->query($query)->result();
    }

    public function get_data_canceled_pasien()
    {
        $query = "
        SELECT * FROM (
            SELECT * FROM tb_data where episode_of_care_status = 'canceled'
            UNION
            SELECT * FROM tb_data_schedule where episode_of_care_status = 'canceled'
        ) AS combined_data
        GROUP BY patient_name
        ORDER BY encounter_period_start DESC
        ";
        return $this->db->query($query)->result();
    }

    public function get_data_active_pasien()
    {
        $query = "
        SELECT * FROM (
            SELECT * FROM tb_data where episode_of_care_status = 'active'
            UNION
            SELECT * FROM tb_data_schedule where episode_of_care_status = 'active'
        ) AS combined_data
        GROUP BY patient_name
        ORDER BY encounter_period_start DESC
        ";
        return $this->db->query($query)->result();
    }


    public function get_pasien_terbaru()
    {
        $this->db->select('patient_name, episode_of_care_status, episode_of_care_period_start,period_end');
        $this->db->from('tb_data_schedule');
        $this->db->order_by('episode_of_care_period_start', 'DESC');
        $this->db->limit(5);
        return $this->db->get()->result();
    }

    public function get_riwayat_pengobatan()
    {
        $this->db->select('td.patient_name,tl.episode_number,tl.issued');
        $this->db->from('tb_data_schedule td,tb_observ_labor tl');
        $this->db->where('td.encounter_local_id = tl.id_pelayanan');
        $this->db->where('td.episode_of_care_id_tb_03 IS NOT NULL');
        $this->db->where('td.episode_of_care_id_tb_03 !=', '');
        $this->db->limit(5);
        return $this->db->get()->result();
    }

    public function get_pasien_active()
    {
        $query = "
        SELECT COUNT(DISTINCT patient_name) AS pasien_active FROM (
            SELECT patient_name, episode_of_care_status FROM tb_data
            UNION
            SELECT patient_name, episode_of_care_status FROM tb_data_schedule
        ) AS combined_data
        WHERE episode_of_care_status = 'active'
    ";
        $result = $this->db->query($query)->row();
        return $result->pasien_active;
    }

    public function get_pasien_selesai()
    {
        $query = "
        SELECT COUNT(DISTINCT patient_name) AS pasien_selesai FROM (
            SELECT patient_name, episode_of_care_status FROM tb_data
            UNION
            SELECT patient_name, episode_of_care_status FROM tb_data_schedule
        ) AS combined_data
        WHERE episode_of_care_status = 'finished'
    ";
        $result = $this->db->query($query)->row();
        return $result->pasien_selesai;
    }

    public function get_pasien_berhenti_pengobatan()
    {
        $query = "
        SELECT COUNT(DISTINCT patient_name) AS pasien_berhenti FROM (
            SELECT patient_name, episode_of_care_status FROM tb_data
            UNION
            SELECT patient_name, episode_of_care_status FROM tb_data_schedule
        ) AS combined_data
        WHERE episode_of_care_status = 'canceled'
    ";
        $result = $this->db->query($query)->row();
        return $result->pasien_berhenti;
    }

    public function get_terkirim()
    {
        $sql = "
            SELECT * FROM ihs_encounter_2
            UNION
            SELECT * FROM ihs_encounter
        ";

        $query = $this->db->query($sql);
        return $query->result_array(); // Mengembalikan hasil dalam bentuk array
    }

    // public function get_data_lanjut_pasien()
    // {
    //     $this->db->select('tb.*, ih.status, ih.tanggal');
    //     $this->db->from('tb_data_schedule tb, ihs_encounter ih,tb_observ_labor to');
    //     $this->db->where('tb.episode_of_care_id_tb_03 = ih.id_tb');
    //     $this->db->where('tb.encounter_local_id = to.id_pelayanan');
    //     $this->db->group_by('tb.patient_name'); // Asumsi 'nama' ada di tb_data_schedule, sesuaikan dengan kolom yang benar
    //     return $this->db->get()->result();
    // }

    public function get_data_lanjut_pasien2()
    {
        // Subquery UNION untuk ihs_encounter dan ihs_encounter_2
        $subquery_encounter = "
        (SELECT * FROM ihs_encounter
         UNION
         SELECT * FROM ihs_encounter_2) AS ih
        ";

        // Subquery UNION untuk tb_data_schedule dan tb_data
        $subquery_data = "
        (SELECT * FROM tb_data_schedule
         UNION
         SELECT * FROM tb_data) AS tb
        ";

        $sql = "
        SELECT tb.*, ih.status, tl.local_id, tl.issued, tl.status_pengobatan, ih.tanggal
        FROM $subquery_data
        JOIN $subquery_encounter ON tb.episode_of_care_id_tb_03 = ih.id_tb
        JOIN tb_observ_labor tl ON tb.encounter_local_id = tl.id_pelayanan
        WHERE tl.episode_number = '1'
        GROUP BY tb.patient_name
        ";

        return $this->db->query($sql)->result();
    }



    public function get_data_lanjut_pasien3()
    {
        // Buat subquery UNION untuk ihs_encounter dan ihs_encounter_2
        // Subquery UNION untuk ihs_encounter dan ihs_encounter_2
        $subquery_encounter = "
        (SELECT * FROM ihs_encounter
         UNION
         SELECT * FROM ihs_encounter_2) AS ih
        ";

        // Subquery UNION untuk tb_data_schedule dan tb_data
        $subquery_data = "
        (SELECT * FROM tb_data_schedule
         UNION
         SELECT * FROM tb_data) AS tb
        ";

        $sql = "
        SELECT tb.*, ih.status, tl.local_id, tl.issued, tl.status_pengobatan, ih.tanggal
        FROM $subquery_data
        JOIN $subquery_encounter ON tb.episode_of_care_id_tb_03 = ih.id_tb
        JOIN tb_observ_labor tl ON tb.encounter_local_id = tl.id_pelayanan
        WHERE tl.episode_number = '2'
        GROUP BY tb.patient_name
        ";

        return $this->db->query($sql)->result();
    }

    public function get_data_lanjut_pasien4()
    {
        // Buat subquery UNION untuk ihs_encounter dan ihs_encounter_2
        // Subquery UNION untuk ihs_encounter dan ihs_encounter_2
        $subquery_encounter = "
        (SELECT * FROM ihs_encounter
         UNION
         SELECT * FROM ihs_encounter_2) AS ih
        ";

        // Subquery UNION untuk tb_data_schedule dan tb_data
        $subquery_data = "
        (SELECT * FROM tb_data_schedule
         UNION
         SELECT * FROM tb_data) AS tb
        ";

        $sql = "
        SELECT tb.*, ih.status, tl.local_id, tl.issued, tl.status_pengobatan, ih.tanggal
        FROM $subquery_data
        JOIN $subquery_encounter ON tb.episode_of_care_id_tb_03 = ih.id_tb
        JOIN tb_observ_labor tl ON tb.encounter_local_id = tl.id_pelayanan
        WHERE tl.episode_number = '3'
        GROUP BY tb.patient_name
        ";

        return $this->db->query($sql)->result();
    }
    public function get_data_lanjut_pasien6()
    {
        // Buat subquery UNION untuk ihs_encounter dan ihs_encounter_2
        // Subquery UNION untuk ihs_encounter dan ihs_encounter_2
        $subquery_encounter = "
        (SELECT * FROM ihs_encounter
         UNION
         SELECT * FROM ihs_encounter_2) AS ih
        ";

        // Subquery UNION untuk tb_data_schedule dan tb_data
        $subquery_data = "
        (SELECT * FROM tb_data_schedule
         UNION
         SELECT * FROM tb_data) AS tb
        ";

        $sql = "
        SELECT tb.*, ih.status, tl.local_id, tl.issued, tl.status_pengobatan, ih.tanggal
        FROM $subquery_data
        JOIN $subquery_encounter ON tb.episode_of_care_id_tb_03 = ih.id_tb
        JOIN tb_observ_labor tl ON tb.encounter_local_id = tl.id_pelayanan
        WHERE tl.episode_number = '5'
        GROUP BY tb.patient_name
        ";

        return $this->db->query($sql)->result();
    }

    public function get_no_hp_pasien($no_rm)
    {
        $this->db->select('telp');
        $this->db->from('pasien');
        $this->db->where('no_rm', $no_rm);
        return $this->db->get()->row();
    }

    public function jumlah_kasus_tb_semua_poli()
    {
        $this->db->select("COUNT(*) as jumlah_kasus_tb");
        $this->db->from("diagnosa_utama");
        $this->db->where('kode >=', 'A15');
        $this->db->where('kode <=', 'A19');
        $this->db->where('YEAR(tanggal) >=', 2024);
        $this->db->where('YEAR(tanggal) <=', 2025);

        return $this->db->get()->row();
    }

    public function jumlah_kasus_terdiagnosa_tbc()
    {
        $query = "
            SELECT COUNT(DISTINCT patient_name) AS total_terdiagnosa FROM (
                SELECT patient_name FROM tb_data
                UNION
                SELECT patient_name FROM tb_data_schedule
            ) AS combined_data
        ";
        $result = $this->db->query($query)->row();
        return $result->total_terdiagnosa;
    }

    public function get_data_finish()
    {
        $this->db->select("COUNT(*) as total_sembuh");
        $this->db->from('tb_data_schedule');
        $this->db->where('episode_of_care_status', "finished");
        return $this->db->get()->row();
    }

    // public function get_data_umur_pasien()
    // {
    //     $query = "
    //     SELECT 
    //         CASE
    //             WHEN TIMESTAMPDIFF(YEAR, patient_dob, CURDATE()) BETWEEN 0 AND 14 THEN '0-14 Tahun'
    //             WHEN TIMESTAMPDIFF(YEAR, patient_dob, CURDATE()) BETWEEN 15 AND 24 THEN '15-24 Tahun'
    //             WHEN TIMESTAMPDIFF(YEAR, patient_dob, CURDATE()) BETWEEN 25 AND 54 THEN '25-54 Tahun'
    //             ELSE '55+ Tahun'
    //         END AS kelompok_usia,
    //         COUNT(DISTINCT patient_name) AS total
    //     FROM tb_data_schedule
    //     GROUP BY kelompok_usia
    // ";

    //     return $this->db->query($query)->result();
    // }

    public function get_data_umur_pasien()
    {
        $query = "
        SELECT 
            CASE
                WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 0 AND 14 THEN '0-14 Tahun'
                WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 15 AND 24 THEN '15-24 Tahun'
                WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 25 AND 54 THEN '25-54 Tahun'
                ELSE '55+ Tahun'
            END AS kelompok_usia,
            COUNT(DISTINCT nama) AS total
        FROM v_kunjungan_poli
        GROUP BY kelompok_usia
    ";

        return $this->db->query($query)->result();
    }


    public function get_data_resistensi()
    {
        $query = "
        SELECT 
            SUM(CASE WHEN episode_of_care_type_code = 'TB-SO' THEN 1 ELSE 0 END) AS total_tb_so,
            SUM(CASE WHEN episode_of_care_type_code = 'TB-RO' THEN 1 ELSE 0 END) AS total_tb_ro
        FROM (
            SELECT DISTINCT patient_name, episode_of_care_type_code
            FROM (
                SELECT patient_name, episode_of_care_type_code FROM tb_data_schedule
                UNION
                SELECT patient_name, episode_of_care_type_code FROM tb_data
            ) AS combined_data
        ) AS subquery
        ";
        return $this->db->query($query)->row();
    }

    public function get_data_gender()
    {
         $query = "
        SELECT patient_gender, COUNT(*) AS total FROM (
            SELECT DISTINCT patient_name, patient_dob, patient_gender
            FROM (
                SELECT patient_name, patient_dob, patient_gender FROM tb_data_schedule
                UNION
                SELECT patient_name, patient_dob, patient_gender FROM tb_data
            ) AS combined_data
        ) AS unique_patients
        GROUP BY patient_gender
        ";


        $query = $this->db->query($query);

        $result = ['male' => 0, 'female' => 0, 'unknown' => 0];
        foreach ($query->result() as $row) {
            if ($row->patient_gender == 'L') {
                $result['male'] = $row->total;
            } elseif ($row->patient_gender == 'P') {
                $result['female'] = $row->total;
            } else {
                $result['unknown'] += $row->total;
            }
        }

        return $result;
    }

    public function kasus_poli_anak()
    {
        $this->db->select('COUNT(*) as poli_anak');
        $this->db->from('v_kunjungan_poli');
        // $this->db->where('vk.id_pelayanan = td.encounter_local_id');
        $this->db->where('nama_poli', 'E00RX703');
        $this->db->where('kode_diagnosa', 'A15');
        return $this->db->get()->row()->poli_anak;
    }

    public function kasus_poli_paru()
    {
        $this->db->select('COUNT(*) as poli_paru');
        $this->db->from('v_kunjungan_poli');
        // $this->db->where('vk.id_pelayanan = td.encounter_local_id');
        $this->db->where('nama_poli', 'ZX2016T39');
        $this->db->where('kode_diagnosa', 'A15');
        return $this->db->get()->row()->poli_paru;
    }

    public function kasus_poli_dalam()
    {
        $this->db->select('COUNT(*) as poli_dalam');
        $this->db->from('v_kunjungan_poli');
        // $this->db->where('vk.id_pelayanan = td.encounter_local_id');
        $this->db->where('nama_poli', '24QRNLX29R');
        $this->db->where('kode_diagnosa', 'A15');
        return $this->db->get()->row()->poli_dalam;
    }

    public function kasus_poli_umum()
    {
        $this->db->select('COUNT(*) as poli_umum');
        $this->db->from('v_kunjungan_poli');
        // $this->db->where('vk.id_pelayanan = td.encounter_local_id');
        $this->db->where('nama_poli', 'RZE28J1098');
        $this->db->where('kode_diagnosa', 'A15');
        return $this->db->get()->row()->poli_umum;
    }

    public function kasus_poli_obgyn()
    {
        $this->db->select('COUNT(*) as poli_obgyn');
        $this->db->from('v_kunjungan_poli');
        // $this->db->where('vk.id_pelayanan = td.encounter_local_id');
        $this->db->where('nama_poli', '	HLGI4176K8');
        $this->db->where('kode_diagnosa', 'A15');
        return $this->db->get()->row()->poli_obgyn;
    }

    public function kasus_poli_anak_range($start, $end)
    {
        $this->db->select('COUNT(*) as poli_anak');
        $this->db->from('v_kunjungan_poli vk');
        // $this->db->join('tb_data_schedule td', 'vk.id_pelayanan = td.encounter_local_id');
        $this->db->where('nama_poli', 'E00RX703');
        $this->db->where('kode_diagnosa', 'A15');
        $this->db->where("DATE(vk.tgl_masuk) >=", $start);
        $this->db->where("DATE(vk.tgl_masuk) <=", $end);
        return $this->db->get()->row()->poli_anak;
    }

    public function kasus_poli_paru_range($start, $end)
    {
        $this->db->select('COUNT(*) as poli_paru');
        $this->db->from('v_kunjungan_poli vk');
        // $this->db->join('tb_data_schedule td', 'vk.id_pelayanan = td.encounter_local_id');
        $this->db->where('nama_poli', 'ZX2016T39');
        $this->db->where('kode_diagnosa', 'A15');
        $this->db->where("DATE(vk.tgl_masuk) >=", $start);
        $this->db->where("DATE(vk.tgl_masuk) <=", $end);
        return $this->db->get()->row()->poli_paru;
    }

    public function kasus_poli_dalam_range($start, $end)
    {
        $this->db->select('COUNT(*) as poli_dalam');
        $this->db->from('v_kunjungan_poli vk');
        // $this->db->join('tb_data_schedule td', 'vk.id_pelayanan = td.encounter_local_id');
        $this->db->where('nama_poli', '24QRNLX29R');
        $this->db->where('kode_diagnosa', 'A15');
        $this->db->where("DATE(vk.tgl_masuk) >=", $start);
        $this->db->where("DATE(vk.tgl_masuk) <=", $end);
        return $this->db->get()->row()->poli_dalam;
    }

    public function kasus_poli_umum_range($start, $end)
    {
        $this->db->select('COUNT(*) as poli_umum');
        $this->db->from('v_kunjungan_poli vk');
        // $this->db->join('tb_data_schedule td', 'vk.id_pelayanan = td.encounter_local_id');
        $this->db->where('nama_poli', 'RZE28J1098');
        $this->db->where('kode_diagnosa', 'A15');
        $this->db->where("DATE(vk.tgl_masuk) >=", $start);
        $this->db->where("DATE(vk.tgl_masuk) <=", $end);
        return $this->db->get()->row()->poli_umum;
    }

    public function kasus_poli_obgyn_range($start, $end)
    {
        $this->db->select('COUNT(*) as poli_obgyn');
        $this->db->from('v_kunjungan_poli vk');
        // $this->db->join('tb_data_schedule td', 'vk.id_pelayanan = td.encounter_local_id');
        $this->db->where('nama_poli', 'HLGI4176K8');
        $this->db->where('kode_diagnosa', 'A15');
        $this->db->where("DATE(vk.tgl_masuk) >=", $start);
        $this->db->where("DATE(vk.tgl_masuk) <=", $end);
        return $this->db->get()->row()->poli_obgyn;
    }

    public function get_filtered_data($mulai, $selesai, $jenis)
    {
        // Format tanggal ke format Y-m-d
        $mulai = date('Y-m-d', strtotime($mulai));
        $selesai = date('Y-m-d', strtotime($selesai));

        if ($jenis == 'data_tbc') {
            // Union antara tb_data_schedule dan tb_data
            $sql = "
            SELECT patient_name, patient_nik, patient_gender, patient_dob, patient_province, patient_district, patient_address, encounter_local_id, no_rm, episode_of_care_id_tb_03, episode_of_care_status, episode_of_care_period_start, period_end
            FROM tb_data_schedule
            WHERE episode_of_care_period_start BETWEEN ? AND ?
            UNION
            SELECT patient_name, patient_nik, patient_gender, patient_dob, patient_province, patient_district, patient_address, encounter_local_id, no_rm, episode_of_care_id_tb_03, episode_of_care_status, episode_of_care_period_start, period_end
            FROM tb_data
            WHERE episode_of_care_period_start BETWEEN ? AND ?
            ORDER BY episode_of_care_period_start ASC
        ";
            $query = $this->db->query($sql, [$mulai, $selesai, $mulai, $selesai]);
        } elseif ($jenis == 'data_terkirim') {
            // Union antara ihs_encounter_2 dan ihs_encounter
            $sql = "
            SELECT i.id_tb, i.id_pelayanan, i.status, i.tanggal, 
                t.patient_name, t.patient_nik
            FROM ihs_encounter_2 i
            LEFT JOIN tb_data_schedule t ON i.id_tb = t.episode_of_care_id_tb_03
            WHERE i.tanggal BETWEEN ? AND ?

            UNION

            SELECT i.id_tb, i.id_pelayanan, i.status, i.tanggal, 
                t.patient_name, t.patient_nik
            FROM ihs_encounter i
            LEFT JOIN tb_data t ON i.id_tb = t.episode_of_care_id_tb_03
            WHERE i.tanggal BETWEEN ? AND ?

            ORDER BY tanggal ASC
            ";
            $query = $this->db->query($sql, [$mulai, $selesai, $mulai, $selesai]);
        } else {
            // Jika jenis tidak dikenali, return array kosong
            return [];
        }

        return $query->result();
    }


    public function filtered_data_perawat($mulai, $selesai)
    {
        // Format tanggal jika perlu
        $mulai = date('Y-m-d', strtotime($mulai));
        $selesai = date('Y-m-d', strtotime($selesai));
        $table = 'tb_data_schedule';
        $date_column = 'episode_of_care_period_start';

        // Query ke database
        $this->db->distinct();
        $this->db->select('patient_name,patient_nik,patient_gender,patient_dob,patient_province,patient_district,patient_address,encounter_local_id,no_rm,episode_of_care_id_tb_03,episode_of_care_status,episode_of_care_period_start,period_end'); // atau bisa ganti dengan field tertentu, misal: 'patient_name, episode_of_care_period_start'
        $this->db->from($table);
        $this->db->where($date_column . ' >=', $mulai);
        $this->db->where($date_column . ' <=', $selesai);
        $this->db->group_by('patient_name'); // agar benar-benar mengelompokkan berdasarkan nama
        $query = $this->db->get();

        return $query->result();
    }

    public function filtered_data_direktur($mulai, $selesai)
    {
        // Format tanggal jika perlu
        $mulai = date('Y-m-d', strtotime($mulai));
        $selesai = date('Y-m-d', strtotime($selesai));
        $table = 'tb_data_schedule';
        $date_column = 'episode_of_care_period_start';

        // Query ke database
        $this->db->distinct();
        $this->db->select('patient_name,patient_nik,patient_gender,patient_dob,patient_province,patient_district,patient_address,encounter_local_id,no_rm,episode_of_care_id_tb_03,episode_of_care_status,episode_of_care_period_start,period_end'); // atau bisa ganti dengan field tertentu, misal: 'patient_name, episode_of_care_period_start'
        $this->db->from($table);
        $this->db->where($date_column . ' >=', $mulai);
        $this->db->where($date_column . ' <=', $selesai);
        $this->db->group_by('patient_name'); // agar benar-benar mengelompokkan berdasarkan nama
        $query = $this->db->get();

        return $query->result();
    }

    public function get_local_id($id)
    {
        $this->db->select('local_id');
        $this->db->from('tb_observ_labor');
        $this->db->where('id_pelayanan', $id);
        return $this->db->get()->row();
    }


    public function get_episode($local_id)
    {
        $this->db->select('episode_number');
        $this->db->from('tb_observ_labor');
        $this->db->where('local_id', $local_id);
        $result = $this->db->get()->row();

        if ($result) {
            // Jika sudah pengobatan ke-1, maka lanjutkan ke-2
            $next_episode = (int)$result->episode_number + 1;
            return $next_episode;
        }
    }


    public function get_tanggal_observ($local_id)
    {
        $this->db->select('issued');
        $this->db->from('tb_observ_labor');
        $this->db->where('local_id', $local_id);
        $result = $this->db->get()->row();

        if ($result) {
            // Pastikan 'issued' adalah format tanggal yang valid
            $tanggal_awal = new DateTime($result->issued);
            $tanggal_awal->modify('+30 days');
            return $tanggal_awal->format('Y-m-d'); // atau 'd-m-Y' sesuai kebutuhanmu
        } else {
            return null; // atau bisa juga return "Data tidak ditemukan"
        }
    }
}
