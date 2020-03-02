<?php
//require_once('../db_lista_zlecen.php')
$echo='<form id="form1" name="dane" method="post" action="dodaj_kon.php">
<table>
    <tr>
        <td>skrócona nazwa:*</td><td><input name="sknazwa1" type="text" size="34" wrap="physical" maxlength="34" /><br /> <input name="sknazwa2" type="text" size="34" wrap="physical" maxlength="34" /></td>
        </tr>

    <tr>
        <td>nazwa:*</td><td><input name="nazwa1" type="text" size="34" wrap="physical" maxlength="34" /><br /> <input name="nazwa2" type="text" size="34" wrap="physical" maxlength="34" /></td>
        </tr>
    <tr>
        <td>adres:</td><td><input name="adres1" type="text" size="34" wrap="physical" maxlength="34" /><br /><input name="adres2" type="text" size="34" wrap="physical" maxlength="34" /></td>
        </tr>
	<tr>
		<td>NIP</td><td><input name="nip" type="text" size="10" wrap="physical" maxlength="10" /></td>
        </tr>
    <tr>
        <td>numer konta:*</td><td><input name="nr_konta" type="text" size="26" wrap="physical" maxlength="26" /></td>
        </tr>
    <tr>
        <td>tytuł:</td><td><input name="tytul" type="text" size="100" wrap="physical" maxlength="100" /></td>
        </tr>
</table>
<input name="" type="submit" /><input name="" type="reset" />
</form>';

?>
