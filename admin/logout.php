<?php
require_once __DIR__ . '/../core/init.php';
session_destroy();
redirect(BASE_URL . 'admin/index.php');
?>