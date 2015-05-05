<?php
session_start();
require("webservice.php");
$pass=$_SESSION["password"];
$utente=$_SESSION["mail"];
$nome=$_SESSION["nome"];
if((isset($_GET["testo"]))&&($_GET["testo"]!=""))
{
$num=10;
if((isset($_GET["num"]))&&($_GET["num"]!=""))
    $num=$_GET["num"];
$search=$_GET["testo"];
$WEBSchiamate=$webservicepath.'api/Interventi/interventiweb?matricola='.$search.'&num=10';
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
/*
$feed_url = 'http://blogoola.com/blog/feed/';
$content = file_get_contents($feed_url);
$x = new SimpleXmlElement($content);
$feedData = '';
*/
 
//output
	/*
$feedData .=  "<ul>";
foreach($x->channel->item as $entry) {
    $feedData .= "<li><a href='$entry->link' title='$entry->title'>" . $entry->title . "</a></li>";
}
$feedData .= "";
$feedData .= "<p>Data current as at: ".$date."</p>";
 
echo $feedData;
*/
/*echo "<div><br><p class='descl'>| MATRICOLA : </p><b><p ><input type='text' class='form-control piccola' name='codicematricola' value='".$_SESSION["codmatricola"]."' ></p></b>";
echo "<table>";
echo "<tr><td>Data</td><td>Tecnico</td><td>Descrizione</td>";*/
$vuoto=1;
for($i=0;$i<$lenght;$i++)
	{
    $vuoto=0;
    $date=$result_arr[$i]["Data"];
    $date = date("d-m-y",strtotime($date));
    //echo "<div><br><p class='descl'>| Data: </p><b><p ><input type='text' class='form-control piccola' name='codicematricola' value='".$_SESSION["codmatricola"]."' ></p></b>";
		echo "<div><table id='table-style' ><tr><td class='int'> Data  </td><td>".$date."</td></tr>";
                //echo "<tr><td class='int'> Matricola </td><td>".$result_arr[$i]["CodiceMatricola"]."</td>";
                echo "<tr><td class='int'> Tecnico  </td><td>".$result_arr[$i]["NomeTecnico"]."</td>";
                echo "<tr><td class='int'> Descrizione &nbsp&nbsp&nbsp</td><td>".$result_arr[$i]["Descrizione"]."</td></tr></table></div>";
                
	}
if($vuoto==1)
    echo "Nessun intervento precedente in memoria";
//echo "</table";
}
?>