<?php
require_once 'DB.php';
class hierachy {
  public function test() {
    $db = DB::getInstance()->query('SELECT * FROM category');
    print_r($db);
  }
}
