<!DOCTYPE html>
<html lang="en">
	<head></head>
	<body>
		<h1>Add Quote</h1>
		<form role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
			<div class="form-group">
				<label for="itemName">Item/Service Name</label>
				<input type="text" class="form-control" name="itemName" placeholder="Item/Service Name">
			</div>
			<div class="form-group">
				<label for="unitPrice">Price/Unit</label>
				<input type="number" class="form-control" name="unitPrice" placeholder="Price/Unit" step="0.01">
			</div>
			<div class="form-group">
				<label for="extraGuests">Number needed</label>
				<input type="number" class="form-control" name="extraGuests" placeholder="#">
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
