<?php

	include("include/settings.php");
	
	$status = "";
	
	$conn = new mysqli($host, $user, $pass, "SimpleCryptoShop");

	//Get items count
	$sql = "SELECT COUNT(*) FROM `Items`";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$count_int = $row['COUNT(*)'];
	if ($count_int < 1) {
		$status = "No content"; // No items, count 0
	}
	else {
		$status = "Yep!"; // Have some items)
	}

?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/my.css">
		<title>SCS - Simple Crypto Shop</title>
	</head>
	<body>
		<div class="Menu"><br>
			<span class="First1">
				<span style="font-size:50px;" class="menu">Wellcome, to </span>
				<span style="font-size:50px;">Crypto shop</span>
			</span>
			<br>
			<span style="font-size:25px;" class="menu">Buy all items for Ethereum, Monero, DASH, Litecoin or Bitcoin.</span>
		</div>
		<div class="content">
			<?php
				if ($status == "No content") {
					echo $status; // If no items
				}
				else {
					//Get all ID of product
					$sql = "SELECT `id` FROM `Items`";
					$result = $conn->query($sql);
					while($row2 = $result->fetch_assoc()) {
						$a = $row2["id"];
						$sql2 = "SELECT `img`, `name`, `dscr` FROM `Items` WHERE `id` ='$a'"; // Items info
						$result2 = $conn->query($sql2);
						$row = $result2->fetch_assoc();
						//Create div with file info
						echo '<div class="product">';
						echo '<img src="'.$row['img'].'">';
						echo '<h3>'.$row['name'].'</h3>';
						echo '<p>'.$row['dscr'].'</p>';
						echo '<form action="buy.php" method="post"><input type="hidden" name="id" value="'.$a.'"><input type="hidden" name="crypto" value="ethereum"><button type="submit"><img src="img/eth.png"></img></form>';
						echo '<form action="buy.php" method="post"><input type="hidden" name="id" value="'.$a.'"><input type="hidden" name="crypto" value="monero"><button type="submit"><img src="img/xmr.png"></img></form>';
						echo '<form action="buy.php" method="post"><input type="hidden" name="id" value="'.$a.'"><input type="hidden" name="crypto" value="bitcoin"><button type="submit"><img src="img/btc.png"></img></form>';
						echo '<form action="buy.php" method="post"><input type="hidden" name="id" value="'.$a.'"><input type="hidden" name="crypto" value="litecoin"><button type="submit"><img src="img/ltc.png"></img></form>';
						echo '<form action="buy.php" method="post"><input type="hidden" name="id" value="'.$a.'"><input type="hidden" name="crypto" value="dash"><button type="submit"><img src="img/dash.png"></img></form>';
						echo '</div>';
					}
				}
			?>
		</div>
	</body>
</html>