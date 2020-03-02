<?php // .marek/index
include("../funkcje.php");
$time_start = microtime_float();
$menu=menu2();
$style=style2();



if(isset($_POST['id']) )
{
    
    $link=connect();
    $id=safe($_POST['id']);
    
    //$q='DELETE FROM `zlecenia` WHERE `zlecenia`.`id_zlec` = '.$k;
    if(!isset($_POST['pieniadze']))
    {

        $q="SELECT `id_faktury` FROM `marek` WHERE `id_marek` =$id;";
        if(!$s=mysqli_query($link,$q))
            db_error($link,$q);
            
        $r=mysqli_fetch_array($s);
        
        $q="UPDATE `faktury` SET `id_forma_platnosci` = 1 WHERE `faktury`.`id_faktury` = $r[0];";
        if(!mysqli_query($link,$q))
            db_error($link,$q);
        }
            
    $q="DELETE FROM `marek` WHERE `id_marek` =$id;";
    if(!mysqli_query($link,$q))
        db_error($link,$q);
         
    mysqli_close($link);
            
    if($bl=='')
        header('Location: index.php?allert=usunięto');
        else
            echo $bl;
}
?>
