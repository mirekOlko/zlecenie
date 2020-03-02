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
	
    $echo='';
    $echo.=$_REQUEST['masage'].'<br>';
   switch($_REQUEST['masage'])
   {
	   case 1:
		    require_once('../db_lista_kontr.php');
			$link=connect();
			$q='SELECT * FROM `faktury` WHERE `id_faktury`=(SELECT MAX(`id_faktury`)FROM `faktury`)';
			if(!$s=mysqli_query($link,$q))
				db_error($link,$q);
			$r=mysqli_fetch_array($s);
			
			
			//$echo.='<td>'.$baza[$r[5]][1].'<td>
			$q="SELECT `nazwa` FROM `kontrachenci` WHERE `id_kontr`='$r[5]'";
			$kontrach=mysqli_fetch_array(mysqli_query($link,$q));
			
			$q="SELECT `nazwa` FROM `zlecenia` WHERE `id_zlec`='$r[6]'";
			$zlecenie=mysqli_fetch_array(mysqli_query($link,$q));
			
			echo $r[5].' '.$r[6];
	
			$data_wystawienia=dataHTML($r[2]);
			$data_platnosci=dataHTML($r[3]);
			$ileDni=ileDni($r[2], $r[3]);

			$echo = 'Dodano fakturę <strong>"'.$r[1].'"</strong><br><br>';
			$echo.='<table border="0"><tr><td>numer_faktury</td><td>'.$r[1].'</td></tr>
			<tr>
				<td>data wystawienia </td><td>'.$data_wystawienia.'</td>
			</tr>
			<tr>
				<td>data płatnosci </td><td>'.$data_platnosci.'</td>
			</tr>
			<tr><td>wystawca faktury:</td><td>'.$kontrach[0].'</td>
			</tr>		    
			<tr><td>numer zlecenia:</td><td>'.$zlecenie[0].'</td>
			</tr>
			<tr><td>wartość faktury: </td>
				<td>'.$r[7].'</td></tr>
            <tr><td>wartość VAT: </td>
				<td>'.$r[8].'</td></tr>
						
			<tr><td>forma płatności: </td>
				<td>';
					$formaplat=array('','gotówka','karta','przelew','marek');
					$echo.=$formaplat[$r[9]].'</td>
			</tr>
			<tr><td>czy zapłacona:</td>';
						if($r[10]==0)
							$echo.='<td>NIE</td>';
						else 
							$echo.='<td>TAK</td>';
			$echo.='</tr>';
						
						$echo.='
			<tr><td>
				<form id="form1" name="form1" method="post" action="edit_fakture.php">
				<input type="hidden" name="edit" value="edit">
				<input type="hidden" name="id" value="'.$r[0].'">
				<input name="submit" type="submit" value="popraw fakturę"/>
				</form>
				</td>
				<td>
				
				<a href=index.php><button>OK</button></a>

				</td>
			</tr>
			</table>';
	   break;
	   case 2:
	       echo $echo;
	       break;
	   default:
		$echo.='bląd';
   }
		
	include('../html/p.html.php');
?>
