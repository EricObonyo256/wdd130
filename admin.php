<?php
include 'connect.php';
include 'functions.php';
$pageTitle = 'GreenGrow Fertilizers | Admin';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_product') {
  $name = get_post('name');
  $description = get_post('description');
  $price = get_post('price');
  $imagePath = get_post('image_path');

  if ($name === '' || $price === '') {
    $message = 'Please provide both product name and price.';
  } else {
    $stmt = $conn->prepare('INSERT INTO products (name, description, price, image_path) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('ssds', $name, $description, $price, $imagePath);
    if ($stmt->execute()) {
      $message = 'Product uploaded successfully.';
    } else {
      $message = 'Unable to save product. Please try again.';
    }
    $stmt->close();
  }
}

if (isset($_GET['delete_product'])) {
  $deleteId = (int) $_GET['delete_product'];
  $stmt = $conn->prepare('DELETE FROM products WHERE id = ?');
  $stmt->bind_param('i', $deleteId);
  $stmt->execute();
  $stmt->close();
  header('Location: admin.php');
  exit;
}

$productResult = $conn->query('SELECT * FROM products ORDER BY created_at DESC');
$products = $productResult ? $productResult->fetch_all(MYSQLI_ASSOC) : [];
$orderResult = $conn->query('SELECT * FROM orders ORDER BY created_at DESC LIMIT 50');
$orders = $orderResult ? $orderResult->fetch_all(MYSQLI_ASSOC) : [];

include 'header.php';
?>

<section class="section-panel">
  <div class="section-heading">
    <span class="eyebrow">Admin dashboard</span>
    <h2>Upload products and view orders</h2>
  </div>

  <?php if ($message): ?>
    <div class="status-message"><?php echo esc($message); ?></div>
  <?php endif; ?>

  <div class="grid-two">
    <div class="card">
      <h3>Upload a new product</h3>
      <form method="post" class="contact-form">
        <input type="hidden" name="action" value="create_product">

        <label for="name">Product name</label>
        <input id="name" name="name" type="text" required>

        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4"></textarea>

        <label for="price">Price (UGX)</label>
        <input id="price" name="price" type="number" step="0.01" min="0" required>

        <label for="image_path">Image path</label>
        <input id="image_path" name="image_path" type="text" placeholder="images/product.png">

        <button class="btn" type="submit">Save product</button>
      </form>
    </div>

    <div class="card">
      <h3>Product library</h3>
      <?php if (count($products) === 0): ?>
        <p>No products yet. Add one to begin selling through the site.</p>
      <?php else: ?>
        <table class="admin-table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Price</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product): ?>
              <tr>
                <td><?php echo esc($product['name']); ?></td>
                <td><?php echo format_currency($product['price']); ?></td>
                <td><a class="link-button" href="admin.php?delete_product=<?php echo $product['id']; ?>">Delete</a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>
</section>

<section class="section-panel">
  <div class="section-heading">
    <span class="eyebrow">Latest orders</span>
    <h2>Customer requests</h2>
  </div>

  <?php if (count($orders) === 0): ?>
    <p>No orders have been received yet.</p>
  <?php else: ?>
    <table class="admin-table">
      <thead>
        <tr>
          <th>Date</th>
          <th>Name</th>
          <th>Phone</th>
          <th>Email</th>
          <th>Product</th>
          <th>Amount</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $order): ?>
          <tr>
            <td><?php echo esc($order['created_at']); ?></td>
            <td><?php echo esc($order['customer_name']); ?></td>
            <td><?php echo esc($order['phone']); ?></td>
            <td><?php echo esc($order['email']); ?></td>
            <td><?php echo esc($order['product']); ?></td>
            <td><?php echo format_currency($order['amount']); ?></td>
            <td><?php echo esc($order['status']); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</section>

<?php include 'footer.php'; ?>
 