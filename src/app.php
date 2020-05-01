<?php
require_once 'database.php';
require_once 'models/baseModel.php';
require_once 'models/Customer.php';
require_once 'models/Order.php';
require_once 'models/OrderDetail.php';
require_once 'models/CustomerAddressXRef.php';
require_once 'models/Address.php';
class app
{
  protected $db;

  public function __construct()
  {
    //These values would typically be in an env file but for this I will hardcode
    $this->db = new database (
      '127.0.0.1',
      'CustomerOrders',
      'app',
      'password'
    );
    $this->db->init();
  }

  public function getCustomer()
  {
    return new Customer();
  }
  public function getOrder()
  {
    return new Order();
  }
  public function getAddress()
  {
    return new Address();
  }
  public function getCustomerAddressXRef()
  {
    return new CustomerAddressXRef();
  }
  public function getOrderDetail()
  {
    return new OrderDetaiL();
  }

  public function run($state,$model)
  {
    if (!is_null($this->db)) {
      $method = null;
      $params = [];
      $result = null;
      switch ($state) {
        case 'new':
          $method = $model->getNew();
          $params = $model->getNewParams();
          break;
        case 'edit':
          $method = $model->getEdit();
          $params = $model->getEditParams();
          break;
        case 'remove':
          $method = $model->getRemove();
          $params = $model->getRemoveParams();
          break;
        case 'fetch':
          $method = $model->getFetch();
          $params = $model->getFetchParams();
          break;
      }
      if (!is_null($method) && !empty($params)) {
        $result = $this->db->run($method,$params);
      }
    }
    return $result;
  }

  public function progressStatus (Order $order, $newStatus)
  {
    $method = null;
    $result = null;
    if (!is_null($order->getOrderID())) {
      switch ($newStatus) {
        case 'Accepted':
          $method = "orderStatusAccepted";
          break;
        case 'Prepared':
          $method = "orderStatusPrepared";
          break;
        case 'Shipped':
          $method = "orderStatusShipped";
          break;
      }
      if (!is_null($method)) {
        $result = $this->db->run($method, [$order->getOrderID()]);
      }
      return $result;
    }
  }

  public function alert()
  {
    $records = $this->db->run("getOrdersForAlert");
    if (!empty($records)) {
      foreach ($records as $record) {
        $order = new Orders();
        $order->internalize($record);
        switch ($order->getStatus()) {
          case 'Accepted':
            //todo some logic to send newly accepted orders
            break;
          case 'Prepared':
            //todo see above for Prepared
            break;
          case 'Shipped':
            //todo see above for orderStatus
            break;
        }
        $this->db->run("orderAlerted", [$order->getOrderID()]);
      }
    }
  }

  public function ingestInputObject ($input)
  {
    $customer = $this->getCustomer();
    $customer->setFName(explode(' ', $input->Customer->Name)[0])
      ->setLName(explode(' ', $input->Customer->Name)[1])
      ->setEmail('test@email.com');
    $customer->setCustomerID($this->run('new',$customer)['customerID']);
    $address = $this->parseInputObjectFillAddress($this->getAddress(),$input->Customer->CardAddress);
    $address->setAddressID($this->run('new',$address)['addressID']);
    $customerAddr = $this->getCustomerAddressXRef();
    $customerAddr->setCustomerID($customer->getCustomerID())
      ->setAddressID($address->getAddressID())
      ->setName($input->Customer->Name);
    $test = $this->run('new', $customerAddr);
    if (!empty($input->Customer->Order)) {
      $inputOrder = $input->Customer->Order;
      $order = $this->getOrder();
      if ($inputOrder->ShippingAddress != $input->Customer->CardAddress) {
        $shippingAddress = $this->parseInputObjectFillAddress($this->getAddress(),$inputOrder->ShippingAddress);
        $shippingAddress->setAddressID($this->run('new',$shippingAddress)['addressID']);
        $order->setAddressID($shippingAddress->getAddressID());
      } else {
        $order->setAddressID($address->getAddressID());
      }
      $order->setCustomerID($customer->getCustomerID())
        ->setDescription($inputOrder->OrderDescription);
      if (!empty($inputOrder->OrderItems)) {
        $order->setOrderID($this->run('new', $order)['orderID']);
        foreach ($inputOrder->OrderItems as $item) {
          $detail = $this->getOrderDetail();
          $detail->setOrderID($order->getOrderID())
            ->setName($item->Item1->Name)
            ->setQty($item->Item1->Quantity)
            ->setCost($item->Item1->CostPerItem);
          $detail->setOrderDetailsID($this->run('new', $detail)['orderDetailsID']);
        }
      }
    }
  }

  private function parseInputObjectFillAddress($address,$string)
  {
    $string = explode(',', $string);
    $address->setStreet($string[0])
      ->setCity($string[1])
      ->setState($string[2])
      ->setZip($string[3]);
    return $address;
  }

  public function getOrdersForCustomerID($customerID, $deepScan = false)
  {
    $customerRecord = $this->db->run("getCustomerByID", [$customerID]);
    $customer = $this->getCustomer();
    $customer->internalize($customerRecord);
    if (!is_null($customer->getCustomerID())) {
      $customer->Orders = [];
      $orderRecords = $this->db->run("getCustomerOrders", [$customerID]);
      if (!empty($orderRecords)) {
        foreach ($orderRecords as $orderRecord) {
          $order = $this->getOrder();
          $order->internalize($orderRecord);
          if (!is_null($order->getOrderID())) {
            if ($deepScan) {
              $order->OrderDetails = [];
              $orderDetailsRecords = $this->db->run("getOrderDetailsByOrderID", [$order->getOrderID()]);
              if (!empty($orderDetailsRecords)) {
                foreach ($orderDetailRecords as $orderDetailRecord) {
                  $orderDetail = $this->getOrderDetail();
                  $orderDetail->internalize($orderDetailRecord);
                  if (!is_null($orderDetail->getOrderDetailsID())) {
                    $order->OrderDetails[] = $orderDetail;
                  }
                }
              }
            }
            $customer->Orders[] = $order;
          }
        }
      }
    }
    return $customer;
  }
}
