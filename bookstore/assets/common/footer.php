	<?php $dir = ($_SERVER['REQUEST_URI'] === '/bookstore/') ? '' : '../'; ?>
	<script type="text/javascript" src="<?=$dir?>assets/js/scripts/jquery-3.2.0.min.js"></script>
	<script type="text/javascript" src="<?=$dir?>assets/js/scripts/jquery.idTabs.min.js"></script>
	<script type="text/javascript" scr="<?=$dir?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?=$dir?>assets/js/bookstore.js"></script>
	<?php
		$script;
		switch($_SERVER['REQUEST_URI']){
			case '/bookstore/books/':
				$script = 'books.js';
				break;
			case '/bookstore/employees/':
				$script = 'employees.js';
				break;
			case '/bookstore/customers/':
				$script = 'customers.js';
				break;
		}
		if($_SERVER['REQUEST_URI'] !== '/bookstore/'):
	?>
	<script type="text/javascript" src="<?=$dir?>assets/js/<?=$script?>"></script>
	<?php
		endif;
	?>
</body>
</html>