<?php
// Configure session cookie parameters to improve compatibility on mobile browsers
$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
$cookieParams = [
    'lifetime' => 0,
    'path' => '/',
    'secure' => $secure,
    'httponly' => true,
    'samesite' => 'Lax'
];
if (PHP_VERSION_ID >= 70300) {
    session_set_cookie_params($cookieParams);
} else {
    session_set_cookie_params($cookieParams['lifetime'], $cookieParams['path'], ini_get('session.cookie_domain'), $cookieParams['secure'], $cookieParams['httponly']);
}
session_start();

// Logout: unset semua session dan redirect
session_unset();
session_destroy();
header("Location: index.php");
exit;
?>