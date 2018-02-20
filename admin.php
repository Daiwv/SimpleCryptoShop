<?php

	include("include/function.php");
	
	Auth();
	
	$tps = 1;
	$status = "";
	$content_default = '<div class="adm_menu">
		
			<div class="adm_logo">
				<span>SCS</span>
			</div>
			
			<form method="post">
				<input type="hidden" name="page" value="index">
				<button class="menu_list selected">
					Add item
				</button>
			</form>
			
			<form method="post">
				<input type="hidden" name="page" value="show">
				<button class="menu_list">
					Orders
				</button>
			</form>
			
		</div>
	
		<div class="adm_content">
		
			<center>
				<h3>Add new item to shop</h3>
				'.$status.'
			</center>
			
			<form method="post">
			
				<label for="iname">Item Name</label>
				<input type="text" id="iname" name="name" placeholder="Paste item name" required>
				
				<label for="idesc">Item Description</label>
				<input type="text" id="idesc" name="desc" placeholder="Paste item description. Min len 35, max 50" required>
				
				<label for="iicon">Item Icon</label>
				<input type="text" id="iicon" name="icon" placeholder="Link to icon here. Ex http://example.com/item.png" required>

				<label for="icont">Item Data</label>
				<input type="text" id="icont" name="cont" placeholder="Item data here" required>
				
				<label for="ipric">Item Price</label>
				<div class="adm_content2">
					<input type="text" id="ipric" name="pric" placeholder="Fiat price" required>
					
					<select name="fiat_type" >
						<option value="" disabled selected>Select fiat</option>
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
				
				<input type="submit" value="Submit" class="add_item">
				
		  </form>
		</div>
		';
	
	if(isset($_POST["page"])) {
		if($_POST["page"] == "show") {
			$tps = 2;
		} else {
			$tps = 1;
		}
	} else {
		$tps = 1;
	}
	
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
		<link rel="stylesheet" type="text/css" href="css/my.css">
		<link rel="stylesheet" type="text/css" href="https://getbootstrap.com/dist/css/bootstrap.min.css">
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://getbootstrap.com/dist/js/bootstrap.min.js"></script>
		<script>
			$(document).ready(function () {
					$('#maxRows').on('change', function() {
						getPagination('#Tabla',$(this).val());
					});
				getPagination('#Tabla',2); // the no of rows default you want to show
			});
			
			function getPagination(table,norows) {
			
			 $('.pagination').html(''); // reset pagination 
				var trnum = 0; // reset tr counter 
				var maxRows = norows; // get Max Rows from select option
				var totalRows = $(table + ' tbody tr').length; // numbers of rows 
				$(table + ' tr:gt(0)').each(function() { // each TR in  table and not the header
				  trnum++; // Start Counter 
				  if (trnum > maxRows) { // if tr number gt maxRows
			
					$(this).hide(); // fade it out 
				  }
				  if (trnum <= maxRows) {
					$(this).show();
				  } // else fade in Important in case if it ..
				}); //  was fade out to fade it in 
				$('.pagination li:first-child').addClass('active'); // add active class to the first li 
				$('.pagination li').on('click', function() { // on click each page
				  var pageNum = $(this).attr('data-page'); // get it's number
				  var trIndex = 0; // reset tr counter
				  $('.pagination li').removeClass('active'); // remove active class from all li 
				  $(this).addClass('active'); // add active class to the clicked 
				  $(table + ' tr:gt(0)').each(function() { // each tr in table not the header
					trIndex++; // tr index counter 
					// if tr index gt maxRows*pageNum or lt maxRows*pageNum-maxRows fade if out
					if (trIndex > (maxRows * pageNum) || trIndex <= ((maxRows * pageNum) - maxRows)) {
					  $(this).hide();
					} else {
					  $(this).show();
					} //else fade in 
				  }); // end of for each tr in table
				}); // end of on click pagination list
			}
		</script>
		</body>
		<title>Admin Panel</title>
	</head>

	<body class="adm_body">
		<?php
			if ($tps == 1) {
				echo $content_default;
			} else {
				include 'include/settings.php';
			$conn = new mysqli($host, $user, $pass, "SimpleCryptoShop");

			//Get items count
			$sql = "SELECT COUNT(*) FROM `orders`";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			$count_int = $row['COUNT(*)'];
			if ($count_int < 1) {
				$status = "No content"; // No items, count 0
			}
			else {
				$status = "Yep!"; // Have some items)
			}
			
			print '<div class="adm_menu">

			<div class="adm_logo">
				<span>SCS</span>
			</div>

			<form method="post">
				<input type="hidden" name="page" value="index">
				<button class="menu_list">
					Add item
				</button>
			</form>

			<form method="post">
				<input type="hidden" name="page" value="show">
				<button class="menu_list selected">
					Orders
				</button>
			</form>

		</div>

		<div class="adm_content">

			<center>
				<h3>Last order</h3>
			</center>

			<div class="input col-md-6">
				<select class="form-control" name="state" id="maxRows">
					<option value="10">10</option>
					<option value="30">30</option>
					<option value="50">50</option>
					<option value="100">100</option>
					<option value="99999">Show ALL Rows</option>
				</select>
			</div>

			<div class="table-responsive">
				<table class="table table-striped table-hover table-condensed table-bordered" id="Tabla">
					<thead>
						<tr class="info">
							<td>ID<span class="hidden-xs"></span></td>
							<td>TX<span class="hidden-xs"></span></td>
							<td>Crypto<span class="hidden-xs"></span></td>
						</tr>
					</thead>
					<tbody id="TablaFamilias">';
					
					if ($status == "No content") {
						echo $status; // If no items
					}
					else {
						//Get all ID of product
						$sql = "SELECT `id` FROM `orders`";
						$result = $conn->query($sql);
						while($row2 = $result->fetch_assoc()) {
							$a = $row2["id"];
							$sql2 = "SELECT `tx`, `crypto` FROM `orders` WHERE `id` ='$a'"; // Items info
							$result2 = $conn->query($sql2);
							$row = $result2->fetch_assoc();
							echo "<tr><td>$a</td><td>".$row["tx"]."</td><td>".$row["crypto"]."</td></tr>";
						}
					}
					print '</tbody>
					<tfoot></tfoot>
				</table>
				<div>
					<nav>
						<ul class="pagination"></ul>
					</nav>
				</div>
			</div>
			
		</div>';
			}
		?>
	</body>
</html>