<?php //szukaj.php
include_once("../funkcje.php");
$time_start = microtime_float();
$menu=menu2();
$style=style2();

$echo.='<form name="edit" method="post" action="index.php?co=szukaj">
            <table border="1">
            <tr><td>szukaj numerze faktury</td>
                <td><input name="nrFaktury" type="text" /></td><td rowspan="5">
                                                                            <select name="sortTyp">
                                                                              <option value="DESC" checked>malejąco</option>
                                                                              <option value="ASC">rosnąco</option>
                                                                            </select>
                </td></tr>
            <tr><td>szukaj 14 dni po dacie</td>
            	<td><input id="data" name="data" type="text" /></td></tr>
            <tr><td>szukaj między datami</td>
            	<td> od <input id="dataOd" name="dataOd" type="text" onchange="dataTest()" /> do <input id="dataDo" name="dataDo" type="text" onchange="dataTest()" /></td></tr>
            <tr><td>szukaj po kontrachencie</td>
                <td><input name="kontrachent" type="text" /> sortuj po: 
                                                                            <select name="kon_sort">
                                                                              <option value="nazwa" checked>nazwa kontrachenta</option>
                                                                              <option value="data">data</option>
                                                                              <option value="nrFak" >numer faktury</option>
                                                                              <option value="wart" >wartosć </option>
                                                                            </select> 
                </td></tr>
            <tr><td>szukaj NIP</td>
            	<td><input name="NIP" type="text" /></td></tr>
            </table>
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
    $echo.='<div id="alert" style="font-weight:700;"></div> <table border="1">
        <tr><th class="SSort">data wystawienia</th><th class="SSort">nazwa</th><th class="ISort">wartosć</th><th class="SSort">wystawca</th><th class="SSort">sposób płatosci</th><th>edycja</th><th>usuwanie</th></tr>';
    $alert='Wyszukiwanie: ';
    $link=connect();
       
    Switch($_POST)
    {
        case !empty($_POST['nrFaktury']):
            $_POST['nrFaktury']=safe($_POST['nrFaktury']);
            $nazwaTabeli='numer';
            $q="SELECT `faktury`.`id_faktury`, `faktury`.`data_wystawienia`, `faktury`.`numer`,`faktury`.`wartosc`, `kontrachenci`.`nazwa`, `forma_platnosci`.`nazwa`
                        FROM `faktury` INNER JOIN `kontrachenci` ON `faktury`.`id_kontr`=`kontrachenci`.`id_kontr`
                                       INNER JOIN `forma_platnosci` ON `faktury`.`id_forma_platnosci`=`forma_platnosci`.`id_forma_platnosci`
                        WHERE `".$nazwaTabeli."` LIKE '%".$_POST['nrFaktury']."%'";
            $alert.='numer fatury, wyrażenie '.$_POST['nrFaktury'];
           
            break;
            
        case !empty($_POST['data']):
            $_POST['data']=dataSQL(safe($_POST['data']));
            $nazwaTabeli='data_wystawienia';
            $q="SELECT `faktury`.`id_faktury`, `faktury`.`data_wystawienia`, `faktury`.`numer`,`faktury`.`wartosc`, `kontrachenci`.`nazwa`, `forma_platnosci`.`nazwa`
                        FROM `faktury` INNER JOIN `kontrachenci` ON `faktury`.`id_kontr`=`kontrachenci`.`id_kontr`
                                       INNER JOIN `forma_platnosci` ON `faktury`.`id_forma_platnosci`=`forma_platnosci`.`id_forma_platnosci`
                        WHERE `".$nazwaTabeli."` BETWEEN '".$_POST['data']."' And '".dataSqlDodaj($_POST['data'],14)."' ";
            
            $alert.='data na 14 dni od, pomiędzy: '.$_POST['data'].' a '.dataSqlDodaj($_POST['data'],14);
            //echo $q;
            break;
            
        case !empty($_POST['dataOd']) && !empty($_POST['dataDo']):
            $nazwaTabeli='data_wystawienia';
            $dataOd = DateTime::createFromFormat('Y-m-d', dataSQL(safe($_POST['dataOd']))); // 2019-09-02
            $dataDo = DateTime::createFromFormat('Y-m-d', dataSQL(safe($_POST['dataDo'])));
            if($dataOd>$dataDo)
            {
                $temp=$dataOd;
                $dataOd=$dataDo;
                $dataDo=$temp;
                unset ($temp); }
                
            
            $q="SELECT `faktury`.`id_faktury`, `faktury`.`data_wystawienia`, `faktury`.`numer`,`faktury`.`wartosc`, `kontrachenci`.`nazwa`, `forma_platnosci`.`nazwa`
                        FROM `faktury` INNER JOIN `kontrachenci` ON `faktury`.`id_kontr`=`kontrachenci`.`id_kontr`
                                       INNER JOIN `forma_platnosci` ON `faktury`.`id_forma_platnosci`=`forma_platnosci`.`id_forma_platnosci`
                        WHERE `".$nazwaTabeli."` BETWEEN '".$dataOd->format('Y-m-d')."' And '".$dataDo->format('Y-m-d')."' ";
            
            $alert.='data pomiędzy: '.$dataOd->format('Y-m-d').' a '.$dataDo->format('Y-m-d');
            //echo $q;
            break;
        case !empty($_POST['kontrachent']):
            $_POST['kontrachent']=safe($_POST['kontrachent']);
            $q="SELECT `faktury`.`id_faktury`, `faktury`.`data_wystawienia`, `faktury`.`numer`,`faktury`.`wartosc`, `kontrachenci`.`nazwa`, `forma_platnosci`.`nazwa`
                        FROM `faktury` INNER JOIN `kontrachenci` ON `faktury`.`id_kontr`=`kontrachenci`.`id_kontr`
                                       INNER JOIN `forma_platnosci` ON `faktury`.`id_forma_platnosci`=`forma_platnosci`.`id_forma_platnosci`
                        WHERE `kontrachenci`.`nazwa` LIKE '%".$_POST['kontrachent']."%' ";
            
            $alert.='numer fatury, wyrażenie '.$_POST['kontrachent'];
            //value="nazwa" checked>nazwa kontrachenta| value="data">data|input type="radio" name="kon_sort" value="nrFak" >numer faktury </td>
            switch($_POST['kon_sort'])
            {
                case "nazwa":
                    $nazwaTabeli='kontrachenci`.`nazwa';
                    $alert.=', sortowanie po nazwie kontrachenta';
                    break;
                case "data":
                    $nazwaTabeli='faktury`.`data_wystawienia';
                    $alert.=', sortowanie po dacie wystawienia faktury';
                    break;
                case "nrFak":
                    $nazwaTabeli='faktury`.`numer';
                    $alert.=', sortowanie po numerze faktury';
                    //echo $q;
                    break;
                case "wart":
                    $nazwaTabeli='faktury`.`wartosc';
                    $alert.=', sortowanie po wartosci faktury';
                    //echo $q;
                    break;
                default:
                    $nazwaTabeli='kontrachenci`.`nazwa';
                    $alert.=', sortowanie po nazwie kontrachenta';
            }       
            break;
        case !empty($_POST['NIP']):
            $_POST['NIP']=safe($_POST['NIP']);
            $nazwaTabeli='kontrachenci`.`NIP';
            $q="SELECT `faktury`.`id_faktury`, `faktury`.`data_wystawienia`, `faktury`.`numer`,`faktury`.`wartosc`, `kontrachenci`.`nazwa`, `forma_platnosci`.`nazwa`
                        FROM `faktury` INNER JOIN `kontrachenci` ON `faktury`.`id_kontr`=`kontrachenci`.`id_kontr`
                                       INNER JOIN `forma_platnosci` ON `faktury`.`id_forma_platnosci`=`forma_platnosci`.`id_forma_platnosci`
                        WHERE `".$nazwaTabeli."` LIKE '%".$_POST['NIP']."%'";
            $alert.='NIP, wyrażenie '.$_POST['NIP'];
            
            break;
        default:
            $q="SELECT `faktury`.`id_faktury`, `faktury`.`data_wystawienia`, `faktury`.`numer`,`faktury`.`wartosc`, `kontrachenci`.`nazwa`, `forma_platnosci`.`nazwa`
                FROM `faktury` INNER JOIN `kontrachenci` ON `faktury`.`id_kontr`=`kontrachenci`.`id_kontr`
                               INNER JOIN `forma_platnosci` ON `faktury`.`id_forma_platnosci`=`forma_platnosci`.`id_forma_platnosci`
                ORDER BY `data_wystawienia` DESC LIMIT 10;";
    }
    
    if(isset($_POST['sortTyp']) && safe($_POST['sortTyp'])=='DESC'){
        $q.=' ORDER BY `'.$nazwaTabeli.'` DESC';
        $alert.=' malejąco';
        }
        else{
            $q.=' ORDER BY `'.$nazwaTabeli.'` ASC';
            $alert.=' rosnąco';
        }
     
        
    $s=mysqli_query($link,$q);
    //$r=mysqli_fetch_array($s);
    //echo $q;
    if(mysqli_num_rows($s)==0)
        $echo.='<tr><td>brak wyników wyszukiwania<td></tr>';
    else{
        $alert.=', znaleziono '.mysqli_num_rows($s);
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
    $echo.='
    <script type="text/javascript">
		document.getElementById("alert").innerHTML = "'.$alert.'";
        attachSorting();
		    
     </script>
';
}

?>