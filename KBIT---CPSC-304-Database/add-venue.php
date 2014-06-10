<!DOCTYPE html>
<html lang="en">
	<head></head>
	<body>
	<h1>Add Venue</h1>
		<form role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
			<div class="form-group">
				<label for="vName">Venue Name</label>
				<input type="text" class="form-control" name="vName" placeholder="Venue Name">
			</div>
			<div class="form-group">
				<label for="capacity">Capacity</label>
				<input type="number" class="form-control" name="capacity" placeholder="#" size="2">
			</div>
			<div class="form-group">
				<label for="usage">Usage</label>
				<select class="form-control" name="usage">
					<option value="ceremony">Ceremony</option>
					<option value="reception">Reception</option>
					<option value="other">Other</option>
				</select>
			</div>
			<div class="form-group">
				<label for="address">Address</label>
				<input type="text" class="form-control" name="address" placeholder="Address">
			</div>
			<div class="form-group">
				<label for="city">City</label>
				<input type="text" class="form-control" name="city" placeholder="City">
			</div>
			<div class="form-group">
				<label for="city">Province</label>
				<input type="text" class="form-control" name="province" placeholder="Province">
			</div>
			<button type="submit" class="btn btn-default">
				Add
			</button>
		</form>

		<?php
		//delete this test script
		echo "First Name: ", $_POST["vName"];
		echo "<br>";
		echo "Last Name: ", $_POST["capacity"];
		echo "<br>";
		echo "Number of guests: ", $_POST["address"];


		?>
	</body>
</html>
