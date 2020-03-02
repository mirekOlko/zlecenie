<?php
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function safe($string)
{
	$string=trim($string);
	$string=strip_tags($string);
	$string=htmlspecialchars($string, ENT_QUOTES,'UTF-8', true);
	return $string;
	
}

function pieniadze($data)
{
    switch ($data) {
        case isset($data)==false:
            return 0.00;
            break;
        case empty($data)==true:
            return 0.00;
            break;
        case is_double($data)==true:
            return $data;
            break;
        case is_integer($data)==true:
            return $data.'.00';
            break;
        case is_string($data)==true:
            $temp=array();
            $licz=0;
            for($i=0;$i<strlen($data);$i++)
            {
                if($data[$i]==',' || $data[$i]=='.')
                    $licz++;
                    else
                    {
                        if(!isset($temp[$licz]))
                            $temp[$licz]='';
                            if(preg_match('/^[0-9]$/D', $data[$i]))
                                $temp[$licz].=$data[$i];
                    }
            }
            //echo 'licznik '.$licz;
            //$licz--;
            
            switch(sizeof($temp))
            {
                case 0:
                    return 0.00;
                    break;
                case 1:
                    if(!empty($temp[0]))
                        return $temp[0].'.00';
                        else
                            return '0.00';
                            break;
                default:
                    $wyn='';
                    for($i=0;$i<sizeof($temp);$i++)
                    {
                        if($i==$licz)
                            $wyn.='.'.$temp[$i];
                            else
                                $wyn.=$temp[$i];
                    }
                    return $wyn;
                    
            }
            break;
        default:
            return 0.00;
    }
}

function printStringWithSpace($liczba,$coIleSpacja)
{
    $blad=0;
    $liczba=(string)$liczba;

    $temp='';
    $ogon='';
    if(strpos($liczba, ".")>0)
    {
        $temp=explode(".",$liczba);
        $ogon=$temp[1];
        $temp=$temp[0];
    }
    else
        $temp=$liczba;
        
    $temp1='';
    $licz=0;
    for($i=strlen($temp)-1;$i>=0;$i--)
    {
        if($licz>=$coIleSpacja)
        {
            $temp1.=' ';
            $licz=0;
        }
        $temp1.=$temp[$i];
        $licz++;
    }
    $temp='';
    for($i=strlen($temp1)-1;$i>=0;$i--)
        $temp.=$temp1[$i];
        if($ogon!='')
            $temp.='.'.$ogon;
            return $temp;

}

function dataHTML($r)
{
	$temp=explode("-",$r);
	$data_wystawienia=$temp[2].'.'.$temp[1].'.'.$temp[0];
	return $data_wystawienia;			
}

function dataSQL($r)
{
    $temp=explode(".",$r);
    $r=$temp[2].'-'.$temp[1].'-'.$temp[0];
    return $r;
}

function dataSqlDodaj($start, $ileDni)
{   
    $start = new DateTime($start);
    $start->modify('+'.$ileDni.' day');
    return $start->format('Y-m-d');
}

function ileDni($start,$stop)
{
    $start = new DateTime($start);
    $stop = new DateTime($stop);
    $start=$start->diff($stop);
    return $start->days;
    
}
function logout()
{
	$s='<form action="index.php" name="logout" method="post" enctype="application/x-www-form-urlencoded">
			<input type="submit" class="button" name="logout" value="logout" />
			</form>';
return $s;
			
}

function menu1()
{
    //<li><form action="./index.php" name="logout" method="post" enctype="application/x-www-form-urlencoded"><input type="submit" class="button" name="logout" value="logout" /></form></li>
$s='<ul>
        <li><strong>Zadania</strong></li>
            <li><a href="./faktury/index.php">faktury</a></li>
            <li><a href="./Marek/">Marek</a></li>
        	<li><a href="./zlecenia/index.php">zlecenia</a></li>
            <li><a href="./kontrachenci/index.php">kontrachenci</a></li>
            <li><a href="./wyszukaj/index.php">wyszukiwania</a></li>
        <li><strong>Finanse</strong></li>
            <li><a href="./analizy/index.php">analizy</a></li>
        <li><strong>Aktualizacja</strong></li>
            <li><a href="./aktualizacja/aktualizuj.php">aktualizuj</a></li>
	</ul>';
return $s;
}
function menu2()
{
    $s='<ul>
            <li><strong>Zadania</strong></li>
                <li><a href="../faktury/index.php">faktury</a></li>
                <li><a href="../Marek/">Marek</a></li>
            	<li><a href="../zlecenia/index.php">zlecenia</a></li>
                <li><a href="../kontrachenci/index.php">kontrachenci</a></li>
                <li><a href="../wyszukaj/index.php">wyszukiwania</a></li>
            <li><strong>Finanse</strong></li>
                <li><a href="../analizy/index.php">analizy</a></li>
            <li><strong>Aktualizacja</strong></li>
                <li><a href="../aktualizacja/aktualizuj.php">aktualizuj</a></li>
	</ul>';
return $s;
}

function style1()
{
$s="<link rel='stylesheet' href='./js/style.css'>
	<link rel='stylesheet' href='./js/zerogrid.css'>";
return $s;
}

