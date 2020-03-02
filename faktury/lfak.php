<?php
//session_start();
include('../funkcje.php');
$menu=menu2();
$style=style2();

//$numer_faktury$data_wystawienia$data_zaplaty_fakturydata_zapłacenia$wystawca_faktury$numer_zlecenia$wartosc_faktury$forma_platnosci$zaplacona
$dane=array();
include 'lfakData.php';






for($i=0;$i<sizeof($dane);$i++)
{
	$link=connect();
	//echo 'wartoktury:'.$wartosc_faktury.' '.$_POST['wartosc_faktury'];
	$temp=explode("###",$dane[$i]);
	//$q="INSERT INTO `faktury` (`id_faktury`,`numer`,`data_wystawienia`,`data_platnosci`,`data_zaplacenia`,`id_kontr`,`id_zlec`,`wartosc`,`id_forma_platnosci`,`zaplacona`
//) 
	//                        INSERT INTO `faktury` '$temp[0]', '$data_wystawienia','$data_zaplaty_faktury', '$wystawca_faktury', '$numer_zlecenia', '$wartosc_faktury', '$forma_platnosci','$zaplacona');";
	//id_faktury	numer	data_wystawienia	data_platnosci	data_zaplacenia	id_kontr	id_zlec	wartosc	id_forma_platnosci	zaplacona
	
    $q="INSERT INTO `faktury` (`id_faktury`, `numer`, `data_wystawienia`, `data_platnosci`, `data_zaplacenia`, `id_kontr`, `id_zlec`, `wartosc`, `id_forma_platnosci`, `zaplacona`) VALUES ( NULL, ";
        for($j=0;$j<sizeof($temp);$j++)
            if(!empty($temp[$j]))
                 $q.="'".$temp[$j]."',";
            else {
                $q.="NULL,";;
            }
        
    $q[strlen($q)-1]=" ";
    $q.=");";
            
	   
	$bl='';
	if(!mysqli_query($link,$q)){
		$bl.= "<br>błąd zapytania<br>".$q.'<br>';
		$bl.= "Debugging errno: " . mysqli_errno($link).'<br>';
		$bl.= "Debugging error: " . mysqli_error($link).'<br>';
		}

	
	$q="UPDATE `kontrachenci` SET `ilosc` = ilosc + 1 WHERE `kontrachenci`.`id_kontr` = $temp[4];";
	if(!mysqli_query($link,$q)){
	    $bl.= "<br>błąd zapytania<br>".$q.'<br>';
	    $bl.= "Debugging errno: " . mysqli_errno($link).'<br>';
	    $bl.= "Debugging error: " . mysqli_error($link).'<br>';
	}
	mysqli_close($link);

	
	if($bl=='')
	    echo $i.' działa<br>';
	else 
		echo $bl;

}
	//header('Location: index.php'); 
?>
