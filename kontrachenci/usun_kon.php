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
	$k;
	foreach($_POST as $s=>$d)
		$k=$s;
	
	$k=explode("_",$k);
	$k=$k[1];
	
	$q='DELETE FROM `kontrachenci` WHERE `kontrachenci`.`id_kontr` = '.$k;
	if(!mysqli_query($link,$q))
	    db_error($link,$q);

	$dane='';
	$q='SELECT * FROM `kontrachenci` ORDER BY `kontrachenci`.`nazwa` ASC';
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
