<!DOCTYPE html>
<html lang="en">
	<head></head>
	<body>
		<h1>Find me...</h1>
		
		
		
	<form role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
		<div class="form-group">
			<label for="firstName">First Name</label>
			<input type="text" class="form-control" name="firstName" placeholder="First Name">
		</div>
		<div class="form-group">
			<label for="lastName">Last Name</label>
			<input type="text" class="form-control" name="lastName" placeholder="Last Name">
		</div>
		<button type="submit" class="btn btn-default" name="findName" value="findName">Find by Name</button>			
	</form>
	<br>
	<form role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
			<div class="form-group">
				<label for="id">ID #</label>
				<input type="text" class="form-control" name="id" placeholder="ID #">
			</div>
		<button type="submit" class="btn btn-default" name="findID" value="findID">Find by ID #</button>			
	</form>

<?php

//this tells the system that it's no longer just parsing 
//html; it's now parsing PHP

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
		echo "<br>Please enter your first name, last name or the ID # on your invitation";
		$e = oci_error($statement); // For OCIExecute errors pass the statementhandle
		//echo htmlentities($e['message']);
		$success = False;
	} else {

	}
	return $statement;

}

function executeBoundSQL($cmdstr, $list) {
	/* Sometimes a same statement will be excuted for severl times, only
	 the value of variables need to be changed.
	 In this case you don't need to create the statement several times; 
	 using bind variables can make the statement be shared and just 
	 parsed once. This is also very useful in protecting against SQL injection. See example code below for       how this functions is used */

	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr);

	if (!$statement) {
		echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn);
		echo htmlentities($e['message']);
		$success = False;
	}

	foreach ($list as $tuple) {
		foreach ($tuple as $bind => $val) {
			//echo $val;
			//echo "<br>".$bind."<br>";
			OCIBindByName($statement, $bind, $val);
			unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype

		}
		$r = OCIExecute($statement, OCI_DEFAULT);
		if (!$r) {
			echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
			$e = OCI_Error($statement); // For OCIExecute errors pass the statementhandle
			echo htmlentities($e['message']);
			echo "<br>";
			$success = False;
		}
	}

}

function printResult($result) { //prints results from a select statement
	echo "<br><h2>Is this you?</h2><br>";
	echo "<table class=\"table table-striped\">";
	echo "<tr><th>ID #</th><th>Name</th><th></th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["GID"] . "</td><td>" . $row["NAME"] . 
		"</td><td><a href=\"guest.php?id=".$row["GID"]."&page=guest-info\">Select</a></td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";

}

// Connect Oracle...
if ($db_conn) {

	if (array_key_exists('findName', $_POST)) {
		if($_POST[firstName] == "" && $_POST[lastName] == "")
			echo "<br>Please enter your first name, last name or the ID # on your invitation";
		else{
			$result = executePlainSQL("select gid, name from Guest where lower(name) like '%' || lower('". $_POST[firstName] ."') || '%' || lower('" . $_POST[lastName] . "') || '%'");
			printResult($result);
		}
	} else
		if (array_key_exists('findID', $_POST)) {
		$result = executePlainSQL("select gid, name from Guest where gid = ". $_POST[id]);
		printResult($result);
		} 

	//Commit to save changes...
	OCILogoff($db_conn);
} else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}

/* OCILogon() allows you to log onto the Oracle database
     The three arguments are the username, password, and database
     You will need to replace "username" and "password" for this to
     to work. 
     all strings that start with "$" are variables; they are created
     implicitly by appearing on the left hand side of an assignment 
     statement */

/* OCIParse() Prepares Oracle statement for execution
      The two arguments are the connection and SQL query. */
/* OCIExecute() executes a previously parsed statement
      The two arguments are the statement which is a valid OCI
      statement identifier, and the mode. 
      default mode is OCI_COMMIT_ON_SUCCESS. Statement is
      automatically committed after OCIExecute() call when using this
      mode.
      Here we use OCI_DEFAULT. Statement is not committed
      automatically when using this mode */

/* OCI_Fetch_Array() Returns the next row from the result data as an  
     associative or numeric array, or both.
     The two arguments are a valid OCI statement identifier, and an 
     optinal second parameter which can be any combination of the 
     following constants:

     OCI_BOTH - return an array with both associative and numeric 
     indices (the same as OCI_ASSOC + OCI_NUM). This is the default 
     behavior.  
     OCI_ASSOC - return an associative array (as OCI_Fetch_Assoc() 
     works).  
     OCI_NUM - return a numeric array, (as OCI_Fetch_Row() works).  
     OCI_RETURN_NULLS - create empty elements for the NULL fields.  
     OCI_RETURN_LOBS - return the value of a LOB of the descriptor.  
     Default mode is OCI_BOTH.  */
?>
	</body>
</html>