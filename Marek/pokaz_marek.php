<?php
//session_start();
include_once ('../funkcje.php');
$menu=menu2();
$style=style2();

$echo='<h1>Faktury Marek, 20 ostatnich</h1>';
$echo.='<table border="1">';

$link=connect();
$q="SELECT * FROM `marek` ORDER BY `id_marek` DESC LIMIT 20";
$s=mysqli_query($link,$q);
//$r=mysqli_fetch_array($s);
while($result=mysqli_fetch_array($s))
{
    $echo.='<tr><td>'.$result[0].'</td>';
    
    if($result[1]==null){
        $echo.='<td>pieniedze '.$result[2].'</td><td>'.(-$result[3]).'</td>';
        $echo.='<td><form name="edit" method="post" action="edycja_marek.php"><input name="id" type="hidden" value="'.$result[0].'" /><input name="edit" type="submit" value="edit" /></form></td>'."\n";
        $echo.='<td><form id="usn_'.$result[0].'" name="usn_'.$result[0].'" method="post" action="usun_marek.php"><input name="id" type="hidden" value="'.$result[0].'" /><input name="pieniadze" type="hidden" value="true" /><button onclick="usunFakture('."'usn_$result[0]', '$result[2]'".')">usun</button></form></td>';
        
    }
    else{
        $q="SELECT `numer` FROM `faktury` WHERE `id_faktury`=$result[1]";
        $sw=mysqli_query($link,$q);
        $re=mysqli_fetch_array($sw);
        $echo.='<td>'.$re[0].'</td><td>'.$result[3].'</td>';
        $echo.='<td><form name="edit" method="post" action="./faktury/edit_fakture.php"><input name="id" type="hidden" value="'.$result[1].'" /><input name="edit" type="submit" value="edit" /></form></td>'."\n";
        $echo.='<td><form id="usn_'.$result[0].'" name="usn_'.$result[0].'" method="post" action="usun_marek.php"><input name="id" type="hidden" value="'.$result[0].'" /><button onclick="usunFakture('."'usn_$result[0]', '$result[2]'".')">usun</button></form></td>';
        
    }
    
   $echo.="</tr>\n";
}
mysqli_close($link);
$echo.='</table>';

include('../html/p.html.php');

?>
