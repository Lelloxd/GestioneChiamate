<?php
session_start();
if(!isset($_SESSION["password"])|| (!isset($_SESSION["mail"])))
	header("location:index.php");
?>
<!DOCTYPE html>
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
		<link href="../css/style.css" rel="stylesheet" type="text/css">
                  <script src="src/jquery.percentageloader-0.1.js"></script>
                <link rel="stylesheet" href="src/jquery.percentageloader-0.1.css"></script>
                <title>Gestione Chiamate</title>
                </head><body>
                
		<nav class="navbar navbar-default cre">
			<div class="container-fluid">
				<div class="navbar-header">
				
				<a class="navbar-brand" href="#">
					<img alt="Brand" class="logo" src="src/invio.png" />
				</a>
				</div>
				
		
		
		</div>
		</nav>
                    <body>
                        <style>
      body {
        margin: 0px;
        padding: 0px;
      }
      
      #topLoader {
        width: 256px;
        height: 256px;
        margin-bottom: 32px;
      }
      
      #container {
       
        margin-left: auto;
        margin-right: auto;
        width:256px;
      }
      
  
    </style>
    <div id="container">
      <div id="topLoader">      
      </div>
      
       <script>
        $(function() {
          var $topLoader = $("#topLoader").percentageLoader({width: 256, height: 256, controllable : true, progress : 0.1, onProgressUpdate : function(val) {
              $topLoader.setValue(Math.round(val * 100.0));
            }});

          var topLoaderRunning = false;
          
            if (topLoaderRunning) {
              return;
            }
            topLoaderRunning = true;
            $topLoader.setProgress(0);
            $topLoader.setValue('0%');
            var kb = 0;
            var totalKb = 99;
            
            var animateFunc = function() {
              kb += 1;
              $topLoader.setProgress(kb / totalKb);
              $topLoader.setValue(kb.toString() + '%');
              
              if (kb < totalKb) {
                setTimeout(animateFunc, 25);
              } else {
                setTimeout(function(){location.href='../lavori.php?complete=true';}, 25);
                topLoaderRunning = false;
              }
            }
            setTimeout(animateFunc, 25);
            
        });      
      </script>
    </div>
     
<?php
require("webservice.php");
if(isset($_SESSION["sipconc"]))
{
//define("UPLOAD_DIR", "../upload/");



$time = new DateTime;
$time = $time->format('Y-m-d') . 'T' . $time->format('H:i:s');
$firma="";
if(isset($_SESSION["firma"]))
{
	$firma=str_replace("data:image/png;base64,", "",$_SESSION["firma"]);
	//echo "prendo firma sessione :$firma <br>";
}
	if (isset($_SESSION["password"]) && isset($_SESSION["mail"])) {
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
    $descrizione= " ";
    $descrizione = $_POST["descrtecnico"];
    $ris = $_POST["risultato"];
    $matricola = $_SESSION["codmatricola"];
	if(isset($_POST["firma"]))
		$firma = str_replace("data:image/png;base64,", "", $_POST["firma"]);
	
	
    $entrato=0;
    if(isset($_POST["maxlenght"]))
    {
        
        $j=0;
        $massimo=$_POST["maxlenght"];
    for($i=0;$i<=$massimo;$i++)
        {
            $qt="valore".$i;
            if(isset($_POST[$i]))
            {
                $array[$j]["IdIntervento"]=$num;
                $array[$j]["CodiceArticolo"]=$_POST[$i];
                $array[$j]["Qta"]=intval($_POST[$qt]);
                $j++;
            }
        }
    }
    if(isset($array))
    $entrato=1;
    //$array=json_encode($array);
        $rilevazioni["IdIntervento"]=$num;
        $rilevazioni["Scansioni"]=0;
        $rilevazioni["Chiusure"]=0;
        $rilevazioni["CopieCol"]=0;
        $rilevazioni["CopieBN"]=0;
    if(isset($_POST["bn"]))
        $rilevazioni["CopieBN"]=intval($_POST["bn"]);
        
    if(isset($_POST["colore"]))
        $rilevazioni["CopieCol"]=intval($_POST["colore"]);
        
    if(isset($_POST["ch"]))
        $rilevazioni["Chiusure"]=intval($_POST["ch"]);
        
    if(isset($_POST["sc"]))
        $rilevazioni["Scansioni"]=intval($_POST["sc"]);

        
    $WEBSchiamate = $webservicepath . 'api/Interventi/';
    if($entrato==1)
    $data = array("Deleted" => $deleted, "CodiceDitta" => $ditta, "CodiceTipoIntervento" => $tipoint, "Numero" => $num, "Data" => $datai, "DataPartenza" => $partenza, "DataArrivo" => $arrivo, "DataFine" => $fine, "Descrizione" => $descrizione, "MailTecnico" => $utente, "NomeTecnico" => $nome, "Risultato" => $ris, "Matricola" => $matricola, "Firma" => $firma, "Ricambi" => $array, "Rilevazioni" => $rilevazioni);
    else
    $data = array("Deleted" => $deleted, "CodiceDitta" => $ditta, "CodiceTipoIntervento" => $tipoint, "Numero" => $num, "Data" => $datai, "DataPartenza" => $partenza, "DataArrivo" => $arrivo, "DataFine" => $fine, "Descrizione" => $descrizione, "MailTecnico" => $utente, "NomeTecnico" => $nome, "Risultato" => $ris, "Matricola" => $matricola, "Firma" => $firma, "Rilevazioni" => $rilevazioni);
 
    $data_string = json_encode($data);
   // echo $WEBSchiamate;
    //echo $data_string;
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
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Execute request
    $result = curl_exec($ch);
	//echo $result;
    //echo '<br>Curl error: ' . curl_error($ch);
// Close connection
    curl_close($ch);
    unset($_SESSION["partenza"]);
    unset($_SESSION["incorso"]);
	unset($_SESSION["sipconc"]);
	unset($_SESSION["arrivato"]);
	unset($_SESSION["arrivo"]);
    
} else
    echo "<h1>INTERNAL ERROR !</h1>";
}else
	echo "<h1>SEI GIUNTO IN QUESTA PAGINA IN MANIERA ERRATA</h1>"
?>