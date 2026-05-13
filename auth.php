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
  // First try environment variables (legacy/simple)
  $envUser = getenv('SITE_ADMIN_USER') ?: null;
  $envPass = getenv('SITE_ADMIN_PASS') ?: null;
  if ($envUser && $envPass) {
    if ($user === $envUser && $pass === $envPass) {
      $_SESSION['is_admin'] = true;
      return true;
    }
  }

  // Next, try database users table if available
  try {
    if (file_exists(__DIR__ . '/connect.php')) {
      require_once __DIR__ . '/connect.php';
      $stmt = $conn->prepare('SELECT password_hash FROM users WHERE username = ? LIMIT 1');
      if ($stmt) {
        $stmt->bind_param('s', $user);
        $stmt->execute();
        $stmt->bind_result($hash);
        if ($stmt->fetch()) {
          $stmt->close();
          if (password_verify($pass, $hash)) {
            $_SESSION['is_admin'] = true;
            return true;
          }
        } else {
          $stmt->close();
        }
      }
    }
  } catch (Throwable $e) {
    // ignore DB errors and fall back
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
