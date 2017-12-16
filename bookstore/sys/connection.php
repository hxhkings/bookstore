<?php
	
	/**
	 * The class used to connect to the database
	 *
	 * PHP version 7
	 */
	class Connection extends Config
	{
		/**
		 * The variable that stores the host and dbname
		 * configuration for a certain database server
		 * 
		 * @var string database server config
		 */
		private $dsn;

		/**
		 * The variable assigned the PDO instance
		 *
		 * @var object PDO instance
		 */
		public $pdo;
		
		/**
		 * This function creates a PDO object 
		 * assigned to the pdo variable
		 *
		 * @param void
		 * @return object the PDO instance 
		 * for mysql connection
		 */
		public function MySQLConnect(): PDO 
		{
			$this->dsn = 'mysql:host=' . $this->DB_HOST .
							';dbname=' . $this->DB_NAME;

			if ($this->dsn) {

				$this->pdo = new PDO($this->dsn, $this->DB_USER, $this->DB_PASS);
			}

			return $this->pdo;
		}
	}




?>