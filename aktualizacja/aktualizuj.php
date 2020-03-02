<?php

include('../funkcje.php');
$menu=menu2();
$style=style2();
$time_start = microtime_float();


$link=connect();

$dane='';
$q='SELECT * FROM `kontrachenci` ORDER BY `kontrachenci`.`skroc_nazw` ASC';
$s=mysqli_query($link,$q);
while($r=mysqli_fetch_array($s)){
    $dane.="Array('$r[0]','$r[1]','$r[2]','$r[3]','$r[4]'),\n";
}
//echo $dane;

if(!zapisPHP('db_lista_kontr',$dane))
{
    $bl='<span class="red">bład zapisu zapisPHP(db_lista_kontr,$dane);</span>';
}

$dane='';
$q='SELECT * FROM `zlecenia` WHERE `czy_zamkniete`=0;';
$s=mysqli_query($link,$q);
while($r=mysqli_fetch_array($s)){
    $dane.="Array('$r[0]','$r[1]','$r[2]'),\n";
}
//echo $dane;

if(!zapisPHP('db_lista_zlecen',$dane))
{
    $bl.='<span class="red">bład zapisu zapisPHP(db_lista_zlecen,$dane);</span>';
}

mysqli_close($link);

if($bl=='')
    header('Location: ../index.php?echo=zaktualizowano');
    else
        echo $bl;
	
//}
?>
