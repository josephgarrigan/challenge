<?php

class baseModel
{
  protected $new = '';
  protected $edit = '';
  protected $remove = '';
  protected $fetch = '';

  public function getNew()
  {
    return $this->new;
  }
  public function getEdit()
  {
    return $this->edit;
  }
  public function getRemove()
  {
    return $this->remove;
  }
  public function getFetch()
  {
    return $this->fetch;
  }
  public function setNew ($value)
  {
    if (!is_null($value)) {
      $this->new = $value;
    }
    return $this;
  }
  public function setEdit ($value)
  {
    if (!is_null($value)) {
      $this->edit = $value;
    }
    return $this;
  }
  public function setRemove ($value)
  {
    if (!is_null($value)) {
      $this->remove = $value;
    }
    return $this;
  }
  public function setFetch ($value)
  {
    if (!is_null($value)) {
      $this->fetch = $value;
    }
    return $this;
  }

}
?>
