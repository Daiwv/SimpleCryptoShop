<?php

	include("include/settings.php"); // Contains DB data and wallets
	include("include/function.php"); // Functions
	
	//First need check item ID and user payment method (eth, btc...)
	if(isset($_POST["id"]) and isset($_POST["crypto"]) and $_POST["crypto"] == "ethereum" or $_POST["crypto"] == "bitcoin" or $_POST["crypto"] == "monero" or $_POST["crypto"] == "litecoin" or $_POST["crypto"] == "dash") {}
	else { // If one parameter contains bad data
		header("Location: /"); // Redirect to index.php
		die();
	}
	
	//If all good
	$produc_id = preg_replace("/[^0-9]/","",$_POST["id"]); // Delete all in ID without numbers
	$buyed = false; // Default payment status
	$c_name = "SCS"; // Default coin name)
	
	// He-he, you must know this step
	switch($_POST["crypto"]) {
		case "ethereum":
			$c_name = "ETH";
			break;
			
		case "bitcoin":
			$c_name = "BTC";
			break;
			
		case "litecoin":
			$c_name = "ltc";
			break;
			
		case "monero":
			$c_name = "XMR";
			break;
			
		case "dash":
			$c_name = "DASH";
			break;
	}
	
	//Connect to DB
	$conn = new mysqli($host, $user, $pass, "SimpleCryptoShop");
	
	// Check item available
	$sql = "SELECT COUNT(*) FROM `Items` WHERE `id` =".$produc_id;
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$count_int = $row['COUNT(*)'];
	if ($count_int == 0) { // If item not found
		header("Location: /"); // Go to index.php
		die();
	}

	// But if item available
	$sql = "SELECT `name`, `content`, `price` FROM `Items` WHERE `id` =".$produc_id;  // Get item info
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	
	$s_price = Conventer($row["price"],$_POST["crypto"]); // Convert item price from USD to user payment method
	
	if(isset($_POST["payment"]) and isset($_POST["tx_id"]) and $_POST["payment"] == 1) { // Check TX send
		if (strlen($_POST["tx_id"]) == 64 or strlen($_POST["tx_id"]) == 66) { // Validate TX length
			$tx_id_clear = preg_replace("[^\w\d\s]","",$_POST["tx_id"]); // Clear TX
			
			// Checking DB with double tx
			$check = "SELECT COUNT(*) FROM `".$c_name."_tx` WHERE `tx` =".$tx_id_clear;
			$rz_check = $conn->query($check);
			$check_row = $rz_check->fetch_assoc();
			$row_dat = $check_row['COUNT(*)'];
			
			if ($row_dat != 0) { // Found
				header("Location: /");
				die();
			}
			
			$buyed = Find_Payment($tx_id_clear, $_POST["crypto"], $s_price); // Check payment status
		}
	}
	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<style>
			body {
				padding: 10%;
			}
		
			input[type=text], select {
				text-align: center;
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
		<title>Buy Item - Simple Crypto Shop</title>
	</head>
	<body>
			<?php
				if ($buyed) {
					print '
		<div>
			<center>
				<p>Thnx, for buy!</p>
				<h3>'.$row["content"].'</h3>
			</center>
		</div>
		';
					$sql = "DELETE FROM `items` WHERE `id` = ".$produc_id;
					$conn->query($sql);
					
					$sql = "INSERT INTO `".$c_name."_tx`(`tx`) VALUES ('".$_POST["tx_id"]."')";
					$conn->query($sql);
					
					$conn->close();
				} else {
			print '
		<div>
			<form method="post">
				<center>
					<h2>Paste TX ID here to get items.</h2>
					<p>You want buy: '.$row["name"].'</p>
					<p>With '.$s_price.' '.$c_name.'</p>
				</center>
				<input type="text" id="itx_id" name="tx_id" placeholder="TX here" required>
				<input type="hidden" name="crypto" value="'.$_POST["crypto"].'">
				<input type="hidden" name="id" value="'.$_POST["id"].'">
				<input type="hidden" name="payment" value="1">
				<input type="submit" value="Submit">
			</form>
		</div>
		';
				}
			?>

	</body>
</html>