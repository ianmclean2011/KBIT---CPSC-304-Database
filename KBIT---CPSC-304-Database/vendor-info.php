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
		<h1>Welcome, 
		<form role="form" action="<?php $_SERVER['PHP_SELF']?>" method="post">
		<?php
			$db_conn = OCILogon("ora_p7m5", "a62141049", "ug");
			$name = executePlainSQL("select companyname from Vendor where gid = '". $_GET[id] . "'");
			$nameRow = OCI_Fetch_Array($name, OCI_BOTH);
			echo " ".$nameRow["COMPANYNAME"];	
		
			
		?>
		</form>
		</h1><br />
		<h3>Requested Supplies:</h3>
		<form role="form" action="<?php $_SERVER['PHP_SELF']?>" method="post">
					<table class="table table-striped">
					<tr>
						<th>Item Name</th>
						<th>Number Required</td>
						<th>Price/Unit</th>
						<th>Total Cost</th>
						<th>Modify Quote</th>
						<th>Add Supply Provided</th>
					</tr>
					
		<?php
		
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

			function printQuotedResult($result) { //prints results from a select statement
				
			
			while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
					echo "<tr>
						<td>" . $row["ITEMNAME"] . "</td>
						<td>" . $row["QUOTEDNUMBER"] ."</td>
						<td>" . $row["UNITCOST"] ."</td>
						<td>" . $row["TOTALCOST"] ."</td>
						<td><a href=\"vendor.php?id=".$row["GID"]."|".$row["ITEMNAME"]."&page=modify-quote\">Select</a></td>
						<td><a href=\"vendor.php?id=".$row["GID"]."|".$row["ITEMNAME"]."|".$row["COMPANYNAME"]."&page=add-provided\">Select</a></td>
						</tr>"; 
						//<td>"."<button type=\"submit\" class=\"btn btn-link\" name=\"modify\" value=\"" . $row["GID"] ."|".$row["ITEMNAME"]."\">Modify</button></td>
					
				}
				
			}
			
			// Print result if database connection is successful
			if ($db_conn) {
					// Select data...
			$result = executePlainSQL("select * from SupplyQuoted where gID ='".$_GET[id]."'");
			printQuotedResult($result);
			OCICommit($db_conn);
		
			//$deleteQuery= OCI_PARSE($db_conn,"DELETE FROM SupplyQuoted WHERE gID = '$id'");
	  		//OCI_EXECUTE($deleteQuery);
			//OCILogoff($db_conn);
			} else {
				echo "cannot connect";
				$e = OCI_Error(); // For OCILogon errors pass no handle
				echo htmlentities($e['message']);
			}
		?>
		
		</table>
		
		<h3>Provided Supplies:</h3>
					<table class="table table-striped">
					<tr>
						<th>Item Name</th>
						<th>Number Provided</td>
						<th>Price/Unit</th>
						<th>Total Cost</th>
						<th>Remove</th>
						
					</tr>
					
		<?php
			
					
		function printProvidedResult($result) { //prints results from a select statement
				
			
			while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
					echo "<tr>
						<td>" . $row["ITEMNAME"] . "</td>
						<td>" . $row["PROVIDEDNUMBER"] ."</td>
						<td>" . $row["UNITCOST"] ."</td>
						<td>" . $row["TOTALCOST"] ."</td>
						<td>"."<button type=\"submit\" class=\"btn btn-link\" name=\"remove\" value=\"" . $row["GID"] ."|".$row["ITEMNAME"]."\">Remove</button></td>
						</tr>"; 
						//<td>"."<button type=\"submit\" class=\"btn btn-link\" name=\"modify\" value=\"" . $row["GID"] ."|".$row["ITEMNAME"]."\">Modify</button></td>
					
				}
				
			}
			
			// Print result if database connection is successful
			if ($db_conn) {
					// Select data...
			$result = executePlainSQL("select s.gID, s.itemName,s.providedNumber,q.unitcost,s.providednumber*q.unitcost as totalcost  from SupplyQuoted q, 
			SupplyProvided s where s.gID ='".$_GET[id]."' and q.gID='".$_GET[id]."' and s.itemName=q.itemName");
			printProvidedResult($result);
			
			if(array_key_exists('remove', $_POST)){
			
			$separateValue = explode("|",$_POST['remove']);
			$removeGid = $separateValue[0];
			$removeItemName=$separateValue[1];
			
		
			$deleteItem=oci_parse($db_conn,"delete from  SupplyProvided WHERE gid='" . $removeGid."' and itemname='" . $removeItemName."'");
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