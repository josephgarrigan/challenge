<?php

class OrderDetail extends baseModel
{
  protected $orderID = null;
  protected $name = null;
  protected $qty = null;
  protected $cost = null;
  protected $orderDetailsID = null;
  protected $active = 0;
  protected $createDate = null;
  protected $updateDate = null;

  public function __construct()
  {
    $this->setNew('newOrderDetails');
    $this->setEdit('updateOrderDetails');
    $this->setRemove('deleteOrderDetails');
    $this->setFetch('getOrderDetailsByID');
  }

  public function setOrderID ($value) {
    if (!is_null($value)) {
      $this->orderID = $value;
    }
    return $this;
  }
  public function setName ($value) {
    if (!is_null($value)) {
      $this->name = $value;
    }
    return $this;
  }
  public function setQty ($value) {
    if (!is_null($value)) {
      $this->qty = $value;
    }
    return $this;
  }
  public function setCost ($value) {
    if (!is_null($value)) {
      $this->cost = $value;
    }
    return $this;
  }
  public function setOrderDetailsID ($value) {
    if (!is_null($value)) {
      $this->orderDetailsID = $value;
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
  public function getName()
  {
    return $this-name;
  }
  public function getqty()
  {
    return $this->qty;
  }
  public function getcost()
  {
    return $this->cost;
  }
  public function getOrderDetailsID()
  {
    return $this->orderDetailsID;
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
      $this->getOrderID(),
      $this->getName(),
      $this->getQty(),
      $this->getCost(),
      $this->getOrderDetailsID()
    ];
  }
  public function getEditParams()
  {
    return [
      $this->getOrderDetailsID(),
      $this->getName(),
      $this->getQty(),
      $this->getCost()
    ];
  }
  public function getRemoveParams()
  {
    return [
      $this->getOrderDetailsID()
    ];
  }
  public function getFetchParams()
  {
    return [
      $this->getOrderDetailsID()
    ];
  }
}
