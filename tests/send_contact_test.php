<?php
// Simple test script to POST a sample contact message to a running local site.
// Usage: php send_contact_test.php http://localhost:8000/contact_process.php

$url = $argv[1] ?? 'http://localhost:8000/contact_process.php';
$data = [
  'name' => 'Test User',
  'phone' => '+256772722688',
  'email' => 'test@example.com',
  'message' => 'This is a test message from automated test.'
];

$options = [
  'http' => [
    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
    'method'  => 'POST',
    'content' => http_build_query($data),
    'ignore_errors' => true,
  ],
];

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

echo "POST to $url completed. Response length: " . strlen($result) . "\n";
if (!empty($result)) echo substr($result,0,800) . "\n";
