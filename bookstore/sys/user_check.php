<?php

	

	class User
	{

		private $username;

		private $password;

		private $pdo;

		private $id;

		private $query;

		public function __construct($username, $password)
		{
			$this->username = $username;

			$this->password = sha1($password);
			

			try{
			$this->pdo = (new Connection())->MySQLConnect();
			}
			catch(PDOException $e){
				die($e->getMessage());
				exit;
			}
		}

		public function check() 
		{
			if($this->query() && count($this->query()) === 1){
				
				foreach($this->query() as $user){
					
					$this->id = $user['user_id'];
				}
					if($this->id)
				return sha1($this->id);
				}

			return false;
		}

		public function query()
		{
			$this->query = "SELECT user_id FROM users WHERE username = '$this->username' AND
							 password = '$this->password'";
			$this->prep = $this->pdo->prepare($this->query);

			if($this->prep){
				$this->prep->execute();
				return $this->prep->fetchall(PDO::FETCH_ASSOC);
			}
			return false;
		}
	}







?>