<?php
//session_start();

include('../funkcje.php');
$time_start = microtime_float();
$menu=menu2();
$style=style2();
$echo='<h1>Zlecenia</h1>';
/*
if(!isset($_SESSION['sprawdz']))
{
	include('../html/logowanie.html');
	exit();
}
*/

if(isset($_POST['edit'])&& $_POST['edit']=='edit')
{
	if(!$link=connect())
	{
		echo 'błąd połaczenie';
		exit;
	}
	require_once('../db_lista_kontr.php');
	
	$id=safe($_POST['id']);
	
	$q='SELECT * FROM `zlecenia` WHERE `zlecenia`.`id_zlec` = '.$id;
	if(!$s=mysqli_query($link,$q))
	    db_error($link,$q);
		
	$r=mysqli_fetch_array($s);
	mysqli_close($link);
	
	$echo.='<form id="form1" name="form1" method="post" action="edit_zlec.php">

	nazwa zlecenia:  <input name="name_zlec" type="text" size="34" wrap="physical" maxlength="34" value="'.$r[1].'" />  
	<p>zleceniodawca: </p>
	<table border="1"><tr>';

	for($i=0;$i<sizeof($baza);$i++)
	{
		if($i%3==0)
			$echo.="</tr> \n <tr>";
		
		if($r[2]==$baza[$i][0])
			$echo.='<td><input type="radio" name="kontrahent" value="'.$baza[$i][0].'" checked="checked"/>'.$baza[$i][1].'</td>';
		else	
			$echo.='<td><input type="radio" name="kontrahent" value="'.$baza[$i][0].'" />'.$baza[$i][1].'</td>';
		
		//$echo.='<td>id: '.$id.' , baza '.$baza[$i][0].'</td>';
		//echo $baza[$i][0];
		//echo $id;
	}

	$echo.='
	</tr>
	</table>
		czy zamknięte?<select name="czy_zamkniete">
						<option value="0">NIE</option>
						<option value="1">TAK</option>
						</select><br><br>
		szacowana wartość kontraktu:  <input name="wrtosc_zlecenia" type="text" size="34" wrap="physical" maxlength="34" value="'.$r[3].'" />
		<input name="id" type="hidden" value="'.$r[0].'" />
		<input name="" type="submit" value="popraw" />
		</form>';
	include('../html/p.html.php');
	
}

if(isset($_POST['id']) && isset($_POST['name_zlec']) && isset($_POST['kontrahent']) && isset($_POST['czy_zamkniete']))
{	
	$id=safe($_POST['id']);
	$nazwa=safe($_POST['name_zlec']);
	$id_kontr=safe($_POST['kontrahent']);
	$czy_zamkniete=safe($_POST['czy_zamkniete']);
	$wrtosc_zlecenia=pieniadze($_POST['wrtosc_zlecenia']);
	//echo $czy_zamkniete;
	
	$link=connect();
	$q="UPDATE `zlecenia` SET `nazwa` = '$nazwa', `id_kontr` = '$id_kontr', `czy_zamkniete`='$czy_zamkniete', `wrtosc_zlecenia`='$wrtosc_zlecenia' WHERE `zlecenia`.`id_zlec` = $id;";
		
		
	$bl='';
	if(!mysqli_query($link,$q))
	    db_error($link,$q);

	
	$dane='';
	
	$q='SELECT * FROM `zlecenia` WHERE `czy_zamkniete`=0;;';
	$s=mysqli_query($link,$q);
	while($r=mysqli_fetch_array($s)){
		$dane.="Array('$r[0]','$r[1]','$r[2]'),\n";
		}
	//echo $dane;
	
	zapisPHP('db_lista_zlecen',$dane);
	mysqli_close($link);

	if($bl=='')
		header('Location: index.php'); 
	else 
		echo $bl;
}

	
?>
