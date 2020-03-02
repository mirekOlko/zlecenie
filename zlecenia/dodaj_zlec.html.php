<?php
require_once('../db_lista_kontr.php');
$echo='<h1>Zlecenia</h1>';
$echo.='<form id="form1" name="form1" method="post" action="dodaj_zlec.php">

nazwa zlecenia:  <input name="name_zlec" type="text" size="34" wrap="physical" maxlength="34" />  
<p>zleceniodawca: </p>
<table border="1"><tr>';
$echo.='<td><input type="radio" name="kontrahent" value="'.$baza[0][0].'" checked="checked"/>'.$baza[0][1].'</td>';
for($i=1;$i<sizeof($baza);$i++)
{
	if($i%3==0)
		$echo.="</tr> \n <tr>";
	
$echo.='<td><input type="radio" name="kontrahent" value="'.$baza[$i][0].'" />'.$baza[$i][1].'</td>';
}

$echo.='
</tr>
</table>
szacowana wartość kontraktu:  <input name="wrtosc_zlecenia" type="text" size="34" wrap="physical" maxlength="34" /><br><br>
<input name="" type="submit" /><input name="" type="reset" />
</form>';

?>
