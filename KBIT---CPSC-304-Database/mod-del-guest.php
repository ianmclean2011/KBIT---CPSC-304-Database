<?php
include 'connect.php';
include 'sqlFunction.php';

// Delete Tuple of guest with specific GID
if($_REQUEST["deleteGID"])
  {
  	echo "<h2>The guest is deleted successfully. </h2><br>";
	echo "<h3> gID : ".$_REQUEST['deleteGID'];

     $cmdstr = "DELETE FROM Guest WHERE gID = '".$_REQUEST['deleteGID']."'";
     executePlainSQL($cmdstr);
	 OCICommit($db_conn);
     exit();

  }

?>

<!DOCTYPE html>
<html>
<head>
<script src="js/jquery-1.11.1.min.js"></script>
</head>
<body>

<table width=100%>
	<tr>
		<th width=3%> 
		</th>
		<th width=7%>
			Guest ID
		</th>
		<th width=30%>
			Name
		</th>
		<th width=10%>
			# Extra Guest Allowed
		</th>
		<th width=10%>
			# Extra Guest Bringing
		</th>
		<th width=30%>
			Extra Guest Name
		</th>
	</tr>

<?php
$result = executePlainSQL("SELECT * FROM Guest");
$oddRow=true; // For table alternating color
// Prints the guests
while ($row = OCI_Fetch_Array($result, OCI_NUM)) 
{
	$gID = $row[0];
	$name = $row[1];
	$maxDG = $row[2];
	$numDG = $row[3];
	if ($oddRow) echo "<tr bgcolor=#ffffff>"; else echo "<tr bgcolor=#dddddd>"; // A simple alternating background color stuff
	echo "<td>";

	// Link for deleting a tuple with specific GID
	$tempDelStr = "<td><input name=delGuest".$row[0]."type='image' width='20' height='20' src=\"image/delete.png\" onclick=\"deleteGuest('".$row[0];
	$tempDelStr = sprintf("%8.100s",$tempDelStr)."')\"></input>";
	echo "<form action=\"".$_PHP_SELF. "\" method=\"POST\">";
	echo "<input type=\"hidden\" name=\"deleteGID\" value=\"".$gID."\">";
	echo "<input type=image src=\"image\delete.png\" type=\"submit\" width=20 height=20 alt=\"Submit Form\" ></form>";
	echo "</td>";
	// Rest of the info about the guest
	echo "<td>".$gID."</td>";
	echo "<td>".$name."</td>";
	echo "<td>".$maxDG."</td>";
	echo "<td>".$numDG."</td>";
	echo "<td>";

	// This part prints all the extra guests
	$depCmdStr = "SELECT name FROM DependentGuest WHERE gID = '".$gID;
	$depCmdStr = sprintf("%8.51s",$depCmdStr)."'"; 
	$nestedResult = executePlainSQL($depCmdStr);
	while ($row2 = OCI_Fetch_Array($nestedResult, OCI_NUM))
	{
		echo $row2[0]."<br>";
	}

	echo "</td>";
	echo "</tr>";
	$oddRow = !$oddRow;
}
?>

</table>
</body>
</html>

