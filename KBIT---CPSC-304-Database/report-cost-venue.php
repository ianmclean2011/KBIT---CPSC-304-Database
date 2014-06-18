				<?php
				setlocale(LC_MONETARY, 'en_CA');


				$queryString = "CREATE VIEW VenueTCost AS 
								SELECT v.vName, suf.itemName, suf.qty * sq.unitCost AS totalCost
								FROM SupplyUsedFor suf, Venue v, SupplyQuoted sq
								WHERE v.vID = suf.vID AND suf.itemName = sq.itemName AND suf.companyName = sq.companyName
								ORDER BY vName Desc, totalCost Desc";
				$queryStringPrint = "SELECT * FROM VenueTCost";
				$queryStringSum = "SELECT SUM(totalCost) 
								            FROM VenueTCost";
				$queryStringEachVenueSum = "SELECT vName, SUM(totalCost) 
								            FROM VenueTCost
								            GROUP BY vName";
				$queryStringPost = "DROP VIEW VenueTCost";

				executePlainSQL($queryString);
				OCICommit($db_conn);
				$Result = executePlainSQL($queryStringPrint);
				echo "<table id=\"2-1m\" width=100%><tr><th>Venue</th><th>Item</th><th>TotalCost</th></tr>";
				while ($row = OCI_Fetch_Array($Result, OCI_NUM))
				{
					echo "<tr><td>".$row[0]."</td>";
					echo "<td>".$row[1]."</td>";
					echo "<td>".money_format('%.2n', $row[2])."</td></tr>";
				}
				$Result = executePlainSQL($queryStringSum);
				while ($row = OCI_Fetch_Array($Result, OCI_NUM))
				{
					echo "<tr><td>Total</td><td></td><td><h2>".money_format('%.2n', $row[0])."</h2></td></tr>";
				}
				echo "</table>";


				$Result = executePlainSQL($queryStringEachVenueSum);
				echo "<table id=\"2-2m\" width=100%><tr><th>Venue</th><th></th><th>TotalCost</th></tr>";
				while ($row = OCI_Fetch_Array($Result, OCI_NUM))
				{
					echo "<tr><td>".$row[0]."</td><td></td>";
					echo "<td>".money_format('%.2n', $row[1])."</td></tr>";
				}
				$Result = executePlainSQL($queryStringSum);
				while ($row = OCI_Fetch_Array($Result, OCI_NUM))
				{
					echo "<tr><td>Total</td><td></td><td><h2>".money_format('%.2n', $row[0])."</h2></td></tr>";
				}
				echo "</table>";

				$Result = executePlainSQL($queryStringPost);
				OCICommit($db_conn);
				?>
