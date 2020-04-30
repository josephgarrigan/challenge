<?php
require_once 'database.php';
require_once 'models/baseModel.php';
require_once 'models/Customer.php';
require_once 'models/Order.php';
require_once 'models/CustomerAddressXRef.php';
require_once 'models/Address.php';
class app
{
  protected $db = null;

  public function __concstruct()
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

  public function add($type, $data)
  {
    $model = null;
    $params = [];
    switch ($type) {
      case 'customer':
        $model = new Customer();
        $params = [
          $data->fName,
          $data->lName,
          $data->email
        ];
        break;
      case 'order':
        $model = new Order();
        $params = [
          $data->description,
          $data->customerID,
          $data->addressID
        ]
        break;
      case 'customerAddress':
        $model = new CustomerAddressXRef();
        $params = [
          $data->customerID,
          $data->addressID,
          $data->name
        ];
        break;
      case 'address':
        $model = new Address();
        $params = [
          $data->street,
          $data->street2,
          $data->city,
          $data->stateAbbr,
          $data->zip
        ];
        break;
    }
    if (!is_null($model)) {
      $this->db->run($model->getNew(),$params);
    }
  }
}
