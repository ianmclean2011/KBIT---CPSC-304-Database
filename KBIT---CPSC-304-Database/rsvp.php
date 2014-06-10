<!DOCTYPE html>
<html lang="en">
  <head>
  </head>
<body>
		<h1>RSVP</h1>
		<form role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
		<div class="form-group">
			<label for="attending">I will be attendind...</label><br>
				<input type="radio" name="attending" value="ceremony">Ceremony Only<br>
				<input type="radio" name="attending" value="reception">Reception Only<br>
				<input type="radio" name="attending" value="both">Both<br>
				<input type="radio" name="attending" value="neither">Neither
		</div>
		<div class="form-group">
			<label for="extraGuests">Number of extra guests</label>
			<input type="number" class="form-control" name="guest1" placeholder="#">
		</div>
		<div class="form-group">
			<label for="guest1">Name of extra guest</label>
			<input type="text" class="form-control" name="guest1" placeholder="Name">
		</div>
		<div class="form-group">
			<label for="guest2">Name of extra guest</label>
			<input type="text" class="form-control" name="guest2" placeholder="Name">
		</div>
		<div class="form-group">
			<label for="guest3">Name of extra guest</label>
			<input type="text" class="form-control" name="guest3" placeholder="Name">
		</div>
		<div class="form-group">
			<label for="guest4">Name of extra guest</label>
			<input type="text" class="form-control" name="guest4" placeholder="Name">
		</div>
		<div class="form-group">
			<label for="guest5">Name of extra guest</label>
			<input type="text" class="form-control" name="guest5" placeholder="Name">
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
