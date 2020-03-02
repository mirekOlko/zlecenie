<?php
//session_start();
include("../funkcje.php");
$time_start = microtime_float();
$menu=menu2();
$style=style2();
$miesiace=Array(1 => 'styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');
//echo 'działa';
/*
if(!isset($_SESSION['sprawdz']))
{
	include('../html/logowanie.html');
	exit();
}

//wylogowanie urzytkownika
if(isset($_POST['logout'])){
	session_destroy();
	include('../html/logowanie.html');
	exit();
	}
*/
	
if(isset($_POST['co']))
{
	$link=connect();
	$echo='';
	if(isset($_POST['miesiac']) && !empty($_POST['miesiac']) && isset($_POST['rok']) && !empty($_POST['rok']))
	{
	    if(safe($_POST['miesiac'])>0 && safe($_POST['miesiac'])<13)
	       $_POST['miesiac']=safe($_POST['miesiac']);
	    else
	       $_POST['miesiac']=1;
	    
	    $_POST['rok']=safe($_POST['rok']);
	    
	    $echo.='lista faktur w miesiącu '.$miesiace[$_POST['miesiac']].'<br>';
	  

	    $q="SELECT sum(`wartosc`) FROM `faktury` WHERE MONTH(`data_wystawienia`)=".$_POST['miesiac']." AND YEAR(`data_wystawienia`)=".$_POST['rok']." AND `id_kontr`!=181";
	    if(!$s=mysqli_query($link,$q))
	        db_error($link, $q);
	    $r=mysqli_fetch_array($s);
	    if(empty($r[0]))
	        $fakturyZakupowe=0;
	        else 
	            $fakturyZakupowe=$r[0];
	        
        $q="SELECT sum(`VAT`) FROM `faktury` WHERE MONTH(`data_wystawienia`)=".$_POST['miesiac']." AND YEAR(`data_wystawienia`)=".$_POST['rok']." AND `id_kontr`!=181";
        if(!$s=mysqli_query($link,$q))
            db_error($link, $q);
            $r=mysqli_fetch_array($s);
            if(empty($r[0]))
                $fakturyZakupoweVAT=0;
                else
                    $fakturyZakupoweVAT=$r[0];
	        
	  
	    $q="SELECT sum(`wartosc`) FROM `faktury` WHERE MONTH(`data_wystawienia`)=".$_POST['miesiac']." AND YEAR(`data_wystawienia`)=".$_POST['rok']." AND `id_kontr`=181";
	    if(!$s=mysqli_query($link,$q))
	        db_error($link, $q);
	    $r=mysqli_fetch_array($s);
	    if(empty($r[0]))
	       $fakturyWystawione=0.00;
    	    else
    	        $fakturyWystawione=$r[0];
    	    
        $q="SELECT sum(`VAT`) FROM `faktury` WHERE MONTH(`data_wystawienia`)=".$_POST['miesiac']." AND YEAR(`data_wystawienia`)=".$_POST['rok']." AND `id_kontr`=181";
        if(!$s=mysqli_query($link,$q))
            db_error($link, $q);
            $r=mysqli_fetch_array($s);
            if(empty($r[0]))
                $fakturyWystawioneVAT=0.00;
                else
                    $fakturyWystawioneVAT=$r[0];
	    
	  //  $echo.='Faktury Zakupowe (ja pace): '.$fakturyZakupowe.'<br>';
	  //  $echo.='wystawilismy faktury na: '.$fakturyWystawione.'<br>';
	  //  $echo.='zysk: '.$fakturyWystawione.'-'.$fakturyZakupowe.'='.($fakturyWystawione-$fakturyZakupowe).'<br>';
	    
	    $echo.='Faktury Zakupowe (ja pace): '.printStringWithSpace($fakturyZakupowe,3).'<br>';
	    $echo.='wystawilismy faktury na: '.printStringWithSpace($fakturyWystawione,3).'<br>';
	    $echo.='zysk: '.printStringWithSpace($fakturyWystawione,3).'-'.printStringWithSpace($fakturyZakupowe,3).'='.printStringWithSpace(($fakturyWystawione-$fakturyZakupowe),3).'<br>';
	    
	    $echo.='<br><br>Bilans VAT:<br>';
	    $echo.='VAT z Faktury Zakupowe: '.printStringWithSpace($fakturyZakupoweVAT,3).'<br>';
	    $echo.='VAT na wystawionych fakturach: '.printStringWithSpace($fakturyWystawioneVAT,3).'<br>';
	    $echo.='Różnica VAT: '.printStringWithSpace($fakturyWystawioneVAT,3).'-'.printStringWithSpace($fakturyZakupoweVAT,3).'='.printStringWithSpace(($fakturyWystawioneVAT-$fakturyZakupoweVAT),3).'<br>';
                
	    
	    
	    $echo.='<table><tr><td style="vertical-align:top">kosztowe<br>';
	    
	    $q="SELECT `numer`,`wartosc`,`data_wystawienia` FROM `faktury` WHERE MONTH(`data_wystawienia`)=".$_POST['miesiac']." AND YEAR(`data_wystawienia`)=".$_POST['rok']." AND `id_kontr`!=181 ORDER BY `data_wystawienia`;";
	    $temp=db_tableGen($link, $q);
        
        $echo.=$temp.'</td><td style="vertical-align:top">wystawione<br>';
        
        $q="SELECT `numer`,`wartosc`,`data_wystawienia` FROM `faktury` WHERE MONTH(`data_wystawienia`)=".$_POST['miesiac']." AND YEAR(`data_wystawienia`)=".$_POST['rok']." AND `id_kontr`=181 ORDER BY `data_wystawienia`;";
        $temp=db_tableGen($link, $q);
            
        $echo.=$temp.'</td></tr></table>';
	}
	
	if(isset($_POST['zlecenia_szukaj']) && !empty($_POST['zlecenia_szukaj']) )
	{
	    $_POST['zlecenia_szukaj']=safe($_POST['zlecenia_szukaj']);
	    
	    $q="SELECT `nazwa` FROM `zlecenia` WHERE `id_zlec`=".$_POST['zlecenia_szukaj'].";";
	    $s=mysqli_query($link,$q);
	    $r=mysqli_fetch_array($s);
	    $echo.='zlecenie  '.$r[0].'<br>';
	    
	    $q="SELECT sum(`wartosc`) FROM `faktury` WHERE `id_zlec`=".$_POST['zlecenia_szukaj']." AND `id_kontr`!=181;";
	    if(!$s=mysqli_query($link,$q))
	        db_error($link, $q);
	        $r=mysqli_fetch_array($s);
	        if(empty($r[0]))
	            $fakturyZakupowe=0.00;
	            else
	                $fakturyZakupowe=$r[0];
	            
        $q="SELECT sum(`VAT`) FROM `faktury` WHERE `id_zlec`=".$_POST['zlecenia_szukaj']." AND `id_kontr`!=181;";
        if(!$s=mysqli_query($link,$q))
            db_error($link, $q);
            $r=mysqli_fetch_array($s);
            if(empty($r[0]))
                $fakturyZakupoweVAT=0.00;
                else
                    $fakturyZakupoweVAT=$r[0];
	    
	    $q="SELECT sum(`wartosc`) FROM `faktury` WHERE `id_zlec`=".$_POST['zlecenia_szukaj']." AND `id_kontr`=181;";
	    if(!$s=mysqli_query($link,$q))
	        db_error($link, $q);
	        $r=mysqli_fetch_array($s);
	        if(empty($r[0]))
	            $fakturyWystawione=0.00;
	            else
	                $fakturyWystawione=$r[0];
        
        $q="SELECT sum(`VAT`) FROM `faktury` WHERE `id_zlec`=".$_POST['zlecenia_szukaj']." AND `id_kontr`=181;";
        if(!$s=mysqli_query($link,$q))
            db_error($link, $q);
            $r=mysqli_fetch_array($s);
            if(empty($r[0]))
                $fakturyWystawioneVAT=0.00;
                else
                    $fakturyWystawioneVAT=$r[0];
	                
        $echo.='Faktury Zakupowe (ja pace): '.printStringWithSpace($fakturyZakupowe,3).'<br>';
        $echo.='wystawilismy faktury na: '.printStringWithSpace($fakturyWystawione,3).'<br>';
        $echo.='zysk: '.printStringWithSpace($fakturyWystawione,3).'-'.printStringWithSpace($fakturyZakupowe,3).'='.printStringWithSpace(($fakturyWystawione-$fakturyZakupowe),3).'<br>';
        
        $echo.='<br><br>Bilans VAT:<br>';
        $echo.='VAT z Faktury Zakupowe: '.printStringWithSpace($fakturyZakupoweVAT,3).'<br>';
        $echo.='VAT na wystawionych fakturach: '.printStringWithSpace($fakturyWystawioneVAT,3).'<br>';
        $echo.='Różnica VAT: '.printStringWithSpace($fakturyWystawioneVAT,3).'-'.printStringWithSpace($fakturyZakupoweVAT,3).'='.printStringWithSpace(($fakturyWystawioneVAT-$fakturyZakupoweVAT),3).'<br>';
        
	   

	    $echo.='<table><tr><td style="vertical-align:top">kosztowe<br>';
	    
	    //$q="SELECT `numer`,`wartosc`,`data_wystawienia` FROM `faktury` WHERE MONTH(`data_wystawienia`)=".$_POST['miesiac']." AND YEAR(`data_wystawienia`)=".$_POST['rok']." AND `id_kontr`!=181 ORDER BY `data_wystawienia`;";
	    $q="SELECT `numer`,`wartosc`,`data_wystawienia` FROM `faktury` WHERE `id_zlec`=".$_POST['zlecenia_szukaj']." AND `id_kontr`!=181;";
        $temp=db_tableGen($link, $q); // 
	        
	    $echo.=$temp.'</td><td style="vertical-align:top">wystawione<br>';
	        
	        //$q="SELECT `numer`,`wartosc`,`data_wystawienia` FROM `faktury` WHERE MONTH(`data_wystawienia`)=".$_POST['miesiac']." AND YEAR(`data_wystawienia`)=".$_POST['rok']." AND `id_kontr`=181 ORDER BY `data_wystawienia`;";
        $q="SELECT `numer`,`wartosc`,`data_wystawienia` FROM `faktury` WHERE `id_zlec`=".$_POST['zlecenia_szukaj']." AND `id_kontr`=181;";
        $temp=db_tableGen($link, $q);
            
        $echo.=$temp.'</td></tr></table>';
	    
	   
	}
	
	mysqli_close($link);
	/*
	foreach($_POST As $k=>$v)
	    echo $k."=>".$v.'<br>';
	    */
	include('../html/p.html.php');
	
}
else
{
        
	$echo='<h1>analizy</h1>';
 	$echo.='<p>wyświetl wydatki w miesicu: ';
 	$echo.='<form method="post" action="index.php"><select name="miesiac">';
 	$rok_aktualny=date("Y");
 	$miesiac_aktualny=date("m");
 
 	for($i=1;$i<sizeof($miesiace)+1;$i++)
 	    if($i==$miesiac_aktualny)
            $echo.='<option value="'.$i.'" selected>'.$miesiace[$i]."</option>\n";
 	    else 
 	        $echo.='<option value="'.$i.'">'.$miesiace[$i]."</option>\n";
    
    $echo.='</select><select name="rok">';
    for($i=2016;$i<2025;$i++)
        if($i==$rok_aktualny)
            $echo.='<option selected>'.$i."</option>\n";
            else
                $echo.='<option>'.$i."</option>\n";
            
    $echo.='</select><input name="co" type="submit" value="pokaż miesiąc" /></form></p><br>';
			
    $echo.='<p>wyświetl wartości zleceń: ';
    $echo.='<form method="post" action="index.php"><select name="zlecenia_szukaj">';
    
    $link=connect();
    $q='SELECT `id_zlec`,`nazwa` FROM `zlecenia`;';
    $s=mysqli_query($link,$q);
    mysqli_close($link);
    
    while($r=mysqli_fetch_array($s))
        $echo.='<option value="'.$r[0].'">'.$r[1]."</option>\n";
    
    $echo.='</select><input name="co" type="submit" value="wybierz zlecenia" /></form></p>';
	
		
	include('../html/p.html.php');
			
}




?>
