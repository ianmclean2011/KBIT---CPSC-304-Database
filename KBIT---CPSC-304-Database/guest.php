<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Team KBIT</title>

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
		<ul class="nav nav-tabs">
			<li class="active"><a href="#">Guestlist</a></li>
			<li><a href="#">Add Guests</a></li>
		</ul>
	      <!-- Main component for a primary marketing message or call to action -->
	      <div class="jumbotron">
	<form role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
		<div class="form-group">
			<label for="firstName">First Name</label>
			<input type="text" class="form-control" name="firstName" placeholder="First Name">
		</div>
		<div class="form-group">
			<label for="lastName">Last Name</label>
			<input type="text" class="form-control" name="lastName" placeholder="Last Name">
		</div>
		<div class="form-group">
			<label for="lastName">Number of extra guests</label>
			<input type="number" class="form-control" name="extraGuests" placeholder="#" size="2">
		</div>
		<div class="form-group">
			<label for="password">New Password</label>
			<input type="password" class="form-control" name="password" placeholder="Password">
		</div>
		<div class="form-group">
			<label for="passwordRetype">Re-Type Password</label>
			<input type="password" class="form-control" name="passwordRe" placeholder="Re-Type Password">
		</div>
		<button type="submit" class="btn btn-default">
			Add
		</button>			
	</form>
	
	<?php
	echo "First Name: ", $_POST["firstName"];
	echo "<br>";
	echo "Last Name: ", $_POST["lastName"];
	echo "<br>";
	echo "Number of guests: ", $_POST["extraGuests"];
	echo "<br>";
	echo crypt($_POST["password"]);
	?>
	
	
	
		</div>
	</div> <!-- /container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
