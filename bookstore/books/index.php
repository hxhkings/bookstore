<?php
	require_once('../assets/common/header.php');
	require_once('../sys/config/db_config.php');
	require_once('../sys/connection.php');

	
?>
<div class="main">
<ul class="idTabs">
	<li><a href="#booklist">Book List</a></li>
	<li><a href="#addbook">Add Book</a></li>
	<li><a href="#rentbook">Rented</a></li>
	<li><a href="#buybook">Bought</a></li>
</ul>
<div id="booklist">
	<form method="POST" action="/bookstore/sys/modelcontrols/deleterow.php">
		<div>
			<input type="hidden" name="action" value="deletebook">
		</div>
<?php
	require_once('list.php');

	$list = (new ListBook())->query();

	echo '<h1 class="list">List of Books</h1>';
	echo '<table class="table table-striped table-bordered"><tr>';
	echo "<th>Title</th><th>Author</th><th>Price</th><th>Quantity</th><th>Remove</th></tr>";
if ($list){
	foreach($list as $book){
		echo "<tr><td>".$book['title']."</td>" . 
				"<td>".$book['author']."</td>" .
				"<td>P".$book['price']."</td>" .
				"<td>".$book['quantity']."</td>".
				'<td><input type="checkbox" class="book" name="remove[]" value="'
				. sha1($book['book_id']) . '"></td>'.
			"</tr>";
	}
}
	echo "</table>";

?>
	<button type="submit" name="submit" id="books" class="btn btn-primary" disabled>
		<span class="glyphicon glyphicon-refresh"> Save|Refresh</span>
	</button>
		</form>
	</div>
	<div id="addbook">
		<h1>Add Book</h1>
		<div id="adduserform" class="col-md-6 col-md-offset-3">
			<form method="POST" action="/bookstore/sys/modelcontrols/addrow.php">
				<div>
					<input type="hidden" name="action" value="addbook">
				</div>
				<div class="form-group">
					<label>Title:</label>
					<input type="text" name="title" class="form-control adduser" placeholder="Title" required maxlength="64">
				</div>
				<div class="form-group">
					<label>Author:</label>
					<input type="text" name="author" class="form-control adduser" placeholder="Author" required maxlength="64">
				</div>
				<div class="form-group">
					<label>Quantity:</label>
					<input type="number" name="quantity" class="form-control adduser" min="1" value="1" required maxlength="11">
				</div>
				<div class="form-group">
					<label>Price (PHP):</label>
					<input type="number" name="price" class="form-control adduser" step="10" value="500" required>
				</div>
				<div class="form-group">
					<button type="submit" name="submit" class="btn btn-primary adduser">
						<span class="glyphicon glyphicon-saved"> Save</span>
					</button>
				</div>
			</form>
		</div>
	</div>
	<div id="rentbook">
		<h1>Rented Books</h1>
	<?php 

		require_once('../sys/core/rentlist.php'); 
		$list = (new ListRent('books'))->query();
	if($list){
		echo '<table class="table table-striped table-bordered"><tr>';
		echo '<th>Title</th><th>Author</th><th>Total Price</th><th>Total Quantity</th></tr>';
		foreach($list as $item){
			echo '<tr><td>'.$item['title'].'</td><td>'.$item['author'].'</td>'.
			'<td>'.$item['total_price'].'</td><td>'.$item['total_quantity'].'</td></tr>';
		}
			echo "</table>";

	}
	?>
	</div>
	<div id="buybook">
		<h1>Bought Books</h1>
		<?php 

		require_once('../sys/core/buylist.php'); 
		$list = (new ListBuy('books'))->query();
	if($list){
		echo '<table class="table table-striped table-bordered"><tr>';
		echo '<th>Title</th><th>Author</th><th>Total Price</th><th>Total Quantity</th></tr>';
		foreach($list as $item){
			echo '<tr><td>'.$item['title'].'</td><td>'.$item['author'].'</td>'.
			'<td>'.$item['total_price'].'</td><td>'.$item['total_quantity'].'</td></tr>';
		}
			echo "</table>";

	}
	?>
	</div>
	</div>

<?php
	require_once('../assets/common/footer.php');
?>

	
