<?php
	
	function redirect_to($url){
			header("Location: {$url}");
	}
	
	function open_db(){
		mysql_connect(HOST, DB_USER, DB_PASS);
	}
	
	function select_db($db){
		mysql_select_db($db);
	}
	
	function clean($var){
		return mysql_real_escape_string($var);
	}
	
	

?>
