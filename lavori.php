<!DOCTYPE html>
<html>
    <head>
		<META name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script src="js/stdlib.js"></script>
		<script src="js/funzioni.js"></script>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700' rel='stylesheet' type='text/css'>
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
		<?php
		session_start();
		if(isset($_GET["text"]))
			$_SESSION["grandezzatesto"]=$_GET["text"];
		if(isset($_SESSION["grandezzatesto"]))
		{
			if($_SESSION["grandezzatesto"]=="small")
				echo '<link href="css/style.css" rel="stylesheet" type="text/css">';
			if($_SESSION["grandezzatesto"]=="normal")
				echo '<link href="css/stylem.css" rel="stylesheet" type="text/css">';
			if($_SESSION["grandezzatesto"]=="big")
				echo '<link href="css/styleb.css" rel="stylesheet" type="text/css">';
		}
		else
			echo '<link href="css/style.css" rel="stylesheet" type="text/css">';
			?>
		
		
                <title>Gestione Chiamate</title>
    </head>
<body>
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
					 <li class="active"><a href="lavori.php">LAVORO <span class="sr-only">(current)</span></a></li>
                                         <li><a href="anagrafiche.php">ANAGRAFICHE</a></li>
					 <li><a href="ultimi.php">ULTIMI INTERVENTI</a></li>
<li class='contenuto'>Grandezza testo : <span onclick='javascript:smallfont();' class="glyphicon glyphicon-font small"></span>
                                                <span onclick='javascript:normalfont();'  class="glyphicon glyphicon-font normal"></span>
                                                 <span onclick='javascript:bigfont();' class="glyphicon glyphicon-font big"></span>     
					</li>
					 <li><a href="php/logout.php">ESCI</a></li>
					 </ul>
				</div>
		
		
		</div>
		</nav>

<?php
require("php/webservice.php");

