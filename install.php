<?php
	if(isset($_POST["install"])) {

		// Create connection
		$conn = new mysqli($_POST["host"],$_POST["user"],$_POST["pass"]);

		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 

		$sqls0 = array("CREATE DATABASE SimpleCryptoShop", "CREATE TABLE `SimpleCryptoShop`.`Items` ( `id` INT(255) NOT NULL AUTO_INCREMENT , `img` TEXT NOT NULL , `name` VARCHAR(50) NOT NULL , `dscr` VARCHAR(100) NOT NULL, `content` TEXT NOT NULL , `price` INT NOT NULL, `fiat_type` VARCHAR(3) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB; CREATE TABLE `simplecryptoshop`.`orders` ( `id` INT NOT NULL AUTO_INCREMENT , `tx` VARCHAR(66) NOT NULL , `crypto` VARCHAR(3) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
		
		for ($i = 0; $i != 2; $i++)
			$conn->query($sqls0[$i]);
		
		$conn->close();

		$settings = fopen("include/settings.php", "w") or die("Unable to open file!");
		$set = "<?php\n".'	$host = "'.$_POST["host"].'"'.";\n".'	$user = "'.$_POST["user"].'"'.";\n".'	$pass = "'.$_POST["pass"].'"'.";\n".'	$admin = "'.$_POST["adm"].'"'.";\n".'	$btc = "'.$_POST["btc"].'"'.";\n".'	$ltc = "'.$_POST["ltc"].'"'.";\n".'	$xmr = "'.$_POST["xmr"].'"'.";\n".'	$dash = "'.$_POST["dash"].'"'.";\n".'	$eth = "'.$_POST["eth"].'"'.";\n".'	$vwk = "'.$_POST["vwk"].'"'.";\n"."?>";
		fwrite($settings, $set);
		fclose($settings);
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
		<title>Install Page</title>
	</head>
	<body>

		<h3>Install</h3>

		<div>
		  <form method="post">
			<label for="lhost">Host</label>
			<input type="text" id="lhost" name="host" placeholder="Example: localhost" required>
			
			<label for="luser">User</label>
			<input type="text" id="luser" name="user" placeholder="Example: magazine" required>
			
			<label for="lpass">User password</label>
			<input type="text" id="lpass" name="pass" placeholder="8-64 length" required>
			
			<hr>
			
			<label for="ladm">Admin Password</label>
			<input type="text" id="lamd" name="adm" placeholder="8-64 lenght" required>
			
			<hr>
			
			<label for="lbtc">Bitcoin Address</label>
			<input type="text" id="lbtc" name="btc" placeholder="" required>
			
			<label for="leth">Ethreum Address</label>
			<input type="text" id="leth" name="eth" placeholder="" required>
			
			<label for="ldash">DASH Address</label>
			<input type="text" id="ldash" name="dash" placeholder="" required>
			
			<label for="lltc">Litecoin Address</label>
			<input type="text" id="lltc" name="ltc" placeholder="" required>
			
			<hr>
			
			<label for="lxmr">Monero Address</label>
			<input type="text" id="lxmr" name="xmr" placeholder="" required>
			
			<label for="lvwk">Monero Viewkey</label>
			<input type="text" id="lvwk" name="vwk" placeholder="Viewkey for you wallet" required>
			
			<input type="hidden" name="install" value="1">
			
			<input type="submit" value="Submit">
		  </form>
		</div>

	</body>
</html>
