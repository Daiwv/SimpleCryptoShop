<?php

	include("include/function.php");
	
	Auth();
	
	$status = "";
	
	if(isset($_POST["new_item"])) {
		SQL_Query("INSERT INTO `items`(`img`, `name`, `dscr`, `content`, `price`, `fiat_type`) VALUES ('".$_POST["icon"]."', '".$_POST["name"]."', '".$_POST["desc"]."', '".$_POST["cont"]."', '".$_POST["pric"]."', '".$_POST["fiat_type"]."')");
		$status = '<div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='."none".';">&times;</span> 
  <strong>Succesfylly</strong> Item add to shop.
</div>
<br>';
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<style>
			body {
				margin: 5%;
			}
		
			input[type=text], select {
				width: 100%;
				padding: 12px 20px;
				margin: 8px 0;
				display: inline-block;
				border: 1px solid #ccc;
				border-radius: 4px;
				box-sizing: border-box;
			}
			
			.alert {
				padding: 20px;
				background-color: #4CAF50;
				color: white;
			}

			.closebtn {
				margin-left: 15px;
				color: white;
				font-weight: bold;
				float: right;
				font-size: 22px;
				line-height: 20px;
				cursor: pointer;
				transition: 0.3s;
			}

			.closebtn:hover {
				color: black;
			}
			
			.container{
				display: flex;                  /* establish flex container */
				flex-direction: row;            /* default value; can be omitted */
				flex-wrap: nowrap;              /* default value; can be omitted */
				justify-content: space-between; /* switched from default (flex-start, see below) */
				background-color: lightyellow;
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

		<center>
			<h3>Add new item to shop</h3>
			<?php 
				echo $status;
			?>
		</center>

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
			
			<div class="container">
				<input type="text" id="ipric" name="pric" placeholder="Fiat price" required>
				
				<select name="fiat_type" >
				    <option value="" disabled selected>Select fiat type</option>
					<option value="UAH">UAH</option>
					<option value="USD">USD</option>
					<option value="GBP">GBP</option>
					<option value="RUB">RUB</option>
					<option value="EUR">EUR</option>
					<option value="CZK">CZK</option>
					<option value="BLN">BLN</option>
					<option value="PLN">PLN</option>
					<option value="CHF">CHF</option>
					<option value="AED">AED</option>
				</select>
			</div>
			
			<input type="hidden" name="new_item" value="1">
			
			<input type="submit" value="Submit">
		  </form>
		</div>

	</body>
</html>
