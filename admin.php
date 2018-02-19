<?php

	include("include/function.php");
	
	Auth();
	
	if(isset($_POST["new_item"])) {
		SQL_Query("INSERT INTO `items`(`img`, `name`, `dscr`, `content`, `price`) VALUES ('".$_POST["icon"]."', '".$_POST["name"]."', '".$_POST["desc"]."', '".$_POST["cont"]."', '".$_POST["pric"]."')");
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<style>
			input[type=text], select {
				width: 100%;
				padding: 12px 20px;
				margin: 8px 0;
				display: inline-block;
				border: 1px solid #ccc;
				border-radius: 4px;
				box-sizing: border-box;
			}

			input[type=submit] {
				width: 100%;
				background-color: #4CAF50;
				color: white;
				padding: 14px 20px;
				margin: 8px 0;
				border: none;
				border-radius: 4px;
				cursor: pointer;
			}

			input[type=submit]:hover {
				background-color: #45a049;
			}

			div {
				border-radius: 5px;
				background-color: #f2f2f2;
				padding: 20px;
			}
		</style>
		<title>Admin Panel</title>
	</head>
	<body>

		<h3>Add new item to shop</h3>

		<div>
		  <form method="post">
			<label for="iname">Item Name</label>
			<input type="text" id="iname" name="name" placeholder="Paste item name" required>
			
			<label for="idesc">Item Description</label>
			<input type="text" id="idesc" name="desc" placeholder="Paste item description" required>
			
			<label for="iicon">Item Icon</label>
			<input type="text" id="iicon" name="icon" placeholder="Link to icon here. Ex http://example.com/item.png" required>

			<label for="icont">Item Data</label>
			<input type="text" id="icont" name="cont" placeholder="Item data here" required>

			<label for="ipric">Price in USD</label>
			<input type="text" id="ipric" name="pric" placeholder="$$$" required>
			
			<input type="hidden" name="new_item" value="1">
			
			<input type="submit" value="Submit">
		  </form>
		</div>

	</body>
</html>
