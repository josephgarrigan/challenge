<?php
require_once "src/app.php";
$app = new app();
$inputs = json_decode(file_get_contents('InputData.json'));

if (!empty($inputs)) {
  foreach ($inputs as $input) {
    $customer = $app->getCustomer();
    $customer->setFName(getName(0, $input->Customer->Name))
      ->setLName(getName(1, $input->Customer->Name))
      ->setEmail('test@email.com');
    $customer->setCustomerID($app->run('new',$customer)['customerID']);

    $address = fillAddress($app->getAddress(),$input->Customer->CardAddress);
    $address->setAddressID($app->run('new',$address)['addressID']);

    $customerAddr = $app->getCustomerAddressXRef();
    $customerAddr->setCustomerID($customer->getCustomerID())
      ->setAddressID($address->getAddressID())
      ->setName($input->Customer->Name);
    $test = $app->run('new', $customerAddr);

    if (!empty($input->Customer->Order)) {
      $inputOrder = $input->Customer->Order;
      $order = $app->getOrder();
      if ($inputOrder->ShippingAddress != $input->Customer->CardAddress) {
        $shippingAddress = fillAddress($app->getAddress(),$inputOrder->ShippingAddress);
        $shippingAddress->setAddressID($app->run('new',$shippingAddress)['addressID']);
        $order->setAddressID($shippingAddress->getAddressID());
      } else {
        $order->setAddressID($address->getAddressID());
      }
      $order->setCustomerID($customer->getCustomerID())
        ->setDescription($inputOrder->OrderDescription);
      if (!empty($inputOrder->OrderItems)) {
        $order->setOrderID($app->run('new', $order)['orderID']);
        foreach ($inputOrder->OrderItems as $item) {
          $detail = $app->getOrderDetail();
          $detail->setOrderID($order->getOrderID())
            ->setName($item->Item1->Name)
            ->setQty($item->Item1->Quantity)
            ->setCost($item->Item1->CostPerItem);
          $detail->setOrderDetailsID($app->run('new', $detail)['orderDetailsID']);
        }
      }
    }
  }
}

function getName ($i, $string) {
  return explode(' ',$string)[$i];
}
function fillAddress($address, $string) {
  $string = explode(',', $string);
  $address->setStreet($string[0])
    ->setCity($string[1])
    ->setState($string[2])
    ->setZip($string[3]);
  return $address;
}
?>
