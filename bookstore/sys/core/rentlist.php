<?php

	/**
	 *
	 * Operates functions depending on actions
	 * necessary on the renters list
	 *
	 * PHP version 7
	 *
	 */
	declare(strict_types = 1);
	
	class ListRent implements Lists
	{

		/**
		 * The main clause used to query the rentbook table
		 * joined by the books table or both books and customers table
		 * depending on the value assigned to file variable
		 * 
		 * @var string the select clause for querying
		 */
		private $query = "SELECT * FROM rentbook";

		/**
		 * The main clause used to insert data into rentbook table
		 * 
		 * @var string the insert clause for adding data into the table
		 */
		private $insert = "INSERT INTO rentbook (customer_id, book_id, quantity, borrow_date) VALUES ";

		/**
		 * The main clause used to delete data from rentbook table
		 * 
		 * @var string the delete clause for deleting data from the table
		 */
		private $delete = "DELETE FROM rentbook";

		/**
		 * The variable used for temporary assignment of main/sub clauses
		 * 
		 * @var string main and/or sub-clauses for model manipulation
		 */
		private $clause;

		/**
		 * The variable assigned a value for deciding upon
		 * which type of querying will be used
		 *
		 * @var mixed (string either 'customers' or 'books',
		 * NULL if no value is assigned) serves as deciding factor 
		 * for query type
		 */
		private $file;

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
		 * and assigns either a string or default NULL value to file variable
		 * 
		 * @param mixed (string file if assigned a param or null if not)
		 * @return void
		 */
		public function __construct($file = NULL)
		{
			try{
			$this->pdo = (new Connection())->MySQLConnect();
			}
			catch(PDOException $e){
				die($e->getMessage());
				exit;
			}

			$this->file = $file;
		}

		/**
		 * This function creates a join query including rentbook table 
		 * and books table, which may include the customers table 
		 * if the file variable is equal to 'customers'
		 * 
		 * @param void
		 * @return mixed the associated array of data if successful, false if failed
		 */
		public function query()
		{
			if($this->file === 'books'){
				$this->query = "SELECT b.title, b.author, SUM(b.price * rb.quantity) AS total_price, SUM(rb.quantity) AS total_quantity FROM books AS b INNER JOIN rentbook AS rb ON b.book_id = rb.book_id GROUP BY rb.book_id ORDER BY b.title";
			} elseif($this->file === 'customers'){
				$this->query = "SELECT CONCAT(c.first_name, ' ', c.last_name) AS fullname, c.logdate, b.title, b.author, rb.quantity, rb.rent_id, rb.book_id FROM customers AS c INNER JOIN rentbook AS rb ON c.customer_id = rb.customer_id INNER JOIN books AS b ON b.book_id = rb.book_id ORDER BY fullname";
			}
			$this->prep = $this->pdo->prepare($this->query);

			if($this->prep){
				$this->prep->execute();

				return $this->prep->fetchall(PDO::FETCH_ASSOC);
			}

			return false;
		}

		/**
		 * This function inserts data into the rentbook table 
		 *
		 * @param int customer id, int book id, int quantity, string borrow date, 
		 * 
		 * @return bool true if insertion success, false if fail
		 */
		public function insert(Builder $builder): bool
		{

			$this->clause = " ('".$builder->cust_id."', '".$builder->book_id."', '".
								$builder->quantity."', '".$builder->date."')";

			$this->insert .= $this->clause;

			$this->prep = $this->pdo->prepare($this->insert);

			if($this->prep){
				$this->prep->execute();

				return true;
			}

			return false;
		}

		/**
		 * This function deletes a row from the rentbook table
		 * 
		 * 
		 * @param string hashed rent_id 
		 * 
		 * @return bool true if deletion success, false if fail
		 */
		public function delete($id): bool
		{

			$this->clause = " WHERE SHA1(rent_id) = '$id'";

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





