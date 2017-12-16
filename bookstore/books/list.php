<?php
	
	/**
	 *
	 * Operates functions depending on actions
	 * on the book list
	 *
	 * PHP version 7
	 *
	 */
	declare(strict_types = 1);
	
	class ListBook implements Lists
	{

		/**
		 * The main clause used to query the books table
		 * 
		 * @var string the select clause for querying ordered by title 
		 */
		private $query = "SELECT * FROM books ORDER BY title";

		/**
		 * The main clause used to insert data into books table
		 * 
		 * @var string the insert clause for adding data into the table
		 */
		private $insert = "INSERT INTO books (title, author, quantity, price) VALUES ";

		

		/**
		 * The main clause used to delete data from books table
		 * 
		 * @var string the delete clause for deleting data from the table
		 */
		private $delete = "DELETE FROM books";

		/**
		 * The variable used for temporary assignment of main/sub clauses
		 * 
		 * @var string main and/or sub-clauses for model manipulation
		 */
		private $clause;

		/**
		 * The variable used for testing if the added book
		 * is already inserted in the table
		 * 
		 * @var array stores the data queried from the book table
		 * stores null if no such book exists yet from the table
		 */
		private $test;

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
		 * This function queries the books table of the database
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
		 * This function inserts data into the books table 
		 * or updates the quantity column of books table
		 * if the book entry is already existing
		 *
		 * @param string title, string author, int quantity, float price, 
		 * 
		 * @return bool true if insertion success, false if fail
		 */
		public function insert(Builder $builder): bool
		{



			$this->test = $this->testSelect($builder->title, $builder->author, $builder->price);

			if($this->test && count($this->test[0]['book_id']) === 1){
	
				return $this->update(sha1($this->test[0]['book_id']), $builder->quantity);
				
			} else{

			$this->clause = " ('".$builder->title."', '".$builder->author."', 
								'".$builder->quantity."', '".$builder->price."')";

			$this->insert .= $this->clause;

			$this->prep = $this->pdo->prepare($this->insert);

			if($this->prep){
				$this->prep->execute();

				return true;
			}

			return false;
			}
			
		}

		/**
		 * This function deletes a row from the books table
		 * 
		 * 
		 * @param string hashed book_id 
		 * 
		 * @return bool true if deletion success, false if fail
		 */
		public function delete($id): bool
		{

			$this->clause = " WHERE SHA1(book_id) = '$id'";

			$this->delete .= $this->clause;

			$this->prep = $this->pdo->prepare($this->delete);

			if($this->prep){
				$this->prep->execute();

				return true;
			}

			return false;
		}

		/**
		 * This function selects a book_id from books table
		 * if the entry exists
		 * 
		 * @param string title, string author, int price
		 * @return mixed (book id if existing, false if not)
		 */
		private function testSelect($title, $author, $price)
		{
			$this->clause = "SELECT book_id FROM books WHERE title LIKE '$title' AND author LIKE '$author'
							 AND price = '$price' LIMIT 1";

			$this->prep = $this->pdo->prepare($this->clause);

			
			if($this->prep){
				$this->prep->execute();

				return $this->prep->fetchall(PDO::FETCH_ASSOC);
			}
			return false;

		}

		/**
		 * This function updates the quantity column of books table
		 * 
		 * @param int quantity of books to add
		 * @return bool
		 */
		public function update($id, int $quantity, $process=NULL): bool 
		{
			if($process === 'subtract'){
				$this->clause = "UPDATE books SET quantity = (quantity - $quantity) WHERE book_id = '$id'";
			}else{

				$this->clause = "UPDATE books SET quantity = quantity + $quantity WHERE SHA1(book_id) = '$id'";
			}
				$this->prep = $this->pdo->prepare($this->clause);

			if($this->prep){
				$this->prep->execute();

				return true;
			}

			return false;
		}

	}


?>