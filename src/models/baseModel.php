<?php

class baseModel
{
  protected $new = '';
  protected $newParams = array();
  protected $edit = '';
  protected $editParams = array();
  protected $remove = '';
  protected $removeParams = array();
  protected $fetch = '';
  protected $fetchParams = array();

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

  public function getNewParams()
  {
    return $this->newParams;
  }
  public function getEditParams()
  {
    return $this->editParams;
  }
  public function getRemoveParams()
  {
    return $this->removeParams;
  }
  public function getFetchParams()
  {
    return $this->fetchParams;
  }
  public function setNewParams ($value  = [])
  {
    if (!empty($value)) {
      $this->newParams = $value;
    }
    return $this;
  }
  public function setEditParams ($value  = [])
  {
    if (!empty($value)) {
      $this->editParams = $value;
    }
    return $this;
  }
  public function setRemoveParams ($value  = [])
  {
    if (!empty($value)) {
      $this->removeParams = $value;
    }
    return $this;
  }
  public function setFetchParams ($value  = [])
  {
    if (!empty($value)) {
      $this->fetchParams = $value;
    }
    return $this;
  }

  public function internalize ($data = []) {
    if (is_array($data)) {
      $data = (object)$data;
    }
    if (!empty($data)) {
      foreach ($data as $k => $v) {
        if (property_exists($this, ucfirst($k))) {
          $method = "set".ucfirst($k);
          $this->{$method}($v);
        }
      }
    }
    return $this;
  }
}
?>
