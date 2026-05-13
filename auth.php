<?php
// Simple session-based admin authentication. Uses environment variables SITE_ADMIN_USER and SITE_ADMIN_PASS.
if (session_status() === PHP_SESSION_NONE) session_start();

function admin_is_logged_in() {
  return !empty($_SESSION['is_admin']);
}

function require_admin() {
  if (!admin_is_logged_in()) {
    header('Location: admin_login.php');
    exit;
  }
}

function attempt_login($user, $pass) {
  $envUser = getenv('SITE_ADMIN_USER') ?: 'admin';
  $envPass = getenv('SITE_ADMIN_PASS') ?: 'changeme';
  if ($user === $envUser && $pass === $envPass) {
    $_SESSION['is_admin'] = true;
    return true;
  }
  return false;
}

function admin_logout() {
  $_SESSION = [];
  if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
      $params['path'], $params['domain'], $params['secure'], $params['httponly']
    );
  }
  session_destroy();
}
