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
}
