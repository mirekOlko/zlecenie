<?php 
//include("../funkcje.php");

if(isset($_POST['STEP2']) && $_POST['STEP2']=='step2')
{

    $echo='<form name="edit" method="post" action="../faktury/edit_fakture.php"><input name="fakturyDoOplaceniaZaplacone" type="hidden" ><table border="1">
        <tr><td>data wystawienia</td><td>nazwa</td><td>wartosć</td><td>wystawca</td><td>zapłacona</td></tr>';
    
    $ids='';
    foreach($_POST As $k=>$v)
        if(is_int(strpos($k, "fakt")) && !empty($v))
            $ids.="`id_faktury` = ".safe($v)." OR "; //`id_faktury`
        
    if($ids=='')
        header('Location:index.php');
    else 
        $ids=substr($ids, 0, -4);
    
    $link=connect();
    $q="SELECT `faktury`.`id_faktury`, `faktury`.`data_wystawienia`, `faktury`.`numer`,`faktury`.`wartosc`, `kontrachenci`.`nazwa`
                    FROM `faktury` INNER JOIN `kontrachenci`
                    						ON `faktury`.`id_kontr`=`kontrachenci`.`id_kontr`
                    WHERE ".$ids.";";
    if(!$s=mysqli_query($link,$q))
        db_error($link,$q);
        //$r=mysqli_fetch_array($s);
        $script='';

        while($r=mysqli_fetch_array($s))
        {
            $echo.='<tr>';
            for($i=1;$i<5;$i++)
            {
                $echo.='<td>'.$r[$i].'</td>'."\n";
            }
            
            $echo.='<td><input id="fakt'.$r[0].'" name="fakt'.$r[0].'" type="checkbox" value="'.$r[0].'" /></td>'."\n";
            $echo.='<td><input id="datafakt'.$r[0].'" name="datafakt'.$r[0].'" type="text" /></td>'."\n";
            $echo.='<td><input name="datafakt'.$r[0].'F" type="button" value="teraz" onClick="teraz(this.name)"/></td>'."\n";
            $echo.="</tr>\n";
            //$script.='$( "#datafakt'.$r[0].'" ).datepicker({dateFormat: "dd.mm.yy"});'."\n";
            $script.=scriptJS('datafakt'.$r[0]);
        }
        mysqli_close($link);
        $echo.='</table><input name="wyslij" type="submit" value="zapłać za faktury"/></form>';

}
else{
    $echo.='<form name="edit" method="post" action="index.php?co=fakDoOpl"><input name="STEP2" type="hidden" value="step2"><input name="wyslij" type="submit" value="zapłać za faktury"/><table border="1">
        <tr><td>data wystawienia</td><td>nazwa</td><td>wartosć</td><td>wystawca</td><td>zapłacona</td></tr>';
    
    
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
    $link=connect();
    $q="SELECT `faktury`.`id_faktury`, `faktury`.`data_wystawienia`, `faktury`.`numer`,`faktury`.`wartosc`, `kontrachenci`.`nazwa`
                    FROM `faktury` INNER JOIN `kontrachenci`
                    						ON `faktury`.`id_kontr`=`kontrachenci`.`id_kontr`
                    WHERE (`faktury`.`zaplacona` IS NULL OR `faktury`.`zaplacona`=0)  
                        AND `faktury`.`id_kontr`!=181
                    ORDER BY `faktury`.`data_wystawienia`  ASC";
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
        
        $echo.='<td><input name="fakt'.$r[0].'" type="checkbox" value="'.$r[0].'" /></td>'."\n";
        $echo.="</tr>\n";
    }
    mysqli_close($link);
    $echo.='</table><input name="wyslij" type="submit" value="zapłać za faktury"/></form>';
}

?>