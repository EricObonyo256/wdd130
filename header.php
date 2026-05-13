<?php if (!isset($pageTitle)) { $pageTitle = 'GreenGrow Fertilizers'; } ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo esc($pageTitle); ?></title>
  <link rel="manifest" href="manifest.json">
  <link rel="stylesheet" href="styles/styles.css">
  <script defer src="scripts/app.js"></script>
</head>
<body>
  <header class="site-header">
    <div class="container header-inner">
      <div>
        <h1>GreenGrow Fertilizers</h1>
        <p>Premium nutrients for healthier soil and stronger harvests.</p>
      </div>

      <button class="menu-toggle" aria-expanded="false" aria-controls="primary-nav" aria-label="Toggle menu">
        <span></span>
        <span></span>
        <span></span>
      </button>

      <nav class="site-nav" id="primary-nav" aria-label="Primary navigation">
        <a href="index.php#hero">Home</a>
        <a href="index.php#products">Products</a>
        <a href="index.php#about">About</a>
        <a href="contact.php">Contact</a>
        <a href="admin.php">Admin</a>
      </nav>
    </div>
  </header>

  <main class="container">
