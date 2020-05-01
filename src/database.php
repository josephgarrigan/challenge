<?php

class database {

  protected $db = null;
  protected $host = null;
  protected $dbname  = null;
  protected $user = null;
  protected $pass = null;
  private $options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
  ];

  public function __construct ($host = null, $dbname = null, $user = null, $pass = null)
  {
    $this->setHost($host);
    $this->setDbname($dbname);
    $this->setUser($user);
    $this->setPass($pass);
  }

  public function setHost ($host) {
    if (!is_null($host)) {
      $this->host = $host;
    }
    return $this;
  }

  public function setDbname ($dbname) {
    if (!is_null($dbname)) {
      $this->dbname = $dbname;
    }
    return $this;
  }

  public function setUser ($user) {
    if (!is_null($user)) {
      $this->user = $user;
    }
    return $this;
  }

  public function setPass ($pass) {
    if (!is_null($pass)) {
      $this->pass = $pass;
    }
    return $this;
  }

  public function init ()
  {
    try {
      $dsn = "mysql:host=".$this->host.";dbname=".$this->dbname.";charset=utf8";
      $this->db = new PDO($dsn,$this->user,$this->pass,$this->options);
    } catch (PDOExcetption $e) {
      die($e->getMessage());
      exit;
    }
    return $this;
  }

  public function run ($procedure, $params = [])
  {
    try {
      $paramString = "";
      if (!empty($params)) {
        $paramString = "'".rtrim(implode('\',\'',$params),',')."'";
      }
      $string = "CALL $procedure ( $paramString )";
      echo $string . "\r\n";
      $stmt = $this->db->prepare($string);
      $counter = 1;
      if (!empty($params)) {
        foreach ($params as $param) {
          $stmt->bindValue($counter, $param);
        }
      }
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOExcetption $e) {
      $result = $e->getMessage();
    }
    return $result;
  }

  public function getLastInsertID()
  {
    return $this->db->lastinsertID();
  }
}
?>
