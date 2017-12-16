<?php
	
	/**
	 *
	 * Operates functions depending on actions
	 * on the customer list
	 *
	 * PHP version 7
	 *
	 */
	declare(strict_types = 1);
	
	class ListCustomer implements Lists
	{

		/**
		 * The main clause used to query the customers table
		 * 
		 * @var string the select clause for querying ordered by last name
		 */
		private $query = "SELECT * FROM customers ORDER BY last_name";

		/**
		 * The main clause used to insert data into customers table
		 * 
		 * @var string the insert clause for adding data into the table
		 */
		private $insert = "INSERT INTO customers (first_name, last_name, email, phone_num, rent) VALUES ";

		

		/**
		 * The main clause used to check deleted data from rentbook table
		 * 
		 * @var bool the result of deleting data from the table
		 */
		private $delete;

		/**
		 * The variable used to store the customer id and logdate
		 * 
		 * @var array stores customer id and logdate from customers table
		 */
		public $cust_id;

		/**
		 * The variable used to store the book id and quantity of books
		 * 
		 * @var array stores book id and quantity from books table
		 */
		private $book_id = array();

		/**
		 * The variable used for temporary assignment of main/sub clauses
		 * 
		 * @var string main and/or sub-clauses for model manipulation
		 */
		private $clause;

		/**
		 * Assignment of prepared model manipulation
		 * 
		 * @var string assigned the prepared pdo query/insert/delete/update methods
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
		 * This function queries the customers table of the database
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
		 * This function inserts data into the customers table and update the books table
		 * 
		 * @param string firstname, string lastname, string email, 
		 * string phonenum, array select hashed book id, string offer, array quantity 
		 *
		 * @return bool true if insertion success, false if fail
		 */
		public function insert(Builder $builder): bool
		{
			

			($this->cust->offer === 'rentbook') ?

			$this->clause = " ('".$builder->firstname."', '".$builder->lastname."',
							 '".$builder->email."', '".$builder->phone."', 1)" : 
			$this->clause = " ('".$builder->firstname."', '".$builder->lastname."',
							 '".$builder->email."', '".$builder->phone."', 0)";

			$this->insert .= $this->clause;

			$this->prep = $this->pdo->prepare($this->insert);

			if($this->prep){
				$this->prep->execute();

				$this->cust_id = $this->select_cust();

				$this->book_id = $this->select_book($builder->select, $builder->quantity);

				if($this->cust_id && $this->book_id){
					foreach($this->book_id as $book){
						
						(new ListBook())->update($book['id'], (int)$book['quan'], 'subtract');

						$coreBuilder = (new CoreBuilder())->setCustId($this->cust_id['customer_id'])
													  ->setBookId($book['id'])->setQuantity($book['quan'])
													  ->setDate($this->cust_id['logdate'])->build();

						($this->cust->offer === 'rentbook') ?
						(new ListRent())->insert($coreBuilder) : (new ListBuy())->insert($coreBuilder);
					}
				}

				return true;
			}

			return false;
		}

		/**
		 * This function deletes a row from the rentbook table
		 * 
		 * 
		 * @param string hashed rent_id, 
		 * 
		 * @return bool true if deletion success, false if fail
		 */
		public function delete($id): bool
		{

			$this->delete = (new ListRent())->delete($id);

			if($this->delete){
				
				return true;
			}

			return false;

		}

		/**
		 * This function selects a customer id and logdate from the customers table
		 * and assigns the array to the cust_id variable
		 * 
		 * @param void 
		 * 
		 * @return mixed the cust_id array if successful, false if failed
		 */
		private function select_cust()
		{

			$this->clause = "SELECT customer_id, logdate FROM customers ORDER BY customer_id DESC LIMIT 1";

			$this->prep = $this->pdo->prepare($this->clause);

				if($this->prep){
				$this->prep->execute();

				$this->cust_id = $this->prep->fetch(PDO::FETCH_ASSOC);

				return $this->cust_id;
			}
			return false;
		}

		/**
		 * This function creates arrays of book ids and book quantities
		 * and stores each created array in the book_id variable and returns it
		 * 
		 * @param string hashed book_id, array quantity storing int quantities, 
		 * 
		 * @return mixed the book_id array query success, false if fail
		 */
		private function select_book($select, $quantity)
		{
			for($i = 0; $i < count($select); $i++){
			$this->clause = "SELECT book_id FROM books WHERE SHA1(book_id) = '$select[$i]'";

			$this->prep = $this->pdo->prepare($this->clause);

				if($this->prep){
				$this->prep->execute();

				array_push($this->book_id, array('id' => $this->prep->fetch(PDO::FETCH_NUM)[0], 'quan' => (int)$quantity[$i] ));
				}
			}
				return $this->book_id;
			
			return false;
		}


	}

?>