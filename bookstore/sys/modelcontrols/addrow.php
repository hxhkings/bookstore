<?php

require_once('../config/db_config.php');
require_once('../connection.php');
require_once('../../assets/common/builder.php');
require_once('../../assets/common/list.php');
require_once('../sanitizer.php');
if(isset($_POST['submit'])){
	if(isset($_POST['action']))
	{
		if($_POST['action'] === 'addbook'){
			if(isset($_POST['title']) && isset($_POST['author'])
				&& isset($_POST['quantity']) && isset($_POST['price'])
				&& !empty($_POST['title']) && !empty($_POST['author'])
				&& is_numeric($_POST['quantity']) && is_numeric($_POST['price'])){

				require_once('../../books/list.php');
				require_once('../../books/builder.php');

				$title = htmlentities(trim($_POST['title']), ENT_QUOTES);
				$author = htmlentities(trim($_POST['author']));
				$quantity = htmlentities(trim($_POST['quantity']));
				$price = htmlentities(trim($_POST['price']));

				$builder = (new BookBuilder())->setTitle($title)
							->setAuthor($author)->setQuantity((int)$quantity)
							->setPrice($price)->build();
				if(new Sanitizer($builder)){
					$add = (new ListBook())->insert($builder);
				}
				
				if($add){
					header('Location: /bookstore/books/');
					exit;
				} else{
					echo "Oops! Something wrong happened!";
				} 

			}
		}
		elseif($_POST['action'] === 'adduser'){
			if(isset($_POST['firstname']) && isset($_POST['lastname']) 
				&& isset($_POST['username']) && isset($_POST['password']) 
				&& isset($_POST['confirmpass']) && !empty($_POST['password'])
				&& !empty($_POST['username']) && !empty($_POST['confirmpass'])
				&& isset($_POST['age']) && isset($_POST['email'])
				&& !empty($_POST['firstname']) && !empty($_POST['lastname'])
				&& is_numeric($_POST['age']) && !empty($_POST['email'])){

				require_once('../../employees/list.php');
				require_once('../../employees/builder.php');
				$username = htmlentities(trim($_POST['username']));
				$password = htmlentities(trim($_POST['password']));
				$confirm = htmlentities(trim($_POST['confirmpass']));
				$firstname = htmlentities(trim($_POST['firstname']));
				$lastname = htmlentities(trim($_POST['lastname']));
				$age = htmlentities(trim($_POST['age']));
				$email = htmlentities(trim($_POST['email']));
				if($confirm === $password){
				$builder = (new UserBuilder())->setUsername($username)
							->setPassword($password)->setFirstname($firstname)
							->setLastname($lastname)->setAge($age)
							->setEmail($email)->build();
				if(new Sanitizer($builder)){
					$add = (new ListUser())->insert($builder);
				}
				if($add){
					header('Location: /bookstore/employees/');
					exit;
					var_dump($add);
				} else{
					echo "Oops! Something wrong happened!";
				}
				}
			}
		}
		elseif($_POST['action'] === 'addcustomer'){
			if(isset($_POST['firstname']) && isset($_POST['lastname'])
				&& isset($_POST['phone']) && isset($_POST['email'])
				&& !empty($_POST['firstname']) && !empty($_POST['lastname'])
				&& !empty($_POST['phone']) && !empty($_POST['email'])){
				$offer = $_POST['offer'];
				$select = $_POST['select'];
				
				$quantity = array();
				foreach($_POST['quantity'] as $quan){
					if($quan) array_push($quantity, $quan);
				}
				require_once('../../books/list.php');
				require_once('../../sys/core/builder.php');
				require_once('../../customers/list.php');
				require_once('../../customers/builder.php');
				($offer === 'rentbook') ?
				require_once('../../sys/core/rentlist.php'):
				require_once('../../sys/core/buylist.php');
				$firstname = htmlentities(trim($_POST['firstname']));
				$lastname = htmlentities(trim($_POST['lastname']));
				$phone = htmlentities(trim($_POST['phone']));
				$email = htmlentities(trim($_POST['email']));

				$builder = (new CustomerBuilder())->setFirstname($firstname)
							->setLastname($lastname)->setEmail($email)
							->setPhone($phone)->setSelect($select)
							->setOffer($offer)->setQuantity($quantity)->build();
				if(new Sanitizer($builder)){
					$add = (new ListCustomer())->insert($builder);
				}
				if($add){
					header('Location: /bookstore/customers/');
					exit;
				} else{
					echo "Oops! Something wrong happened!";
				}
				
				
			}
		}else{
			header('Location: /bookstore/');
			exit;
		}
	}else{
		header('Location: /bookstore/');
		exit;
	}

}else{
	header('Location: /bookstore/');
	exit;
}





?>