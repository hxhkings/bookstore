<?php

require_once('../config/db_config.php');
require_once('../connection.php');
require_once('../../assets/common/builder.php');
require_once('../../assets/common/list.php');
if(isset($_POST['submit'])){

	if(isset($_POST['action'])){
		if($_POST['action'] === 'deletebook'){
			if(isset($_POST['remove'])){

			require_once('../../books/list.php');
				$books = $_POST['remove'];
				$delete;
				foreach($books as $book )
				{
					$delete = (new ListBook())->delete($book);

				}
				if($delete){
					header('Location: /bookstore/books/');
					exit;
				} else{
					echo "Oops! Something wrong happened!";
				}
			}
		}
		elseif($_POST['action'] === 'deleteuser'){
			if(isset($_POST['remove'])){

			require_once('../../employees/list.php');
				$users = $_POST['remove'];
				$delete;
				foreach($users as $user )
				{
					$delete = (new ListUser())->delete($user);

				}
				if($delete){
					header('Location: /bookstore/employees/');
					exit;
				} else{
					echo "Oops! Something wrong happened!";
				}
			}
		}
		elseif($_POST['action'] === 'deletecustomer'){
			if(isset($_POST['remove'])){
			require_once('../../sys/core/rentlist.php');
			require_once('../../books/list.php');
			require_once('../../customers/list.php');
				$customers = $_POST['remove'];
				$rent_id;
				$book_id;
				$quan;
				$delete;
				foreach($customers as $customer)
				{
					$cust_arr = explode('_', $customer);
					$rent_id = $cust_arr[0];
					$book_id = $cust_arr[1];
					$quan = (int)$cust_arr[2];
					$book_delete = (new ListBook())->update($book_id, $quan,'add');
					if($book_delete){
						$delete = (new ListCustomer())->delete($rent_id);
					}
				}
				if($delete){
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