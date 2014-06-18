				<?php
				setlocale(LC_MONETARY, 'en_CA');


				$queryString = "CREATE VIEW VendorTCost AS 
								SELECT sp.companyName, sp.itemName, sp.providedNumber * sq.unitCost AS totalCost
								FROM SupplyProvided sp, SupplyQuoted sq
								WHERE sp.gID = sq.gID AND sp.itemName = sq.itemName
								ORDER BY companyName Desc, itemName Desc";
				$queryStringPrint = "SELECT * FROM VendorTCost";
				$queryStringSum = "SELECT SUM(totalCost) 
								            FROM VendorTCost";
				$queryStringEachVendorSum = "SELECT companyName, SUM(totalCost) 
								            FROM VendorTCost
								            GROUP BY companyName";
				$queryStringPost = "DROP VIEW VendorTCost";

				executePlainSQL($queryString);
				OCICommit($db_conn);
				$Result = executePlainSQL($queryStringPrint);
				echo "<table id=\"3-1m\" width=100%><tr><th>Vendor</th><th>Item</th><th>TotalCost</th></tr>";
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


				$Result = executePlainSQL($queryStringEachVendorSum);
				echo "<table id=\"3-2m\" width=100%><tr><th>Vendor</th><th></th><th>TotalCost</th></tr>";
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
