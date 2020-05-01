<?php
require_once "src/app.php";
$app = new app();
$inputs = json_decode(file_get_contents('InputData.json'));

if (!empty($inputs)) {
  foreach ($inputs as $input) {
    $customer = $app->getCustomer();
    $customer->setFName(explode(' ',$input->Customer->Name)[0])
      ->setLName(explode(' ',$input->Customer->Name)[1])
      ->setEmail("test@email.com");
    $test = $app->run('new',$customer);
    $customer->setCustomerID($app->getLastID());
    echo $app->getLastID()."\r\n";

    $address = $app->getAddress();
    $addressString = explode(',', $input->Customer->CardAddress);
    if (isset($addressString[0])) {
      $address->setStreet($addressString[0]);
    }
    if (isset($addressString[1])) {
      $address->setCity($addressString[1]);
    }
    if (isset($addressString[2])) {
      $address->setState($addressString[2]);
    }
    if (isset($addressString[3])) {
      $address->setZip($addressString[3]);
    }
    $test = $app->run('new',$address);
    $address->setAddressID($app->getLastID());

    /*
    $customerAddr = $app->getCustomerAddressXRef();
    $customerAddr->setCustomerID($customer->getCustomerID())
      ->setAddressID($address->getAddressID())
      ->setName($input->Customer->Name);
    $test = $app->run('new', $customerAddr);
    */

    if (!empty($input->Customer->Order)) {
      $inputOrder = $input->Customer->Order;
      $order = $app->getOrder();
      $shippingAddressString = explode(',', $inputOrder->ShippingAddress);
      if ($shippingAddressString != $addressString) {
        $shippingAddress = $app->getAddress();
        if (isset($shippingAddressString[0])) {
          $shippingAddress->setStreet($shippingAddressString[0]);
        }
        if (isset($shippingAddressString[1])) {
          $shippingAddress->setCity($shippingAddressString[1]);
        }
        if (isset($shippingAddressString[2])) {
          $shippingAddress->setState($shippingAddressString[2]);
        }
        if (isset($shippingAddressString[3])) {
          $shippingAddress->setZip($shippingAddressString[3]);
        }
        $test = $app->run('new',$shippingAddress);
        $shippingAddress->setAddressID($app->getLastID());
        $order->setAddressID($shippingAddress->getAddressID());
      } else {
        $order->setAddressID($address->getAddressID());
      }
      $order->setCustomerID($customer->getCustomerID());
      $order->setDescription($inputOrder->OrderDescription);
      if (!empty($inputOrder->OrderItems)) {
        $test = $app->run('new', $order);
        $order->setOrderID($app->getLastID());
        foreach ($inputOrder->OrderItems as $item) {
          $detail = $app->getOrderDetail();
          $detail->setOrderID($order->getOrderID());
          if (isset($item->Item1->Name)) {
            $detail->setName($item->Item1->Name);
          }
          if (isset($item->Item1->Quantity)) {
            $detail->setQty($item->Item1->Quantity);
          }
          if (isset($item->Item1->CostPerItem)) {
            $detail->setCost($item->Item1->CostPerItem);
          }
          $test = $app->run('new', $detail);
        }
      }
    }
  }
}

?>
