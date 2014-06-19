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
<table class='table table-striped'>
	<tr>
		<th> 
		</th>
		<th>
			Guest ID
		</th>
		<th>
			Name
		</th>
		<th>
			# Extra Guest Allowed
		</th>
		<th>
			# Extra Guest Bringing
		</th>
		<th>
			Extra Guest Name
		</th>
		<th>
			Invitations
		</th>
		<th>
		</th>
	</tr>

<?php
	//Update invitations
	if(array_key_exists('venues', $_POST)){
		
			$inviteCheck = executePlainSQL("select * from v_invitedto where gid ='" . $_REQUEST["changeGuest"] . "'");
			
			$currVenues = array();
			
			while($inviteCheckRow = oci_fetch_array($inviteCheck)){
				if(!in_array($inviteCheckRow['VID'], $_POST['venues'])){
					executePlainSQL("delete from v_invitedto where vid ='" . $inviteCheckRow['VID']. "' and gid = '" . $_REQUEST["changeGuest"] . "'");
					OCICommit($db_conn);
				}
				array_push($currVenues, $inviteCheckRow['VID']);
			}
				
			foreach($_POST['venues'] as $i){
				if(!in_array($i, $currVenues)){
					executePlainSQL("INSERT INTO v_InvitedTo VALUES ('" . $_REQUEST["changeGuest"] . "','". $i . "', NULL,NULL,NULL)");
					OCICommit($db_conn);
				}	
			}
	}
// Delete Tuple of guest with specific GID
if($_REQUEST["deleteGuest"])
{
  	echo "<h2>The guest is deleted successfully. </h2><br>";

     $cmdstr = "DELETE FROM Guest WHERE gID = '".$_REQUEST['deleteGuest']."'";
     executePlainSQL($cmdstr);
	 OCICommit($db_conn);
}

else if($_REQUEST["changeGuest"])
{
	if (($_REQUEST['newName'] ==''))
	$newName = $_REQUEST['oldName'];
	else $newName = $_REQUEST['newName'];

	if (($_REQUEST['newMax'] ==''))
	$newMax = $_REQUEST['oldMax'];
	else $newMax = $_REQUEST['newMax'];

	// Check for non-alphabetic letter for first and last name;
	$newNameNoSpace = str_replace(' ', '', $newName);
	if (!ctype_alpha($newNameNoSpace))
		echo "<SCRIPT>alert('Your name can\'t contain number/symbol.');</SCRIPT>";
	// Check for non-digit letter for extraGuests;
	else if (!ctype_digit($newMax))
		echo "<SCRIPT>alert('Please use digits for the number of extra guests entry.');</SCRIPT>";
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

	echo "<tr id='".$gID."'>"; // A simple alternating background color stuff
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
	
	echo "<td></td>";
	
	echo "</tr>";

		//This row contains form for editing
	echo "<tr id='edit".$gID."'>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td><form action=\"".$_PHP_SELF. "\" method=\"POST\">";
	echo "<input type=\"text\" name=\"newName\" placeholder = \"New Name\">";
	echo "<input type=\"hidden\" name=\"oldName\" value=\"".$name."\">";
	echo "</td>";
	echo "<td><input type=\"text\" name =\"newMax\" placeholder = \"Max Guests\">";
	echo "<input type=\"hidden\" name=\"oldMax\" value=".$maxDG.">";
	echo "</td>";
	echo "<td><input type=\"hidden\" name=\"changeGuest\" value=\"".$gID."\"></td>";
	echo "<td></td>";
	echo "<td>";
		echo "<input type=\"hidden\" name=\"venues\" value=\"\">";
		$venue = executePlainSQL("SELECT vid, usage FROM venue");
		$i=0;
		while($venueRow = oci_fetch_array($venue)){
			
		$inviteCheck = executePlainSQL("select * from v_invitedto where vid = '" . $venueRow['VID'] . "' and gid = '" . $gID . "'");	
			
		if($inviteCheck = oci_fetch_array($inviteCheck)){	
		echo "<input type=\"checkbox\" name=\"venues[" . $i . "]\" value=\"" . $venueRow['VID'] . "\" checked>" . 
		"<b>" . $venueRow['USAGE'] . "<br>";
		}
		
		else{
		echo "<input type=\"checkbox\" name=\"venues[" . $i . "]\" value=\"" . $venueRow['VID'] . "\">" . 
		"<b>" . $venueRow['USAGE'] . "<br>";
		}
		$i++;
		}
	echo "</td>";
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

