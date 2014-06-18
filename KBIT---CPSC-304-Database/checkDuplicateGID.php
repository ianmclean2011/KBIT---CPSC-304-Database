<?php
	function checkDuplicateGID($guestID)
	{
		// Query for checking if the newly generated ID already exists in Guest database
		$cmdstr = "SELECT GID
		   		   FROM Guest 
				   WHERE GID = '".$guestID."'";

		// Executing the query
		$result = executePlainSQL($cmdstr);
		while ($row = OCI_Fetch_Array($result, OCI_NUM))
		{					
			if (isset($row[GID]))
			{
				echo "The ID is duplicate."; 
				return true;
			}
		else 
			{
				echo "The ID is unique.";
				return false;			
			}
		}	
?>
