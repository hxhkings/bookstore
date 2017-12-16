<?php


 class UserBuilder implements Builder
 {
 	public $username;
 	public $password;
 	public $firstname;
 	public $lastname;
 	public $age;
 	public $email;

 	public function setUsername($username)
 	{
 		$this->username = $username;

 		return $this;
 	}

 	public function setPassword($password)
 	{
 		$this->password = $password;

 		return $this;
 	}


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

 	public function setAge($age)
 	{
 		$this->age = $age;

 		return $this;
 	}

 	public function setEmail($email)
 	{
 		$this->email = $email;

 		return $this;
 	}

 	public function build()
 	{
 		return $this;
 	}
 }






?>