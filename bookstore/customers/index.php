<?php
	require_once('../assets/common/header.php');
	
	require_once('../sys/config/db_config.php');
	require_once('../sys/connection.php');
	
?>

<div class="main">
<ul class="idTabs">
	<li><a href="#customerlist">Customer List</a></li>
	<li><a href="#addcustomer">Add Customer</a></li>
	<li><a href="#rented">Rented</a></li>
	<li><a href="#bought">Bought</a></li>
	
</ul>
<div id="customerlist">

<?php
	require_once('list.php');
	require_once('../books/list.php');
	$list = (new ListCustomer())->query();
	$booklist = (new ListBook())->query();
	echo '<h1 class="list">List of Customers</h1>';
	echo '<table class="table table-striped table-bordered"><tr>';
	echo "<th>First Name</th><th>Last Name</th><th>Phone Number</th><th>E-mail</th><th>Log Date</th></tr>";
if ($list){
	foreach($list as $customer){
		echo "<tr><td>".$customer['first_name']."</td>" . 
				"<td>".$customer['last_name']."</td>" .
				"<td>".$customer['phone_num']."</td>" .
				"<td>".$customer['email']."</td>".
				"<td>".$customer['logdate']."</td>".
			"</tr>";
	}
}
	echo "</table>";

?>

</div>
	<div id="addcustomer">
		<h1>Add Customer</h1>
		<div id="addcustomerform">
			<form method="POST" action="/bookstore/sys/modelcontrols/addrow.php">
				<div>
					<input type="hidden" name="action" value="addcustomer">
				</div>
				<div class="form-group col-md-6 col-md-offset-3">
					<label>First Name:</label>
					<input type="text" name="firstname" class="form-control add-cust" placeholder="First Name" required maxlength="32">
				</div>
				<div class="form-group col-md-6 col-md-offset-3">
					<label>Last Name:</label>
					<input type="text" name="lastname" class="form-control add-cust" placeholder="Last Name" required maxlength="32">
				</div>
				<div class="form-group col-md-6 col-md-offset-3">
					<label>Phone Number:</label>
					<input type="text" name="phone" id="cnum" class="form-control add-cust" placeholder="Phone Number (xxxx-xxx-xxxx)" required maxlength="32">
					<div id="num_err"></div><div id="num_succ"></div>
				</div>
				
				<div class="form-group col-md-6 col-md-offset-3">
					<label>E-mail:</label>
					<input type="text" name="email" id="cemail" class="form-control add-cust" placeholder="E-mail" required maxlength="32">
					<div id="mail_err"></div><div id="mail_succ"></div>
				</div>
				
				<div class="form-group col-md-6 col-md-offset-3">
					<label>Rent:</label>
					<input type="radio" name="offer" value="rentbook" required>
					<label>Buy:</label>
					<input type="radio" name="offer" value="buybook">
				</div>

		<div>
		<?php
			
			echo '<h1 class="list col-md-6 col-md-offset-3">List of Books</h1>';
			echo '<table class="table table-striped table-bordered"><tr>';
			echo "<th>Title</th><th>Author</th><th>Price</th><th>Quantity</th><th>Select Book</th><th>Quantity</th></tr>";
		if ($booklist){
			foreach($booklist as $book){
				echo "<tr><td>".$book['title']."</td>" . 
						"<td>".$book['author']."</td>" .
						"<td>P".$book['price']."</td>" .
						"<td>".$book['quantity']."</td>".
						'<td><label>Select</label> <input type="checkbox" class="books" name="select[]" value="'.
						 sha1($book['book_id']).'" disabled></td>'.
						'<td><label>Quantity:</label> <input type="number" name="quantity[]" min="1" disabled></td>' .
					"</tr>";
			}
		}
			echo "</table>";

				?>
			<button type="submit" name="submit" id="submit" class="btn btn-primary" disabled>
				<span class="glyphicon glyphicon-send"> Submit</span>
			</button>
		</div>
			</form>
		</div>
	</div>
	<div id="rented">
		<h1>Renters</h1>
		<form method="POST" action="/bookstore/sys/modelcontrols/deleterow.php">
		<div>
			<input type="hidden" name="action" value="deletecustomer">
		</div>
		<?php 

		require_once('../sys/core/rentlist.php'); 
		$list = (new ListRent('customers'))->query();
	if ($list){
		echo '<table class="table table-striped table-bordered"><tr>';
		echo '<th>Fullname</th><th>Title</th><th>Author</th>'.
			'<th>Quantity</th><th>Borrow Date</th><th>Remove</th></tr>';
		foreach($list as $item){
			echo '<tr><td>'.$item['fullname'].'</td><td>'.$item['title'].'</td>'.
			'<td>'.$item['author'].'</td><td>'.$item['quantity'].'</td>'.
			'<td>'.$item['logdate'].'</td>'.
			'<td><input type="checkbox" class="rent" name="remove[]" value="'
				. sha1($item['rent_id']) . '_'.sha1($item['book_id']).'_'.
				$item['quantity'] .'"></td></tr>';
		}
			echo "</table>";
	}

		?>
		<button type="submit" name="submit" id="save" class="btn btn-primary" disabled>
			<span class="glyphicon glyphicon-refresh"> Save|Refresh</span>
		</button>
		</form>
	</div>
	<div id="bought">
		<h1>Buyers</h1>
		<?php 

		require_once('../sys/core/buylist.php'); 
		$list = (new ListBuy('customers'))->query();
	if($list){
		echo '<table class="table table-striped table-bordered"><tr>';
		echo '<th>Fullname</th><th>Title</th><th>Author</th>'.
			'<th>Quantity</th><th>Total Price</th><th>Buy Date</th></tr>';
		foreach($list as $item){
			echo '<tr><td>'.$item['fullname'].'</td><td>'.$item['title'].'</td>'.
			'<td>'.$item['author'].'</td><td>'.$item['quantity'].'</td>'.
			'<td>'.$item['total_price'].'</td><td>'.$item['logdate'].'</td></tr>';
		}
			echo "</table>";
	}

		?>
	</div>
	
</div>
<?php
	require_once('../assets/common/footer.php')
?>
