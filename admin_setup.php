<?php
// admin_setup.php - create an admin user in the database with a hashed password.
require_once 'connect.php';
require_once 'functions.php';

if (php_sapi_name() !== 'cli') {
  echo "Run this script from the command line: php admin_setup.php username password\n";
  exit;
}

$username = $argv[1] ?? null;
$password = $argv[2] ?? null;
if (!$username || !$password) {
  echo "Usage: php admin_setup.php <username> <password>\n";
  exit(1);
}
$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare('INSERT INTO users (username, password_hash, display_name) VALUES (?, ?, ?)');
$display = $username;
$stmt->bind_param('sss', $username, $hash, $display);
if ($stmt->execute()) {
  echo "Created admin user: $username\n";
} else {
  echo "Failed to create user: " . $stmt->error . "\n";
}
$stmt->close();
