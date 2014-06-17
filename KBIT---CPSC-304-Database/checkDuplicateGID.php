<?php
	function checkDuplicateGID($guestID)
	{
		// Query command
		$cmdstr = "SELECT GID
				FROM Guest 
				WHERE GID = '".$guestID."'";

		// Executing the query
		$result = executePlainSQL($cmdstr);
		$row = OCI_Fetch_Array($result, OCI_BOTH);

		// Need doublecheck for this statement
		if (isset($row[GID]))
		{
			echo "The ID is duplicate."; 
			return true;
		}
		else 
			echo "The ID is unique.";
			return false;			
	}
?>
