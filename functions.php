<?php 
require_once(dirname(__FILE__).'/mvc/base.php');

Router::set('produto', 'super/.*', array('controller' => 'Category' , 'method'=>'lista'));
Router::set('produto', 'super/.*', array('controller' => 'Category' , 'method'=>'lista2'));
Router::set('user',    'super/produtos/',    array('id' => '\d+'));

?>