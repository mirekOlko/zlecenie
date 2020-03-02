<?php
//session_start();
include('../funkcje.php');
$menu=menu2();
$style=style2();
$time_start = microtime_float();

	
if(isset($_POST['data_wystawienia']) && isset($_POST['data_zaplaty_faktury']) && isset($_POST['numer_zlecenia']) && isset($_POST['zaplacona']) && isset($_POST['forma_platnosci']))
{
	
	
	if(!$data_wystawienia=dataSQL(safe($_POST['data_wystawienia'])))echo '<font color="red">błąd 2</font><br>';
	if(!$data_zaplaty_faktury=dataSQL(safe($_POST['data_zaplaty_faktury'])))echo '<font color="red">błąd 3</font><br>';
	if(!$wystawca_faktury=safe($_POST['wystawca_faktury']))echo '<font color="red">błąd 4</font><br>';
	if(!$numer_zlecenia=safe($_POST['numer_zlecenia']))echo '<font color="red">błąd 5</font><br>';
	if(!$zaplacona=safe($_POST['zaplacona'])) echo '<font color="red">błąd 7 dfgs</font><br>';
	if(!$forma_platnosci=safe($_POST['forma_platnosci'])) echo '<font color="red">błąd 8</font><br>';

	
	$link=connect();

	
	/*isset($_POST['numer_faktury']) && && isset($_POST['wartosc_faktury'])
    $echo
	        */
	//foreach($_POST AS $k=>$v)
	//    echo $k.' => '.$v.'<br>';
	
	$echo='<table><tr><td>LP</td><td>nazwa</td><td>brutto</td><td>VAT</td><td>status</td><tr>';
	
	for($i=1;$i<9;$i++){
	    $bl=0;
	    if(isset($_POST['numer_faktury_'.$i]) && !empty($_POST['numer_faktury_'.$i])) 
	       $numer_faktury=safe($_POST['numer_faktury_'.$i]);
    	    else
    	        $bl++;
    	        
	    if(isset($_POST['wartosc_faktury_'.$i]) && !empty($_POST['wartosc_faktury_'.$i]))
	        $wartosc_faktury=pieniadze($_POST['wartosc_faktury_'.$i]);
    	    else
    	        $bl++;
	    
    	       // echo $numer_faktury.' '.$bl.'<br>';
    	        
        if($bl==0)
        {
    	    $wartosc_VAT=0;
    	    if(!empty($_POST['wartosc_VAT_'.$i]))
    	    {
    	        $wartosc_VAT=pieniadze($_POST['wartosc_VAT_'.$i]);
    	        $q="INSERT INTO `faktury` (`id_faktury`, `numer`, `data_wystawienia`, `data_platnosci`, `id_kontr`, `id_zlec`, `wartosc`, `VAT`, `id_forma_platnosci`,`zaplacona`)
        						  VALUES (NULL, '$numer_faktury', '$data_wystawienia','$data_zaplaty_faktury', '$wystawca_faktury', '$numer_zlecenia', '$wartosc_faktury', '$wartosc_VAT','$forma_platnosci','$zaplacona');";
    	        
    	    }
    	        else
    	            $q="INSERT INTO `faktury` (`id_faktury`, `numer`, `data_wystawienia`, `data_platnosci`, `id_kontr`, `id_zlec`, `wartosc`, `VAT`, `id_forma_platnosci`,`zaplacona`)
        						  VALUES (NULL, '$numer_faktury', '$data_wystawienia','$data_zaplaty_faktury', '$wystawca_faktury', '$numer_zlecenia', '$wartosc_faktury', NULL,'$forma_platnosci','$zaplacona');";
    	            
    	    
        	//echo $q.'<br>';
        	if(!mysqli_query($link,$q))
        	    $echo.='<tr><td>'.$i.'</td><td>'.$numer_faktury.'</td><td>'.$wartosc_faktury.'</td><td>'.$wartosc_VAT.'</td><td>'.db_error_info($link,$q).'</td></tr>';
        	else 
        	    $echo.='<tr><td>'.$i.'</td><td>'.$numer_faktury.'</td><td>'.$wartosc_faktury.'</td><td>'.$wartosc_VAT.'</td><td>OK<td></tr>';
        

        	
        	$q="UPDATE `kontrachenci` SET `ilosc` = ilosc + 1 WHERE `kontrachenci`.`id_kontr` = $wystawca_faktury;";
        	if(!mysqli_query($link,$q))
        		db_error($link,$q);
        }
    }
		$echo.='</table>';
		mysqli_close($link);
		include('../html/p.html.php');
		

	
}

else
	echo 'błąd dodania faktury';
	//header('Location: index.php'); 
?>
