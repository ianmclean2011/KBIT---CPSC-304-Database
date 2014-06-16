<?php
 
 //$id = $_GET['id'];
 
  $db_conn = OCILogon("ora_p7m5", "a62141049", "ug");
 
  if ($db_conn) {
			//$deleteQuery= OCI_PARSE($db_conn,"DELETE FROM SupplyQuoted WHERE gID = '$id'");
	  		//OCI_EXECUTE($deleteQuery);
	  		
			OCILogoff($db_conn);
			} else {
				echo "cannot connect";
				$e = OCI_Error(); // For OCILogon errors pass no handle
				echo htmlentities($e['message']);
			}

	//header('location:supplylist.php');
?>