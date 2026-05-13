<?php
require_once 'auth.php';
admin_logout();
header('Location: admin_login.php');
exit;
