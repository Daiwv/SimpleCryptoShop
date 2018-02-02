<?php

	//Connect to database
	$servername = "localhost";
	$username = "bot";
	$password = "bot";
	$dbname = "SBS";
	$status = "";

	$conn = new mysqli($servername, $username, $password, $dbname);

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
		<title>SBS - Simple Bitcoin Shop</title>
	</head>
	<body>
		<div class="Menu"><br>
			<span class="First1">
				<span style="font-size:50px;" class="menu">Wellcome, to </span>
				<span style="font-size:50px;">Bitcoin shop</span>
			</span>
			<br>
			<span style="font-size:25px;" class="menu">Buy all items for bitcoin</span>
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
						$sql2 = "SELECT `img`, `short`, `middle` FROM `Items` WHERE `id` ='$a'"; // Items info
						$result2 = $conn->query($sql2);
						$row = $result2->fetch_assoc();
						//Create div with file info
						echo '<div class="product">';
						echo '<img src="'.$row['img'].'">';
						echo '<h3>'.$row['short'].'</h3>';
						echo '<p>'.$row['middle'].'</p>';
						echo '<a href="/buy.php?id='.$a.'" class="open-product">Buy product</a>';
						echo '</div>';
					}
				}
			?>
		</div>
	</body>
</html>