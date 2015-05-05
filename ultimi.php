<?php
session_start();
if(!isset($_SESSION["password"])|| (!isset($_SESSION["mail"])))
	header("location:index.php");
?>
<!DOCTYPE html>
<html><head>
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
</head><body>
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
                                         <li ><a href="lavori.php">LAVORO</a></li>
                                         <li ><a href="anagrafiche.php">ANAGRAFICHE  <span class="sr-only">(current)</span></a></li>
                                            
                                         <li class="active"><a href="#">ULTIMI INTERVENTI</a></li>
					 <li><a href="php/logout.php">ESCI</a></li>
					 </ul>
				</div>
		
		
		</div>
		</nav>

    <div class='header-chiamate testata'>ULTIMI INTERVENTI</div>
        <div class='chiamata-attiva'>
            <div class='middle' align='center'>
                
                <div class="searchcont befcontent"><br><p class='descl'>| CERCA  : </p>
                        <p class='form-inline'><input type='text' id='descrizione' class='form-control sini' placeholder='Descrizione/Matricola'>
                       <a href='javascript:cerca();'><span class='glyphicon glyphicon-search'></span></a> 
                       <?php
                        if(isset($_SESSION["mail"])&&($_SESSION["mail"]=="alberto.miccio@cremonesini.it"))
                            echo "<br><img src='images/pika.gif' id='loading' width='100' height='100' alt='loading' style='display:none;' />";
                        else
							 if(isset($_SESSION["mail"])&&($_SESSION["mail"]=="ernesto.zorzi@cremonesini.it"))
                            echo "<br><div style='display:none;' id='loading'><img src='images/000.gif'  width='150' height='70' ><img src='images/001.gif' width='50' height='50' ></div>";
							else
                            echo "<br><img src='images/loading.gif' id='loading' width='100' height='100' alt='loading' style='display:none;' />";
                        ?>
                       <br>
                        <div id="content"></div>
                        
                </div>
               
    </div>

             