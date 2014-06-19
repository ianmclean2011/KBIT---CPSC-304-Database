<!DOCTYPE html>
<html lang="en">
	<head></head>
	<body>
	<h1>Modify Quote</h1>
		<form role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
			<?php
			include 'sqlFunction.php';
			$success = True; //keep track of errors so it redirects the page only if there are no errors
	        $db_conn = OCILogon("ora_p7m5", "a62141049", "ug");
			$separateValue = explode("|",$_GET[id]);
			$vendorID = $separateValue[0];
			$itemName = $separateValue[1];
			
			$retrieveValues = "select * from SupplyQuoted where gid='".$vendorID."' and itemname='".$itemName."'";
			$supplyValue = executePlainSQL($retrieveValues);
			while ($supValues = OCI_Fetch_Array($supplyValue, OCI_BOTH)) {
			
			
			echo "hello".$supValues['QUOTEDNUMBER'];
			echo '<div class="form-group">
				<label for="itemName">Item/Service Name</label>
				<input type="text" class="form-control" name="itemName" value="'.$itemName.'" readonly>
			</div>
			<div class="form-group">
				<label for="numItems">Number needed</label>
				<input type="number" class="form-control" name="neededItem" value="'.$supValues['QUOTEDNUMBER'].'" readonly>
			</div>
			<div class="form-group">
				<label for="numItems">Unit Cost</label>
				<input type="number" step="0.01" class="form-control" name="unitCost" value="'.$supValues['UNITCOST'].'">
			</div>
			<div class="form-group">
				<label for="numItems">Total Cost</label>
				<input type="number" step="0.01" class="form-control" name="totalCost" value="'.$supValues['TOTALCOST'].'">
			</div>
			

			<button type="submit" name="modifyQuote" class="btn btn-default">
				Modify
			</button>';
			}
			?>
		</form>
		
<?php		

//this tells the system that it's no longer just parsing 
//html; it's now parsing PHP





if (array_key_exists('modifyQuote', $_POST)) { //If the click addSupply button
			//parses out a list of vendor IDs
			
			/*$gID = 'SELECT gID FROM Vendor';
			$pgID = oci_parse($db_conn, $gID);
			oci_execute($pgID);
			

			//goes through the list of vendor IDs
			while (oci_fetch($pgID)) {
				
				
				$compID = oci_result($pgID, 'GID');
				//vendor ID entered by user
				$compID2 = $_POST[company];
			
				//Checks to see if the vendor ID entered matches one of a pre-existing vendor
				if($compID2 == $compID){
					$vendExist=1;*/
					//Checks to see if the user entered an item and the number needed
					if ($_POST[neededItem]== "" || $_POST[unitCost]=="" || $_POST[totalCost]==""){
						echo "Please enter values for the unit costs, and the total cost.";
					}else{	
												
						//Inserts the modified supply into the supplyquoted table
						$newSupply=oci_parse($db_conn,"Update SupplyQuoted Set totalcost=:bv_tCost,
						unitcost= :bv_uCost where gid='".$vendorID."' and itemname='".$itemName."'");
						oci_bind_by_name($newSupply,":bv_tCost",$_POST[totalCost]);
						oci_bind_by_name($newSupply,":bv_uCost",$_POST[unitCost]);
						oci_execute($newSupply);
						
					
						OCICommit($db_conn);
						
					}				
				   //$vendExist = 1;
    			   //echo $compID;
				   
			
				
				}
			OCILogoff($db_conn);	
			
	
?>
		
	</body>
</html>

