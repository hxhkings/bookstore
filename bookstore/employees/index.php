
<?php
	
	require_once('../assets/common/header.php');
	require_once('../sys/config/db_config.php');
	require_once('../sys/connection.php');
	
	
?>

<div class="main">
<ul class="idTabs">
	<li><a href="#userlist">User List</a></li>
</ul>
<div id="userlist">

<form method="POST" action="/bookstore/sys/modelcontrols/deleterow.php">
		<div>
			<input type="hidden" name="action" value="deleteuser">
		</div>
<?php
	require_once('list.php');

	$list = (new ListUser())->query();
	echo '<h1 class="list">List of Employees</h1>';
	echo '<table class="table table-striped table-bordered"><tr>';
	echo "<th>First Name</th><th>Last Name</th><th>Age</th><th>E-mail</th><th>Remove</th></tr>";
if ($list){
	foreach($list as $user){
		echo "<tr><td>".$user['first_name']."</td>" . 
				"<td>".$user['last_name']."</td>" .
				"<td>".$user['age']."</td>" .
				"<td>".$user['email']."</td>".
				'<td><input type="checkbox" class="user" name="remove[]" value="'
				. sha1($user['user_id']) . '"></td>'.
			"</tr>";
	}
}
	echo "</table>";

?>
<button type="submit" name="submit" class="btn btn-primary" id="users" disabled>
	<span class="glyphicon glyphicon-refresh"> Save|Refresh</span>
</button>
</form>
</div>
	
</div>
<?php
	require_once('../assets/common/footer.php')
?>

