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

if(isset($_POST['name_zlec']) && isset($_POST['kontrahent']) && isset($_POST['wrtosc_zlecenia']))
{
	$link=connect();
	
	$nazwa=safe($_POST['name_zlec']); 
	$kontrachent=safe($_POST['kontrahent']); 
	$wrtosc_zlecenia=pieniadze($_POST['wrtosc_zlecenia']);	
	//echo $wrtosc_zlecenia.' $wrtosc_zlecenia';
	//exit;

	
	$q="INSERT INTO `zlecenia` (`id_zlec`, `nazwa`, `id_kontr`, `wrtosc_zlecenia`, `czy_zamkniete`) VALUES (NULL, '$nazwa', '$kontrachent', '$wrtosc_zlecenia', '0');";
	//$echo=$q.'<br>';
	
	$bl='';
	if(!mysqli_query($link,$q))
	    db_error($link,$q);

	
	$dane='';
	$q='SELECT * FROM `zlecenia` WHERE `czy_zamkniete`=0;';
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
