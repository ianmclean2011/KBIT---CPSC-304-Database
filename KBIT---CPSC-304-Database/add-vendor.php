<?php 
include 'idGen.php';
include 'connect.php';
include 'sqlFunction.php';
include 'checkDuplicateGID.php';

if ($_POST)
{
	// Check for empty field
	$companyNameNoSpace = str_replace(' ', '', $_POST["companyName"]);
	// Check for Company Name 
	if (!ctype_alpha($companyNameNoSpace))
		echo "<SCRIPT>alert('Your company name can't contain number/symbol.');</SCRIPT>";
	else if (empty($_POST["firstName"]) || empty($_POST["lastName"]) || empty($companyNameNoSpace))
		echo "<SCRIPT>alert('All fields must not be empty.');</SCRIPT>";
	// Check for empty space in first/last name
	else if (preg_match('/\s/',$_POST["firstName"]) || preg_match('/\s/',$_POST["lastName"]))
		echo "<SCRIPT>alert('Your first/last name can\'t contain space.');</SCRIPT>";
	// Check for non-alphabetic letter for first and last name;
	else if (!ctype_alpha($_POST["firstName"]) || !ctype_alpha($_POST["lastName"]))
		echo "<SCRIPT>alert('Your first/last name can\'t contain number/symbol.');</SCRIPT>";
	// Check for non-digit letter for extraGuests;
	else if (!ctype_digit($_POST["extraGuests"]))
		echo "<SCRIPT>alert('Please use digits for the number of extra guests entry.');</SCRIPT>";
	// Given proper input, insert the data into the Guest table
	else 
	{	// Creating a unique GID & check that it is unique.
		$cmdstr = "SELECT COUNT(*) FROM Guest";
		$guestCountResult = executePlainSQL($cmdstr);
		$guestCount = oci_fetch_array($guestCountResult, OCI_BOTH);
		$guestSeed = intval($guestCount["COUNT(*)"]);
		$guestType = 2; // 1 for guests, 2 for vendors
		Do{
			$guestID = idGen($guestType, $guestSeed++); // Tries to find an unused ID
		} while (checkDuplicateGID($guestID));

		//If guestID is null, then all assignable unique IDs have been used. Do not proceed.
		if ($guestID == null) {
			  echo "Unable to add Vendor, all assignable IDs have been used.";
		} else {
		$cmdstr = "INSERT INTO Guest (GID, name, maxNumberAllowed, numberBringing) VALUES ('"
				.$guestID."', '".
				$_POST["firstName"]." ".$_POST["lastName"]."', ".
				$_POST["extraGuests"].", 0)";
		// Executing the query
		executePlainSQL($cmdstr);
		OCICommit($db_conn);

		$cmdstr2 = "INSERT INTO Vendor (GID, companyName) VALUES ('"
			.$guestID."', '".$_POST["companyName"]."')";
		executePlainSQL($cmdstr2);
		OCICommit($db_conn);
			// Display Insertion summary
		echo "<h2>The vendor is added successfully. </h2><br>";
		echo "<h3> Name : ".$_POST["firstName"]." ".$_POST["lastName"]."<br>";
		echo "Number of extra guests allowed : ".$_POST["extraGuests"]."<br>";
		echo "Companyname : ".$_POST["companyName"]."<br>";
		echo "Guest ID : <b>".$guestID."</b></h3><br>";
		echo "<h3>Please inform the vendor to use this ID for the access.</h3><br>";
		}
	}
}		

?>

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
		<button type="submit" class="btn btn-default">
			Add
		</button>			
	</form>

  </body>
</html>
