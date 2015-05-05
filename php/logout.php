<?php 
session_start();
unset($_SESSION["password"]);
unset($_SESSION["mail"]);
header("location:../index.php");
?>