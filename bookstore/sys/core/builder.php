<?php


 class CoreBuilder implements Builder
 {
 	public $cust_id;
 	public $book_id;
 	public $quantity;
 	public $date;

 	public function setCustId($cust_id)
 	{
 		$this->cust_id = $cust_id;

 		return $this;
 	}

 	public function setBookId($book_id)
 	{
 		$this->book_id = $book_id;

 		return $this;
 	}


 	public function setQuantity($quantity)
 	{
 		$this->quantity = $quantity;

 		return $this;
 	}

 	public function setDate($date)
 	{
 		$this->date = $date;

 		return $this;
 	}


 	public function build()
 	{
 		return $this;
 	}
 }






?>