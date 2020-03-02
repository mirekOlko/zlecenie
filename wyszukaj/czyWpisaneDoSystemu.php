<?php //szukaj.php
include_once("../funkcje.php");
$time_start = microtime_float();
$menu=menu2();
$style=style2();

$echo.='
		<p>
		Proszę wpisać numery faktur po przecinku.
		</p>
		<form name="edit" method="post" action="index.php?co=czyWpisaneDoSystemu">
		<textarea name="nazwa" type="text" rows="4" cols="50"></textarea>  
        <input name="test" value="test" type="hidden" />
        <input name="wyslij" type="submit" value="szukaj"/> 
        </form>';

$script=scriptJS('data');
$script.=scriptJS('dataOd');
$script.=scriptJS('dataDo');
/*
 * SELECT `faktury`.`id_faktury`, `faktury`.`data_wystawienia`, `faktury`.`numer`,`faktury`.`wartosc`, `kontrachenci`.`nazwa`, `forma_platnosci`.`nazwa`
 FROM `faktury` INNER JOIN `kontrachenci`
 ON `faktury`.`id_kontr`=`kontrachenci`.`id_kontr`
 INNER JOIN `forma_platnosci`
 on `faktury`.`id_forma_platnosci`=`forma_platnosci`.`id_forma_platnosci`
 WHERE (`faktury`.`zaplacona` IS NULL OR `faktury`.`zaplacona`=0)
 AND `faktury`.`id_kontr`!=181
 ORDER BY `faktury`.`data_wystawienia`  ASC
 */
if(isset($_POST['test']))
{
    $echo.='<table border="1">
        <tr><td>data wystawienia</td><td>nazwa</td><td>wartosć</td><td>wystawca</td><td>sposób płatosci</td><td>edycja</td><td>usuwanie</td></tr>';
    
    $link=connect();
       
	$_POST['nazwa']=safe($_POST['nazwa']);
	$arary=explode(",",$_POST['nazwa']);
	for($kkko=0;$kkko<sizeof($arary);$kkko++)
	{
		$nazwa=trim($arary[$kkko]);
		$q="SELECT `faktury`.`id_faktury`, `faktury`.`data_wystawienia`, `faktury`.`numer`,`faktury`.`wartosc`, `kontrachenci`.`nazwa`, `forma_platnosci`.`nazwa`
					FROM `faktury` INNER JOIN `kontrachenci` ON `faktury`.`id_kontr`=`kontrachenci`.`id_kontr`
								   INNER JOIN `forma_platnosci` ON `faktury`.`id_forma_platnosci`=`forma_platnosci`.`id_forma_platnosci`
					WHERE `numer` LIKE '%".$nazwa."%'";

		 
			
		$s=mysqli_query($link,$q);
		//$r=mysqli_fetch_array($s);
		if(mysqli_num_rows($s)==0)
			$echo.='<tr><td>'.$nazwa.'</td><td>brak w bazie<td></tr>';
		else    
			while($r=mysqli_fetch_array($s))
			{
				$echo.='<tr>';
				for($i=1;$i<6;$i++)
				{
					$echo.='<td>'.$r[$i].'</td>'."\n";
				}
				
				$echo.='<td><form name="edit" method="post" action="../faktury/edit_fakture.php"><input name="id" type="hidden" value="'.$r[0].'" /><input name="edit" type="submit" value="edit" /></form></td>'."\n";
				$echo.='<td><form id="usn_'.$r[0].'" name="usn_'.$r[0].'" method="post" action="usun_fakture.php"><input name="id" type="hidden" value="'.$r[0].'" /><button onclick="usunFakture('."'usn_$r[0]', '$r[2]'".')">usun</button></form></td>';
				$echo.="</tr>\n";
			}
	}
    mysqli_close($link);
    $echo.='</table>';
}

?>