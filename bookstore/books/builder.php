<?php

	
	class BookBuilder implements Builder
	{
		public $title;
		public $author;
		public $quantity;
		public $price;

		public function setTitle($title)
		{
			$this->title = $title;

			return $this;
		}

		public function setAuthor($author)
		{
			$this->author = $author;

			return $this;
		}

		public function setQuantity($quantity)
		{
			$this->quantity = $quantity;

			return $this;
		}

		public function setPrice($price)
		{
			$this->price = $price;

			return $this;
		}

		public function build()
		{
			return $this;
		}
	}








?>