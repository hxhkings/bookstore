<?php
	
	/**
	 * The class used to check the validity
	 * of entered username and password
	 *
	 * PHP version 7
	 */
	class Admin extends AdminConfig
	{	

		/**
		 * The variable for username assignment
		 *
		 * @var string username entry
		 */
		private $username;

		/**
		 * The variable for password assignment
		 *
		 * @var string password entry
		 */
		private $password;

		/**
		 * Assigns the username and password
		 * to the defined private variables
		 *
		 * @param string username, string password
		 * @return void
		 */
		public function __construct($username, $password)
		{
			$this->username = $username;

			$this->password = $password;
		}

		/**
		 * Checks if the username and password are valid
		 *
		 * @param void
		 * @return bool true if valid, false if invalid
		 */
		public function check(): bool
		{
			if($this->admin_user === $this->username 
				&& $this->admin_pass === $this->password)
				return true;


			return false;
		}

	}


?>