<?php
//echo "SQL status : ";
$db_conn = OCILogon("ora_a7t8", "a23518095", "ug");
if ($db_conn) {
  //echo "Successfully connected to Oracle.\n";
} else {
  $err = OCIError();
  echo "Oracle Connect Error " . $err['message'];
}

?>