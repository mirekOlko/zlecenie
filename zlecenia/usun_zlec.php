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

if(isset($_POST))
{
	
	$link=connect();
	$k=safe($_POST['id']);
	
	$q='SELECT count(*) FROM `faktury` WHERE `faktury`.`id_zlec` = '.$k;
	if(!$s=mysqli_query($link,$q))
	    db_error($link,$q);
		
	$r=mysqli_fetch_array($s);

	if($r[0]==0)
	{
		$q='DELETE FROM `zlecenia` WHERE `zlecenia`.`id_zlec` = '.$k;
		if(!mysqli_query($link,$q))
		    db_error($link,$q);
	}
	
	$dane='';
	$q='SELECT * FROM `zlecenia`;';
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
