<?php
require_once("../db/connect.php");

$images_dir = 'photos';

// USER TABLE 
function user_exists($name) {
	global $conn;
	$query = $conn->prepare("SELECT username FROM users WHERE username = :username");
	$query->bindParam(':username', $name);
	$query->execute();
	if ($query->rowCount() > 0) 
		return (1);
	return (0);
}

function email_exists($email) {
	global $conn;
	$query = $conn->prepare("SELECT email FROM users WHERE email = :email");
	$query->bindParam(':email', $email);
	$query->execute();
	if ($query->rowCount() > 0)
		return (1);
	return (0);
}

function get_user_info_by_email($email) {
	global $conn;
	$query = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
	$query->bindParam(':email', $email);
	$query->execute();
	$results = $query->fetch(PDO::FETCH_ASSOC);
	return $results ? : [];
}

function get_user_info_by_id($id) {
	global $conn;
	$query = $conn->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
	$query->bindParam(':id', $id);
	$query->execute();
	$results = $query->fetch(PDO::FETCH_ASSOC);
	return $results ? : [];
}

function get_user_info_by_name($name) {
	global $conn;
	$query = $conn->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
	$query->bindParam(':username', $name);
	$query->execute();
	$results = $query->fetch(PDO::FETCH_ASSOC);
	return $results ? : [];
}

function update_validation($name, $code, $valid) {
	global $conn;
	$query = $conn->prepare("UPDATE users SET validation = :validation WHERE username = :username");
	$query->bindParam(':username', $name);
	$query->bindParam(':validation', $valid);
	$query->execute();
	
	$query = $conn->prepare("UPDATE users SET confirm_code = :confirm_code WHERE username = :username");
	$query->bindParam(':username', $name);
	$query->bindParam(':confirm_code', $code);
	$query->execute();
}

function update_password($name, $password) {
	global $conn;
	$query = $conn->prepare("UPDATE users SET password = :password WHERE username = :username;");
	$query->bindParam(':username', $name);
	$query->bindParam(':password', $password);
	$query->execute();
}

function update_email($name, $email) {
	global $conn;
	$query = $conn->prepare("UPDATE users SET email = :email WHERE username = :username;");
	$query->bindParam(':username', $name);
	$query->bindParam(':email', $email);
	$query->execute();
}

function add_user($name, $email, $password, $code) {
	global $conn;
	$query = $conn->prepare("INSERT INTO users (username, email, password, confirm_code) VALUES (:username, :email, :password, :confirm_code);");
	$query->bindParam(':username', $name);
	$query->bindParam(':email', $email);
	$query->bindParam(':password', $password);
	$query->bindParam(':confirm_code', $code);
	$query->execute();
}

function delete_user($id) {
	global $conn;
	$query = $conn->prepare("DELETE FROM users WHERE id = :id");
	$query->bindParam(':id', $id);
	$query->execute();
}

// GALLERY & PHOTO TABLE
function add_category_name($name) {
	global $conn;
	$query = $conn->prepare("INSERT INTO gallery_category (category_name) VALUES (:category_name);");
	$query->bindParam(':category_name', $name);
	$query->execute();
}

function add_photo_to_gallery_and_get_id($name, $category) {
	global $conn;
	$query = $conn->prepare("INSERT INTO gallery_photos (photo_filename, photo_category) VALUES (:photo_filename, :photo_category);");
	$query->bindParam(':photo_filename', $name);
	$query->bindParam(':photo_category', $category);
	$query->execute();
	// return last inserted id
	return $conn->lastInsertId();
}

function update_filename($name, $id) {
	global $conn;
	$query = $conn->prepare("UPDATE gallery_photos SET photo_filename = :photo_filename WHERE photo_id = :photo_id;");
	$query->bindParam(':photo_filename', $name);
	$query->bindParam(':photo_id', $id);
	$query->execute();
}
?>
