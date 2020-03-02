<?php
require_once('../db_lista_kontr.php');

$echo='<button onclick="myFunction()">nasza faktura</button><script>function myFunction() {document.getElementById("181").selected=true;document.getElementById("forma_platnosci3").selected=true;}</script>
<button onclick="myFunction1()">lista płac</button><script>function myFunction1() {document.getElementById("247").selected=true;document.getElementById("zlec47").selected=true;document.getElementById("forma_platnosci3").selected=true;}</script>';

$echo.='<form id="form1" name="form1" method="post" action="dodaj_faktu.php">
<table border="1">
<tr><td>Numer faktury </td>
    <td> <input name="numer_faktury" type="text" size="34" wrap="physical" maxlength="34" />  </td></tr>
<tr><td>data wystawienia </td>
    <td> <input id="data_wystawienia" name="data_wystawienia" type="text" size="34" wrap="physical" maxlength="34" onchange="datagora()" />  </td></tr>
<tr><td>ilość dni na płatności: </td>
    <td> 
	<input id="ile_dni" name="ile_dni" type="text" onchange="datagora()" value="30" />

    </td></tr>

<tr><td>data płatnosci </td>
    <td><input id="data_zaplaty_faktury" name="data_zaplaty_faktury" type="text" onchange="datadol()" />
    </td></tr>
<tr><td>wystawca faktury:</td>
    <td>
	<select id="wystawca_faktury" name="wystawca_faktury">
	';
	for($i=0;$i<sizeof($baza);$i++)
{
		$echo.='<option id="'.$baza[$i][0].'" value="'.$baza[$i][0].'">'.$baza[$i][1].' </option>';	
}
	$echo.='</select>
	</td></tr>

<tr><td>numer zlecenia:</td>
    <td>
	<select name="numer_zlecenia">0
	';
	require_once('../db_lista_zlecen.php');
	for($i=0;$i<sizeof($baza);$i++)
{
		$echo.='<option id="zlec'.$baza[$i][0].'" value="'.$baza[$i][0].'">'.$baza[$i][1].' </option>';	
}
	$echo.='</select></td></tr>
<tr><td>wartość faktury: </td>
    <td><input name="wartosc_faktury" type="text" size="34" wrap="physical" maxlength="34" /> 
	</td></tr>
<tr><td>w tym VAT: </td>
    <td><input name="wartosc_VAT" type="text" size="34" wrap="physical" maxlength="34" /> 
	</td></tr>

<tr><td>forma płatności: </td>
    <td>
	<select name="forma_platnosci" onchange="formaPlatloscik()">';
	$formaplat=array('','gotówka','karta','przelew','marek');
	for($i=1;$i<sizeof($formaplat);$i++)
		$echo.='<option id="forma_platnosci'.$i.'" value="'.$i.'">'.$formaplat[$i].' </option>';

	$echo.='</select>
	</td></tr>

<tr><td>czy zapłacona:</td>
    <td>
	<select name="zaplacona">
	<option id="zaplaconaNie" value="0">NIE</option>
	<option id="zaplaconaTak" value="1">TAK</option>
	</select>
	</td></tr>';
	
$echo.='
<tr><td></td>
    <td>
<input name="submit" type="submit" value="dodaj fakturę"/></td></tr></table>
</form>';

?>
