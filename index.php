<?php
require_once "src/app.php";
$app = new app();
$inputs = json_decode(file_get_contents('InputData.json'));

if (!empty($inputs)) {
  foreach ($inpus as $input) {
    $customer = $app->getCustomer();
    $customer->setFName(explode(' ',$input->Customer->Name)[0])
      ->setLName(explode(' ',$input->Customer->Name)[1])
      ->setEmail('');
    $app->run('new',$customer);
    $customer->setCustomerID($app->getLastID());
    $address = $app->getAddress();
    $string = explode(',', $input->Customer->CardAddress);
    if (isset($string[0])) {
      $address->setStreet($string[0]);
    }
    if (isset($string[1])) {
      $address->setStreet($string[1]);
    }
    if (isset($string[2])) {
      $address->setStateAbbr($string[2]);
    }
    if (isset($string[3])) {
      $address->setZip($string[3]);
    }
    $app->run('new',$address);

  }
}

?>
