<?php

	
	class CustomerBuilder implements Builder
	{
		public $firstname;
		public $lastname;
		public $phone;
		public $email;
		public $select;
		public $offer;
		public $quantity;

		public function setFirstname($firstname)
		{
			$this->firstname = $firstname;

			return $this;
		}

		public function setLastname($lastname)
		{
			$this->lastname = $lastname;

			return $this;
		}

		public function setPhone($phone)
		{
			$this->phone = $phone;

			return $this;
		}

		public function setEmail($email)
		{
			$this->email = $email;

			return $this;
		}

		public function setSelect($select)
		{
			$this->select = $select;

			return $this;
		}

		public function setOffer($offer)
		{
			$this->offer = $offer;

			return $this;
		}

		public function setQuantity($quantity)
		{
			$this->quantity = $quantity;

			return $this;

		}

		public function build()
		{
			return $this;
		}
	}







?>