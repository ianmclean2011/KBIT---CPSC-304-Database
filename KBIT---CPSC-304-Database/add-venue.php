<!DOCTYPE html>
<html lang="en">
	<head></head>
	<body>
	<?php
	 include 'idGen.php';
	 
		$db_conn = OCILogon("ora_p7m5", "a62141049", "ug");
		if(($_POST['name'] && $_POST['address'] && $_POST['city'] && $_POST['province']) != ""){
			executePlainSQL("INSERT INTO Venue VALUES ('" . idGen() . "'," . $_POST['capacity'] . ",'" . $_POST['usage'] . "','" . $_POST['name'] . "','" . 
			$_POST['address'] . " " . $_POST['city'] . " " . $_POST['province'] . "')");
			OCICommit($db_conn);
		}
		else echo "Please enter the venue name, address and city."
	
	
	?>
	<h1>Add Venue</h1>
		<form role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
			<div class="form-group">
				<label for="vName">Venue Name</label>
				<input type="text" class="form-control" name="name" placeholder="Venue Name">
			</div>
			<div class="form-group">
				<label for="capacity">Capacity</label>
				<input type="number" class="form-control" name="capacity" placeholder="#" size="2">
			</div>
			<div class="form-group">
				<label for="usage">Usage</label>
				<input type="text" class="form-control" name="usage" placeholder="Usage">
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
				<input type="text" class="form-control" name="province" placeholder="Province/State">
			</div>
			<button type="submit" class="btn btn-default">
				Add
			</button>
		</form>
<?php

//this tells the system that it's no longer just parsing 
//html; it's now parsing PHP

$success = True; //keep track of errors so it redirects the page only if there are no errors


function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
	//echo "<br>running ".$cmdstr."<br>";
	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

	if (!$statement) {
		echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn); // For OCIParse errors pass the       
		// connection handle
		echo htmlentities($e['message']);
		$success = False;
	}

	$r = OCIExecute($statement, OCI_DEFAULT);
	if (!$r) {
		//echo "<br>Please enter your first name, last name or the ID # on your invitation";
		$e = oci_error($statement); // For OCIExecute errors pass the statementhandle
		echo htmlentities($e['message']);
		$success = False;
	} else {

	}
	return $statement;

}

// Connect Oracle...
if ($db_conn) {
	OCILogoff($db_conn);
} else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}

?>
	</body>
</html>
