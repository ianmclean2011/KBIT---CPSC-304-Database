<?php
echo "SQL status : ";
$db_conn = OCILogon("ora_p7m5", "a62141049", "ug");
if ($db_conn) {
  echo "Successfully connected to Oracle.\n";
} else {
  $err = OCIError();
  echo "Oracle Connect Error " . $err['message'];
}

?>