<?php
require_once 'DB.php';
class hierachy {
  private $_db;

  public function __construct() {
    $this->_db = DB::getInstance();
  }

  public function fullTree($parent) {
    $res = $this->_db->query(
      "SELECT node.name
      FROM categories AS node, categories AS parent
      WHERE node.left_node BETWEEN parent.left_node AND parent.right_node
      AND parent.name = ? ORDER BY node.left_node", [$parent])->results();

    return $res;
  }

}
