<?php
	$conn = new PDO("pgsql:host=192.168.99.101;port=8080;dbname=cama_db;user=cama_user;password=cama_pw") or die("unable to connect to database\n");

	try{
		// display a message if connected to the PostgreSQL successfully
		if($conn){
			echo "Connected to the <strong>cama_db</strong> database successfully!";
		}
	}catch (PDOException $e){
		// report error message
		echo $e->getMessage();
	}
?>
