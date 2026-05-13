<?php
include 'connect.php';
include 'functions.php';
$pageTitle = 'GreenGrow Fertilizers | Contact';

$selectedProduct = get_post('product', isset($_GET['product']) ? $_GET['product'] : '');
$message = '';
$success = false;

$productQuery = $conn->query('SELECT id, name, price FROM products ORDER BY created_at DESC');
$products = $productQuery ? $productQuery->fetch_all(MYSQLI_ASSOC) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = get_post('name');
  $phone = get_post('phone');
  $email = get_post('email');
  $product = get_post('product');
  $messageText = get_post('message');
  $amount = 0;

  foreach ($products as $item) {
    if ($item['id'] == $product) {
      $selectedProduct = $item['name'];
      $amount = $item['price'];
      break;
    }
  }

  if ($name === '' || $phone === '' || $email === '' || $product === '') {
    $message = 'Please fill in all required fields.';
  } else {
    $stmt = $conn->prepare('INSERT INTO orders (customer_name, phone, email, product, amount, message) VALUES (?, ?, ?, ?, ?, ?)');
    $productName = $selectedProduct ?: 'General inquiry';
    $stmt->bind_param('ssssds', $name, $phone, $email, $productName, $amount, $messageText);

    if ($stmt->execute()) {
      $success = true;
      $message = 'Thank you! Your request has been received.';
    } else {
      $message = 'There was a problem sending your message. Please try again.';
    }
    $stmt->close();
  }
}

include 'header.php';
?>

<section class="section-panel">
  <div class="section-heading">
    <span class="eyebrow">Contact us</span>
    <h2>Send us a quick message</h2>
    <p>Fill out the form below and our team will follow up with delivery details.</p>
  </div>

  <?php if ($message): ?>
    <div class="status-message <?php echo $success ? 'success' : 'error'; ?>"><?php echo esc($message); ?></div>
  <?php endif; ?>

  <form method="post" class="contact-form">
    <label for="name">Name</label>
    <input type="text" id="name" name="name" placeholder="Your full name" required>

    <label for="phone">Phone</label>
    <input type="tel" id="phone" name="phone" placeholder="+256 772 722 688" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" placeholder="you@example.com" required>

    <label for="product">Product</label>
    <select id="product" name="product" required>
      <option value="">Choose a product</option>
      <?php foreach ($products as $item): ?>
        <option value="<?php echo esc($item['id']); ?>" <?php if ($selectedProduct == $item['id'] || $selectedProduct == $item['name']) echo 'selected'; ?>>
          <?php echo esc($item['name']); ?> (UGX <?php echo format_currency($item['price']); ?>)
        </option>
      <?php endforeach; ?>
    </select>

    <label for="message">Message</label>
    <textarea id="message" name="message" rows="5" placeholder="Tell us about your order or question"></textarea>

    <button type="submit" class="btn">Send message</button>
  </form>
</section>

<?php include 'footer.php'; ?>