function style2()
{
$s="<link rel='stylesheet' href='../js/style.css'>
	<link rel='stylesheet' href='../js/zerogrid.css'>";
return $s;
}

// baza danych
function connect()
{
	$nazwa='localhost';
	$my_user='mirek';
	$my_password='1qazxsw2';
	$my_db='baza_testowa';
	//$link = mysqli_connect($nazwa, $my_user, $my_password, $my_db);

	if (!$link = mysqli_connect($nazwa, $my_user, $my_password, $my_db)) {
		echo 'Error: Unable to connect to MySQL.<br>';
		echo "Debugging errno: " . mysqli_connect_errno().'<br>';
		echo "Debugging error: " . mysqli_connect_error().'<br>';
		exit;
	}
	//$link -> query("SET NAMES 'utf8_unicode_ci'");
	//$link -> query("SET CHARSET 'utf8'");
	if (!$link->set_charset("utf8")) {
	    printf("Error loading character set utf8: %s\n", $link->error);
	    exit();
	}

	
	return $link;
}

function db_error($link,$q)
{
    echo "<br>błąd zapytania<br>".$q.'<br>';
    echo "Debugging errno: " . mysqli_errno($link).'<br>';
    echo "Debugging error: " . mysqli_error($link).'<br>';
    exit();
    
}

function db_error_info($link,$q)
{
    $temp= "<br>błąd zapytania<br>".$q.'<br>';
    $temp.= "Debugging errno: " . mysqli_errno($link).'<br>';
    $temp.= "Debugging error: " . mysqli_error($link).'<br>';
    return $temp;
    
}

function db_tableGen($link,$q) // wypisuje tabele z wynikami zapytania o dowolnej długosci
{
    if(!$s=mysqli_query($link,$q))
        db_error($link, $q);
        $temp='brak faktur.';
        
        if(mysqli_num_rows($s)>0){
            $temp='<table border="1" >';
            while($r=mysqli_fetch_array($s))
            {
                $temp.='<tr>';
                for($i=0;$i<sizeof($r);$i++)
                    if(!empty($r[$i]))
                        $temp.='<td>'.$r[$i].'</td>';
                
                $temp.='</tr>';
            }    
            $temp.='</table>';
        }
    return $temp; 
}

function errorOpis($opis)
{
    echo $opis.'<br>';
}

function gen_database($my_db)
{
	$q="CREATE TABLE `".$my_db."`.`faktury` ( `id_faktury` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT , `numer` VARCHAR(150) NOT NULL , `data` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `id_kontr` SMALLINT UNSIGNED NOT NULL , `id_zlec` SMALLINT UNSIGNED NOT NULL , `wartosc` DECIMAL NOT NULL , PRIMARY KEY (`id_faktury`), INDEX (`data`), INDEX (`id_kontr`), INDEX (`id_zlec`)) ENGINE = MyISAM;";
	
	$q="CREATE TABLE `".$my_db."`.`zlecenia` ( `id_zlec` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT , `nazwa` VARCHAR(150) NOT NULL , `id_kontr` SMALLINT UNSIGNED NOT NULL , PRIMARY KEY (`id_zlec`), INDEX (`id_kontr`)) ENGINE = MyISAM;";
	
	$q="CREATE TABLE `".$my_db."`.`kontrachenci` ( `id_kontr` SMALLINT NOT NULL AUTO_INCREMENT , `nazwa` VARCHAR(100) NOT NULL , `adres` VARCHAR(100) NULL , `konto` CHAR(26) NOT NULL , `tytul` VARCHAR(100) NULL , `klucz` VARCHAR(10) NOT NULL , PRIMARY KEY (`id_kontr`)) ENGINE = MyISAM;";
}

function zapisPHP($nazwa,$dane){ // funkcja 1 zapisuje do pliku, 0 dodaje nową linię
	$bl='';
    if(!$plik = fopen('../'.$nazwa.'.php', "w")) $bl.=' open 1<br>';
    if(!fwrite($plik, pack("CCC",0xef,0xbb,0xbf))) $bl.=' write 2<br>';
    if(!fwrite($plik,'<?php $baza=Array(')) $bl.=' write 3<br>';
    if(!fwrite($plik,$dane)) $bl.=' write 4<br>';
    if(!fwrite($plik,'); ?>')) $bl.=' write 5<br>';
    if(!fclose($plik)) $bl.=' close 6<br>';
    
    if($bl=='')
        return true;
    else 
        {
            errorOpis($bl);
            exit;
        }
    
}

function zapisPHPKopia($nazwa,$dane){ // funkcja 1 zapisuje do pliku, 0 dodaje nową linię
    $plik = fopen('../'.$nazwa.'.php', "w");
    fwrite($plik, pack("CCC",0xef,0xbb,0xbf));
    fwrite($plik,'<?php $baza=Array(');
    fwrite($plik,$dane);
    fwrite($plik,'); ?>');
    fclose($plik);
}

function scriptJS($string)
{
    return '$( "#'.$string.'" ).datepicker({dateFormat: "dd.mm.yy"});'."\n";
}

?>