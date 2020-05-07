<?php
require_once 'DB.php';
class hierachy {
  private $_db;

  public function __construct() {
    $this->_db = DB::getInstance();
  }

  public function fullTree($parent) {
    $sql = "SELECT node.name
    FROM categories AS node, categories AS parent
    WHERE node.left_node BETWEEN parent.left_node AND parent.right_node
    AND parent.name = ? ORDER BY node.left_node";

    if(!$this->_db->query($sql, [$parent])->error()) {
      return $this->_db->results();
    }
    return ' ';
  }

}
