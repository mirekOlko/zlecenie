<?php

//session_start();
include("./funkcje.php");
$time_start = microtime_float();
//wylogowanie urzytkownika

if(isset($_POST['logout'])){
	session_destroy();
	include('./html/logowanie.html');
	exit();
	}
/*
// włączanie logowania
if(isset($_POST['login']) && isset($_POST['haslo'])){
	$login=safe($_POST['login']);
	$haslo=safe($_POST['haslo']);
	//echo $login.' '.$haslo;
	if($login='1' && $haslo='1')
	{
		session_regenerate_id();
		$_SESSION['sprawdz'] = true;
		$_SESSION['zalogowany']='tak';
		$_SESSION['adres_ip'] = $_SERVER['REMOTE_ADDR'];
		//echo 'zalogowano';
	}
}

if(!isset($_SESSION['sprawdz']))
	include('./html/logowanie.html');
else
{
*/
if(isset($_GET['echo']) && empty($_GET['echo']))
    $echo=$_GET['echo'];
else
	$echo='zalogowany';

$style=style1();
$menu=menu1();
include('./html/p.html.php');
	
//}
?>
