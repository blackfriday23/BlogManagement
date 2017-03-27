<?php
	include "config.php";
	
	$conn = new mysqli($hostname, $username, $password);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	
	$sql = "CREATE DATABASE IF NOT EXISTS ".$dbname;
	if ($conn->query($sql) === TRUE) {
		$conn = new mysqli($hostname, $username, $password, $dbname);
		if ($conn->connect_error) {
			die("Error connecting database: " . $conn->connect_error);
		}
		$sql = "CREATE TABLE ".$table_users." (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
		name VARCHAR(30) NOT NULL,
		email VARCHAR(30) NOT NULL,
		password VARCHAR(30) NOT NULL,
		avatar VARCHAR(100) NOT NULL,
		approveStatus INT(30) NOT NULL,
		type VARCHAR(30) NOT NULL
		)";
		
		if ($conn->query($sql) === FALSE) {
			die("Error creating table: " .$table_users. $conn->error);
		}
		
		$sql = "CREATE TABLE ".$table_posts." (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
		user_id INT(30) NOT NULL,
		post VARCHAR(5000) NOT NULL,
		time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		can_edit BOOLEAN NOT NULL DEFAULT 1
		)";
		
		if ($conn->query($sql) === FALSE) {
			die("Error creating table: " .$table_posts. $conn->error);
		}
	} else {
		echo "Error creating database: " . $conn->error;
	}

	$conn->close();
?>