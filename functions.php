<?php 
require_once(dirname(__FILE__).'/mvc/base.php');

Router::set('produto', 'super/.*', array('controller' => 'Category' , 'method'=>'lista'));
Router::set('produto', 'produtos/.*', array('controller' => 'Category' , 'method'=>'produtos'));
Router::set('user',    'super/produtos/',    array('id' => '\d+'));

?>