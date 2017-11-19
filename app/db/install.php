<?php

require_once("../db/connect.php");

// Create table for registered users and stuff
$sql = "CREATE TABLE IF NOT EXISTS users (
		id SERIAL PRIMARY KEY NOT NULL,
		username VARCHAR(255) NOT NULL UNIQUE,
		password VARCHAR(255) NOT NULL,
		email VARCHAR(255) NOT NULL UNIQUE,
		confirm_code INTEGER NULL, 
		creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		privilege VARCHAR(255) NOT NULL DEFAULT 'user',
		validation BOOLEAN NOT NULL DEFAULT 'f'
		);";
$conn->exec($sql);

// Create gallery_category table
$sql = "CREATE TABLE IF NOT EXISTS gallery_category (
		category_id SERIAL PRIMARY KEY NOT NULL,
		category_name VARCHAR(255) NOT NULL DEFAULT '0'
		);";
$conn->exec($sql);

// Create gallery_photos table
$sql = "CREATE TABLE IF NOT EXISTS gallery_photos (
		photo_id SERIAL PRIMARY KEY NOT NULL,
		photo_filename VARCHAR(255),
		photo_caption TEXT,
		photo_category BIGSERIAL NOT NULL,
		creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
		);";
$conn->exec($sql);

// end connection
$conn = null;
?>
