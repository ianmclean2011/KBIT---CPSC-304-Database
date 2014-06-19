<?php
include 'connect.php';
include 'sqlFunction.php';

?>

<!DOCTYPE html>
<html>
<head>
<script src="js/jquery-1.11.1.min.js"></script>

</head>
<body>
<h1>Delete/Modify Guest</h1><br>
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
// Delete Tuple of guest with specific GID
if($_REQUEST['deleteGuest'])
{
  	echo "<h2>The guest is deleted successfully. </h2><br>";

     $cmdstr = "DELETE FROM Guest WHERE gID = '".$_REQUEST['deleteGuest']."'";
     executePlainSQL($cmdstr);
	 OCICommit($db_conn);
}

else if($_REQUEST['changeGuest'])
{
	// Query to get the # of extra guests in order to compare with new max # update
	$sqlcmd = "SELECT numberBringing 
		   FROM Guest
		   WHERE gID = '".$_REQUEST['changeGuest']."'";
	$result = executePlainSQL($sqlcmd);
	while ($row = OCI_Fetch_Array($result, OCI_NUM))
	{
		$oldExtraG = $row[0];
	} //

	if ($_REQUEST['newName'] =='')
	$newName = $_REQUEST['oldName'];
	else $newName = $_REQUEST['newName'];

	if ($_REQUEST['newMax'] =='')
	$newMax = $_REQUEST['oldMax'];
	else $newMax = $_REQUEST['newMax'];

	// Check for non-alphabetic letter for first and last name;
	$newNameNoSpace = str_replace(' ', '', $newName);
	if (!ctype_alpha($newNameNoSpace))
		echo "<SCRIPT>alert('Your name can\'t contain number/symbol.');</SCRIPT>";
	// Check for non-digit letter for extraGuests;
	else if (!ctype_digit($newMax))
		echo "<SCRIPT>alert('Please use digits for the number of extra guests entry.');</SCRIPT>";
	// Check that #Extra Guest Allowed cannot be smaller than #Extra Guest a person is already bringing.
	else if ($newMax < $oldExtraG)
		echo "<SCRIPT>alert('You cannot update max# of extra guests lower than already he/she is bringing.');</SCRIPT>";
	else 
	{
     $cmdstr = "UPDATE Guest SET name='".$newName."', maxNumberAllowed=".$newMax. " WHERE gID = '".$_REQUEST['changeGuest']."'";
     executePlainSQL($cmdstr);
	 OCICommit($db_conn);

	 echo "<h2>The guest info is updated. </h2><br>";
	}
}



$result = executePlainSQL("SELECT * FROM Guest");
$oddRow=true; // For table alternating color
$color1 = '#ffffff';
$color2 = '#dddddd';
$colorTemp;
// Prints the guests
while ($row = OCI_Fetch_Array($result, OCI_NUM)) 
{
	$gID = $row[0];
	$name = $row[1];
	$maxDG = $row[2];
	$numDG = $row[3];

	echo "<tr bgcolor=".$color1." id='".$gID."'>"; // A simple alternating background color stuff
	echo "<td>";
	// Link for deleting a tuple with specific GID
	echo "<form action=\"".$_PHP_SELF. "\" method=\"POST\">";
	echo "<input type=\"hidden\" name=\"deleteGuest\" value=\"".$gID."\">";
	echo "<input type=image src=\"image\delete.png\" type=\"submit\" width=20 height=20 alt=\"Delete\" ></form>";
	echo "</td>";
	// Rest of the info about the guest
	echo "<td>".$gID."</td>";
	echo "<td>".$name;"</td>";
	echo "<td>".$maxDG."</td>";
	echo "<td>".$numDG."</td>";
	echo "<td>";

	// This part prints all the dependent guests
	$depCmdStr = "SELECT name FROM DependentGuest WHERE gID = '".$gID."'";
	//$depCmdStr = sprintf("%8.51s",$depCmdStr)."'"; 
	$nestedResult = executePlainSQL($depCmdStr);
	while ($row2 = OCI_Fetch_Array($nestedResult, OCI_NUM))
	{
		echo $row2[0]."<br>";
	}
	echo "</td>";
	echo "</tr>";

		//This row contains form for editing
	echo "<tr bgcolor=".$color1." id='edit".$gID."'>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td><form action=\"".$_PHP_SELF. "\" method=\"POST\">";
	echo "<input type=\"text\" name=\"newName\" >";
	echo "<input type=\"hidden\" name=\"oldName\" value=\"".$name."\">";
	echo "</td>";
	echo "<td><input type=\"text\" name =\"newMax\" >";
	echo "<input type=\"hidden\" name=\"oldMax\" value=".$maxDG.">";
	echo "</td>";
	echo "<td><input type=\"hidden\" name=\"changeGuest\" value=\"".$gID."\"></td>";
	echo "<td align=right><button type=\"submit\">Update</td></form>";
	echo "</tr>";
	// hides edit form initially.
	//echo "<script>$(document).ready(function(){";
	//echo "$(\"#edit".$gID."\").hide();";
	//echo "});</script>";
	$colorTemp = $color2;
	$color2 = $color1;
	$color1 = $colorTemp;
}
?>

</table>
</body>
</html>

