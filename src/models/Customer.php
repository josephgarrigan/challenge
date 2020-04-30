<?php

class Customer extends baseModel
{
  protected $customerID = null;
  protected $fName = null;
  protected $lName = null;
  protected $email = null;
  protected $active = 0;
  protected $createDate = null;
  protected $updateDate = null;

  public function __construct()
  {
    $this->setNew();
    $this->setEdit();
    $this->setRemove();
    $this->setFetch();
  }

  public function setCustomerID ($value) {
    if (!is_null($value)) {
      $this->customerID = $value;
    }
    return $this;
  }
  public function setFName ($value) {
    if (!is_null($value)) {
      $this->fName = $value;
    }
    return $this;
  }
  public function setLName ($value) {
    if (!is_null($value)) {
      $this->lName = $value;
    }
    return $this;
  }
  public function setEmail ($value) {
    if (!is_null($value)) {
      $this->email = $value;
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
  public function setFName ($value) {
    if (!is_null($value)) {
      $this->fName = $value;
    }
    return $this;
  }
}

 ?>
