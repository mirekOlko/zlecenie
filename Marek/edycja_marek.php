<?php // .marek/index
include('../funkcje.php');
$time_start = microtime_float();
$menu=menu2();
$style=style2();
/*
 if(!isset($_SESSION['sprawdz']))
 {
 include('../html/logowanie.html');
 exit();
 }
 */

if(isset($_POST['edit'])&& $_POST['edit']=='edit')
{
    $link=connect();
    
    //require_once('../db_lista_kontr.php');
    
                            
                            
                            include('../html/p.html.php');
                            
}


    
    if(isset($_POST['id']) && isset($_POST['numer_faktury']) && isset($_POST['data_wystawienia']) && isset($_POST['data_zaplaty_faktury']) && isset($_POST['wystawca_faktury']) && isset($_POST['numer_zlecenia']) && isset($_POST['wartosc_faktury']) && isset($_POST['zaplacona']) && isset($_POST['forma_platnosci']))
    {
        $id=safe($_POST['id']);
        $numer_faktury=safe($_POST['numer_faktury']);
        $data_wystawienia=safe($_POST['data_wystawienia']);
        $data_zaplaty_faktury=safe($_POST['data_zaplaty_faktury']);
        $wystawca_faktury=safe($_POST['wystawca_faktury']);
        $numer_zlecenia=safe($_POST['numer_zlecenia']);
        $wartosc_faktury=pieniadze($_POST['wartosc_faktury']);
        $_POST['wartosc_faktury']=pieniadze($_POST['wartosc_faktury']);
        $forma_platnosci=safe($_POST['forma_platnosci']);
        $zaplacona=safe($_POST['zaplacona']);
        
        
        
        $temp=explode(".",$data_wystawienia);
        //2019-01-01 00:00:00
        //echo $data_wystawienia_faktury.'<br>';
        $data_wystawienia=$temp[2].'-'.$temp[1].'-'.$temp[0];
        
        $temp=explode(".",$data_zaplaty_faktury);
        $data_zaplaty_faktury=$temp[2].'-'.$temp[1].'-'.$temp[0];
        
        
        $link=connect();
        
        $q="SELECT * FROM `faktury` WHERE `id_faktury` =$id;";
        if(!$s=mysqli_query($link,$q))
            db_error($link,$q);
            
            $nagl=array(
                array('id_faktury', 'id'),
                array('numer', 'numer_faktury'),
                array('data_wystawienia', 'data_wystawienia'),
                array('data_platnosci', 'data_zaplaty_faktury'),
                array('id_kontr', 'wystawca_faktury'),
                array('id_zlec', 'numer_zlecenia'),
                array('wartosc', 'wartosc_faktury'),
                array('id_forma_platnosci', 'forma_platnosci'),
                array('zaplacona','zaplacona'),
            );
            
            $r=mysqli_fetch_array($s);
            
            
            $ciag='';
            for($i=0;$i<sizeof($nagl);$i++)
            {
                if($i==2 || $i==3)
                {
                    if($r[$i]!=dataSQL(safe($_POST[$nagl[$i][1]])))
                    {
                        $ciag.=" `".$nagl[$i][0]."` = '".dataSQL(safe($_POST[$nagl[$i][1]]))."',";
                    }
                }
                else
                    if($r[$i]!=safe($_POST[$nagl[$i][1]]))
                    {
                        $ciag.=" `".$nagl[$i][0]."` = '".safe($_POST[$nagl[$i][1]])."',";
                    }
            }
            //if($r[1]!=$numer_faktury)
            
            
            //echo "UPDATE `faktury` SET `zaplacona` = '0' WHERE `faktury`.`id_faktury` = 5;<br>";
            
            
            if($ciag!='')
            {
                $ciag=substr($ciag, 0, -1); //usuwa ostatni przecinek ze stringa
                $q="UPDATE `faktury` SET ".$ciag." WHERE `faktury`.`id_faktury` = $id;";
                // echo $q;
                $bl='';
                if(!mysqli_query($link,$q))
                    db_error($link,$q);
                    // echo $bl;
            }
            //UPDATE `faktury` SET `numer` = 'mirek1', `data_wystawienia` = '2019-02-05', `data_platnosci` = '2019-03-07', `wartosc` = '112.00', `zaplacona` = '0' WHERE `faktury`.`id_faktury` = 5;
            mysqli_close($link);
            if($bl=='')
                header('Location: index.php');
                else
                    echo $bl;
                    
    }
    
?>
