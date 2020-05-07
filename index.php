<?php
  require_once 'hierachy.php';
  $h = new hierachy();
  // $data = $h->fullTree('electronics');
  // $data = $h->fullTree('televisions');
  // $data = $h->leafNodes();
  // $data = $h->singlePath('mp3 players');
  // $data = $h->getNodeDepth();
  // $data = $h->nodeDepth('flash');
  // print_r($data);
  // echo $data[0]['name'] . ' ' . $data[0]['depth'];
  //
  $data = $h->subTreeDepth('PORTABLE ELECTRONICS');
  foreach ($data as $value) {
    // print_r($value);
    echo $value['name'] . ' ' . $value['depth'] . '<br>';
  }
 ?>
