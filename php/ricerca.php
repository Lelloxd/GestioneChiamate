<?php
$parola = "carotta";
$termini = array("carro", "carota", "limone");

foreach($termini as $termine)
{
    $num_char = similar_text($parola, $termine, $percententuale);
    
    echo "$num_char caratteri di '$parola' sono contenuti in '$termine'";
    echo " (" . round($percententuale) . "%)<br>";
}

//OUTPUT
//
//4 caratteri di 'carotta' sono contenuti in 'carro' (67%)
//6 caratteri di 'carotta' sono contenuti in 'carota' (92%)
//1 caratteri di 'carotta' sono contenuti in 'limone' (15%) 
?>