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
        <div class="container">

      <!-- Static navbar -->
      <div class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Wedding Manager</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="index.php">Home</a></li>

              <li class="dropdown">
                <a href="index.php?page=guest" class="dropdown-toggle" data-toggle="dropdown">Guests<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="index.php?page=guest">GuestList</a></li>
                  <li><a href="index.php?page=guest">Add Guests</a></li>
                </ul>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Team KBIT!!!</h1>
        <br> SQL Server Status: <?php
if ($c=OCILogon("ora_p7m5", "a62141049", "ug")) {
  echo "Successfully connected to Oracle.\n";
  OCILogoff($c);
} else {
  $err = OCIError();
  echo "Oracle Connect Error " . $err['message'];
}
?>
		<?php
			$page = $_GET['page'];	/* gets the variable $page */
			if (!empty($page)) {
				$page .= ".php";
				include($page);
			} 	/* if $page has a value, include it */
			else {
			} 	/* otherwise, include the default page */
		?>

      </div>

    </div> <!-- /container -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
