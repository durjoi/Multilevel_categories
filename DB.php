<?php
class DB {
  private static $instance = null;
  private $_pdo, $_query, $_error = false, $_results;


  final private function __construct() {
    try {
      $this->_pdo = new PDO("mysql:host=localhost;dbname=list_model", 'root', '');
    } catch (PDOException $e) {
      die( "Connection Failed: ".$e->getMessage());
    }
  }

  public static function getInstance() {
    if(!isset(self::$instance)) {
      self::$instance = new DB;
    }
    return self::$instance;
  }


  public function query($sql, $params = []) {
    $this->_error = false;

    if($this->_query = $this->_pdo->prepare($sql)) {
      $x = 1;
      if(count($params)) {
        foreach ($params as $param) {
          $this->_query->bindValue($x, $param);
          $x++;
        }
      }

      if($this->_query->execute()) {
        $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
        // $this->_count = $this->_query->rowCount();
      } else {
        $this->_error = true;
      }
    }
    return $this;
  }

  public function results() {
    return $this->_results;
  }
}
