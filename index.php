<?php
$pageTitle = 'GreenGrow Fertilizers | Home';
include 'connect.php';
include 'functions.php';

$productResult = $conn->query('SELECT * FROM products ORDER BY created_at DESC');
$products = $productResult ? $productResult->fetch_all(MYSQLI_ASSOC) : [];
include 'header.php';
?>

<section id="hero" class="hero-panel">
  <div class="hero-copy">
    <span class="eyebrow">Grow with confidence</span>
    <h2>Stronger soil, higher yields, and healthier crops.</h2>
    <p class="lead">GreenGrow blends expert agronomy with dependable fertilizer supply so farmers can achieve more reliable harvests.</p>
    <div class="button-group">
      <a class="btn" href="https://wa.me/256772722688?text=Hello%20GreenGrow,%20I%20want%20to%20place%20an%20order">Order on WhatsApp</a>
      <a class="btn-secondary" href="#products">View products</a>
    </div>
  </div>
  <div class="hero-image">
    <img src="images/Alex1.png" alt="GreenGrow fertilizer packaging and healthy crops">
  </div>
</section>

<section id="products" class="section-panel">
  <div class="section-heading">
    <span class="eyebrow">Our product range</span>
    <h2>Fertilizer blends for every stage of growth</h2>
  </div>
  <div class="card-grid">
    <?php if (count($products) > 0): ?>
      <?php foreach ($products as $product): ?>
        <article class="product-card">
          <h3><?php echo esc($product['name']); ?></h3>
          <p><?php echo esc($product['description']); ?></p>
          <?php if (!empty($product['image_path'])): ?>
            <img src="<?php echo esc($product['image_path']); ?>" alt="<?php echo esc($product['name']); ?>">
          <?php endif; ?>
          <button type="button" onclick="orderProduct('<?php echo esc($product['name']); ?>')">Order now</button>
        </article>
      <?php endforeach; ?>
    <?php else: ?>
      <article class="product-card">
        <h3>NPK 20:10:10</h3>
        <p>Balanced nutrition for sustained growth and strong plant development.</p>
        <button type="button" onclick="orderProduct('NPK 20:10:10')">Order now</button>
      </article>
      <article class="product-card">
        <h3>Organic Fertilizer</h3>
        <p>Improves soil health naturally while boosting yield quality.</p>
        <button type="button" onclick="orderProduct('Organic Fertilizer')">Order now</button>
      </article>
      <article class="product-card">
        <h3>Liquid Fertilizer</h3>
        <p>Fast nutrient uptake for quicker crop recovery and stronger leaves.</p>
        <button type="button" onclick="orderProduct('Liquid Fertilizer')">Order now</button>
      </article>
    <?php endif; ?>
  </div>
</section>

<section id="about" class="section-panel">
  <div class="section-heading">
    <span class="eyebrow">About GreenGrow</span>
    <h2>Local fertilizer expertise designed to help farms thrive.</h2>
  </div>
  <div class="grid-two">
    <div>
      <p>GreenGrow delivers reliable fertilizer products, practical guidance, and local support to help farmers make the most of every season.</p>
      <ul class="feature-list">
        <li>Trusted formulas for healthier growth.</li>
        <li>Quick ordering via WhatsApp with fast delivery.</li>
        <li>Simple guidance for fertilizer use and soil care.</li>
      </ul>
    </div>
    <div class="feature-aside">
      <img src="images/Alex1.png" alt="Fertilizer bag beside healthy crops">
    </div>
  </div>
</section>

<section id="contact" class="contact-strip">
  <div>
    <h2>Ready to grow with GreenGrow?</h2>
    <p>Message our team today for product recommendations, delivery details, and order support.</p>
  </div>
  <div class="contact-actions">
    <a class="contact-link" href="tel:+256772722688">+256 772 722 688</a>
    <a class="btn" href="https://wa.me/256772722688?text=Hello%20GreenGrow">Chat on WhatsApp</a>
  </div>
</section>

<?php include 'footer.php'; ?>
