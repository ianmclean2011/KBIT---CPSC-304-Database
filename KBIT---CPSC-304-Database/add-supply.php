<!DOCTYPE html>
<html lang="en">
	<head></head>
	<body>
	<h1>Add Supply</h1>
		<form role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
			<div class="form-group">
				<label for="itemName">Item/Service Name</label>
				<input type="text" class="form-control" name="itemName" placeholder="Item/Service Name">
			</div>
			<div class="form-group">
				<label for="numItems">Number needed</label>
				<input type="number" class="form-control" name="neededItem" placeholder="#">
			</div>
			<div class="form-group">
				<label for="company">Vendor ID</label>
				<input type="text" class="form-control" name="company" placeholder="#">
			</div>

			<button type="submit" name="addsupply" class="btn btn-default">
				Add
			</button>
		</form>
		
		<?php

//this tells the system that it's no longer just parsing 
//html; it's now parsing PHP

$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_p7m5", "a62141049", "ug");

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
		echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
		$e = oci_error($statement); // For OCIExecute errors pass the statementhandle
		echo htmlentities($e['message']);
		$success = False;
	} else {

	}
	
	return $r;

}
$vendExist = 5;
if (array_key_exists('addsupply', $_POST)) { //If the click addSupply button
			//parses out a list of vendor IDs
			$gID = 'SELECT gID FROM Vendor';
			$pgID = oci_parse($db_conn, $gID);
			oci_execute($pgID);
			

			//goes through the list of vendor IDs
			while (oci_fetch($pgID)) {
				
				
				$compID = oci_result($pgID, 'GID');
				//vendor ID entered by user
				$compID2 = $_POST[company];
			
				//Checks to see if the vendor ID entered matches one of a pre-existing vendor
				if($compID2 == $compID){
					$vendExist=1;
					//Checks to see if the user entered an item and the number needed
					if ($_POST[itemName]== "" || $_POST[neededItem]==""){
						echo "Please enter an item name and the number of that item that is required.";
					} else {
						//looks for the company associated with the ID entered
						$compSearch = 'select companyName from Vendor where gID = '.$compID;
						
						//parses out the company associated with the entered ID
						$company = oci_parse($db_conn,$compSearch);
						oci_execute($company);
						$compName=oci_fetch_array($company, OCI_BOTH);
						echo $compName['COMPANYNAME'];
						
						//Inserts the new supply into the supplyquoted table
						$newSupply=oci_parse($db_conn,"INSERT INTO SupplyQuoted VALUES (:bv_id, :bv_company, :bv_item, :bv_number,0,0)");
						oci_bind_by_name($newSupply,":bv_id",$compID);
						oci_bind_by_name($newSupply,":bv_company",$compName['COMPANYNAME']);
						oci_bind_by_name($newSupply,":bv_item",$_POST[itemName]);
						oci_bind_by_name($newSupply,":bv_number",$_POST[neededItem]);
						oci_execute($newSupply);
						
						echo "It worked";
						OCICommit($db_conn);
					}					
				   //$vendExist = 1;
    			   //echo $compID;
				}   
			}
				if ($vendExist == 5){
					echo "The Vendor you have chosen does not exist. Please choose a Vendor that exists, or please update the Vendor list.";
				}
			OCILogoff($db_conn);	
			}
	
?>
		
	</body>
</html>
