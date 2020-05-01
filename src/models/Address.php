<?php

class Address extends baseModel
{
  protected $addressID = null;
  protected $street = null;
  protected $street2 = null;
  protected $city = null;
  protected $state = null;
  protected $zip = null;
  protected $active = 0;
  protected $createDate = null;
  protected $updateDate = null;

  public function __construct()
  {
    $this->setNew('newAddress');
    $this->setEdit('updateAddress');
    $this->setRemove('deleteAddress');
    $this->setFetch('getAddressByID');
  }

  public function setAddressID ($value) {
    if (!is_null($value)) {
      $this->addressID = $value;
    }
    return $this;
  }
  public function setStreet ($value) {
    if (!is_null($value)) {
      $this->street = $value;
    }
    return $this;
  }
  public function setStreet2 ($value) {
    if (!is_null($value)) {
      $this->street2 = $value;
    }
    return $this;
  }
  public function setCity ($value) {
    if (!is_null($value)) {
      $this->city = $value;
    }
    return $this;
  }
  public function setState ($value) {
    if (!is_null($value)) {
      $this->state = $value;
    }
    return $this;
  }
  public function setZip ($value) {
    if (!is_null($value)) {
      $this->zip = $value;
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

  public function getAddressID()
  {
    return $this->addressID;
  }
  public function getStreet()
  {
    return $this->street;
  }
  public function getStreet2()
  {
    return $this->street2;
  }
  public function getCity()
  {
    return $this->city;
  }
  public function getState ()
  {
    return $this->state;
  }
  public function getZip()
  {
    return $this->zip;
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
      $this->getStreet(),
      $this->getStreet2(),
      $this->getCity(),
      $this->getState(),
      $this->getZip(),
      '@addressID'
    ];
  }
  public function getEditParams()
  {
    return [
      $this->getStreet(),
      $this->getStreet2(),
      $this->getCity(),
      $this->getState(),
      $this->getZip()
    ];
  }
  public function getRemoveParams()
  {
    return [
      $this->getAddressID()
    ];
  }
  public function getFetchParams()
  {
    return [
      $this->getAddressID()
    ];
  }
}
