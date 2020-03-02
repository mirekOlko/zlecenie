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
			include('dodaj_fakture.html.php');
			include('../html/p.html.php');
		    break;
		case 'dodaj_hurtowe':
		    include('dodaj_fakture_hurtowe.html.php');
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
    $echo='';
    
    if(isset($_REQUEST['masage']))
        $echo.='<p class="red">Info: '.safe($_REQUEST['masage']).'</p>';
    
	$echo.='<p><a href="index.php?co=dodaj">dodaj nową fakturę</a>
                <a href="index.php?co=dodaj_hurtowe">dodaj faktury hurtowo</a> </p>';
			
	//require_once('../db_lista_zlecen.php');
	$echo.='<table border="1">
    <tr><td>data wystawienia</td><td>nazwa</td><td>wartosć</td><td>wystawca</td><td>sposób płatosci</td><td>edycja</td><td>usuwanie</td></tr>';
	
	$link=connect();
	$q="SELECT `faktury`.`id_faktury`, `faktury`.`data_wystawienia`, `faktury`.`numer`,`faktury`.`wartosc`, `kontrachenci`.`nazwa`, `forma_platnosci`.`nazwa` 
                FROM `faktury` INNER JOIN `kontrachenci` ON `faktury`.`id_kontr`=`kontrachenci`.`id_kontr` 
                               INNER JOIN `forma_platnosci` ON `faktury`.`id_forma_platnosci`=`forma_platnosci`.`id_forma_platnosci` 
                ORDER BY id_faktury DESC LIMIT 10;";
	$s=mysqli_query($link,$q);
	//$r=mysqli_fetch_array($s);
	while($r=mysqli_fetch_array($s))
	{
		$echo.='<tr>';
	for($i=1;$i<6;$i++)
	{
	    $echo.='<td>'.$r[$i].'</td>'."\n";
	}
	   
	$echo.='<td><form name="edit" method="post" action="edit_fakture.php"><input name="id" type="hidden" value="'.$r[0].'" /><input name="edit" type="submit" value="edit" /></form></td>'."\n";
	$echo.='<td><form id="usn_'.$r[0].'" name="usn_'.$r[0].'" method="post" action="usun_fakture.php"><input name="id" type="hidden" value="'.$r[0].'" /><input name="STEP2" type="hidden" value="'.$r[0].'" /><input  type="submit" value="usuń" /></form></td>';
	$echo.="</tr>\n";
	}
	mysqli_close($link);	
	$echo.='</table>';
	
		
	include('../html/p.html.php');
			
}




?>
