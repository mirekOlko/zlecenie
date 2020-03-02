<?php
//session_start();
include("../funkcje.php");
$time_start = microtime_float();
$menu=menu2();
$style=style2();

/*
if(!isset($_SESSION['sprawdz']))
{
	include('../html/logowanie.html');
	exit();
}
//wylogowanie urzytkownika
if(isset($_POST['logout'])){
	session_destroy();
	include('../html/logowanie.html');
	exit();
	}
*/
	
if(isset($_GET['co']))
{
	$s=safe($_GET['co']);
	switch($s)
	{
		case 'dodaj':
			include('dodaj_kon.html.php');
			include('../html/p.html.php');
		break;
		case 'usun':
			include('usun_kon.php');
		break;
		case 'edit':
			include('edit_kon.php');
		break;

	}
}
else
{
	$echo='<h1>Kontrachenci</h1>';
	$echo.='<a href="index.php?co=dodaj">dodaj nowego kontrachenta</a>';
			
	require_once('../db_lista_kontr.php');
	$echo.='<table border="1">';
	$echo.='<tr><td>LP</td><td>nazwa kontrachenta</td><td>adres kontrachenta</td><td>nr konta</td><td>tytuł przelewu</td><td></td></tr>';
	for($i=0;$i<sizeof($baza);$i++)
	{
		$j;
		$echo.='<tr><td>'.$i.'</td>';
		for($j=1;$j<sizeof($baza[$i]);$j++)
			$echo.='<td>'.$baza[$i][$j].'</td>';
		//$echo.='<td><form name="usn" method="post" action="usun_kon.php"><input name="usun_'.$baza[$i][0].'" type="submit" value="usun" /></form></td>';
		$echo.='<td><form name="edit" method="post" action="edit_kon.php"><input name="edit" type="hidden" value="true" /><input name="'.$baza[$i][0].'" type="submit" value="edit" /></form></td>';
		$echo.="</tr>\n";
	}
		
	$echo.='</table>';

		
	include('../html/p.html.php');
			
}




?>
