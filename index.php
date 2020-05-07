<?php
  require_once 'hierachy.php';
  $h = new hierachy();
  // $data = $h->fullTree('electronics');
  // $data = $h->fullTree('televisions');
  $data = $h->leafNodes();
  // print_r($data);

  foreach ($data as $value) {
    // print_r($value);
    echo $value['name'] . '<br>';
  }
 ?>
