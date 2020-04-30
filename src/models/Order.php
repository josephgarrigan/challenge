<?php

class Address
{
  protected $orderID = null;
  protected $description = null;
  protected $customerID = null;
  protected $addressID = null;
  protected $status = null;
  protected $alert = null;
  protected $active = 0;
  protected $createDate = null;
  protected $updateDate = null;

  public function __construct()
  {
    //
  }

  public function setOrderID ($value) {
    if (!is_null($value)) {
      $this->OrderID = $value;
    }
    return $this;
  }
  public function setdescription ($value) {
    if (!is_null($value)) {
      $this->description = $value;
    }
    return $this;
  }
  public function setcustomerID ($value) {
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
  public function setstatus ($value) {
    if (!is_null($value)) {
      $this->status = $value;
    }
    return $this;
  }
  public function setalert ($value) {
    if (!is_null($value)) {
      $this->alert = $value;
    }
    return $this;
  }
  public function setActive ($value = false) {
    if ($value) {
      $this->active = $value;
    }
    return $this;
  }
  public function setCreateDate ($value) {
    if (!is_null($value)) {
      $this->createDate = $value;
    }
    return $this;
  }
  public function setUpdateDate ($value) {
    if (!is_null($value)) {
      $this->updateDate = $value;
    }
    return $this;
  }
  public function setdescription ($value) {
    if (!is_null($value)) {
      $this->description = $value;
    }
    return $this;
  }
}
