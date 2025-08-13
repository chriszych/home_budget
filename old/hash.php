<?php 

$haslo = 'kotdamian'; 
$haslo_zahashowane = password_hash($haslo, PASSWORD_DEFAULT); 
echo nl2br($haslo." = ".$haslo_zahashowane."\n"); 

$haslo2 = 'kownackimichal'; 
$haslo2_zahashowane = password_hash($haslo2, PASSWORD_DEFAULT); 
echo nl2br($haslo2." = ".$haslo2_zahashowane."\n"); 

$haslo3 = 'brzeczykroman'; 
$haslo3_zahashowane = password_hash($haslo3, PASSWORD_DEFAULT); 
echo nl2br($haslo3." = ".$haslo3_zahashowane."\n"); 

$haslo4 = 'rybajuliusz'; 
$haslo4_zahashowane = password_hash($haslo4, PASSWORD_DEFAULT); 
echo nl2br($haslo4." = ".$haslo4_zahashowane."\n"); 

$haslo5 = 'rogowskaanna'; 
$haslo5_zahashowane = password_hash($haslo5, PASSWORD_DEFAULT); 
echo nl2br($haslo5." = ".$haslo5_zahashowane."\n"); 

$haslo6 = 'twarogewa'; 
$haslo6_zahashowane = password_hash($haslo6, PASSWORD_DEFAULT); 
echo nl2br($haslo6." = ".$haslo6_zahashowane."\n"); 

/*
kownackimichal
brzeczykroman
rybajuliusz
rogowskaanna
twarogewa
*/
?>