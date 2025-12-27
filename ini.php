// Catat error ke file log, JANGAN tampilkan di production
ini_set('display_errors', 0);
ini_set('log_errors', 1);
// Tentukan path file log
ini_set('error_log', '/path/to/php/error.log');