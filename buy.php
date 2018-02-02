<?php

	if(isset($_GET["id"])) {}
	else {
		header("Location: /");
		die();
	}

	$servername = "localhost";
	$username = "bot";
	$password = "bot";
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

	$sql = "SELECT `short`, `middle`, `content`, `price` FROM `Items` WHERE `id` =".$produc_id;
	$conn->query($sql);
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
		
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
			<h1>You want buy <?php echo $row['short']; ?> </h1>
			<h2>With <input style="width: 85px; text-align: center; height: 20px; vertical-align:middle; font-size: 20px;" value="<?php echo $row['price']; ?>" disabled> BTC</h2>
		</div>
	</body>
</html>