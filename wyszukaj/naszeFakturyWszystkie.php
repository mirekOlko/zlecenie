<?php 
require_once("../funkcje.php");
if(!isset($echo))
    $echo='';
$miesiace=Array(1 => 'styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');

if(isset($_POST['formnaszefak']))
{
    $_POST['rok']=safe($_POST['rok']);
    if(is_int((integer)$_POST['rok']))
        $rok=$_POST['rok'];
}
else {
    $rok=gmdate("Y");
}
    


$echo.='<h1>Nasze faktury na rok: '.$rok.'</h1>';
$echo.='<form method="POST" action="index.php?co=naszeFakturyWszystkie">';
$echo.='</select><select name="rok">';
for($i=2017;$i<2022;$i++)
    if($i==$rok)
        $echo.='<option selected="selected">'.$i.'</option>';
    else 
        $echo.='<option>'.$i.'</option>';
        
$echo.='</select><input name="formnaszefak" type="submit" value="pokaż rok" /></form></p>';
    
//echo '<br>przed bazą '.$mies.' '.$rok;
$link=connect();
$q="SELECT sum(`wartosc`) FROM `faktury` WHERE YEAR(`data_wystawienia`)=".$rok." AND `id_kontr`=181";
$s=mysqli_query($link,$q);
$zakupy=mysqli_fetch_array($s);
$echo.='wystawiono faktury na: '.$zakupy[0].'<br>';

$echo.='<table border="1">
    <tr><td>data wystawienia</td><td>nazwa</td><td>wartosć</td><td>sposób płatosci</td><td>zapłacona</td><td>edytuj</td></tr>';


$q="SELECT `faktury`.`id_faktury`, `faktury`.`data_wystawienia`, `faktury`.`numer`,`faktury`.`wartosc`, `zlecenia`.`nazwa`
                FROM `faktury`
                       LEFT OUTER JOIN `zlecenia`
                            ON `faktury`.`id_zlec`=`zlecenia`.`nazwa`
                WHERE YEAR(`faktury`.`data_wystawienia`)=".$rok." AND `faktury`.`id_kontr`=181
                ORDER BY `faktury`.`numer`  ASC;";

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