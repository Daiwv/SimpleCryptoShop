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
						$sql2 = "SELECT `img`, `name`, `dscr`, `price`, `fiat_type` FROM `Items` WHERE `id` ='$a'"; // Items info
						$result2 = $conn->query($sql2);
						$row = $result2->fetch_assoc();
						//Create div with file info
						echo '<div class="product">';
						echo "\n";
						echo '				<img src="'.$row['img'].'" height="200" width="200">';
						echo "\n";
						echo '				<h3>'.$row['name'].'</h3>';
						echo "\n";
						echo '				<p>'.$row['dscr'].'</p>';
						echo "\n";
						echo '				<div class="payment_methods">';
						echo "\n";
						echo '					<form action="buy.php" method="post">'."\n						".'<input type="hidden" name="id" value="'.$a.'">'."\n						".'<input type="hidden" name="crypto" value="ethereum">'."\n						".'<button type="submit"><img src="img/eth.png" title="Buy with Ethereum" alt="ETH"></button>'."\n					".'</form>';
						echo "\n";
						echo '					<form action="buy.php" method="post">'."\n						".'<input type="hidden" name="id" value="'.$a.'">'."\n						".'<input type="hidden" name="crypto" value="monero">'."\n						".'<button type="submit"><img src="img/xmr.png" title="Buy with Monero" alt="XMR"></button>'."\n					".'</form>';
						echo "\n";
						echo '					<form action="buy.php" method="post">'."\n						".'<input type="hidden" name="id" value="'.$a.'">'."\n						".'<input type="hidden" name="crypto" value="bitcoin">'."\n						".'<button type="submit"><img src="img/btc.png" title="Buy with Bitcoin" alt="BTC"></button>'."\n					".'</form>';
						echo "\n";
						echo '					<form action="buy.php" method="post">'."\n						".'<input type="hidden" name="id" value="'.$a.'">'."\n						".'<input type="hidden" name="crypto" value="litecoin">'."\n						".'<button type="submit"><img src="img/ltc.png" title="Buy with Litecoin" alt="LTC"></button>'."\n					".'</form>';
						echo "\n";
						echo '					<form action="buy.php" method="post">'."\n						".'<input type="hidden" name="id" value="'.$a.'">'."\n						".'<input type="hidden" name="crypto" value="dash">'."\n						".'<button type="submit"><img src="img/dash.png" title="Buy with DASH" alt="DASH"></button>'."\n					".'</form>';
						echo "\n";
						echo '				</div>';
						echo "\n";
						echo '				<b>Price</b>: '.$row["price"]." ".$row["fiat_type"];
						echo '			</div>';
						echo "\n";
						echo "\n";
					}
				}
			?>
		</div>
	</body>
</html>