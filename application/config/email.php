<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//SMTP email
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.googlemail.com'; // Hanya satu 'ssl://'
$config['smtp_port'] = 587; // Port SMTP
$config['smtp_user'] = 'akbarmaulana.am826@gmail.com'; // Email pengirim
$config['smtp_pass'] = 'eqycpjxwnzaxmjlo'; // Password email pengirim
$config['smtp_crypto'] = 'tls'; // Enkripsi SSL atau TLS
$config['mailtype'] = 'text'; // Tipe email, bisa 'text' atau 'html'
$config['charset'] = 'utf-8'; // Karakter yang digunakan
$config['wordwrap'] = TRUE; // Menentukan apakah baris teks dipotong
$config['newline'] = "\r\n"; // Baris baru untuk header email