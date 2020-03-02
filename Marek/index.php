<?php // .marek/index

/*
 * if(isset($_GET['co']))
{
	$s=safe($_GET['co']);
	switch($s)
	{
		case 'dodaj':
			include('dodaj_fakture.html.php');
			include('../html/p.html.php');
		break;
		case 'usun':
			include('usun_kon.php');
		break;
		case 'edit':
			include('edit_kon.php');
		break;

	}
}
else
{
    $echo='';
    
    if(isset($_REQUEST['masage']))
        $echo.='<p class="red">Info: '.safe($_REQUEST['masage']).'</p>';
    
	$echo.='<p><a href="index.php?co=dodaj">dodaj nową fakturę</a></p>';
			
	//require_once('../db_lista_zlecen.php');
	$echo.='<table border="1">';
	
	$link=connect();
	$q="SELECT `id_faktury`,`data_wystawienia`,`numer`,`wartosc`, `nazwa` FROM `faktury`,`kontrachenci` WHERE  `faktury`.`id_kontr`=`kontrachenci`.`id_kontr` ORDER BY id_faktury DESC LIMIT 10";
	$s=mysqli_query($link,$q);
	//$r=mysqli_fetch_array($s);
	while($r=mysqli_fetch_array($s))
	{
		$echo.='<tr>';
	for($i=1;$i<5;$i++)
	{
	    $echo.='<td>'.$r[$i].'</td>'."\n";
	}
	$echo.='<td><form name="edit" method="post" action="edit_fakture.php"><input name="id" type="hidden" value="'.$r[0].'" /><input name="edit" type="submit" value="edit" /></form></td>'."\n";
	$echo.='<td><form id="usn_'.$r[0].'" name="usn_'.$r[0].'" method="post" action="usun_fakture.php"><input name="id" type="hidden" value="'.$r[0].'" /><button onclick="usunFakture('."'usn_$r[0]', '$r[2]'".')">usun</button></form></td>';
	$echo.="</tr>\n";
	}
	mysqli_close($link);	
	$echo.='</table>';
	
		
	include('../html/p.html.php');
			
}
 */
include("../funkcje.php");
$time_start = microtime_float();
$menu=menu2();
$style=style2();

if(isset($_GET['co']))
{
    $s=safe($_GET['co']);
    switch($s)
    {
        case 'pokaz':
            
            include('pokaz_marek.php');
            break;
        case 'usun':
            include('usun_marek.php');
            break;
        case 'edit':
            include('edit_marek.php');
            break;
            
    }
}
else
{
    $echo='<a href="?co=pokaz">Pokaż faktury Marka</a>';
    $echo.='<h1>Marek</h1>';
    if(isset($_REQUEST['allert']))
        $echo.='<br>'.$_REQUEST['allert'].'<br>';
    
    $link=connect();
    $dane='';
    $q='SELECT SUM(`wrtosc_zlecenia`) FROM `marek`';
    $s=mysqli_query($link,$q);
    $r=mysqli_fetch_array($s);
    $echo.='Bilans Pana Marka: '.(-1*$r[0]).'zł<br><br><br>';
    
    $echo.='<form id="form1" name="form1" method="post" action="dodaj_marek.php">
        <table border="1">
        <tr><td>Marek otrzymał: </td>
            <td><input name="otrzymal" type="text" size="34" wrap="physical" maxlength="34" /> 
        	</td></tr>
        <tr><td>data wystawienia </td>
            <td> <input id="data_otzymania" name="data_otzymania" type="text" size="34" wrap="physical" maxlength="34" />  </td></tr>
        <tr><td></td>
            <td>
        <input name="submit" type="submit" value="przekaż"/></td></tr></table>
        </form>';
    
    
    include('../html/p.html.php');
    }
?>
