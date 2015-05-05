//FADE
(function() {
    var FX = {
        easing: {
            linear: function(progress) {
                return progress;
            },
            quadratic: function(progress) {
                return Math.pow(progress, 2);
            },
            swing: function(progress) {
                return 0.5 - Math.cos(progress * Math.PI) / 2;
            },
            circ: function(progress) {
                return 1 - Math.sin(Math.acos(progress));
            },
            back: function(progress, x) {
                return Math.pow(progress, 2) * ((x + 1) * progress - x);
            },
            bounce: function(progress) {
                for (var a = 0, b = 1, result; 1; a += b, b /= 2) {
                    if (progress >= (7 - 4 * a) / 11) {
                        return -Math.pow((11 - 6 * a - 11 * progress) / 4, 2) + Math.pow(b, 2);
                    }
                }
            },
            elastic: function(progress, x) {
                return Math.pow(2, 10 * (progress - 1)) * Math.cos(20 * Math.PI * x / 3 * progress);
            }
        },
        animate: function(options) {
            var start = new Date;
            var id = setInterval(function() {
                var timePassed = new Date - start;
                var progress = timePassed / options.duration;
                if (progress > 1) {
                    progress = 1;
                }
                options.progress = progress;
                var delta = options.delta(progress);
                options.step(delta);
                if (progress == 1) {
                    clearInterval(id);
                    options.complete();
                }
            }, options.delay || 10);
        },
        fadeOut: function(element, options) {
            var to = 1;
            this.animate({
                duration: options.duration,
                delta: function(progress) {
                    progress = this.progress;
                    return FX.easing.swing(progress);
                },
                complete: options.complete,
                step: function(delta) {
                    element.style.opacity = to - delta;
                }
            });
        },
        fadeIn: function(element, options) {
            var to = 0;
            this.animate({
                duration: options.duration,
                delta: function(progress) {
                    progress = this.progress;
                    return FX.easing.swing(progress);
                },
                complete: options.complete,
                step: function(delta) {
                    element.style.opacity = to + delta;
                }
            });
        }
    };
    window.FX = FX;
})()
//FINE

// TEST CONNESSIONE

function checkJSNetConnection(){
 var xhr = new XMLHttpRequest();
 var file = "dot.png";
 var r = Math.round(Math.random() * 10000); 
 xhr.open('HEAD', file + "?subins=" + r, false); 
 try {
  xhr.send(); 
  if (xhr.status >= 200 && xhr.status < 304) {
   return true;
  } else {
   return false;
  }
 } catch (e) {
  return false;
 }
}

function checkNetConnection(){
 jQuery.ajaxSetup({async:false});
 re="";
 r=Math.round(Math.random() * 10000);
 $.get("dot.png",{subins:r},function(d){
  re=true;
 }).error(function(){
  re=false;
 });
 return re;
}

// FINE TEST CONNESSIONE