echo "<div id='divElement'></div>";
if(isset($_SESSION["password"])&&isset($_SESSION["mail"]))
{
$pass=$_SESSION["password"];
$utente=$_SESSION["mail"];
$nome=$_SESSION["nome"];
$WEBSchiamate=$webservicepath.'api/SyncChiamate/web';
// Open connection
$ch = curl_init();
$headers = array(
    'Content-Type: application/json',
);
// Set the url, number of GET vars, GET data
curl_setopt($ch, CURLOPT_URL, $WEBSchiamate);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt($ch,CURLOPT_USERPWD,$utente.':'.$pass);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
// Execute request
$result = curl_exec($ch);

// Close connection
curl_close($ch);
$loggato=0;
// get the result and parse to JSON
$result_arr = json_decode($result, true);
$lenght=count($result_arr);
echo "<div class='header-chiamate'><p class='Num'>#</p><p class='Data'>Data</p><p class='hidden-xs Data'>Nome</p><p class='Stato'>Stato</p></div>";
for($i=0;$i<$lenght;$i++)
{
$num=$result_arr[$i]["Numero"];
$originaldata=$result_arr[$i]["Data"];
$data=date("d-m-Y",strtotime($result_arr[$i]["Data"]));
//$data=date("d-m-Y",strtotime($data));
$stato="ERR";
$status="";
switch ($result_arr[$i]["Stato"]) {
    case 1:
        $stato="Ritornare";
		$status="back";
        break;
    case 3:
        $stato="In Attesa Ricambi";
		$status="ar";
        break;
    case 6:
        $stato="In Corso";
		$status="ic";
        break;
	case 5:
		$stato="";
		$status="de";
		break;
	case 2:
		$stato="Chiusa";
		$status="closed";
		break;
}
$coditta=$result_arr[$i]["CodiceDitta"];
$cliente=$result_arr[$i]["RagioneSociale"];
$macchina=$result_arr[$i]["Attrezzatura"];
$codmacchina=$result_arr[$i]["CodiceMatricola"];
$partenzaeff=0;
$arrivoeff=0;
if(isset($result_arr[$i]["DataPartenza"]))
$partenzaeff=$result_arr[$i]["DataPartenza"];
if(isset($result_arr[$i]["DataArrivo"]))
$arrivoeff=$result_arr[$i]["DataArrivo"];
$guasto=$result_arr[$i]["Guasto"];
$descrizioneguasto=$result_arr[$i]["DescrizioneGuasto"];
$provincia=$result_arr[$i]["Provincia"];
$latitude=$result_arr[$i]["Latitudine"];
$longitude=$result_arr[$i]["Longitudine"];
$addressold="http://maps.google.com/?q=".$result_arr[$i]["Indirizzo"]." ".$result_arr[$i]["Localita"];
$address="https://www.google.com/maps/dir/Current+Location/".$latitude.",".$longitude;
$indirizzo=$result_arr[$i]["Indirizzo"];
$localita=$result_arr[$i]["Localita"];
$contratto=$result_arr[$i]["TipoAbbonamento"];
$tipoint=$result_arr[$i]["CodiceTipoIntervento"];
$note=$result_arr[$i]["Note"];
$ufficio=$result_arr[$i]["Ufficio"];
$MatricolaObbligatoria=$result_arr[$i]["MatricolaObbligatoria"];
$Matricolacod=$result_arr[$i]["CodiceMatricola"];
$ubicazione=str_replace("°","&#176;",$result_arr[$i]["Ubicazione"]);
$functdesc="descrizioneguasto('desc$num')";
$functdesc=preg_replace('/\s+/', '_', $functdesc);
$fun='javascript:collapse('.$num.',"a'.$num.'")';
$telefono=-1;
if(isset($result_arr[$i]["Telefono"]))
    $telefono=$result_arr[$i]["Telefono"];
$arrivato=0;
$partito=0;

if($result_arr[$i]["Stato"]==6)
{
   
    if($partenzaeff!=0)
    {
    $partito=1;
    $_SESSION["partenza"]=$partenzaeff;
    $_SESSION["dpartenza"]=$partenzaeff;
    $_SESSION["matricola"]=$MatricolaObbligatoria;
    $_SESSION["codmatricola"]=$Matricolacod;
	$_SESSION["ditta"]=$coditta;
	$_SESSION["tipoint"]=$tipoint;
	$_SESSION["num"]=$num;
	$_SESSION["data"]=$originaldata;
    echo "<a class='nounderline' href=$fun>";
    }
    if($arrivoeff!=0)
    {
        
        $_SESSION["arrivo"]=substr($arrivoeff, 11);
        $_SESSION["arrivo"]=substr($_SESSION["arrivo"],0,-3);
        $_SESSION["darrivo"]=$arrivoeff;
        $arrivato=1;
        echo "<script>location.href='intervento.php';</script>";
    }
    
}else {
        echo "<a class='nounderline' href=$fun>";
}
echo "<div class='after-header-chiamate' id=a$num><p class='Num'>$num</p><p class='hidden-xs Data'>$data</p><p class='visible-xs Datam'>$data</p><p class='hidden-xs Data'>$cliente</p><p class='Stato $status'>$stato</p><span class='nomemobile visible-xs'>$cliente</span></div></a>";
if($partito==1)
    echo "<div class='chiamata--attiva' id=$num>";
else 
    echo "<div class='chiamata-non-attiva' id=$num>";
echo "<div class='middle' align='center'><div><p class='descl'>| MACCHINA</p><p><b>$macchina</b></p> <span class='agg'> $codmacchina</span></div>";
echo "<div><p class='descl'>| DESTINAZIONE</p> <b><p><a class='conbigonly' href='$address'>$indirizzo</a></p></b><span class='agg'>$localita($provincia)</span></div>"; //SINISTRA
if($telefono!=-1)
echo "<div><br><p class='descl'>| TELEFONO</p> <b><p><a href='tel:$telefono'>$telefono</a></p></b></div>"; 
if($guasto!="")
{
echo "<div><br><p class='descl'>| GUASTO </p><b><p> $guasto </p></b>";
if($descrizioneguasto!="")
echo "<button class='btn' onclick=$functdesc>Dettagli guasto</button><br><p id='desc$num' class='descguasto'>$descrizioneguasto</p>"; 
echo "</div>";
}
echo "<div><br><p class='descl'>| CONTRATTO </p><b><p> $contratto </p></b></div>";
if($ubicazione!=""){
echo "<div><br><p class='descl'>| UBICAZIONE </p><b><p> $ubicazione </p></b>";
if($ufficio!="")
echo "<span class='agg'> $ufficio</span></div>";
else
echo "</div>";
}
if($note!="")
echo "<div><br><p class='descl'>| NOTE </p><b><p> $note </p></b></div>"; 


echo "</div>";
$func="parti('$tipoint','$num','$originaldata','$coditta','btn$num','startingh$num','arr$num','ass$num')";
$funcarr="arriva('$tipoint','$num','$originaldata','$coditta','arr$num','arrh$num','ass$num','$MatricolaObbligatoria','$Matricolacod')";
$funcass="assente('$tipoint','$num','$originaldata','$coditta','arr$num','arrh$num','ass$num','$MatricolaObbligatoria','$Matricolacod')";
if($partito!=1&&$arrivato!=1)
    echo "<div><p class='op' id='startingh$num'></p><p class='pedice' id='op$num'>Orario di partenza</p><br><br><br><input type='button' id='btn$num'onclick=$func class='btnlogin' value='Partenza intervento'><p class='op' id='startingh$num'></p><input type='button' class='arrhidden btnlogin' id='arr$num'onclick=$funcarr class='btnlogin' value='Arrivo dal cliente'><p class='op' id='arrh$num'></p><input type='button' class='arrhidden btnlogin' id='ass$num' onclick=$funcass class='btnlogin' value='Cliente assente'></div>";
if($partito==1&&$arrivato!=1)
{
    echo "<br><br><div><input type='button' class='btnlogin' id='arr$num' onclick=$funcarr class='btnlogin' value='Arrivo dal cliente'><p class='op' id='arrh$num'></p></div>";
    echo "<br><br><div><input type='button' class='btnlogin' id='ass$num' onclick=$funcass class='btnlogin' value='Cliente assente'><p class='op' id='assh$num'></p></div>";
}
echo "<br><div><p class='pedicea' id='oa$num'>Orario Arrivo</p></div>";
echo "</div>";
}
echo "</table>";
}
else
{
header("location:index.php");
}
?>
