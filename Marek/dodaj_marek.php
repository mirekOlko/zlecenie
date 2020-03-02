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
//$bl='';
//foreach($_POST as $k=>$v)
  //  $bl.= $k.': '.$v.'<br>';
    //echo 'isset($_POST['."'".$k."'".']) && ';
if(isset($_POST['otrzymal']) && isset($_POST['data_otzymania']))
{
    if(!$_POST['otrzymal']=pieniadze($_POST['otrzymal']))
        echo '<font color="red">błąd 1</font><br>';
    if(!$_POST['data_otzymania']=dataSQL(safe($_POST['data_otzymania'])))
        echo '<font color="red">błąd 2</font><br>';
	

	$link=connect();
	//echo 'wartoktury:'.$wartosc_faktury.' '.$_POST['wartosc_faktury'];
	$q="INSERT INTO `marek` (`id_marek`, `id_faktury`, `data_otrz_kasy`, `wrtosc_zlecenia`) 
                                    VALUES (NULL, NULL, '".$_POST['data_otzymania']."', '-".$_POST['otrzymal']."');";

	if(!mysqli_query($link,$q))
	    db_error($link,$q);

	if($bl=='')
		header('Location: index.php?allert=dodano pieniądze '.$_POST['otrzymal']); 
	else 
		echo $bl;

}
else
	echo 'błąd dodania pieniedzy Markowi<br>';
    echo $bl;
	//header('Location: index.php'); 
?>
