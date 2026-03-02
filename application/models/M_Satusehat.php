<?php
class M_Satusehat extends CI_Model {
    function __construct(){
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        setlocale(LC_ALL, 'id_ID');
    }
   
    public function update_data($where, $page_data, $table){
        $this->db->where($where);
        $this->db->update($table, $page_data);
    }
    public function insert_data($data, $table){
    $this->db->insert($table, $data);
    }
   
}
