<?php

if(isset($_GET['dom']) && !empty($_GET['dom']) && isset($_GET['t'])){

	$domain = htmlentities(stripslashes(trim($_GET['dom'])));

	if(checkdnsrr($domain)){
		echo 'DNS found successfully!';
	} else{
		echo 'DNS not found!';
	}
}



?>