<?php

require_once("../db/connect.php");

// Create table 
$table_stmt = "CREATE TABLE IF NOT EXISTS cama_db.users (
	id serial PRIMARY KEY NOT NULL,
	user VARCHAR(255) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL UNIQUE,
	creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	privilege VARCHAR(255) NOT NULL DEFAULT 'user'
	);";



// end connection
$conn = null;
