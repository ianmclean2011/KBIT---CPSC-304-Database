				<?php
				setlocale(LC_MONETARY, 'en_CA');

				$queryString = "CREATE VIEW ItemTCost AS
								SELECT sp.itemName, sp.providedNumber * sq.unitCost AS totalCost 
								FROM SupplyProvided sp, SupplyQuoted sq
								WHERE sp.itemName = sq.itemName AND sp.gID = sq.gID
								ORDER BY totalCost Desc";
				$queryStringPrint = "SELECT * FROM ItemTCost";
				$queryStringSum = "SELECT SUM(totalCost) FROM ItemTCost";
				$queryStringPost = "DROP VIEW ItemTCost";

				executePlainSQL($queryString);
				OCICommit($db_conn);
				$Result = executePlainSQL($queryStringPrint);
				echo "<table id=\"1-1m\" width=100%><tr><th>Item</th><th>TotalCost</th></tr>";
				while ($row = OCI_Fetch_Array($Result, OCI_NUM))
				{
					echo "<tr><td>".$row[0]."</td>";
					echo "<td>".money_format('%.2n', $row[1])."\n"."</td></tr>";
				}
				$Result = executePlainSQL($queryStringSum);
				while ($row = OCI_Fetch_Array($Result, OCI_NUM))
				{
					echo "<tr><td>Total</td><td><h2>"money_format('%.2n', $row[0])."\n"."</h2></td></tr>";
				}
				echo "</table>";
				$Result = executePlainSQL($queryStringPost);
				OCICommit($db_conn);
				?>
