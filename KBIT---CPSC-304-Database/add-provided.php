<!DOCTYPE html>
<html lang="en">
	<head></head>
	<body>
	<h1>Add Provided Items</h1>
		<form role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
			<?php
			include 'sqlFunction.php';
			$success = True; //keep track of errors so it redirects the page only if there are no errors
	        $db_conn = OCILogon("ora_p7m5", "a62141049", "ug");
			$separateValue = explode("|",$_GET[id]);
			$vendorID = $separateValue[0];
			$itemName = $separateValue[1];
			$compName = $separateValue[2];
			echo $compName;
			
			echo "hello".$supValues['PROVIDEDNUMBER'];
			echo '<div class="form-group">
				<label for="itemName">Item/Service Name</label>
				<input type="text" class="form-control" name="itemName" value="'.$itemName.'" readonly>
			</div>
			<div class="form-group">
				<label for="numItems">Number Provided</label>
				<input type="number" class="form-control" name="providedItem">
			</div>
			
			

			<button type="submit" name="addProvided" class="btn btn-default">
				Add
			</button>';
			
			?>
		</form>
		
<?php		

//this tells the system that it's no longer just parsing 
//html; it's now parsing PHP





if (array_key_exists('addProvided', $_POST)) { //If the click addSupply button
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
					if ($_POST[providedItem]== ""){
						echo "Please enter the number of items provided.";
					}else{	
												
						//Inserts the modified supply into the supplyquoted table
						$newSupply=oci_parse($db_conn,"INSERT INTO SupplyProvided VALUES (:bv_id, :bv_company, :bv_item, :bv_numProv)");
						
						
						oci_bind_by_name($newSupply,":bv_id",$vendorID);
						oci_bind_by_name($newSupply,":bv_company",$compName);
						oci_bind_by_name($newSupply,":bv_item",$itemName);
						oci_bind_by_name($newSupply,":bv_numProv",$_POST[providedItem]);
						
						oci_execute($newSupply);
						echo $vendorID;
						echo $itemName;
						echo $compName;
						echo "It worked".$_POST[totalCost];
						OCICommit($db_conn);
						
					}				
				   //$vendExist = 1;
    			   //echo $compID;
				   
			
				
				}
			OCILogoff($db_conn);	
			
	
?>
		
	</body>
</html>