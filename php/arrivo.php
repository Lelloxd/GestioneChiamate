<?php 
require("webservice.php");
session_start();
$time = new DateTime;
$oraeminuti=new DateTime;
$time = $time->format('Y-m-d').'T'.$time->format('H:i:s');
$oraeminuti=new DateTime;
$oraeminuti = $oraeminuti->format('H:i');

if(isset($_SESSION["password"])&&isset($_SESSION["mail"]))
{
$pass=$_SESSION["password"];
$utente=$_SESSION["mail"];
$nome=$_SESSION["nome"];
$tipoint=intval($_GET["tipoint"]);
$num=intval($_GET["num"]);
$data=$_GET["data"];
$_SESSION["data"]=$data;
$_SESSION["num"]=$num;
$_SESSION["darrivo"]=$time;
$ditta=intval($_GET["ditta"]);
$_SESSION["tipoint"]=$tipoint;
$_SESSION["ditta"]=$ditta;
$_SESSION["arrivo"]=$_GET["oraarrivo"];
if(!isset($_SESSION["arrivo"]))
	$_SESSION["arrivo"]=$oraeminuti;
$_SESSION["matricola"]=$_GET["matricolaobb"];
$_SESSION["codmatricola"]=$_GET["codmatricola"];
$WEBSchiamate=$webservicepath.'api/SyncChiamate/arrivo?dataArrivo='.$time;
$data = array("TipoInt" => $tipoint , "Numero" => $num ,"Data" => $data ,"CodDitta" => $ditta );
$data_string = json_encode($data);  
echo $WEBSchiamate;
echo $data_string; 
// Open connection
$ch = curl_init($WEBSchiamate);
$headers = array(
     'Content-Type: application/json',                                                                                
	 'Content-Length: ' . strlen($data_string)   
);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt($ch, CURLOPT_USERPWD,$utente.':'.$pass);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
 
                                                                   
// Execute request
$result = curl_exec($ch);
echo '<br>Curl error: ' . curl_error($ch);
// Close connection
curl_close($ch);
$_SESSION["arrivato"]=1;
//unset($_SESSION["incorso"]);

}else
echo "INTERNAL ERROR";

?>