<?php
require_once "src/database.php";

$db = new database (
  '127.0.0.1',
  'CustomerOrders',
  'app',
  'password'
);
$db->init();
print_r($db);
?>
