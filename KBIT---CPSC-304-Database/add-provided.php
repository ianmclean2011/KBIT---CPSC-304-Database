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

if (array_key_exists('addProvided', $_POST)) { //If the click addSupply button
			
					if ($_POST[providedItem]== ""){
						echo "Please enter the number of items provided.";
					}else{	
												
						//Inserts the provided supplies into the supplyquoted table
						$newSupply=oci_parse($db_conn,"INSERT INTO SupplyProvided VALUES (:bv_id, :bv_company, :bv_item, :bv_numProv)");
						
						
						oci_bind_by_name($newSupply,":bv_id",$vendorID);
						oci_bind_by_name($newSupply,":bv_company",$compName);
						oci_bind_by_name($newSupply,":bv_item",$itemName);
						oci_bind_by_name($newSupply,":bv_numProv",$_POST[providedItem]);
						
						oci_execute($newSupply);
						
						OCICommit($db_conn);
						
					}				
				 }
			OCILogoff($db_conn);	
			
	
?>
		
	</body>
</html>