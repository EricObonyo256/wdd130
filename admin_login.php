<?php
require_once 'functions.php';
require_once 'auth.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user = isset($_POST['user']) ? trim($_POST['user']) : '';
  $pass = isset($_POST['pass']) ? trim($_POST['pass']) : '';
  if (attempt_login($user, $pass)) {
    header('Location: admin.php');
    exit;
  } else {
    $error = 'Invalid credentials.';
  }
}
?>
<?php include 'header.php'; ?>

<section class="section-panel">
  <div class="section-heading">
    <span class="eyebrow">Admin sign in</span>
    <h2>Please sign in to access the admin dashboard</h2>
  </div>

  <?php if ($error): ?>
    <div class="status-message error"><?php echo esc($error); ?></div>
  <?php endif; ?>

  <form method="post" style="max-width:420px;">
    <label for="user">Username</label>
    <input id="user" name="user" type="text" required>

    <label for="pass">Password</label>
    <input id="pass" name="pass" type="password" required>

    <button class="btn" type="submit">Sign in</button>
  </form>
</section>

<?php include 'footer.php'; ?>
