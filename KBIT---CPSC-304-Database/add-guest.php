<?php

include 'idGen.php';
include 'connect.php';
include 'sqlFunction.php';


if (empty($_POST["firstName"]) || empty($_POST["lastName"]) || empty($_POST["extraGuests"]) || empty($_POST["email"]) || empty($_POST["emailRe"]))
	echo "<SCRIPT>alert('All fields must not be empty.');</SCRIPT>";
else 
{
	$cmdstr = "INSERT INTO Guest (GID, name, maxnumberallowed, numberBringing) VALUES ('".
	idGen()."', '".
	$_POST["firstName"]." ".$_POST["lastName"]."', ".
	"0, ".
	$_POST["extraGuests"].")";
	echo "Guest added successfully<br><br>command executed : ".$cmdstr;

	executePlainSQL($cmdstr);
	OCICommit($db_conn);
}



?>

<!DOCTYPE html>
<html lang="en">
  <head>
  </head>
<body>
		<h1>Add Guest</h1>
		<form role="form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
		<div class="form-group">
			<label for="firstName">First Name</label>
			<input type="text" class="form-control" name="firstName" placeholder="First Name">
		</div>
		<div class="form-group">
			<label for="lastName">Last Name</label>
			<input type="text" class="form-control" name="lastName" placeholder="Last Name">
		</div>
		<div class="form-group">
			<label for="extraGuests">Number of extra guests</label>
			<input type="number" class="form-control" name="extraGuests" placeholder="#" size="2">
		</div>
		<div class="form-group">
			<label for="email">Email</label>
			<input type="email" class="form-control" name="email" placeholder="Email">
		</div>
		<div class="form-group">
			<label for="emailRe">Re-Type Email</label>
			<input type="email" class="form-control" name="emailRe" placeholder="Re-Type Email">
		</div>
		<button type="submit" class="btn btn-default">
			Add
		</button>			
	</form>

</body>
</html>
