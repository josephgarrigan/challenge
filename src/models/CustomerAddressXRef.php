<?php

class CustomerAddressXRef extends baseModel
{
  protected $customerID = null;
  protected $addressID = null;
  protected $name = null;

  public function __construct()
  {
    $this->setNew('newCustomerAddressXref');
    $this->setEdit();
    $this->setRemove('deleteCustomerAddressXRef');
    $this->setFetch();
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

  public function getNewParams ()
  {
    return [
      $this->getCustomerID(),
      $this->getAddressID(),
      $this->getName()
    ];
  }
  public function getEditParams()
  {
    return [];
  }
  public function getRemoveParams()
  {
    return [
      $this->getCustomerID(),
      $this->getAddressID()
    ];
  }
  public function getFetchParams()
  {
    return [
      $this->getCustomerID(),
      $this->getAddressID()
    ];
  }
}
