<?php

	$dir = ($_SERVER['REQUEST_URI'] === '/bookstore/') ? '' : '../';
	require_once($dir. 'assets/common/log.php');
	require_once($dir.'assets/common/list.php');

	(new Log())->login_check();
	if(!isset($_SESSION['admin_id']) && $_SERVER['REQUEST_URI'] === '/bookstore/employees/'){
		header('Location: /bookstore/');
		exit;
	}
	if((!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) && ($_SERVER['REQUEST_URI'] === 
		'/bookstore/customers/' || $_SERVER['REQUEST_URI'] === '/bookstore/books/')){
		header('Location: /bookstore/');
		exit;
	}
	
	

?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">
	<title>Book Store</title>
	<link type="text/css" rel="stylesheet" href="<?=$dir?>assets/bootstrap/css/bootstrap.min.css">
	<link type="text/css" rel="stylesheet" href="<?=$dir?>assets/css/bookstore.css">
</head>
<body>
	<div>
		<nav>
			<?php
			echo (!isset($_SESSION['admin_id']) && !isset($_SESSION['user_id'])) ? '<span id="in">Log In </span>':
								'<span id="out">'.'<a href="'.$dir.'logout.php'.'">'.
								'Log Out</a></span>';
			echo (isset($_SESSION['admin_id'])) ? '<span id="signup"> Sign Up</span>': '';
			?>
		</nav>
	</div>
	<div>
		<nav class="navbar navbar-default">
						
				<ul class="nav nav-tabs">
					<li><a href="/bookstore/">Home</a></li>
					<li><?php echo (isset($_SESSION['admin_id']) || isset($_SESSION['user_id']) ) ?
					'<a href="/bookstore/books">Books</a>':'' ?></li>
					<li><?php echo isset($_SESSION['admin_id']) ? '<a href="/bookstore/employees/">Employees</a>':''; ?></li>
					<li><?php echo (isset($_SESSION['admin_id']) || isset($_SESSION['user_id']) ) ?
					'<a href="/bookstore/customers">Customers</a>':'' ?></li>
				</ul>
				
		</nav>
	</div>
		<?php if(!isset($_SESSION['admin_id']) && !isset($_SESSION['user_id'])){ ?>
	<form method="POST" class="auth" action="<?=$dir?>login.php">
		<div class="form-group">
			<label>Username:</label>
			<div class="input-group">
				<input type="text" name="username" class="form-control" placeholder="Username" maxlength="32">
				<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
			</div>
		</div>
		<div class="form-group">
			<label>Password:</label>
			<div class="input-group">
				<input type="password" name="password" class="form-control" placeholder="Password" maxlength="32">
				<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
			</div>
		</div>
		<div class="form-group">
			<button type="submit" name="submit" class="btn btn-primary">
				<span class="glyphicon glyphicon-log-in"> Login</span>
			</button>
		</div>
	</form>
		<?php } ?>

		<?php if(isset($_SESSION['admin_id'])){ ?>

	<form method="POST" action="/bookstore/sys/modelcontrols/addrow.php" id="empsignup">
				<div>
					<input type="hidden" name="action" value="adduser">
				</div>
				<div class="form-group">
					<label>First Name:</label>
					<input type="text" name="firstname" class="form-control" placeholder="First Name" required maxlength="32">
				</div>
				<div class="form-group">
					<label>Last Name:</label>
					<input type="text" name="lastname" class="form-control" placeholder="Last Name" required maxlength="32">
				</div>
				<div class="form-group">
					<label>Age:</label>
					<input type="number" name="age" min="1" class="form-control" required maxlength="4">
				</div>
				<div class="form-group">
					<label>E-mail:</label>
					<input type="text" name="email" id="uemail" class="form-control" placeholder="E-mail" required maxlength="32">
					<div id="email_err"></div><div id="email_succ"></div>
				</div>
				<div class="form-group">
					<label>Username:</label>
					<input type="text" name="username" class="form-control" placeholder="Username" required maxlength="32">
				</div>
				<div class="form-group">
					<label>Password:</label>
					<input type="password" name="password" class="form-control" placeholder="Password" required maxlength="40">
				</div>
				<div class="form-group">
					<label>Confirm Password:</label>
					<input type="password" name="confirmpass" class="form-control" placeholder="Confirm Password" required maxlength="40">
				</div>
				<div class="form-group">
					<button type="submit" name="submit" class="btn btn-primary" id="esave">
						<span class="glyphicon glyphicon-saved"> Save</span>
					</button>
				</div>
			</form>
			<?php } ?>

	<h1 id="title">hxhKING's Book Store</h1>