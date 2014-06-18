<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Team K-BIT - Wedding Planner</title>

		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<h1>Supply List</h1>
		<form role="form" action="<?php $_SERVER['PHP_SELF']?>" method="post">
					<table class="table table-striped">
					<tr>
						<th>Vendor</th>
						<th>Item Name</th>
						<th>Number Required</td>
						<th>Price/Unit</th>
						<th>Total Cost</th>
						<th>Remove</th>
					</tr>
					
		<?php
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
				return $statement;
			}

			function printResult($result) { //prints results from a select statement
				
			
			while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
					echo "<tr>
						<td>" . $row["COMPANYNAME"] . "</td>
						<td>" . $row["ITEMNAME"] . "</td>
						<td>" . $row["QUOTEDNUMBER"] ."</td>
						<td>" . $row["UNITCOST"] ."</td>
						<td>" . $row["TOTALCOST"] ."</td>
						<td>"."<button type=\"submit\" class=\"btn btn-link\" name=\"remove\" value=\"" . $row["GID"] ."|".$row["ITEMNAME"]."\">Remove</button></td>
					</tr>"; 
				}
				
			}
			
			// Print result if database connection is successful
			if ($db_conn) {
					// Select data...
			$result = executePlainSQL("select * from SupplyQuoted");
			printResult($result);
			
			if(array_key_exists('remove', $_POST)){
			
			$separateValue = explode("|",$_POST['remove']);
			$removeGid = $separateValue[0];
			$removeItemName=$separateValue[1];
			
		
			$deleteItem=oci_parse($db_conn,"delete from  SupplyQuoted WHERE gid='" . $removeGid."' and itemname='" . $removeItemName."'");
			oci_execute($deleteItem);
			
			
		}
			OCICommit($db_conn);
			//$deleteQuery= OCI_PARSE($db_conn,"DELETE FROM SupplyQuoted WHERE gID = '$id'");
	  		//OCI_EXECUTE($deleteQuery);
			OCILogoff($db_conn);
			} else {
				echo "cannot connect";
				$e = OCI_Error(); // For OCILogon errors pass no handle
				echo htmlentities($e['message']);
			}
		?>
		</table></form>
		

	</body>
</html>