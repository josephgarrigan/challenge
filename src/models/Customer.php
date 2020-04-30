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
    $this->setNew('newCustomer');
    $this->setEdit('updateCustomer');
    $this->setRemove('deleteCustomer');
    $this->setFetch('getCustomerByID');
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

  public function getCustomerID()
  {
    return $this->customerID;
  }
  public function getFName()
  {
    return $this->fName;
  }
  public function getLName()
  {
    return $this->lName;
  }
  public function getEmail()
  {
    return $this->email;
  }
  public function getActive()
  {
    return $this->active;
  }
  public function getCreateDate()
  {
    return $this->createDate;
  }
  public function getUpdateDate()
  {
    return $this->updateDate;
  }

  public function getNewParams ()
  {
    return [
      $this->getFName(),
      $this->getLName(),
      $this->getEmail()
    ];
  }
  public function getEditParams()
  {
    return [
      $this->getCustomerID(),
      $this->getFName(),
      $this->getLName(),
      $this->getEmail()
    ];
  }
  public function getRemoveParams()
  {
    return [
      $this->getCustomerID()
    ];
  }
  public function getFetchParams()
  {
    return [
      $this->getCustomerID()
    ];
  }
}

 ?>
