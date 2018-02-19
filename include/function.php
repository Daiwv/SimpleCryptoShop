<?php

	function Auth() {
		include 'settings.php';
		
		if(isset($_GET["key"]) and $_GET["key"] == $admin) {}
		else { die; }
	}
	
	function Find_Payment($tx_id, $crypto, $price) {
		
		include 'settings.php';
		
		$buyed = false;
		
		if($crypto == "monero") {
			$var = file('https://xmrchain.net/myoutputs/'.$tx_id."/$xmr/$vwk");
			for($i=160; $i != sizeof($var); $i++)
				if(strstr($var[$i], $price)) {
					$buyed = true;
				}
		} else if($crypto == "ethereum") {
			$var = file("https://api.ethplorer.io/getTxInfo/$tx_id?apiKey=freekey");
			$var2 = explode(",", $var[0]);
			
			if(strstr($var2[6], $eth)) {
				if(substr($var2[7], 8) == $price) {
					$buyed = true;
				}
			}
		} else if($crypto == "bitcoin") {
			$pr_lin = 0;
			$sa_pr = $price*10**8;
	
			$var = file('https://blockchain.info/rawtx/'.$tx_id);
			
			for($i=10; $i != sizeof($var); $i++) {
				if(strstr($var[$i], $btc)) {
					$pr_lin = $i+1;
				}
			}
			
			$p_p_btc = substr($var[$pr_lin], 17, -2);
			
			if ($p_p_btc == $sa_pr) {
				$buyed = true;
			}
		} else if($crypto == "litecoin") {
			$var = file("https://chainz.cryptoid.info/explorer/tx.raw.dws?coin=ltc&id=$tx_id&fmt.js");
			for($i = 0; $i != sizeof($var2)-1; $i++) {
				if(strstr($var2[$i], $ltc)) {
					if(strstr($var2[$i-6], $price)) {
						$buyed = true;
					}
				}
			}
		} else if($crypto == "dash") {
			$var = file("https://chainz.cryptoid.info/explorer/tx.raw.dws?coin=dash&id=$tx_id&fmt.js");
			$var2 = explode(",", $var[0]);
	
			for($i = 0; $i != sizeof($var2)-1; $i++) {
				if(strstr($var2[$i], $dash)) {
					if(strstr($var2[$i-7], $price)) {
						$buyed = true;
					}
				}
			}
		} else {
			die;
		}
		
		return $buyed;
	}
	
	function Conventer($fiat,$crypto) {
		$c_p_temp = file("https://api.coinmarketcap.com/v1/ticker/$crypto");
		$c_price = substr($c_p_temp[6], 22, -4);
		$p_tmp0 = 1*$fiat/$c_price;
		$expd = explode(".",$p_tmp0);
		$price = $expd[0].'.'.substr($expd[1], 0, 3);
		return $price;
	}
	
	function SQL_Query($sql) {
		
		include 'settings.php';
		
		$conn = new mysqli($host, $user, $pass, "SimpleCryptoShop");
		$conn->query($sql);
		$conn->close();
	}

?>