var latest="primavolta";
var webserviceaddress="https://localhost:44300/";
function collapse(id,wow)
{
var elem=document.getElementById(id);
if(elem.style.display=="block")
{
document.getElementById(id).style.display = 'none';
//document.getElementById(wow).style.backgroundColor = 'initial';
}
else
{
if(latest!="primavolta")
document.getElementById(latest).style.display = 'none';
document.getElementById(id).style.display = 'block';
//document.getElementById(wow).style.backgroundColor = '#66edc8';
}
latest=id;
}
function parti(tipoint,num,originaldata,coditta,btn,divp,arr,ass)
{  
 document.getElementById(btn).value = 'Verifica connessione . .';   
if((checkNetConnection()!=true)||(checkJSNetConnection()!=true))
    {
        alert("Problema di connessione con il server! riprova");
        return;
    }
   document.getElementById(btn).value = 'Attendere . .';     
    var opnum="op"+num;
var currentdate = new Date(); 
var datetime = ""+ currentdate.getHours() + ":" + currentdate.getMinutes();
document.getElementById(arr).style.display = 'none';
document.getElementById(opnum).style.display = 'block';
document.getElementById(divp).innerHTML = datetime;
document.getElementById(btn).style.display = 'none';
document.getElementById(arr).style.display = 'block';
document.getElementById(ass).style.display = 'block';
var x=document.getElementsByClassName("nounderline");
for (index = 0, len = x.length; index < len; ++index) {
    x[index].setAttribute('href', "#");
}
var request = new XMLHttpRequest();
request.open("GET", "php/partenza.php?tipoint="+tipoint+"&num="+num+"&data="+originaldata+"&ditta="+coditta+"&orapartenza="+datetime, true);
request.send(null);
//location.href='lavori.php';
}
function arriva(tipoint,num,originaldata,coditta,btn,divp,arr,matrobb,codmatr)
{
    if((checkNetConnection()!=true)||(checkJSNetConnection()!=true))
    {
        alert("Problema di connessione con il server! riprova");
        return;
    }
var oanum="oa"+num;
var opnum="op"+num;
var currentdate = new Date(); 
var datetime = ""+ currentdate.getHours() + ":" + currentdate.getMinutes();
document.getElementById(arr).style.display = 'none';
document.getElementById(btn).style.display = 'none';
document.getElementById(oanum).style.display = 'block';
document.getElementById(opnum).style.display = 'block';
var request = new XMLHttpRequest();
request.open("GET", "php/arrivo.php?tipoint="+tipoint+"&num="+num+"&data="+originaldata+"&ditta="+coditta+"&oraarrivo="+datetime+"&matricolaobb="+matrobb+"&codmatricola="+codmatr, true);
request.send(null);
location.href='lavori.php';
}
function getPosition(element) {
    var xPosition = 0;
    var yPosition = 0;
  
    while(element) {
        xPosition += (element.offsetLeft - element.scrollLeft + element.clientLeft);
        yPosition += (element.offsetTop - element.scrollTop + element.clientTop);
        element = element.offsetParent;
    }
    return { x: xPosition, y: yPosition };
}
function descrizioneguasto(parag)
{
	
	if(document.getElementById(parag).style.display=="block")
		document.getElementById(parag).style.display="none";
	else
		document.getElementById(parag).style.display="block";
}
function descrizioneultimi(parag,mat)
{
	
	if(document.getElementById(parag).style.display=="block")
        {
                
		document.getElementById(parag).style.display="none";
                
            }
	else
        {
            ultimiinterventi(mat);
		document.getElementById(parag).style.display="block";
            }
}
function cerca()
{
    var testo=document.getElementById("descrizione").value;
(function($)
{ 
        $.ajaxSetup(
        {
            cache: false,
            beforeSend: function() {
                $('#content').hide();
                $('#loading').show();
            },
            complete: function() {
                $('#loading').hide();
                $('#content').show();
            },
            success: function() {
                $('#loading').hide();
                $('#content').show();
            }
        });
        var $container = $("#content");
        $container.load("php/rss-feed-data.php?testo="+testo);
})(jQuery);
}
function ultimiinterventi(matricola)
{
(function($)
{ 
        $.ajaxSetup(
        {
            cache: false,
            beforeSend: function() {
                $('#contentultimi').hide();
                $('#loadingultimi').show();
            },
            complete: function() {
                $('#loadingultimi').hide();
                $('#contentultimi').show();
            },
            success: function() {
                $('#loadingultimi').hide();
                $('#contentultimi').show();
            }
        });
        var $container = $("#contentultimi");
        $container.load("php/rss-feed-data.php?testo="+matricola+"&num=5");
})(jQuery);
}
function clean()
{
    var $sigdiv = $("#signature");
	
	$sigdiv.jSignature("reset");
}
function save()
{
        var $sigdiv = $("#signature");
        datapair = $sigdiv.jSignature("getData","base64");
        // Getting signature as "base30" data pair
	// array of [mimetype, string of jSIgnature"s custom Base30-compressed format]
	// reimporting the data into jSignature.
	// import plugins understand data-url-formatted strings like "data:mime;encoding,data"
	$sigdiv.jSignature("setData", "data:" + datapair.join(","));
	
}
function assente(tipoint,num,originaldata,coditta,btn,divp,arr,matrobb,codmatr)
{
    if((checkNetConnection()!=true)||(checkJSNetConnection()!=true))
    {
        alert("Problema di connessione con il server! riprova");
        return;
    }
var currentdate = new Date(); 
var datetime = ""+ currentdate.getHours() + ":" + currentdate.getMinutes();
var request = new XMLHttpRequest();
request.open("GET", "php/assente.php?tipoint="+tipoint+"&num="+num+"&data="+originaldata+"&ditta="+coditta+"&oraarrivo="+datetime+"&matricolaobb="+matrobb+"&codmatricola="+codmatr, true);
request.send(null);
location.href='lavori.php';
} 

