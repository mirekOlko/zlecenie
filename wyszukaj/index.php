<?php
//session_start();
include("../funkcje.php");
$time_start = microtime_float();
$menu=menu2();
$style=style2();

$echo='';
if(isset($_GET['masage']))
    $echo.=safe($_GET['masage']);

$echo.=' <div style="border:dotted; border-color:#00F; margin-bottom:1em;"><a href="index.php?co=fakDoOpl"><button>faktury do opłacenia</button></a>
        <a href="index.php?co=szukaj"><button>szukaj Faktury</button></a>
        <a href="index.php?co=naszeFaktury"><button>Nasze faktury</button></a>
        <a href="index.php?co=naszeFakturyWszystkie"><button>Nasze faktury Wszystkie</button></a>
		<a href="index.php?co=czyWpisaneDoSystemu"><button>sprawdź czy wpisana</button></a>
        </div>
';


if(isset($_GET['co']))
    $co=safe($_GET['co']);
else
    $co='';

    
switch($co)
{
    case 'fakDoOpl':
        include 'fakturyDoOplacenia.php';
        break;
    case 'szukaj':
        include 'szukaj.php';
        break;
    case 'naszeFaktury':
        include 'naszeFaktury.php';
        break;
    case 'naszeFakturyWszystkie':
        include 'naszeFakturyWszystkie.php';
        break;
	case 'czyWpisaneDoSystemu':
        include 'czyWpisaneDoSystemu.php';
        break;
    default:
               
}
include('../html/p.html.php');
/*
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
	    $s=mysqli_query($link,$q);
	    $zakupy=mysqli_fetch_array($s);
	    $echo.='zakupiono towary za: '.$zakupy[0].'<br>';
	    
	    $q="SELECT sum(`wartosc`) FROM `faktury` WHERE MONTH(`data_wystawienia`)=".$_POST['miesiac']." AND YEAR(`data_wystawienia`)=".$_POST['rok']." AND `id_kontr`=181";
	    $s=mysqli_query($link,$q);
	    $r=mysqli_fetch_array($s);
	    $echo.='wystawilismy faktury na: '.$r[0].'<br>';
	    $echo.='obrót: '.$zakupy[0].'-'.$r[0].'='.($zakupy[0]-$r[0]).'<br>';
	       
	    $q="SELECT `numer`,`wartosc`,`data_wystawienia` FROM `faktury` WHERE MONTH(`data_wystawienia`)=".$_POST['miesiac']." AND YEAR(`data_wystawienia`)=".$_POST['rok']." ORDER BY `data_wystawienia`;";
        $s=mysqli_query($link,$q);
       
        $echo.='<table border="1"><tr><td>numer</td><td>wartosć</td><td>data</td></tr>';
        while($r=mysqli_fetch_array($s))
	        $echo.='<tr><td>'.$r[0].'</td><td>'.$r[1].'</td><td>'.$r[2].'</td></tr>';
       
	    $echo.='</table>';
	}
	
	if(isset($_POST['zlecenia_szukaj']) && !empty($_POST['zlecenia_szukaj']) )
	{
	    $_POST['zlecenia_szukaj']=safe($_POST['zlecenia_szukaj']);

        	    $q="SELECT `nazwa` FROM `zlecenia` WHERE `id_zlec`=".$_POST['zlecenia_szukaj'].";";
        	    $s=mysqli_query($link,$q);
        	    $r=mysqli_fetch_array($s);
        	    $echo.='zlecenie  '.$r[0].'<br>';
	            
	            $q="SELECT sum(`wartosc`) FROM `faktury` WHERE `id_zlec`=".$_POST['zlecenia_szukaj']." AND `id_kontr`!=181;";
	            $s=mysqli_query($link,$q);
	            $r1=mysqli_fetch_array($s);
	            $echo.='zakupiono towary za: '.$r1[0].'<br>';
	            
	            $q="SELECT sum(`wartosc`) FROM `faktury` WHERE `id_zlec`=".$_POST['zlecenia_szukaj']." AND `id_kontr`=181;";
	            $s=mysqli_query($link,$q);
	            $r=mysqli_fetch_array($s);
	            $echo.='wystawilismy faktury na: '.$r[0].'<br>';
	            
	            $echo.='obrót: '.$r1[0].' - '.$r[0].'='.($r1[0]-$r[0]).'<br>';
	            
	            $q="SELECT `numer`,`wartosc`,`data_wystawienia` FROM `faktury` WHERE `id_zlec`=".$_POST['zlecenia_szukaj'].";";
	            $s=mysqli_query($link,$q);
	            
	            $echo.='<table border="1"><tr><td>lp</td><td>numer</td><td>wartosć</td><td>data</td></tr>';
	            $lp=1;
	            while($r=mysqli_fetch_array($s))
	            {
	                $echo.='<tr><td>'.$lp.'</td><td>'.$r[0].'</td><td>'.$r[1].'</td><td>'.$r[2].'</td></tr>';
	                $lp++;
	            }
	                
	                $echo.='</table>';
	}
	
	mysqli_close($link);

	foreach($_POST As $k=>$v)
	    echo $k."=>".$v.'<br>';
	  
	include('../html/p.html.php');
	
}
else
{
        
	$echo='<h1>analizy</h1>';
 	$echo.='<p>wyświetl wydatki w miesicu: ';
 	$echo.='<form method="post" action="index.php"><select name="miesiac">';
 
 	for($i=1;$i<sizeof($miesiace)+1;$i++)
        $echo.='<option value="'.$i.'">'.$miesiace[$i]."</option>\n";
    
    $echo.='</select><select name="rok"><option>2018</option><option>2019</option></select><input name="co" type="submit" value="pokaż miesiąc" /></form></p>';
			
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


*/

?>
