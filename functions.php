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
