<?php

	session_start();
	clearstatcache(); 
	unset($_SESSION);
	ob_end_flush();
	header("location: ../index.php");