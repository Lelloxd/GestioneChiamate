<!DOCTYPE html>
<head>
        
		<META name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
                
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script src="js/stdlib.js"></script>              
                <!--[if lt IE 9]>
                <script type="text/javascript" src="js/flashcanvas.js"></script>
                <![endif]-->
                <script src="js/jSignature.min.noconflict.js"></script>
		<script src="js/funzioni.js"></script>
                <script src="js/firma.js" type="text/javascript"></script>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700' rel='stylesheet' type='text/css'>
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
		<?php
		session_start();
		
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
					 <li class="active"><a href="#">LAVORO <span class="sr-only">(current)</span></a></li>
                                         <li><a href="anagrafiche.php">ANAGRAFICHE</a></li>
                                         <li><a href="ultimi.php">ULTIMI INTERVENTI</a></li>
					 <li><a href="php/logout.php">ESCI</a></li>
					 </ul>
				</div>
		
		
		</div>
		</nav>

    <div class='header-chiamate testata'>Chiusura intervento</div>
        <div class='chiamata-attiva'>
            <div class='middle' align='center'>
                <form id="intervento" method="POST" onsubmit="php/salvaintervento.php">
				
				
           
    <?php
	
	if(!isset($_SESSION["password"])|| (!isset($_SESSION["mail"])) || (!isset($_SESSION["arrivo"])))
	header("location:index.php");
	$_SESSION["sipconc"]=1;
	
    echo "<div><br><p class='descl'>| ORA INIZIO : </p><b><p class='ora'>".$_SESSION["arrivo"]."</p></b></div>";
    if($_SESSION["codmatricola"]!="")
          echo "<div><br><p class='descl'>| MATRICOLA : </p><b><p ><input type='text' class='form-control piccola' name='codicematricola' value='".$_SESSION["codmatricola"]."' ></p></b>";
        else
            if($_SESSION["matricola"]==1)
        {
            echo '<div class="form-group has-error has-feedback">
                <label class="control-label" for="inputError2">Matricola Obbligatoria</label>
                <input type="text" class="form-control" id="inputError2" name="codicematricola" aria-describedby="inputError2Status" required>
                <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                <span id="inputError2Status" class="sr-only">(error)</span>
              </div>';
        }

    
    
    ?>
                
                        
                        
                   <!-- <div><br><p class='descl'>| ALLEGATO : </p><b><p ><br><input type="file" name="user_file" class='btn'><input type="hidden" name="action" value="upload" />  <input type="text" name='imgdesc' class='form-control piccola' Placeholder="Descrizione"></p></div>!-->
       
            <div><br><p class='descl'>| RILEVAZIONI : </p><br><br>
                <table>
                    <tr><td>Copie B/N <input style='float:right;' class='form-control mm' type='number' name='bn'></td><td>&nbsp; Copie Colore <input class='form-control mm' type='number'style='float:right;' name='colore'></td></tr>
                    <tr><td>Chiusure <input class='form-control mm' type='number' style='float:right;' name='ch'></td><td>&nbsp; Scansioni <input class='form-control mm' style='float:right;' type='number' name='sc'></td></tr>
                </table></div>
            <div><br><p class='descl'>| DESCRIZIONE : </p>
                <textarea placeholder="Descrizione" name="descrtecnico"  class="form-control" rows="4" id="comment" required></textarea></div>
             
                
                
    <?php
    echo "<div class='searchcont befcontent'><input type='text' id='maxlenght' name='maxlenght' hidden><br><p class='descl'>| RICAMBI : </p>";
    echo    "<p class='form-inline'><input type='text' id='idescrizione' class='form-control sini' placeholder='Descrizione/Matricola'>";
    echo    "<a href='javascript:icerca();'><span class='glyphicon glyphicon-search'></span></a></div>";
    echo"<div  class='row'><table id='divNOTE' class='tabhidden' border=1><tr class='intestazione'><td>Descrizione</td><td>Codice</td><td>Qt&agrave;</td><td></td></tr></table><div id='icontent' ></div>
                <img src='images/loading.gif' id='iloading' width='100px' height='100px' alt='loading' style='display:none;' /></div>";
     if($_SESSION["codmatricola"]!="")
     {
    echo "<div class='searchcont befcontent'><br><p class='descl' id='duecento'>| ULTIMI INTERVENTI : </p>";
    $functdesc="javascript:descrizioneultimi('contentultimi','".$_SESSION["codmatricola"]."')";
    echo "<br><br><a id='btn' href=$functdesc>Mostra / Nascondi</a><br>"; 
    
    echo "<div id='contentultimi' class='ultimiin'></div><img src='images/loading.gif' width='100px' height='100px' id='loadingultimi' alt='loading' style='display:none;' />";
    echo "</div>";
    
     }

    ?>
      <script>
                document.getElementById('idescrizione').oninput= function(e)
                {
                        icerca();
                };
        </script>        
     
    <div><p class='descl'>| STATO FINALE </p>
     <select name="risultato" class='form-control piccola'>
         <option value=2 class='ic'>Completato</option>
         <option value=1 class='back'>Ritornare</option>
         <option value=3 class='ar'>In attesa di ricambi</option>
     </select>
        
    </div>
    
    
    
    <div><br><p class='descl'>| FIRMA : </p><br><br>
        <div id="signature"><input type='text' name="firma" id='base' hidden>  </div>
  </form>
<script>

        $(document).ready(function() {
        var $sigdiv = $("#signature");
        $sigdiv.jSignature({color:"#000"});
        $sigdiv.jSignature("reset");
        $('#reset').click(function(e) {
             $sigdiv.jSignature("reset");
        });
        $('#submit').click(function(e) {
            var data = $('#signature').jSignature('getData');
            var url = "php/salvaintervento.php";
			datao=btoa(data);
            $('#base').val(data);
            if((checkNetConnection()!=true)||(checkJSNetConnection()!=true))
            {
                alert("Problema di connessione con il server! riprova");
                return;
            }
            if(data)
            {
				if (confirm('Conferma invio')) {
						var temp=data.replace()
						var $container = $("#creazione");
						$container.load("php/crea.php?nome=firma&valore="+datao);	
						form=document.getElementById('intervento');
						form.target='';
						form.action=url;
						form.submit();
					
				}
            }
        });
    })
                    
    
</script>
             </div></div><br><button class="btnres" id='reset'>Reset</button><button class="btnsend" id="submit" >Salva</button>
                </div>
<div id="creazione"></div>
        </div>
    

</body>