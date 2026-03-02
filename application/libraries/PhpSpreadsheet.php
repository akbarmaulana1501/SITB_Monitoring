<?php

require_once APPPATH . '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PhpSpreadsheet {
    public function __construct() {
        
    }

    public function createSpreadsheet() {
        return new Spreadsheet();
    }

    public function createWriter($spreadsheet, $type = 'Xlsx') {
        if ($type === 'Xlsx') {
            return new Xlsx($spreadsheet);
        }
        // Anda dapat menambahkan jenis penulis lain di sini jika diperlukan
    }
}
