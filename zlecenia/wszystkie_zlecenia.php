<?php
	$time_start = microtime_float();
	$echo='<h1>Wszystkie zlecenia</h1>';
	$echo.='<p><a href="index.php?co=dodaj">dodaj nowe zlecenie</a><br><a href="index.php?co=all">wszystkie zlecenia</a></p>';
			
	//require_once('../db_lista_zlecen.php');
	$echo.='<table border="1" cell><tr>
			<td>LP</td>
			<td>nazwa zlecenia</td>
			<td>zlecił</td>
			<td>czy aktywne</td>';
	
		if(!$link=connect())
	{
		echo 'błąd połaczenie';
		exit;
	}
	//require_once('../db_lista_kontr.php');
	
	//$id=safe($_POST['id']);
	
	//$q='SELECT * FROM `zlecenia` WHERE `zlecenia`.`id_zlec` = 0;';
	$q='SELECT `zlecenia`.`id_zlec`,`zlecenia`.`nazwa`, `kontrachenci`.`nazwa` ,`zlecenia`.`czy_zamkniete`, `zlecenia`.`wrtosc_zlecenia` FROM `zlecenia` LEFT OUTER JOIN `kontrachenci` ON `zlecenia`.`id_kontr`=`kontrachenci`.`id_kontr` ORDER BY `zlecenia`.`id_zlec`;';
	//$q='SELECT `zlecenia`.`id_zlec`,`zlecenia`.`nazwa`, `kontrachenci`.`nazwa` ,`zlecenia`.`czy_zamkniete` FROM `zlecenia`, `kontrachenci`';
	if(!$s=mysqli_query($link,$q))
	    db_error($link,$q);
		
	//for($i=0;$i<sizeof($baza);$i++)
		$i=1;
	while($r=mysqli_fetch_array($s))
	{
		$echo.='<tr><td>'.$i.'</td>';
		//for($j=1;$j<sizeof($baza[$i]);$j++)
			$echo.='<td>'.$r[0].'</td>';
		$echo.='<td>'.$r[1].'</td>';
		$echo.='<td>'.$r[2].'</td>';
		if($r[3]==0)
			$echo.='<td>NIE</td>';
		else
			$echo.='<td>TAK</td>';
		$echo.='<td>'.$r[4].'</td>';
		//$echo.='<td><form name="usn" method="post" action="usun_zlec.php"><input name="id" type="hidden" value="'.$baza[$i][0].'" /><input name="usun_'.$baza[$i][0].'" type="submit" value="usun" /></form></td>';
		$echo.='<td><form name="edit" method="post" action="edit_zlec.php"><input name="id" type="hidden" value="'.$r[0].'" /><input name="edit" type="submit" value="edit" /></form></td>';
		$echo.="</tr>\n";
		$i++;
	}
		
	$echo.='</table>';
	
?>
