<?php

class databee {
	
	var $host = DB_HOST;
	var $username = DB_USERNAME;
	var $password = DB_PASSWORD;
	var $db = DB_DATABASE;
	var $result = "";
	
	function __construct() {
			$this->connect();
		}
	
	function connect() {
		$con = mysql_connect($this->host, $this->username, $this->password);
		mysql_select_db($this->db, $con) or die(mysql_error());
	}
	
	function query($query) {
		$result = mysql_query($query) or die(mysql_error());
		return $result;
	}
	
	function execute($query) {
		mysql_query("SET time_zone = 'America/Chicago';");
		$result = mysql_query($query) or die(mysql_error());

		return mysql_affected_rows();
	}
	
	

}