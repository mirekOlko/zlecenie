<?php
//session_start();
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

if(isset($_REQUEST['edit'])&& $_REQUEST['edit']=='edit')
{
	$link=connect();

	//require_once('../db_lista_kontr.php');
	
	$id=safe($_REQUEST['id']);
	
	$q='SELECT * FROM `faktury` WHERE `faktury`.`id_faktury` = '.$id;
	if(!$s=mysqli_query($link,$q))
	    db_error($link,$q);
		
	$r=mysqli_fetch_array($s);
	mysqli_close($link);
	
	$data_wystawienia=dataHTML($r[2]);
	$data_platnosci=dataHTML($r[3]);
	$ileDni=ileDni($r[2], $r[3]);

	$echo = 'Edycja faktury <strong>"'.$r[1].'"</strong><br><br>';
		$echo.='<button onclick="myFunction()">nasza faktura</button><script>function myFunction() {document.getElementById("181").selected=true;document.getElementById("forma_platnosci3").selected=true;}</script>';
		
		$echo.='<form id="form1" name="form1" method="post" action="edit_fakture.php">
    <table border="1">
    <tr><td>Numer faktury </td>
        <td> <input name="numer_faktury" type="text" size="34" wrap="physical" maxlength="34" value="'.$r[1].'" />  </td></tr>
    <tr><td>data wystawienia </td>
        <td> <input id="data_wystawienia" name="data_wystawienia" type="text" size="34" wrap="physical" maxlength="34"  value="'.$data_wystawienia.'" onchange="datagora()" />  </td></tr>
    <tr><td>ilość dni na płatności: </td>
        <td>
    	<input id="ile_dni" name="ile_dni" type="text" onchange="datagora()" value="'.$ileDni.'" />
    		    
        </td></tr>
    		    
    <tr><td>data płatnosci </td>
        <td><input id="data_zaplaty_faktury" name="data_zaplaty_faktury" type="text" value="'.$data_platnosci.'" onchange="datadol()" />
        </td></tr>
    <tr><td>wystawca faktury:</td>
        <td>
    	<select id="wystawca_faktury" name="wystawca_faktury">
    	';
    		require_once('../db_lista_kontr.php');
    		for($i=0;$i<sizeof($baza);$i++)
    		{
    		    if($r[5]==$baza[$i][0]){
    		      $echo.='<option id="'.$baza[$i][0].'" value="'.$baza[$i][0].'" selected>'.$baza[$i][1].' </option>';
    		      //echo 'select '.$r[5].' '.$baza[$i][0];
    		      }
    	      else
    	          $echo.='<option id="'.$baza[$i][0].'" value="'.$baza[$i][0].' ">'.$baza[$i][1].' </option>';
    		}
    		$echo.='</select>
    	</td></tr>
    		    
    <tr><td>numer zlecenia:</td>
        <td>
    	<select name="numer_zlecenia">
    	';
    		require_once('../db_lista_zlecen.php');
    		for($i=0;$i<sizeof($baza);$i++)
    		{
    		    if($r[6]==$baza[$i][0])
    		        $echo.='<option value="'.$baza[$i][0].'" selected>'.$baza[$i][1].' </option>';
    		        else
    		            $echo.='<option value="'.$baza[$i][0].'">'.$baza[$i][1].' </option>';
    		}
    		$echo.='</select></td></tr>
    <tr><td>wartość faktury: </td>
        <td><input name="wartosc_faktury" type="text" size="34" wrap="physical" maxlength="34" value="'.$r[7].'"/>
    	</td></tr>
    <tr><td>wartość VAT: </td>
        <td><input name="wartosc_VAT" type="text" size="34" wrap="physical" maxlength="34" value="'.$r[8].'"/>
    	</td></tr>
    		    
    <tr><td>forma płatności: </td>
        <td>
    	<select name="forma_platnosci" onchange="formaPlatloscik()">';
    		$formaplat=array('','gotówka','karta','przelew','marek');
    		for($i=1;$i<sizeof($formaplat);$i++)
    		    if($i==$r[9])
    		        $echo.='<option id="forma_platnosci'.$i.'" value="'.$i.'" selected>'.$formaplat[$i].' </option>';
    		    else 
    		        $echo.='<option id="forma_platnosci'.$i.'" value="'.$i.'">'.$formaplat[$i].' </option>';
    		    
    		    
    		    $echo.='</select>
    	</td></tr>
    		        
    <tr><td>czy zapłacona:</td>
        <td>
    	<select name="zaplacona">';
    		    if($r[10]==0)
    		        $echo.='<option id="zaplaconaNie" value="0" selected>NIE</option>
    	                   <option id="zaplaconaTak" value="1">TAK</option>';
    		    else 
    		        $echo.='<option id="zaplaconaNie" value="0" >NIE</option>
    	                   <option id="zaplaconaTak" value="1" selected>TAK</option>';
    	$echo.='</select>
    	</td></tr>';
    		    
    		    $echo.='
    <tr><td></td>
        <td>
    <input type="hidden" name="id" value="'.$r[0].'">
    <input name="submit" type="submit" value="popraw fakturę"/></td></tr></table>
    </form>';


	include('../html/p.html.php');
	
}

