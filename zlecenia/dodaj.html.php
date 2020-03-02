<?php
//require_once('db_lista_zlecen.php')
$echo='<form id="form1" name="form1" method="post" action="dodaj.php">
<table>
<tr><td>nazwa zlecenia: </td><td> <input name="name_zlec" type="text" size="40" />  </td></tr>
<tr><td>zleceniodawca </td><td>'.$lista.'</td></tr>
<tr><td>szacowana wartość kontraktu:</td><td>  <input name="kontrakt" type="text" size="34" wrap="physical" maxlength="34" /></td></tr>
</table>
<input name="" type="submit" /><input name="" type="reset" />
</form>';

?>
