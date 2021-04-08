<!DOCTYPE HTML>
<html lang="pl">
<head>

<body>
<?php 
session_start();
if(!isset($_SESSION['zalogowany'])){
header('Location:main.php');
}
else{
require_once "connect.php";
$polaczenie= @new mysqli($host,$db_user,$db_password, $db_name);
if ($polaczenie->connect_errno!=0)
{
echo "Błąd połączenia";
}
else{
	$id=$_SESSION['idusera'];

if(isset($_GET['id_dodawanie'])&&isset($_GET['ilosc'])){
$produktDodany=$_GET['id_dodawanie'];
$waga=$_GET['ilosc'];
$SQLdodawanie="INSERT INTO `jadlospis_temp` (`id`, `id_usera`, `id_produktu`,`ilosc`)
 VALUES (NULL, '$id', '$produktDodany','$waga')";
 $polaczenie->query($SQLdodawanie);
echo '<br>id= '.$produktDodany;
echo 'waga= '.$waga;}


$_SESSION['komunikat_usuniecie']="";

if(isset($_GET['usun_z_bazy'])&&$_SESSION['ile_w_tablicy']==0){
	$id_do_usuniecia=$_GET['usun_z_bazy'];
	$SQLusuwamyProdukt="DELETE FROM `produkty` WHERE id='$id_do_usuniecia'";
	$polaczenie->query($SQLusuwamyProdukt);
	$_SESSION['komunikat_usuniecie']="";
}
else{
	$_SESSION['komunikat_usuniecie']="Nie można usunąć produktu, wyczyść kreator!";
}


if(isset($_GET['id_usuwanie'])){$produktDoUsuniecia=$_GET['id_usuwanie'];
$SQLusuwanie="DELETE FROM `jadlospis_temp` WHERE `id` = '$produktDoUsuniecia'";
 $polaczenie->query($SQLusuwanie);
 	$_SESSION['komunikat_usuniecie']="";
 }



if(isset($_GET['iddd'])){$produktDoUsunieciaZTablicyWKatalogu=$_GET['iddd'];
$_SESSION['doUsunieciaZKatalogu']=$produktDoUsunieciaZTablicyWKatalogu;
	$_SESSION['komunikat_usuniecie']="";}

if(isset($_GET['flaga'])){$_SESSION['flaga']=$_GET['flaga']; 	$_SESSION['komunikat_usuniecie']="";}

if(isset($_POST['dodaniePosilku'])){
	$SQLdodaniePosilku=$_POST['dodaniePosilku'];
	$polaczenie->query($SQLdodaniePosilku);
	
/* 	$ilosc_indeksow=count($_SESSION['indeksy_do_bazy']);
	$SQLdodanieIndeksow="INSERT INTO `posilki` (`ig`) VALUES";
	for($i=0;$i<$ilosc_indeksow;$i++){
	$SQLdodanieIndeksow=$SQLdodanieIndeksow."(".$_SESSION['indeksy_do_bazy'][$i]."),";
	}
	
	$dlugosc=strlen($SQLdodanieIndeksow);
	$SQLdodanieIndeksow[$dlugosc-1]=" ";
	$polaczenie->query($SQLdodanieIndeksow); */
	$_SESSION['komunikat_usuniecie']="";	
}



var_dump($_SESSION['indeksy_do_bazy']);

if(isset($_POST['nazwa_posilku'])&&isset($_POST['opis_posilku'])){
	
	$id_do_bazy=$_SESSION['id_DoBazy'];
	$nazwa_posi=$_POST['nazwa_posilku'];
	$opis_posi=$_POST['opis_posilku'];
	
	$ilosc_indeksow=count($_SESSION['indeksy_do_bazy']);
	$ig_gora=0;
	$ig_dol=0;
	$ig=0;
	$SQLpobranieIg=
	"SELECT DISTINCT p.`nazwa`, p.`indeks`, p.`Glukoza`, p.`Fruktoza`, p.`Galaktoza`, p.`Malachoza_disacharydowa`, p.`Trehaloza`, p.`Sacharoza`, p.`Laktoza`, p.`Polisacharydy_Maltotriose`, p.`Maltotetraoza`, p.`Skrobia`, p.`Maltodekstryna`, p.`Alkohole_cukrowe_Maltitol`, p.`Ksylitol` 
	FROM `produkty` p, `posilki` a
	WHERE a.`id_produktu`=p.`id` AND a.id_produktu=";
	for($i=0;$i<$ilosc_indeksow;$i++){
		echo $_SESSION['indeksy_do_bazy'][$i]."<br><br>";
	$SQLpobranieIg=$SQLpobranieIg.$_SESSION['indeksy_do_bazy'][$i];
	echo $SQLpobranieIg."<br><br>";
	$wynik15=$polaczenie->query($SQLpobranieIg);
		
	while($wiersz= mysqli_fetch_row($wynik15)) {
		if($wiersz[1]==0){
       $mnoznik=$_SESSION['ilosc_do_bazy'][$i]/100;
        $ig_gora=$ig_gora+$wiersz[2]*$mnoznik*100+$wiersz[3]*$mnoznik*20+20*$wiersz[4]*$mnoznik+105*$wiersz[5]*$mnoznik+70*$wiersz[6]*$mnoznik+62*$wiersz[7]*$mnoznik+47*$wiersz[8]*$mnoznik+$wiersz[9]*$mnoznik*110+110*$wiersz[10]*$mnoznik+$wiersz[11]*$mnoznik*110+110*$wiersz[12]*$mnoznik+35*$wiersz[13]*$mnoznik+12*$wiersz[14]*$mnoznik;
		$ig_dol=$ig_dol+$wiersz[2]*$mnoznik+$wiersz[3]*$mnoznik+$wiersz[4]*$mnoznik+$wiersz[5]*$mnoznik+$wiersz[6]*$mnoznik+$wiersz[7]*$mnoznik+$wiersz[8]*$mnoznik+$wiersz[9]*$mnoznik+$wiersz[10]*$mnoznik+$wiersz[11]*$mnoznik+$wiersz[12]*$mnoznik+$wiersz[13]*$mnoznik+$wiersz[14]*$mnoznik;
		
			$_SESSION['komunikat_usuniecie']="";
						}
	else{
    echo $wiersz[1]." ";
	//if($wiersz[1]==NULL){$wiersz[0]=0;}
    $mnoznik=$_SESSION['ilosc_do_bazy'][$i]/100;
	$ig_gora=$ig_gora+$wiersz[1]*$mnoznik;
	$ig_dol=$ig_dol+$mnoznik;
		$_SESSION['komunikat_usuniecie']="";
	}
	//}		
						
	} 
	
	 $SQLpobranieIg=
	"SELECT DISTINCT p.`nazwa`, p.`indeks`, p.`Glukoza`, p.`Fruktoza`, p.`Galaktoza`, p.`Malachoza_disacharydowa`, p.`Trehaloza`, p.`Sacharoza`, p.`Laktoza`, p.`Polisacharydy_Maltotriose`, p.`Maltotetraoza`, p.`Skrobia`, p.`Maltodekstryna`, p.`Alkohole_cukrowe_Maltitol`, p.`Ksylitol` 
	FROM `produkty` p, `posilki` a
	WHERE a.`id_produktu`=p.`id` AND a.id_produktu="; 
		$_SESSION['komunikat_usuniecie']="";
	}
	
	/* echo '<br>';
	echo $ig_gora;
	echo '<br>';
	echo $ig_dol;
	echo '<br>'; */
	
	$ig=$ig_gora/$ig_dol;
	echo $ig;
	
	

	

	$SQLdodaniePosilkuZlozonego="INSERT INTO posilki_zlozone (`id`, `nazwa`, `opis`,`ig`)
 VALUES ('$id_do_bazy', '$nazwa_posi', '$opis_posi','$ig')";
	$polaczenie->query($SQLdodaniePosilkuZlozonego);
	
		$_SESSION['komunikat_usuniecie']="";
	
	
}
	if(isset($_POST['id_dodawanie'])&&isset($_POST['time0'])&&isset($_POST['time30'])&&isset($_POST['time60'])&&isset($_POST['time90'])&&isset($_POST['time150'])&&isset($_POST['time300'])&&isset($_POST['time500']))
	{
		
	
$posilekDodanyId=$_POST['id_dodawanie'];
$time0=$_POST['time0'];
$time30=$_POST['time30'];
$time60=$_POST['time60'];  
$time90=$_POST['time90'];
$time150=$_POST['time150']; 
$time300=$_POST['time300']; 
$time500=$_POST['time500']; 
	$_SESSION['komunikat_usuniecie']="";

	
$SQLdodanieModelu= "INSERT INTO `model_posilku` (`id`, `id_posilku`, `time0`, `time30`, `time60`, `time90`, `time150`, `time300`, `time500`) VALUES (NULL, $posilekDodanyId ,$time0, $time30, $time60, $time90, $time150, $time300, $time500)";

$polaczenie->query($SQLdodanieModelu); 

}

}
$polaczenie->close();

header('Location:katalog.php');
}
?>


</body>
</html>