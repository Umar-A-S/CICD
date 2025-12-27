<?php
// Centralized logger for production
// Place this file in project root and include it in entry points (index.php, scripts)

// Ensure no output and disable display errors in production
ini_set('display_errors', '0');
ini_set('log_errors', '0');

date_default_timezone_set('UTC');

$LOG_DIR = __DIR__ . '/logs';
$LOG_FILE = $LOG_DIR . '/error.log';

function write_log($level, $message, $file = null, $line = null, $trace = null) {
    global $LOG_FILE;
    $time = date('Y-m-d H:i:s');
    $entry = "[$time] [$level] $message";
    if ($file) $entry .= " in $file";
    if ($line) $entry .= " on line $line";
    if ($trace) $entry .= "\nTrace:\n$trace";
    $entry .= PHP_EOL;

    $dir = dirname($LOG_FILE);
    if (!is_dir($dir)) {
        @mkdir($dir, 0750, true);
    }

    // Rotate log if larger than 10 MB
    if (file_exists($LOG_FILE) && filesize($LOG_FILE) > 10 * 1024 * 1024) {
        $rotated = $LOG_FILE . '.' . date('YmdHis');
        @rename($LOG_FILE, $rotated);
    }

    $fp = @fopen($LOG_FILE, 'a');
    if ($fp) {
        @flock($fp, LOCK_EX);
        @fwrite($fp, $entry);
        @flock($fp, LOCK_UN);
        @fclose($fp);
    }
}

function log_error($message, $file = null, $line = null) {
    write_log('ERROR', $message, $file, $line, null);
}

function log_exception($e) {
    $trace = method_exists($e, 'getTraceAsString') ? $e->getTraceAsString() : print_r($e, true);
    write_log('EXCEPTION', $e->getMessage(), $e->getFile(), $e->getLine(), $trace);
}

set_error_handler(function($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        return false; // respect @ operator and current error_reporting
    }
    log_error($message, $file, $line);
    return true; // prevent PHP internal handler from duplicating
});

set_exception_handler(function($e) {
    log_exception($e);
});

register_shutdown_function(function() {
    $err = error_get_last();
    if ($err && in_array($err['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        write_log('FATAL', $err['message'], $err['file'], $err['line'], null);
    }
});
