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
    return new OrderDetails();
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
}
