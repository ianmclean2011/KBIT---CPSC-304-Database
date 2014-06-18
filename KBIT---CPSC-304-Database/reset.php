<!DOCTYPE html>
<html lang="en">
	<head></head>
	<body>
	<h2>Database has been reset!</h2>
	<?php
	$db_conn = OCILogon("ora_p7m5", "a62141049", "ug");
 
  if ($db_conn) {
			
			$sqlFile=file_get_contents('project.sql');
			
			$reset=oci_parse($db_conn,$sqlFile);
	  		oci_execute($reset);

	  		
	  		
			oci_commit($db_conn);
			
			OCILogoff($db_conn);
			} 
?>
	</body>
</html>
	