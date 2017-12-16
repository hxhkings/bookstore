<?php
	
	/**
	 *
	 * Operates functions depending on actions
	 * on the user list
	 *
	 * PHP version 7
	 *
	 */
	declare(strict_types = 1);
	
	class ListUser implements Lists
	{

		/**
		 * The main clause used to query the users table
		 * 
		 * @var string the select clause for querying ordered by last name 
		 */
		private $query = "SELECT * FROM users ORDER BY last_name";

	

		/**
		 * The main clause used to insert data into users table
		 * 
		 * @var string the insert clause for adding data into the table
		 */
		private $insert = "INSERT INTO users (username, password, first_name, last_name, age, email) VALUES ";

		/**
		 * The main clause used to delete data from users table
		 * 
		 * @var string the delete clause for deleting data from the table
		 */
		private $delete = "DELETE FROM users";

		/**
		 * The variable used for temporary assignment of main/sub clauses
		 * 
		 * @var string main and/or sub-clauses for model manipulation
		 */
		private $clause;

		/**
		 * Assignment of prepared model manipulation
		 * 
		 * @var string assigned the prepared pdo query/insert/delete methods
		 */
		private $prep;

		/**
		 * The variable used to store the PDO instance
		 * 
		 * @var object storage of PDO object connection instance
		 */
		private $pdo;

		/**
		 * This constructor assigns the PDO instance to the pdo variable
		 * 
		 * @param void
		 * @return void
		 */
		public function __construct()
		{
			
			try{
			$this->pdo = (new Connection())->MySQLConnect();
			}
			catch(PDOException $e){
				die($e->getMessage());
				exit;
			}
		}

		/**
		 * This function queries the users table of the database
		 * 
		 * @param void
		 * @return mixed the associated array of data if successful, false if failed
		 */
		public function query()
		{
			
			$this->prep = $this->pdo->prepare($this->query);

			if($this->prep){
				$this->prep->execute();

				return $this->prep->fetchall(PDO::FETCH_ASSOC);
			}

			return false;
		}

		/**
		 * This function inserts data into the users table 
		 *
		 * @param string firstname, string lastname, int age, string email, 
		 * 
		 * @return bool true if insertion success, false if fail
		 */
		public function insert(Builder $builder): bool
		{
			
			
			$this->clause = " ('".$builder->username."', SHA1('".$builder->password."'),
								'".$builder->firstname."', '".$builder->lastname."',
								'".$builder->age."', '".$builder->email."')";

			$this->insert .= $this->clause;

			$this->prep = $this->pdo->prepare($this->insert);

			if($this->prep){
				$this->prep->execute();

				return true;
			}

			return false;
		}

		/**
		 * This function deletes a row from the users table
		 * 
		 * 
		 * @param string hashed user_id 
		 * 
		 * @return bool true if deletion success, false if fail
		 */
		public function delete($id): bool
		{

			$this->clause = " WHERE SHA1(user_id) = '$id'";

			$this->delete .= $this->clause;

			$this->prep = $this->pdo->prepare($this->delete);

			if($this->prep){
				$this->prep->execute();

				return true;
			}

			return false;

		}

	}


?>