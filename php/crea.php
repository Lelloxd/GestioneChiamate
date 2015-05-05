<?php 
session_start();
$nome=$_GET["nome"];
$txt = $_GET["valore"];
$txt=base64_decode($txt);
$_SESSION["firma"]=$txt;

/*$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
$txt = preg_replace('/\s+/', '', $txt);
fwrite($myfile, $txt);
fclose($myfile);*/
?>
