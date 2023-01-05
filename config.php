<?php

	class config  
	{	
		public $host = "";
		public $user = "";
		public $pass = "";
		public $db = "";

		function __construct($host, $user, $pass, $db) 
		{
			$this->host = $host;
			$this->user  = $user;
			$this->pass = $pass;
			$this->db = $db;
		}
	}

?>