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
    //$bl.= $k.': '.$v.'<br>';
    //echo 'isset($_POST['."'".$k."'".']) && ';
	
/*	
if(isset($_POST['numer_faktury'])){
		$link=connect();
		if(!$numer_faktury=safe($_POST['numer_faktury']))echo '<font color="red">błąd 1</font><br>';
	
	$q="SELECT `id_faktury` FROM `faktury` WHERE `faktury`.`numer` = '$numer_faktury';";
	if($s=mysqli_query($link,$q))
	{
		$r=mysqli_fetch_array($s);
		mysqli_close($link);
		echo 'Location: edit_fakture.php?edit=edit&id='.$r[0];
		header('Location: edit_fakture.php?edit=edit&id='.$r[0]);
		exit();
	}
	mysqli_close($link);
*/
	
if(isset($_POST['numer_faktury']) && isset($_POST['data_wystawienia']) && isset($_POST['data_zaplaty_faktury']) && isset($_POST['numer_zlecenia']) && isset($_POST['wartosc_faktury']) && isset($_POST['zaplacona']) && isset($_POST['forma_platnosci']))
{
	
	if(!$numer_faktury=safe($_POST['numer_faktury']))echo '<font color="red">błąd 1</font><br>';
	if(!$data_wystawienia=dataSQL(safe($_POST['data_wystawienia'])))echo '<font color="red">błąd 2</font><br>';
	if(!$data_zaplaty_faktury=dataSQL(safe($_POST['data_zaplaty_faktury'])))echo '<font color="red">błąd 3</font><br>';
	if(!$wystawca_faktury=safe($_POST['wystawca_faktury']))echo '<font color="red">błąd 4</font><br>';
	if(!$numer_zlecenia=safe($_POST['numer_zlecenia']))echo '<font color="red">błąd 5</font><br>';
	if(!$wartosc_faktury=pieniadze($_POST['wartosc_faktury']))echo '<font color="red">błąd 6</font><br>';
	if(!empty($_POST['wartosc_VAT']))
	       $wartosc_VAT=pieniadze($_POST['wartosc_VAT']);
	   else
	       $wartosc_VAT=null;
	if(!$zaplacona=safe($_POST['zaplacona'])) echo '<font color="red">błąd 7</font><br>';
	if(!$forma_platnosci=safe($_POST['forma_platnosci'])) echo '<font color="red">błąd 8</font><br>';
	

	//$bl=$numer_faktury.' '.$data_wystawienia_faktury.' '.$termin_platnosci.' '.$wystawca_faktury.' '.$numer_zlecenia.' '.$wartosc_faktury;

	
	//id_faktury`, `numer`, `data`, `id_kontr`, `id_zlec`, `wartosc	
	
	$link=connect();
	//echo 'wartoktury:'.$wartosc_faktury.' '.$_POST['wartosc_faktury'];
	
	$q="INSERT INTO `faktury` (`id_faktury`, `numer`, `data_wystawienia`, `data_platnosci`, `id_kontr`, `id_zlec`, `wartosc`, `VAT`, `id_forma_platnosci`,`zaplacona`) 
						  VALUES (NULL, '$numer_faktury', '$data_wystawienia','$data_zaplaty_faktury', '$wystawca_faktury', '$numer_zlecenia', '$wartosc_faktury', '$wartosc_VAT','$forma_platnosci','$zaplacona');";

	if(!mysqli_query($link,$q))
	{
		if(mysqli_errno($link)==1062)
		{
			$q="SELECT `id_faktury` FROM `faktury` WHERE `faktury`.`numer` = '$numer_faktury';";
			if($s=mysqli_query($link,$q))
			{
				$r=mysqli_fetch_array($s);
				mysqli_close($link);
				echo 'Location: edit_fakture.php?edit=edit&id='.$r[0];
				header('Location: edit_fakture.php?edit=edit&id='.$r[0]);
			}
		}
		else
			db_error($link,$q);
	}
	
	if($forma_platnosci>3){
		$q="SELECT MAX(`id_faktury`) FROM `faktury`;";
		if(!$s=mysqli_query($link,$q))
			db_error($link,$q);
		$r=mysqli_fetch_array($s);
		
		$q="INSERT INTO `marek` (`id_marek`, `id_faktury`, `data_otrz_kasy`, `wrtosc_zlecenia`)
									VALUES (NULL, '$r[0]', NULL, '$wartosc_faktury');";
		if(!mysqli_query($link,$q))
			db_error($link,$q);
		}
	
	$q="UPDATE `kontrachenci` SET `ilosc` = ilosc + 1 WHERE `kontrachenci`.`id_kontr` = $wystawca_faktury;";
	if(!mysqli_query($link,$q))
		db_error($link,$q);
		
		
		mysqli_close($link);

		
		if($bl=='')
			header('Location: masage.php?masage=1'); 
		else 
			echo $bl;
	
}

else
	echo 'błąd dodania faktury';
	//header('Location: index.php'); 
?>
