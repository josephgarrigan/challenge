<?php
require_once "src/app.php";
$app = new app();
$inputs = json_decode(file_get_contents('InputData.json'));

if (!empty($inputs)) {
  foreach ($inputs as $input) {
    $app->ingestInputObject($input);
  }
}
?>
