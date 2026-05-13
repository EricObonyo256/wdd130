<?php
// contact_process.php
// Receives POST from ggr/contact.html and stores message in `contacts` table.

require_once __DIR__ . '/connect.php';
require_once __DIR__ . '/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ggr/contact.html');
  exit;
}

$name = get_post('name');
$phone = get_post('phone');
$email = get_post('email');
$message = get_post('message');

if (!$name || !$phone || !$email) {
  header('Location: ggr/contact.html?error=1#contact-form');
  exit;
}

// Ensure contacts table exists
$tableSql = "CREATE TABLE IF NOT EXISTS contacts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  phone VARCHAR(50) NOT NULL,
  email VARCHAR(150) NOT NULL,
  message TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
$conn->query($tableSql);

// Insert message using prepared statement
$stmt = $conn->prepare("INSERT INTO contacts (name, phone, email, message) VALUES (?, ?, ?, ?)");
if ($stmt) {
  $stmt->bind_param('ssss', $name, $phone, $email, $message);
  $ok = $stmt->execute();
  $stmt->close();
} else {
  $ok = false;
}

// Optional: send notification email (may not work on local dev)
$siteEmail = getenv('SITE_EMAIL') ?: 'info@greengrowfertilizers.com';
$subject = "New contact message from " . substr($name, 0, 100);
$body = "Name: " . $name . "\nPhone: " . $phone . "\nEmail: " . $email . "\n\nMessage:\n" . $message;
$headers = 'From: noreply@' . ($_SERVER['HTTP_HOST'] ?? 'localhost');
@mail($siteEmail, $subject, $body, $headers);

if ($ok) {
  header('Location: ggr/thank-you.html');
} else {
  header('Location: ggr/contact.html?error=1#contact-form');
}
exit;
