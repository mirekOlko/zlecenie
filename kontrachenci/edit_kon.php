<?php
//session_start();
include('../funkcje.php');
$menu=menu2();
$style=style2();

/*
if(!isset($_SESSION['sprawdz']))
{
	include('../html/logowanie.html');
	exit();
}
*/

if(isset($_POST['edit'])&& $_POST['edit']=='true')
{
	$link=connect();
	
	foreach($_POST as $s=>$d)
	$id=$s;
	
	$q='SELECT `nazwa`,`adres`,`konto`,`tytul`,`klucz` FROM `kontrachenci` WHERE `kontrachenci`.`id_kontr` ='.$id;
	$s=mysqli_query($link,$q);
	$r=mysqli_fetch_array($s);
		
	if(explode("|",$r[0]))
		$nazwa=explode("|",$r[0]);
	else
		$nazwa[0]=$r[0];

	if(explode("|",$r[1]))
		$adres=explode("|",$r[0]);
	else
		$adres[0]=$r[0];

	
	
	$echo='<form id="form1" name="dane" method="post" action="edit_kon.php">
		<table>
			<tr>
				<td>nazwa:*</td><td><input name="nazwa1" type="text" size="34" wrap="physical" maxlength="34" value="'.$nazwa[0].'" /><br /> <input name="nazwa2" type="text" size="34" wrap="physical" maxlength="34" value="';
	if(isset($nazwa[1]))
		$echo.=$nazwa[1];
	$echo.='" /></td>
				</tr>
			<tr>
				<td>adres:</td><td><input name="adres1" type="text" size="34" wrap="physical" maxlength="34" value="'.$adres[0].'" /><br /><input name="adres2" type="text" size="34" wrap="physical" maxlength="34" value="';
	if(isset($adres[1]))
		$echo.=$adres[1];
	$echo.='" /></td>
				</tr>
			<tr>
				<td>numer konta:*</td><td><input name="nr_konta" type="text" size="26" wrap="physical" maxlength="26" value="'.$r[2].'"/></td>
				</tr>
			<tr>
				<td>tytuł:</td><td><input name="tytul" type="text" size="100" wrap="physical" maxlength="100" value="'.$r[3].'"/></td>
				</tr>
		</table>
		<input name="id" type="hidden" value="'.$id.'" />
		<input name="" type="submit" /><input name="" type="reset" />
		</form>';
	include('../html/p.html.php');
	
}

if(isset($_POST['id']))
{	
	$id=$_POST['id'];
	$link=connect();
	if(isset($_POST['nazwa1']))
		$nazwa=safe($_POST['nazwa1']); 
	else
		$nazwa='';
	if(isset($_POST['nazwa2']) && !empty($_POST['nazwa2']))
		$nazwa.='|'.safe($_POST['nazwa2']); 

	if(isset($_POST['adres1']))
		$adres=safe($_POST['adres1']); 
	else 
		$adres='';
	if(isset($_POST['adres2']) && !empty($_POST['adres2']))
		$adres.='|'.safe($_POST['adres2']);
	
	if(isset($_POST['nr_konta']))
		$nr_konta=(string)safe($_POST['nr_konta']); 
	else 
		$nr_konta='';
	if(isset($_POST['tytul']))
		$tytul=safe($_POST['tytul']); 
	else 
		$tytul='';
	
	if( strlen($nazwa)>3)
		$klucz=$nazwa[0].$nazwa[1].$nazwa[2];
	$klucz.=$nr_konta[0].$id;
	//echo $klucz.'<br> id:'.$id.'<br>';
	
	$link=connect();
	$q="UPDATE `kontrachenci` SET `nazwa` = '$nazwa', `adres` = '$adres', `konto` = '$nr_konta', `tytul` = '$tytul', `klucz` = '$klucz' 
		WHERE `kontrachenci`.`id_kontr` = $id;";
		
		
	$bl='';
	if(!mysqli_query($link,$q))
	    db_error($link,$q);

	
	$dane='';
	$q='SELECT * FROM `kontrachenci` ORDER BY `kontrachenci`.`skroc_nazw` ASC';
	$s=mysqli_query($link,$q);
	while($r=mysqli_fetch_array($s)){
		$dane.="Array('$r[0]','$r[1]','$r[2]','$r[3]','$r[4]','$r[5]'),\n";
		}
	//echo $dane;
	
	zapisPHP('db_lista_kontr',$dane);
	mysqli_close($link);
	
	if($bl=='')
		header('Location: index.php'); 
	else 
		echo $bl;
	
}
	
?>
