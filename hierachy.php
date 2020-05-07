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

  public function leafNodes() {
    $sql = "SELECT name FROM categories WHERE right_node = left_node+1";
    if(!$this->_db->query($sql)->error()) {
      return $this->_db->results();
    }
    return ' ';
  }

  public function singlePath($node_name) {
    $sql = "SELECT parent.name
            FROM categories AS node, categories AS parent
            WHERE node.left_node BETWEEN parent.left_node AND parent.right_node
            AND node.name = ? ORDER BY parent.left_node";
    if(!$this->_db->query($sql, [$node_name])->error()) {
      return $this->_db->results();
    }
    return ' ';
  }


  public function getNodeDepth() {
    $sql = "SELECT node.name, (COUNT(parent.name)-1) AS depth
            FROM categories AS node, categories AS parent
            WHERE node.left_node BETWEEN parent.left_node AND parent.right_node
            GROUP BY node.name
            ORDER BY node.left_node";

    if(!$this->_db->query($sql)->error()) {
      return $this->_db->results();
    }
    return ' ';
  }

  public function singelNodeDepth($node_name) {
    $sql = "SELECT node.name, (COUNT(parent.name)-1) AS depth
            FROM categories AS node, categories AS parent
            WHERE node.left_node BETWEEN parent.left_node AND parent.right_node
            AND node.name = ?
            GROUP BY node.name
            ORDER BY node.left_node";
    if(!$this->_db->query($sql, [$node_name])->error()) {
      return $this->_db->results();
    }
    return ' ';
  }

  public function subTreeDepth($node_name) {
    $sql = "SELECT node.name, (COUNT(parent.name)-(sub_tree.depth+1)) AS depth
            FROM categories AS node,
              categories AS parent,
                categories AS sub_parent,
                (
              	SELECT node.name, (COUNT(parent.name)-1) AS depth
                    FROM categories AS node,
              		categories AS parent
                        WHERE node.left_node BETWEEN parent.left_node AND parent.right_node
                        AND node.name = ?
                        GROUP BY node.name
                        ORDER BY node.left_node
                ) AS sub_tree
            WHERE node.left_node BETWEEN parent.left_node AND parent.right_node
            AND node.left_node BETWEEN sub_parent.left_node AND sub_parent.right_node
            AND sub_parent.name = sub_tree.name
            GROUP BY node.name
            ORDER BY node.left_node";

      if(!$this->_db->query($sql, [$node_name])->error()) {
        return $this->_db->results();
      }
      return ' ';
  }

  public function getLocalSubNodes($node_name) {
    $sql = "SELECT node.name, (COUNT(parent.name)-(sub_tree.depth+1)) AS depth
            FROM categories AS node,
              categories AS parent,
                categories AS sub_parent,
                (
              	SELECT node.name, (COUNT(parent.name)-1) AS depth
                    FROM categories AS node,
              		categories AS parent
                        WHERE node.left_node BETWEEN parent.left_node AND parent.right_node
                        AND node.name = ?
                        GROUP BY node.name
                        ORDER BY node.left_node
                ) AS sub_tree
            WHERE node.left_node BETWEEN parent.left_node AND parent.right_node
            AND node.left_node BETWEEN sub_parent.left_node AND sub_parent.right_node
            AND sub_parent.name = sub_tree.name
            GROUP BY node.name
            HAVING depth <= 1
            ORDER BY node.left_node";

      if(!$this->_db->query($sql, [$node_name])->error()) {
        return $this->_db->results();
      }
      return ' ';
  }

}
