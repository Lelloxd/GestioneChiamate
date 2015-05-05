<!DOCTYPE html>
<head>
		<META name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
                <script src="js/funzioni.js"></script>
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
		<link href="css/style.css" rel="stylesheet" type="text/css">
		<nav class="navbar navbar-default cre">
			<div class="container-fluid">
				<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				<a class="navbar-brand" href="#">
					<img alt="Brand" class="logo" src="images/NEiT.png" />
				</a>
				</div>
				 <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">	
					 <ul class="nav navbar-nav">
					 <li class="active"><a href="#">LOGIN <span class="sr-only">(current)</span></a></li>
					 
					 </ul>
				</div>
		
		
		</div>
		</nav>
<title>Gestione Chiamate</title>
</head><body>
     
<?php 
require("php/webservice.php");
session_start();
if(isset($_SESSION["mail"]))
    header("location:lavori.php");
if((isset($_POST["mail"]))&&(isset($_POST["password"])))
{

$mail=mysql_escape_string($_POST["mail"]);
$pass=$_POST["password"];
$json_url = $webservicepath.'api/synctecnici/all';

$headers = array('Content-Type: application/json');

// query string

$url = $webservicepath.'api/synctecnici/all';

// Open connection
$ch = curl_init();

// Set the url, number of GET vars, GET data
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt($ch,CURLOPT_USERPWD,$mail.':'.$pass);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
// Execute request
$result = curl_exec($ch);
$loggato=0;
if($result!='{"Message":"Autorizzazione negata per la richiesta."}')
$loggato=1;
// Close connection
curl_close($ch);

// get the result and parse to JSON

if($loggato==0)
echo "<div class='alert alert-danger' role='alert'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
					<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
					<strong>ERRORE !</strong> Dati di accesso errati !</div>";
else
{
$result_arr = json_decode($result, true);
$lenght=count($result_arr);
for($i=0;$i<$lenght;$i++)
{
if(($mail==$result_arr[$i]["Mail"])&&($pass==$result_arr[$i]["Password"]))
{
$loggato=1;

$_SESSION["nome"]=$result_arr[$i]["Nome"];
$_SESSION["mail"]=$mail;
$_SESSION["password"]=$pass;
}
}
header("location:lavori.php");
}
}
?>
<form method="POST" onsubmit="index.php">
<div class="panel panel-info centrato">  <div class="panel-heading crecolor">Gestione Chiamate</div>

  <div class="panel-body logins" align="center">

    <input type="email" name="mail" placeholder="Mail" required><br>
	<input type="password" name="password" placeholder="Password" required><br>
	<input type="submit" class="btnlogin" value="Login">
	
  </div>
</div>
</form>

<!-- http://www.subinsb.com/2013/10/check-if-internet-connection-exist-jquery-javascript.html -->

</body>