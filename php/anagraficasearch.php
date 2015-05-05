<?php
session_start();
require("webservice.php");
$pass=$_SESSION["password"];
$utente=$_SESSION["mail"];
$nome=$_SESSION["nome"];
if((isset($_GET["testo"]))&&($_GET["testo"]!=""))
{
	$search = $_GET["testo"];
$WEBSchiamate=$webservicepath.'api/syncanagrafiche?searchText='.$search;

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
$latitude=$result_arr[$i]["Latitudine"];
$longitude=$result_arr[$i]["Longitudine"];
$address="https://www.google.com/maps/dir/Current+Location/".$latitude.",".$longitude;
    //echo "<div><br><p class='descl'>| Data: </p><b><p ><input type='text' class='form-control piccola' name='codicematricola' value='".$_SESSION["codmatricola"]."' ></p></b>";
		echo "<div><table id='table-style' ><tr><td class='int'> Azienda  </td><td>".$result_arr[$i]["RagioneSociale"]."</td></tr>";
                echo "<tr><td class='int'> Indirizzo   </td><td><a href='$address'>".$result_arr[$i]["Indirizzo"].", ".$result_arr[$i]["Localita"]." (".$result_arr[$i]["Provincia"].") ".$result_arr[$i]["Cap"]."</a></td>";
                echo "<tr><td class='int'> Telefono  </td><td>".$result_arr[$i]["Telefono"]."</td></tr></table></div>";
                
	}
if($vuoto==1)
    echo "Nessuna anagrafica trovata !";

}
?>