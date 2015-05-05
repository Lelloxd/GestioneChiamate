<?php
session_start();
require("webservice.php");
$pass=$_SESSION["password"];
$utente=$_SESSION["mail"];
$nome=$_SESSION["nome"];
if((isset($_GET["testo"]))&&($_GET["testo"]!=""))
{
	$search = $_GET["testo"];
$WEBSchiamate=$webservicepath.'api/syncarticoli?searchText='.$search;

// Open connection
$ch = curl_init();
$headers = array(
    'Content-Type: application/json',
);

curl_setopt($ch, CURLOPT_URL, $WEBSchiamate);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt($ch,CURLOPT_USERPWD,$utente.':'.$pass);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$result = curl_exec($ch);


curl_close($ch);
$loggato=0;

$result_arr = json_decode($result, true);
$lenght=count($result_arr);

$vuoto=1;
for($i=0;$i<$lenght;$i++)
	{
    $vuoto=0;
    $codicei=$result_arr[$i]["Codice"];
    $descrizionei=$result_arr[$i]["Descrizione"];
    $descrizionei=preg_replace('/\'+/', '', $descrizionei);
    $funzionei="javascript:aggiunginew('$codicei','$descrizionei');";
    $functi=preg_replace('/\s+/', '_', $funzionei);
  
		echo "<div><table id='table-style' ><tr><td class='int'> Codice  </td><td>".$result_arr[$i]["Codice"]."</td></tr>";
		echo "<tr><td class='int'> Descrizione  </td><td>".$result_arr[$i]["Descrizione"]."</td></tr></table>";
                echo "<a class='aggiungiricambio' href=$functi><span class='glyphicon glyphicon-plus-sign'></span></a></div>";
                
                
	}
if($vuoto==1)
    echo "Nessun articolo trovato !";

}
?>