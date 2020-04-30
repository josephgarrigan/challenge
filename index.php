<?php
require_once "src/app.php";
$app = new app();
$data = json_decode(file_get_contents('InputData.json'));
var_dump($data);
?>
