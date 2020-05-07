<?php
require_once 'DB.php';
class hierachy {
  private $_db;

  public function __construct() {
    $_db = DB::getInstance();
  }

}
