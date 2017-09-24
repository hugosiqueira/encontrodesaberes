<?php

	session_start();
	clearstatcache(); 
	unset($_SESSION);	session_destroy();
	ob_end_flush();
	header("location: ../index.php");