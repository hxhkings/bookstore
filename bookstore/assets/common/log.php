<?php
	
	/**
	 * The class responsible for logging in and out
	 * of the admin user
	 *
	 * PHP version 7
	 */
	class Log
	{

		/**
		 * Stores the current session status
		 *
		 * @var int session status value
		 */
		private $stat;

		/**
		 * Assigned the key for session
		 * and cookie objects
		 *
		 * @var string session/cookie key
		 */
		private $id;



		public function __construct($id=NULL)
		{
			$this->id = $id;
	
		}
		/**
		 * Starts the session if not existing
		 *
		 * @param void
		 * @return void
		 */
		private function session_start()
		{
			$this->stat = session_status();

			if($this->stat === PHP_SESSION_NONE)
				session_start();
			
		}

		/**
		 * Checks if an employee(user) 
		 * or the admin is currently logged in
		 *
		 * @param void
		 * @return void
		 */
		public function login_check()
		{
			$this->session_start();

			
				if(isset($_COOKIE['admin_id'])){

					$_SESSION['admin_id'] = $_COOKIE['admin_id'];

				} elseif(isset($_COOKIE['user_id'])) {

					$_SESSION['user_id'] = $_COOKIE['user_id'];

				} 

		}

		/**
		 * Logs in the admin user
		 *
		 * @param void
		 * @return void
		 */
		public function login()
		{
			$this->session_start();

			if (!isset($_SESSION[$this->id])) {
	   
	     		if(isset($_COOKIE[$this->id])){
	      			 $_SESSION[$this->id] = $_COOKIE[$this->id];
	      		} else{
	        		
	       		 setcookie($this->id, uniqid(), time() + 
	       		 	(60 * 60 * 24 * 30),'/bookstore/');
	        		
	      		}
     
   			}
		}

		/**
		 * Logs out the admin user
		 *
		 * @param void
		 * @return void
		 */
		public function logout()
		{
			$this->session_start();

			if(isset($_SESSION[$this->id])){
		
				$_SESSION = array();
				if(isset($_COOKIE[session_name()])){
					unset($_COOKIE[session_name()]);
					setcookie(session_name(), '', time() - 3600, '/bookstore/');	
					
				}
				session_destroy();
			}
				
				unset($_COOKIE[$this->id]);
				setcookie($this->id, '', time()- 3600, '/bookstore/');
		}
	}





?>