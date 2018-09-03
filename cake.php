<?php
	//All the operations about cake

	require_once 'debug.php';
	require_once 'database.php';

	function get_cake_type($value){
	    $arr = array('Mango Mousse', 'Passion Mousse', 'Sweet Wine', 'Durian Crazy', 'Rum Cheese', 'Black & White', 'Teatime', 'Chestnum Cream');
    	return $arr[$value - 1];
	}
	
	function get_cake_size($value){
	    $arr = array('Small', 'Medium', 'Large');
    	return $arr[$value - 1];
	}
	
	function arr_to_num($arr){
		$ret = 0;
		foreach ($arr as $x) $ret += 1 << $x;
		return $ret;
	}
?>