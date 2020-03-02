<?php
//session_start();
include('../funkcje.php');
$time_start = microtime_float();
$menu=menu2();
$style=style2();

if(isset($_POST['id']) )
{
	if(isset($_POST['STEP2']))
	{
	    $echo='';
	    $_POST['id']=safe($_POST['id']);
	    $link=connect();
	    $q="SELECT `faktury`.`id_faktury`, `faktury`.`data_wystawienia`, `faktury`.`numer`, `faktury`.`wartosc`, `kontrachenci`.`nazwa`, `forma_platnosci`.`nazwa`
                FROM `faktury` INNER JOIN `kontrachenci` ON `faktury`.`id_kontr`=`kontrachenci`.`id_kontr`
                               INNER JOIN `forma_platnosci` ON `faktury`.`id_forma_platnosci`=`forma_platnosci`.`id_forma_platnosci`
                WHERE `faktury`.`id_faktury`=".$_POST['id'].".;";
	    $s=mysqli_query($link,$q);
	    //$r=mysqli_fetch_array($s);
	    $echo.='<table border="1">
<tr><td>ID</td><td>data wystawienia</td><td>nazwa</td><td>wartosć</td><td>wystawca</td><td>sposób płatosci</td></tr>';
	
	    while($r=mysqli_fetch_array($s))
	    {
	        $echo.='<tr>';
	        for($i=0;$i<6;$i++)
	        {
	            $echo.='<td>'.$r[$i].'</td>'."\n";
	        }

	        $echo.="</tr>\n";
	    }
	    mysqli_close($link);
	    $echo.='</table>';
	    
	    $echo.='<form action="usun_fakture.php" method="post" enctype="application/x-www-form-urlencoded">
                Czy chcesz usunąć fakturę?
                <input name="id"      type="hidden" value="'.$_POST['id'].'" />
                <input name="confirm" type="submit" value="Tak" />
                <input name="confirm" type="submit" value="Nie" />
                </form>';
	    include('../html/p.html.php');
	    
	}
	elseif (isset($_POST['confirm']) && $_POST['confirm']=='Tak')
        {
    	$link=connect();
    	$id=safe($_POST['id']);
    	
    	//$q='DELETE FROM `zlecenia` WHERE `zlecenia`.`id_zlec` = '.$k;
    	$q="SELECT `id_kontr`,`id_forma_platnosci` FROM `faktury` WHERE `id_faktury` =$id;";
    	if(!$s=mysqli_query($link,$q))
    	    db_error($link,$q);
    	
    	$r=mysqli_fetch_array($s);
    	
    	$q="UPDATE `kontrachenci` SET `ilosc` = ilosc - 1 WHERE `kontrachenci`.`id_kontr` = $r[0];";
    	if(!mysqli_query($link,$q))
    	    db_error($link,$q);
    	
    
        if($r[1]==4)
        {
        $q="DELETE FROM `marek` WHERE `id_faktury`=$id;";
        if(!mysqli_query($link,$q))
            db_error($link,$q);
        }
    
    		
    	$q="DELETE FROM `faktury` WHERE `id_faktury` =$id;";
    	if(!mysqli_query($link,$q))
    	    db_error($link,$q);
    		
    	mysqli_close($link);
    	
    	if($bl=='')
    		header('Location: index.php?masage=usunięto '.$id); 
    	else 
    		echo $bl;
        }
    else
        header('Location: index.php?masage=zaniechano zmian');
	
}

	
?>
