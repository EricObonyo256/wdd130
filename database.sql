CREATE DATABASE IF NOT EXISTS greengrow;
USE greengrow;

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL DEFAULT 0,
  image_path VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_name VARCHAR(100) NOT NULL,
  phone VARCHAR(30) NOT NULL,
  email VARCHAR(150) NOT NULL,
  product VARCHAR(150) NOT NULL,
  amount DECIMAL(10,2) DEFAULT 0,
  message TEXT,
  status VARCHAR(50) DEFAULT 'New',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS contacts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  phone VARCHAR(50) NOT NULL,
  email VARCHAR(150) NOT NULL,
  message TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (name, description, price, image_path) VALUES
('NPK 20:10:10', 'Balanced nutrition for sustained growth and strong plant development.', 24000, 'images/Alex1.png'),
('Organic Fertilizer', 'Improves soil health naturally while boosting yield quality.', 18000, 'images/Alex1.png'),
('Liquid Fertilizer', 'Fast nutrient uptake for quicker crop recovery and stronger leaves.', 22000, 'images/Alex1.png');
