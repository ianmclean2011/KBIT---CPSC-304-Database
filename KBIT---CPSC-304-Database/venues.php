<!DOCTYPE html>
<html lang="en">
	<head></head>
	<body>
		<h1>Venues</h1>
		Display: <br>
		<form class="form-inline" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
		<input type="checkbox" name="columns[]" value="usage">Usage
		<input type="checkbox" name="columns[]" value="address">Address
		<input type="checkbox" name="columns[]" value="capacity">Capacity
		<button type="submit" class="btn btn-default">Refresh</button>
		
		
		
		<table class="table table-striped">
			<tr>
				<th>Name</th>
				
				<?php
		$db_conn = OCILogon("ora_p7m5", "a62141049", "ug");
						
		$columnSelect = "vID, vName";
		
		if(in_array("usage", $_POST['columns']))
			$columnSelect .= ", usage";
		if(in_array("address", $_POST['columns']))
			$columnSelect .= ", vAddress";
		if(in_array("capacity", $_POST['columns']))
			$columnSelect .= ", vCapacity";

		$venueInfo = executePlainSQL("select " . $columnSelect . " from Venue");
		
		if(array_key_exists('remove', $_POST)){
			executePlainSQL("delete from Venue where vid='" . $_POST['remove'] . "'");
			OCICommit($db_conn);
		}
			
			if(in_array("usage", $_POST['columns']))
				echo "<th>Usage</th>";
				else echo "<th></th>";
			if(in_array("address", $_POST['columns']))
				echo "<th>Address</th>";
				else echo "<th></th>";
			if(in_array("usage", $_POST['columns']))
				echo "<th>Capacity</th>";
				else echo "<th></th>";
				
				echo "<td>Remove</td></tr>";

			while($venueInfoRow = OCI_Fetch_Array($venueInfo, OCI_BOTH)){
				echo "<tr>";
				
				echo "<td>" . $venueInfoRow["VNAME"] . "</td>";
				
				echo "<td>" . $venueInfoRow["USAGE"] . "</td>";

				echo "<td>" . $venueInfoRow["VADDRESS"] . "</td>";

				echo "<td>" . $venueInfoRow["VCAPACITY"] . "</td>";
				
				echo "<td><button type=\"submit\" class=\"btn btn-link\" name=\"remove\" value=\"" . $venueInfoRow["VID"] . "\">Remove</button></td>";
				echo "</tr>";
			}
			
			?>
		</table></form>
			
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