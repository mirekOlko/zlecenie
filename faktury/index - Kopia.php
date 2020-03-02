<?php
//session_start();
include("../funkcje.php");
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
			include('dodaj_fakture.html.php');
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
	$echo ='<p><a href="index.php?co=dodaj">dodaj nową fakturę</a></p>';
			
	//require_once('../db_lista_zlecen.php');
	$echo.='<table border="1">';
	for($i=0;$i<sizeof($baza);$i++)
	{
		$j;
		$echo.='<tr><td>'.$i.'</td>';
		//for($j=1;$j<sizeof($baza[$i]);$j++)
		$echo.='<td>'.$baza[$i][1].'</td>';
		$echo.='<td><form name="usn" method="post" action="usun_zlec.php"><input name="id" type="hidden" value="'.$baza[$i][0].'" /><input name="usun_'.$baza[$i][0].'" type="submit" value="usun" /></form></td>';
		$echo.='<td><form name="edit" method="post" action="edit_zlec.php"><input name="id" type="hidden" value="'.$baza[$i][0].'" /><input name="edit" type="submit" value="edit" /></form></td>';
		$echo.="</tr>\n";
	}
		
	$echo.='</table>';
	
		
	include('../html/p.html.php');
			
}




?>
