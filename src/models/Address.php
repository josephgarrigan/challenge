<?php

class Address
{
  protected $addressID = null;
  protected $street = null;
  protected $street2 = null;
  protected $city = null;
  protected $zip = null;
  protected $active = 0;
  protected $createDate = null;
  protected $updateDate = null;

  public function __construct()
  {
    //
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
  public function setstreet ($value) {
    if (!is_null($value)) {
      $this->street = $value;
    }
    return $this;
  }
}
