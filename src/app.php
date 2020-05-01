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
}
