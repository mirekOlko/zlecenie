<?php
//session_start();
//$timestart=microtime();
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
			include('dodaj_zlec.html.php');
			include('../html/p.html.php');
		break;
		case 'usun':
			include('usun_kon.php');
		break;
		case 'edit':
			include('edit_kon.php');
		break;
		case 'all':
			include('wszystkie_zlecenia.php');
			include('../html/p.html.php');
		break;

	}
}
else
{
	$echo='<h1>Zlecenia</h1>';
	$echo.='<p><a href="index.php?co=dodaj">dodaj nowe zlecenie</a><br><a href="index.php?co=all">wszystkie zlecenia</a></p>';
			
	//require_once('../db_lista_zlecen.php');
	$echo.='<table border="1" cell>
	<tr><td>Id</td><td>nazwa zlecenia</td><td>zamawiający</td><td>szacowana wartość</td><td>edycja</td></tr>';
	
		if(!$link=connect())
	{
		echo 'błąd połaczenie';
		exit;
	}
	//require_once('../db_lista_kontr.php');
	
	//$id=safe($_POST['id']);
	
	//$q='SELECT * FROM `zlecenia` WHERE `zlecenia`.`id_zlec` = 0;';
	$q='SELECT `zlecenia`.`id_zlec`,`zlecenia`.`nazwa`, `kontrachenci`.`nazwa`, `zlecenia`.`wrtosc_zlecenia` FROM `zlecenia` LEFT OUTER JOIN `kontrachenci` ON `zlecenia`.`id_kontr`=`kontrachenci`.`id_kontr` where `zlecenia`.`czy_zamkniete`=0 ORDER BY `zlecenia`.`id_zlec`';
	if(!$s=mysqli_query($link,$q))
	    db_error($link,$q);
		

	//for($i=0;$i<sizeof($baza);$i++)
		//$i=0;
	while($r=mysqli_fetch_array($s))
	{
		//$echo.='<tr><td>'.$i.'</td>';
		//for($j=1;$j<sizeof($baza[$i]);$j++)+
		$echo.='<td>'.$r[0].'</td>';
		$echo.='<td>'.$r[1].'</td>';
		$echo.='<td>'.$r[2].'</td>';
		if($r[3]=='')
			$echo.='<td>brak</td>';
		else
			$echo.='<td>'.$r[3].'</td>';
		$echo.='<td><form name="usn" method="post" action="usun_zlec.php"><input name="id" type="hidden" value="'.$r[0].'" /><input name="usun_'.$r[0].'" type="submit" value="usun" /></form></td>';
		$echo.='<td><form name="edit" method="post" action="edit_zlec.php"><input name="id" type="hidden" value="'.$r[0].'" /><input name="edit" type="submit" value="edit" /></form></td>';
		$echo.="</tr>\n";
		//$i++;
	}
		
	$echo.='</table>';
	
	include('../html/p.html.php');
			
}




?>
