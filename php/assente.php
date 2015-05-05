<?php
require("webservice.php");
$time = new DateTime;
$time = $time->format('Y-m-d') . 'T' . $time->format('H:i:s');
session_start();
if (isset($_SESSION["password"]) && isset($_SESSION["mail"])) {
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
$_SESSION["matricola"]=$_GET["matricolaobb"];
$_SESSION["codmatricola"]=$_GET["codmatricola"];
$WEBSchiamate=$webservicepath.'api/SyncChiamate/lock?dataArrivo='.$time;
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
    $pass = $_SESSION["password"];
    $utente = $_SESSION["mail"];
    $nome = $_SESSION["nome"];
    $deleted = true;
    $ditta = $_SESSION["ditta"];
    $tipoint = $_SESSION["tipoint"];
    $num = $_SESSION["num"];
    $datai = $_SESSION["data"];
    $partenza = $_SESSION["dpartenza"];
    $arrivo = $_SESSION["darrivo"];
    $fine = $time;
    $descrizione = "CLIENTE ASSENTE";
    $ris = 1;
    $matricola = $_SESSION["codmatricola"];
    $firma = str_replace("data:image/png;base64,", "", "");
    $WEBSchiamate = $webservicepath . 'api/Interventi/';
    $data = array("Deleted" => $deleted, "CodiceDitta" => $ditta, "CodiceTipoIntervento" => $tipoint, "Numero" => $num, "Data" => $datai, "DataPartenza" => $partenza, "DataArrivo" => $arrivo, "DataFine" => $fine, "Descrizione" => $descrizione, "MailTecnico" => $utente, "NomeTecnico" => $nome, "Risultato" => $ris, "Matricola" => $matricola, "Firma" => $firma);
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
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $utente . ':' . $pass);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Execute request
    $result = curl_exec($ch);
    echo '<br>Curl error: ' . curl_error($ch);
// Close connection
    curl_close($ch);
    //require("cancellasessioni.php");
   unset($_SESSION["partenza"]);
   unset($_SESSION["incorso"]);
    //echo "<script>location.href='../lavori.php'</script>";
} else
    echo "INTERNAL ERROR";
?>