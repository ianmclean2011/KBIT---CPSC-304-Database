<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Team K-BIT - Wedding Planner</title>

		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="container">
			<div class="navbar navbar-default" role="navigation">
			</div>
			<!-- Main component for a primary marketing message or call to action -->
			<div class="jumbotron">
				<div class="inner cover" align="middle">
					<h1>Wedding Manager</h1>
					<br>
					<h2>You are a...</h2>

					<a href="guest.php" class="btn btn-lg btn-default">Guest</a>
					<a href="vendor.php" class="btn btn-lg btn-default">Vendor</a>
					<a href="admin.php" class="btn btn-lg btn-default">Admin</a>
				</div>
				<br>
				SQL Server Status: <?php
				if ($c = OCILogon("ora_p7m5", "a62141049", "ug")) {
					echo "Successfully connected to Oracle.\n";
					OCILogoff($c);
				} else {
					$err = OCIError();
					echo "Oracle Connect Error " . $err['message'];
				}
				?>

			</div>

		</div>
		<!-- /container -->
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>
