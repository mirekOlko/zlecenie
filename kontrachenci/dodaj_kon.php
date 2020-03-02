<?php
//session_start();
include('../funkcje.php');
$time_start = microtime_float();
$menu=menu2();
$style=style2();
/*
if(!isset($_SESSION['sprawdz']))
{
	include('../html/logowanie.html');
	exit();
}
*/
if(isset($_POST))
{
	$link=connect();

	if(isset($_POST['sknazwa1']))
		$sknazwa=safe($_POST['sknazwa1']); 
	else
		$sknazwa='';
	if(isset($_POST['sknazwa2']) && !empty($_POST['sknazwa2']))
		$sknazwa.='|'.safe($_POST['sknazwa2']); 
	
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
	
	if(isset($_POST['nip']))
		$NIP=(string)safe($_POST['nip']); 
	else 
		$NIP='';
	
	if(isset($_POST['nr_konta']))
		$nr_konta=(string)safe($_POST['nr_konta']); 
	else 
		$nr_konta='';
	if(isset($_POST['tytul']))
		$tytul=safe($_POST['tytul']); 
	else 
		$tytul='';
	
	/*
	$q='SELECT COUNT(`id_kontr`) FROM `kontrachenci`';
	if($r=mysqli_query($link,$q)){
		$id=mysqli_fetch_array($r);
		$id=$id[0];
		mysqli_free_result($r);
		}
	$klucz='';
	if( strlen($nazwa)>3)
		$klucz=$nazwa[0].$nazwa[1].$nazwa[2];
	$klucz.=$nr_konta[0].$id;
	echo $klucz.'<br> id:'.$id.'<br>';
	*/
	$q="INSERT INTO `kontrachenci` (`id_kontr`,`skroc_nazw`,`nazwa`,`adres`,`NIP`,`konto`,`tytul`,`ilosc`) 
							VALUES (NULL,'$sknazwa','$nazwa','$adres','$NIP','$nr_konta','$tytul','0');";
	//$echo=$q.'<br>';
	

	if(!mysqli_query($link,$q))
	    db_error($link,$q);

	
	$dane='';
	$q='SELECT * FROM `kontrachenci` ORDER BY `kontrachenci`.`skroc_nazw` ASC';
	$s=mysqli_query($link,$q);
	while($r=mysqli_fetch_array($s)){
		$dane.="Array('$r[0]','$r[1]','$r[2]','$r[3]','$r[4]'),\n";
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