//foreach($_POST As $k=>$v)
 //   echo $k.' '.$v.'<br>';

if(isset($_POST['id']) && isset($_POST['numer_faktury']) && isset($_POST['data_wystawienia']) && isset($_POST['data_zaplaty_faktury']) && isset($_POST['wystawca_faktury']) && isset($_POST['numer_zlecenia']) && isset($_POST['wartosc_faktury']) && isset($_POST['zaplacona']) && isset($_POST['forma_platnosci']) && isset($_POST['wartosc_VAT']))
{
	$id=safe($_POST['id']);
	$numer_faktury=safe($_POST['numer_faktury']);
	$data_wystawienia=safe($_POST['data_wystawienia']);
	$data_zaplaty_faktury=safe($_POST['data_zaplaty_faktury']);
	$wystawca_faktury=safe($_POST['wystawca_faktury']);
	$numer_zlecenia=safe($_POST['numer_zlecenia']);
	$wartosc_faktury=pieniadze($_POST['wartosc_faktury']);
	$_POST['wartosc_faktury']=pieniadze($_POST['wartosc_faktury']);
	if(!empty($_POST['wartosc_VAT']))
	    $wartosc_VAT=pieniadze($_POST['wartosc_VAT']);
	    else
	    $wartosc_VAT=null;
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
	            array('VAT','wartosc_VAT'),
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
        if($forma_platnosci!=$r[8])
        {
            if($r[8]==4)
            {
                $q="DELETE FROM `marek` WHERE `id_faktury`=$id;";
                if(!mysqli_query($link,$q))
                    db_error($link,$q);
                }
            else 
            {
                $q="INSERT INTO `marek` (`id_marek`, `id_faktury`, `data_otrz_kasy`, `wrtosc_zlecenia`)
                                    VALUES (NULL, '$id', NULL, '$wartosc_faktury');";
                if(!mysqli_query($link,$q))
                    db_error($link,$q);
                }
        }
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

if(isset($_POST['fakturyDoOplaceniaZaplacone']))
{
    //echo 'fakturyDoOplaceniaZaplacone<br>';
    $faktury=safe($_POST['fakturyDoOplaceniaZaplacone']);
    
    $masage='';
    $link=connect();
    
    foreach($_POST As $k=>$v)
    {
        if(is_int(strpos($k, "datafakt")) && !empty($v))
        {
            //echo $k.'<br>';
            $v=safe(substr($k, 8));
            
            if(!empty($_POST['datafakt'.$v]))
                if(!$data=dataSQL(safe($_POST['datafakt'.$v])))
                    $data=date("Y-m-d");
                    
            $q="UPDATE `faktury` SET `data_zaplacenia` = '".$data."', `zaplacona` = '1' WHERE `faktury`.`id_faktury` = ".$v.";";
            if(!mysqli_query($link,$q))
                db_error($link,$q);
                
                $masage.='zapłocono id='.$v.', ';
        }
        
    } 
   /* foreach($_POST As $k=>$v)
    {
        echo $k.' '.$v."<br>";
    }
    
    
    foreach($_POST As $k=>$v)
    {
        if(is_int(strpos($k, "fakt")) && !empty($v))
        {
            
            $v=safe($v);
            
            if(isset($_POST['datafakt'.$v]) && !empty($_POST['datafakt'.$v]))
                $data=dataSQL(safe($_POST['datafakt'.$v]));
            else 
                $data=date("Y-m-d");

            //$q="UPDATE `faktury` SET `zaplacona` = '1' WHERE `faktury`.`id_faktury` = ".$v.";";
           $q="UPDATE `faktury` SET `data_zaplacenia` = '".$data."', `zaplacona` = '1' WHERE `faktury`.`id_faktury` = ".$v.";";
            if(!mysqli_query($link,$q))
                db_error($link,$q);
                
            $masage.='zapłocono id='.$v.', ';
        }

    }   
    */
    if($q!='')
        header('Location: ../wyszukaj/index.php?masage='.$masage);
    else
        header('Location: ../wyszukaj/index.php');
       
}
	
?>
