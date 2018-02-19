<?php

	include("include/settings.php");
	include("include/function.php");
	
	
	if(isset($_POST["id"]) and isset($_POST["crypto"]) and $_POST["crypto"] == "ethereum" or $_POST["crypto"] == "bitcoin" or $_POST["crypto"] == "litecoin" or $_POST["crypto"] == "dash") {}
	else {
		header("Location: /");
		die();
	}
	
	$produc_id = preg_replace("/[^0-9]/","",$_POST["id"]);

	$conn = new mysqli($host, $user, $pass, "SimpleCryptoShop");
	
	$sql = "SELECT COUNT(*) FROM `Items` WHERE `id` =".$produc_id;
	$conn->query($sql);
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$count_int = $row['COUNT(*)'];
	if ($count_int == 0) {
		header("Location: /");
		die();
	}

	$sql = "SELECT `name`, `content`, `price` FROM `Items` WHERE `id` =".$produc_id;
	$conn->query($sql);
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	
	$s_price = Conventer($row["price"],$_POST["crypto"]);
	
	if(isset($_POST["payment"]) and isset($_POST["tx_id"]) and $_POST["payment"] == 1 and strlen($_POST["tx_id"]) == 64) {
		$tx_id_clear = preg_replace("[^\w\d\s]","",$_POST["tx_id"]);
		$yes = Find_Payment($tx_id_clear, $_POST["crypto"], $s_price);
		if($yes == true) {
			echo "YEPPPP!";
		}
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
		<title>Buy Item - Simple Monero Shop</title>
	</head>
	<body>
		<div>
			<?php
				if ($buyed) {
					echo $row["content"];
					$sql = "DELETE FROM `items` WHERE `id` = ".$produc_id;
					$conn->query($sql);
				} else {
					print '<form method="post">
					<center><h2>Paste TX ID here to get items.</h2></center>
					<label for="itx_id">TX ID</label>
					<input type="text" id="itx_id" name="tx_id" placeholder="Transaction in here" required>
					<input type="hidden" name="payment" value="1">
					
					<input type="submit" value="Submit">
					</form>';
				}
			?>
		</div>

	</body>
</html>