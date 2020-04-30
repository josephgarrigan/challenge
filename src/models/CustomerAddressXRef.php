<?php

class CustomerAddressXRef extends baseModel
{
  protected $customerID = null;
  protected $addressID = null;
  protected $name = null;

  public function __construct()
  {
    //
  }

  public function setCustomerID ($value) {
    if (!is_null($value)) {
      $this->customerID = $value;
    }
    return $this;
  }
  public function setAddressID ($value) {
    if (!is_null($value)) {
      $this->addressID = $value;
    }
    return $this;
  }
  public function setName ($value) {
    if (!is_null($value)) {
      $this->name = $value;
    }
    return $this;
  }
}
