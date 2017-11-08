<?php

// require_once("../db/connect.php");
// require_once("../public/admin_functions.php");

$host = "db";
$user = "cama_user";
$pw = "password";
$db = "cama_db"; 

/*
** With PDO, mostly only need to change the SQL syntax 
*/

/*
** Create a Database with PDO_pgsql
*/
/*
	// create a database; must specify first 3 args to the obj (servername, username, pw)
		// ex. new mysqli("db", "cama_user", "password")
	try 
	{
		$conn = new PDO("pgsql:host=$host;dbname=$db",$user,$pw); //dbname necessary?
		// set PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		
		// sql to create db
		$sql = "CREATE DATABASE testDB";
		// use exec() b/c no results are returned; executes the sql command to connection
		$conn->exec($sql);
		echo "Database created successfully<br>";
	}
	catch (PDOException $e)
	{
		echo $sql."<br>".$e->getMessage();
	}
	$conn = null;
*/

/*
** Create Tables with PDO_pgsql; each table should have a primary key column
** Need to know PostgreSQL syntax
** Check how to insert date and time into the table
*/
/*
	try 
	{
		$conn = new PDO("pgsql:host=$host;dbname=$db", $user, $pw);
		// set PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// sql to create table
		$sql = "CREATE TABLE IF NOT EXISTS MyGuests (
		id serial PRIMARY KEY NOT NULL,
		firstname VARCHAR(255) NOT NULL,
		lastname VARCHAR(255) NOT NULL,
		email VARCHAR(255) NOT NULL UNIQUE,
		date TIMESTAMP
		);";
		// use exec() b/c no results are returned, apply/send the sql statement to connection
		$conn->exec($sql);
		echo "Table MyGuests created successfully";
	}
	catch (PDOException $e)
	{
		echo $sql."<br>".$e->getMessage();
	}
	$conn = null;
*/

/*
** Insert Data into Table; if including date, need to research
** Get ID of Last Inserted Record
*/
/*
	try
	{
		$conn = new PDO("pgsql:host=$host;dbname=$db", $user, $pw);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO MyGuests (firstname, lastname, email)
				VALUES ('Teri', 'H', 'terri@t.com');";
		$conn->exec($sql);
		echo "New record created successfully";
		
		// get id of last inserted record
		$last_id = $conn->lastInsertId();
		echo "Last inserted ID: ".$last_id;
	}
	catch (PDOException $e)
	{
		echo $sql."<br>".$e->getMessage();
	}
	$conn = null;
*/

/*
** Insert multiple records into database
*/
/*
	try
	{
		$conn = new PDO("pgsql:host=$host;dbname=$db", $user, $pw);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// begin transaction
		$conn->beginTransaction();

		// our SQL statements and pass / execute to the connection
		$sql = "INSERT INTO MyGuests (firstname, lastname, email) ";
		$conn->exec($sql."VALUES ('Bob', 'Ross', 'bo@r.com');");
		$conn->exec($sql."VALUES ('Ernie', 'Sour', 'sh@k.com');");
		$conn->exec($sql."VALUES ('John', 'Doe', 'je@d.com');");
		
		// commit the transaction
		$conn->commit();
		echo "New records created";
	}
	catch (PDOException $e)
	{
		// roll back transaction if something failed
		$conn->rollback();
		echo "Error: ".$e->getMessage();
	}
	$conn = null;
*/

/*
** Prepared Statements - useful against SQL injections
** Executes the same or similar SQL statements repeatedly 
** 
**	Prepare -> template created and sent to the db
		-> some values left unspecified called params ("?")
		-> ex. INSERT INTO MyGuests VALUES(?, ?, ?)
**	DB parses, compiles and performs query optimization on SQL statment template and
		-> stores results w/o executing it
**	Execute -> application binds values to params & executed later
**
** Prevents SQL injections b/c transmitted param values don't need to be correctly escaped,
	and no SQL injection can occur if  original statement template not dervied from external input
*/
/*
	try
	{
		$conn = new PDO ("pgsql:host=$host;dbname=$db", $user, $pw);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// prepare sql and bind params
		$statement = $conn->prepare("INSERT INTO MyGuests (firstname, lastname, email)
									VALUES (:firstname, :lastname, :email);");
		$statement->bindParam(':firstname', $firstname);
		$statement->bindParam(':lastname', $lastname);
		$statement->bindParam(':email', $email);

		// insert a row
		$firstname = 'Joe';
		$lastname = 'Blow';
		$email = 'j@blow.com';
		$statement->execute();

		// insert another row
		$firstname = 'Julie';
		$lastname = 'Doo';
		$email = 'j@doo.com';
		$statement->execute();

		echo "New records created successfully";
	}
	catch (PDOException $e)
	{
		echo "Error: ".$e->getMessage();
	}
	$conn = null;
*/

/*
** Select Data from Database
*/
/*
	// make html table to display the results
	echo "<table style='border: solid 1px black;'>";
	echo "<tr><th>Id</th><th>Firstname</th><th>Lastname</th></tr>";

	// don't need to create this class here? only using this to create table design for results
	// should be able to create this in the html/php view files
	class TableRows extends RecursiveIteratorIterator {
		function __construct($it) {
			parent::__construct($it, self::LEAVES_ONLY);
		}
		function current() {
			return "<td style='width:150px;border: 1px solid black;'>".parent::current()."</td>";
		}
		function beginChildren() {
			echo "<tr>";
		}
		function endChildren() {
			echo "</tr>"."\n";
		}
	}
	try
	{
		$conn = new PDO("pgsql:host=$host;dbname=$db", $user, $pw);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $conn->prepare("SELECT id, firstname, lastname FROM MyGuests");
		$stmt->execute();

		// set result array to associative
		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		foreach(new TableRows (new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v)
		{
			echo $v;
		}
	}
	catch (PDOException $e)
	{
		echo "Error: ".$e->getMessage();
	}
	$conn = null;
	echo "</table>";
*/

/*
** Delete Data from a table
*/
	try
	{
		$conn = new PDO("pgsql:host=$host;dbname=$db", $user, $pw);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		// sql to delete a record
		$sql = "DELETE FROM MyGuests WHERE id=10";

		// use exec() because no results are returned
		$conn->exec($sql);
		echo "Record deleted successfully";
	}
	catch (PDOException $e)
	{
		echo $sql."<br>".$e->getMessagee();
	}
	$conn = null;


?>
