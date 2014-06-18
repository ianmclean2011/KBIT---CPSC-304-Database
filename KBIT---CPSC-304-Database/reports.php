<?php
include 'connect.php';
include 'sqlFunction.php';
?>

<!DOCTYPE html>
<html lang="en">
	<head><script src="js/jquery-1.11.1.min.js"></script>

	<script>
	$(document).ready(function(){
		$("#1-1m").hide()
	});
	$(document).ready(function(){
  		$("#1-1").click(function(){
    		$("#1-1m").toggle();
  		});
	});
	$(document).ready(function(){
		$("#1-2m").hide()
	});
	$(document).ready(function(){
  		$("#1-2").click(function(){
    		$("#1-2m").toggle();
  		});
	});
	$(document).ready(function(){
		$("#3-1m").hide()
	});
	$(document).ready(function(){
  		$("#3-1").click(function(){
    		$("#3-1m").toggle();
  		});
	});

	$(document).ready(function(){
		$("#3-2m").hide()
	});
	$(document).ready(function(){
  		$("#3-2").click(function(){
    		$("#3-2m").toggle();
  		});
	});
</script></head>
	<body>
	<h1 id='0'>Financial Reports</h1><br>
	<h2 id="1">Supply Cost for Each Item</h2><br>
		<table width=1000><tr><td width= width=1000>
			<button id="1-1"> Sort by Highest Cost</button>
			<button id="1-2"> Sort by Lowest Cost</button></td></tr>
			<tr><td><?php include 'report-cost-highest.php' ?></td></tr>
			<tr><td><?php include 'report-cost-lowest.php' ?></td></tr></table>
	<hr>
	<h2 id='3'>Supply Cost For Each Vendor</h2><br>
		<table width=1000><tr><td width= width=1000>
			<button id="3-1"> Vendor/Items </button>
			<button id="3-2"> Total Cost by each Vendor</button></td></tr>
			<tr><td><?php include 'report-cost-vendor.php' ?></td></tr></table>
	<hr>
	</body>
</html>
