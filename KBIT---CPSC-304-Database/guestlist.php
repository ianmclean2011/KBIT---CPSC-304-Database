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
		<h1>Guestlist</h1>
		<?php
			$db_conn = OCILogon("ora_p7m5", "a62141049", "ug");
			
			function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
				global $db_conn;
				$statement = OCIParse($db_conn, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

				if (!$statement) {
					echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
					$e = OCI_Error($db_conn); // For OCIParse errors pass the       
					// connection handle
					echo htmlentities($e['message']);
				}

				$r = OCIExecute($statement, OCI_DEFAULT);
				if (!$r) {
					echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
					$e = oci_error($statement);
					echo htmlentities($e['message']);
				} else {

				}
				return $statement;
			}

			function printGuestlistForVenue($venueID, $venueName) {
				echo "<table class='table table-striped'>
					<caption><h3><u>" . $venueName . "</h3></u></caption>
					<tr>
						<th>Guest ID</th>
						<th>Guest Name</th>
						<th>Table #</th>
						<th>Max # of Guests Allowed</th>
						<th>Bringing # of Guests</th>
						<th>Dependent Guests(s)</th>
					</tr>";
				
				$result = executePlainSQL("SELECT * FROM Guest G, v_InvitedTo V WHERE G.gID = V.gID AND V.vID =" . $venueID);
				
				while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
					echo "<tr>
						<td>" . $row["GID"] . "</td>
						<td>" . $row["NAME"] . "</td>
						<td>" . $row["TABLENO"] . "</td>";
						
						if ($row["MAXNUMBERALLOWED"] != null)
						{
							echo "<td>" . $row["MAXNUMBERALLOWED"] . "</td>";
						}
						else
						{
							echo "<td> 0 </td>";
						}
						
						if ($row["NUMBERBRINGING"] != null || $row["NUMBERBRINGING"] >= 0)
						{
							echo "<td>" . $row["NUMBERBRINGING"] . "</td>";
							
							$dependentNames = executePlainSQL("SELECT name FROM DependentGuest D WHERE D.gID =" . $row["GID"]);
							echo "<td>";
							while ($dependentRow = OCI_Fetch_Array($dependentNames, OCI_BOTH))
							{
								echo $dependentRow["NAME"] . "<br>";
							}
							echo "</td>";
						}
						else
						{
							echo "<td> 0 </td>";
						}
					echo "</tr>";
				}				
				echo "</table>";
			}
			// Print result if database connection is successful
			if ($db_conn){
				$venueResult = executePlainSQL("SELECT vID, vName FROM Venue");
			
				while ($venue = OCI_Fetch_Array($venueResult, OCI_BOTH)){
					printGuestlistForVenue($venue["VID"], $venue["VNAME"]);
				}
				OCILogoff($db_conn);
			} else {
				echo "cannot connect";
				$e = OCI_Error(); // For OCILogon errors pass no handle
				echo htmlentities($e['message']);
			}
		?>
	</body>
</html>