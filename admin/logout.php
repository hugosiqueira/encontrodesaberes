<?php

	session_start();
	clearstatcache(); 
	unset($_SESSION['usernameIP']);
	unset($_SESSION['passwordIP']);
	session_destroy();
	ob_end_flush();
	header("Location: index.php");
