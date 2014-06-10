<!DOCTYPE html>
<html lang="en">
  <head>
  </head>
<body>
		<h1>Add Vendor</h1>
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
			<label for="companyName">Company Name</label>
			<input type="text" class="form-control" name="companyName" placeholder="Company Name">
		</div>
		<div class="form-group">
			<label for="extraGuests">Number of extra guests</label>
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
  </body>
</html>
