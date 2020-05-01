<?php

class Order extends baseModel
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
    $this->setNew('newOrder');
    $this->setEdit('updateOrder');
    $this->setRemove('deleteOrder');
    $this->setFetch('getOrderByID');
  }

  public function setOrderID ($value) {
    if (!is_null($value)) {
      $this->orderID = $value;
    }
    return $this;
  }
  public function setDescription ($value) {
    if (!is_null($value)) {
      $this->description = $value;
    }
    return $this;
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
  public function setStatus ($value) {
    if (!is_null($value)) {
      $this->status = $value;
    }
    return $this;
  }
  public function setAlert ($value) {
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

  public function getOrderID()
  {
    return $this->orderID;
  }
  public function getDescription()
  {
    return $this->description;
  }
  public function getCustomerID()
  {
    return $this->customerID;
  }
  public function getAddressID()
  {
    return $this->addressID;
  }
  public function getStatus()
  {
    return $this->status;
  }
  public function getAlert()
  {
    return $this->alert;
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
      $this->getCustomerID(),
      $this->getAddressID(),
      $this->getDescription(),
      $this->getOrderID()
    ];
  }
  public function getEditParams()
  {
    return [
      $this->getOrderID(),
      $this->getDescription(),
      $this->getCustomerID(),
      $this->getAddressID()
    ];
  }
  public function getRemoveParams()
  {
    return [
      $this->getOrderID()
    ];
  }
  public function getFetchParams()
  {
    return [
      $this->getOrderID()
    ];
  }
}
