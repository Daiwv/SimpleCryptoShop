<?php

	if(isset($_GET["id"])) {}
	else {
		header("Location: /");
		die();
	}

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "SBS";
	$produc_id = preg_replace("/[^0-9]/","",$_GET["id"]);
	
	$conn = new mysqli($servername, $username, $password, $dbname);

	$sql = "SELECT COUNT(*) FROM `Items` WHERE `id` =".$produc_id;
	$conn->query($sql);
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$count_int = $row['COUNT(*)'];
	if ($count_int == 0) {
		header("Location: /");
		die();
	}

	$sql = "SELECT `short`, `middle`, `content`, `price`, `btc` FROM `Items` WHERE `id` =".$produc_id;
	$conn->query($sql);
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	
	$var=file("https://blockchain.info/rawaddr/".$row["btc"]);
	$var2 = substr($var[6], 20, -2);
	
	if($var2 == $row["price"]) {
		$buyed = true;
	} else {
		$buyed = false;
	}
		
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/my.css">
		<title>Buy Item | SBS - Simple Bitcoin Shop</title>
	</head>
	<body>
		<div class="content-buy">
			<br>
			<?php 
				if ($buyed) {
					echo $row["content"];
					$sql = "DELETE FROM `items` WHERE `id` = ".$produc_id;
					$conn->query($sql);
				} else {
					print '<h1>You want buy '.$row["short"].' </h1>
					<h3>With <input style="width: 85px; text-align: center; height: 18px; vertical-align:middle; font-size: 18px;" value="'.$row["price"].'" disabled> satoshi</h3>
					After payment refresh page but don`t close!';
				}
			?>
			</div>
	</body>
</html>