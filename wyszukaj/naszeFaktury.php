<?php 
require_once("../funkcje.php");
if(!isset($echo))
    $echo='';
$miesiace=Array(1 => 'styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');



//$mies=gmdate("n");
//$rok=gmdate("Y");
if(isset($_POST['formnaszefak']))
{
    $_POST['miesiac']=safe($_POST['miesiac']);
    if(is_int((integer)$_POST['miesiac']))
        $mies=$_POST['miesiac'];
    //else 
    //    $mies=gmdate("n");

    $_POST['rok']=safe($_POST['rok']);
    if(is_int((integer)$_POST['rok']))
        $rok=$_POST['rok'];
   // else
   //     $rok=gmdate("Y");
    
    //echo 'form '.$mies.' '.$rok;
    
}
else {
    $mies=gmdate("n");
    $rok=gmdate("Y");
    
    //echo 'else '.$mies.' '.$rok;
}
    
    /*
if(isset($_POST['miesiac']))
{
    $_POST['miesiac']=safe($_POST['miesiac']);
    if(is_int($_POST['miesiac']))
        $mies=$_POST['miesiac'];
        //echo $mies.' '.$rok;
}

if(isset($_POST['rok']))
{
    $_POST['rok']=safe($_POST['rok']);
    if(is_int($_POST['rok']))
        $rok=$_POST['rok'];
        //echo $mies.' '.$rok;
}
*/
//echo $mies.' '.$rok;

$echo.='<h1>Nasze faktury: '.$miesiace[$mies].' '.$rok.'</h1>';
$echo.='<form method="POST" action="index.php?co=naszeFaktury"><select name="miesiac">';
for($i=1;$i<sizeof($miesiace)+1;$i++)
    if($i==$mies)
        $echo.='<option value="'.$i.'" selected="selected">'.$miesiace[$i]."</option>\n";
    else
        $echo.='<option value="'.$i.'">'.$miesiace[$i]."</option>\n";

$echo.='</select><select name="rok">';
for($i=2017;$i<2022;$i++)
    if($i==$rok)
        $echo.='<option selected="selected">'.$i.'</option>';
    else 
        $echo.='<option>'.$i.'</option>';
        
$echo.='</select><input name="formnaszefak" type="submit" value="pokaż miesiąc" /></form></p>';
    
//echo '<br>przed bazą '.$mies.' '.$rok;
$link=connect();
$q="SELECT sum(`wartosc`) FROM `faktury` WHERE MONTH(`data_wystawienia`)=".$mies." AND YEAR(`data_wystawienia`)=".$rok." AND `id_kontr`=181";
$s=mysqli_query($link,$q);
$zakupy=mysqli_fetch_array($s);
$echo.='wystawiono faktury na: '.$zakupy[0].'<br>';

$echo.='<table border="1">
    <tr><td>data wystawienia</td><td>nazwa</td><td>wartosć</td><td>sposób płatosci</td><td>zapłacona</td><td>edytuj</td></tr>';


$q="SELECT `faktury`.`id_faktury`, `faktury`.`data_wystawienia`, `faktury`.`numer`,`faktury`.`wartosc`, `forma_platnosci`.`nazwa`
                FROM `faktury`
                               INNER JOIN `forma_platnosci`     
                                    ON `faktury`.`id_forma_platnosci`=`forma_platnosci`.`id_forma_platnosci`
                WHERE MONTH(`data_wystawienia`)=".$mies." 
                    AND YEAR(`data_wystawienia`)=".$rok." AND `id_kontr`=181
                ORDER BY `faktury`.`data_wystawienia`  ASC;";

if(!$s=mysqli_query($link,$q))
    db_error($link,$q);
//$r=mysqli_fetch_array($s);
while($r=mysqli_fetch_array($s))
{
    $echo.='<tr>';
    for($i=1;$i<5;$i++)
    {
        $echo.='<td>'.$r[$i].'</td>'."\n";
    }
    
    $echo.='<td><form name="edit" method="post" action="../faktury/edit_fakture.php"><input name="id" type="hidden" value="'.$r[0].'" /><input name="edit" type="submit" value="edit" /></form></td>'."\n";
    $echo.="</tr>\n";
}
mysqli_close($link);
$echo.='</table>';


?>