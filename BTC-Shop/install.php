<?php

	$servername = "localhost";
	$username = "root";
	$password = "";

	// Create connection
	$conn = new mysqli($servername, $username, $password);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "CREATE DATABASE SBS";
	if ($conn->query($sql) === TRUE) {}
	else { echo "Error creating database: " . $conn->error; }

	$sql = "CREATE TABLE `SBS`.`Items` ( `id` INT(10) NOT NULL AUTO_INCREMENT , `img` TEXT NOT NULL , `short` TEXT NOT NULL , `middle` TEXT NOT NULL , `content` TEXT NOT NULL , `btc` TEXT NOT NULL , `price` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
	if ($conn->query($sql) === TRUE) {}
	else { echo "Error creating database: " . $conn->error; }

	$conn->close();

?>