function acerca()
{
    var testo=document.getElementById("descrizione").value;
(function()
{ 
        $.ajaxSetup(
        {
            cache: false,
            beforeSend: function() {
                $('#content').hide();
                $('#loading').show();
            },
            complete: function() {
                $('#loading').hide();
                $('#content').show();
            },
            success: function() {
                $('#loading').hide();
                $('#content').show();
            }
        });
        var $container = $("#content");
        $container.load("php/anagraficasearch.php?testo="+testo);
})(jQuery);
}
function icerca()
{
    var testo=document.getElementById("idescrizione").value;
(function($)
{ 
        $.ajaxSetup(
        {
            cache: false,
            beforeSend: function() {
                $('#icontent').hide();
                $('#iloading').show();
            },
            complete: function() {
                $('#iloading').hide();
                $('#icontent').show();
            },
            success: function() {
                $('#iloading').hide();
                $('#icontent').show();
            }
        });
        var $container = $("#icontent");
        $container.load("php/articolisearch.php?testo="+testo);
})(jQuery);
}

var i = 1;
function aggiungi(variation,descrizione)
{
//var botton=document.getElementById(bottone).value;
var variazione=descrizione;
var div = document.getElementById('divNOTE');
var asd="'".concat(variation).concat("'");
var input="input".concat(variation);
if(!document.getElementById(input))
    {
$('<div class="col-md-4 befcontent"><p id='+variation+' class="gmlike"><input type="text" id="'+input+'" style="float:left; background-color: transparent; border: 0px solid; display:none;"  name='+i+' value="'+""+variazione+';" readonly></label>'+'<input type="text" class="valoren" name="valore'+variation+'" id="valore'+variation+'" value=1 readonly>'+variazione+'<a class="glyphicon glyphicon-remove" href="javascript:rimuovinota('+asd+');" id="'+i+'"></a></p></div>').appendTo(div);
    i++;
    }
    else
    {
        var valore="valore".concat(variation);
        document.getElementById(valore).value++;
    }
        

document.getElementById('maxlenght').value=i;
}

function aggiunginew(variation,descrizione)
{
//var botton=document.getElementById(bottone).value;
var div = document.getElementById('divNOTE');
var variazione=descrizione;
if(div.style.display!="block")
    div.style.display="block";
var asd="'".concat(variation).concat("'");
var input="input".concat(variation);
if(!document.getElementById(input))
    {
$('<tr class="wwhite" id='+variation+'><td><input type="text" id="'+input+'" style="float:left; background-color: transparent; border: 0px solid; display:none;"  name='+i+' value="'+""+variation+'" readonly></label>'+variazione+'</td><td>'+variation+'</td><td><input type="text" class="valoren" name="valore'+i+'" id="valore'+variation+'" value=1 readonly></td><td><a class="glyphicon glyphicon-remove" href="javascript:rimuovinota('+asd+');" id="'+i+'"></a></td></tr>').appendTo(div);
    i++;
    }
    else
    {
        var valore="valore".concat(variation);
        document.getElementById(valore).value++;
    }
        

document.getElementById('maxlenght').value=i;
}
function rimuovinota(id)
{
var divi = document.getElementById('divNOTE');
if(document.getElementById(id)!=null)
{
FX.fadeOut(document.getElementById(id), {
        duration: 1000,
        complete: function() {
            document.getElementById(id).remove();
            i--;
document.getElementById('maxlenght').value=i;
        }
    });

}
}
function smallfont()
{
	location.href='lavori.php?text=small';
}
function normalfont()
{
	location.href='lavori.php?text=normal';
}
function bigfont()
{
	location.href='lavori.php?text=big';
}

