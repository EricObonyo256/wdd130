<?php
function esc($value) {
  return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function get_post($key, $default = '') {
  return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
}

function format_currency($amount) {
  return number_format((float) $amount, 2);
}

// Send email using PHPMailer if available, otherwise fallback to mail().
function send_site_email($to, $subject, $body, $from = null) {
  $from = $from ?: (getenv('SITE_EMAIL') ?: 'noreply@' . ($_SERVER['HTTP_HOST'] ?? 'localhost'));

  // Use PHPMailer if installed
  if (class_exists('\PHPMailer\PHPMailer\PHPMailer')) {
    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    try {
      // SMTP settings via env
      $smtpHost = getenv('SMTP_HOST');
      $smtpPort = getenv('SMTP_PORT') ?: 587;
      $smtpUser = getenv('SMTP_USER');
      $smtpPass = getenv('SMTP_PASS');

      if ($smtpHost && $smtpUser && $smtpPass) {
        $mail->isSMTP();
        $mail->Host = $smtpHost;
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUser;
        $mail->Password = $smtpPass;
        $mail->SMTPSecure = getenv('SMTP_SECURE') ?: 'tls';
        $mail->Port = $smtpPort;
      }

      $mail->setFrom($from);
      $mail->addAddress($to);
      $mail->Subject = $subject;
      $mail->Body = $body;
      $mail->send();
      return true;
    } catch (Exception $e) {
      error_log('Mail error: ' . $e->getMessage());
      // fall through to fallback
    }
  }

  // Fallback to PHP mail
  $headers = 'From: ' . $from . "\r\n" . 'Content-Type: text/plain; charset=utf-8';
  return @mail($to, $subject, $body, $headers);
}

// Render the site footer. Use this function when including footer markup.
function render_footer() {
  echo <<<'HTML'
  </main>

  <footer>
    <div class="container">
      <p>© 2026 GreenGrow Fertilizers Ltd</p>
    </div>
  </footer>
</body>
</html>
HTML;
}
