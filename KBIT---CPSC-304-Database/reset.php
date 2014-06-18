<!DOCTYPE html>
<html lang="en">
	<head></head>
	<body>
	<h2>Database has been reset!</h2>
	<?php
	include 'sqlFunction.php';
	
	$db_conn = OCILogon("ora_p7m5", "a62141049", "ug");
	
	if ($db_conn) 
	{
			$sqlFile=file_get_contents('project.sql');
			$sqlFile = explode(";", $sqlFile);
			
			foreach($sqlFile as $sqlCommand)
			{
				executePlainSQL($sqlCommand);
			}
			
			OCILogoff($db_conn);
	} 
	?>
	</body>
</html>
	