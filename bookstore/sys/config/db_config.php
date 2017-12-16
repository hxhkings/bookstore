<?php
	
	// Stores the configuration requirements
	// for database connection
	abstract class Config 
	{
		protected $DB_HOST = 'localhost';
		protected $DB_NAME = 'bookstore';
		protected $DB_USER = 'hxhking';
		protected $DB_PASS = 'hunter1hunter';

		abstract public function MySQLConnect(): PDO;
		
	}




?>