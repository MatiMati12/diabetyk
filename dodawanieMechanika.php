<?php
session_start();
require_once "connect.php";

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>

<body>

<?php
$polaczenie= @new mysqli($host,$db_user,$db_password, $db_name);
if ($polaczenie->connect_errno!=0)
{
echo "Błąd połączenia";
}
else
{////// Przypisanie danych z formsa do zmiennych
$ID=$_SESSION['idusera'];
$indeks_ob=0;
$Glukoza=0;
$Fruktoza=0;
$Galaktoza=0;
$Malachoza_disacharydowa=0;
$Trehaloza=0;
$Sacharoza=0;
$Laktoza=0;
$Polisacharydy_Maltotriose=0;
$Maltotetraoza=0;
$Skrobia=0;
$Maltodekstryna=0;
$Alkohole_cukrowe_Maltitol=0;
$Ksylitol=0;
if(isset($_POST['nazwaProduktu'])){$nazwa=$_POST['nazwaProduktu'];}
if(isset($_POST['OpisProduktu'])){$opis=$_POST['OpisProduktu'];}
if(isset($_POST['indeksGlikemiczny'])){$indeks=$_POST['indeksGlikemiczny'];}
if($indeks==""){
	echo "blabla";
if(isset($_POST['Glukoza'])){$Glukoza=$_POST['Glukoza'];$indeks=0;}if($Glukoza==""){$Glukoza=0;}
if(isset($_POST['Fruktoza'])){$Fruktoza=$_POST['Fruktoza'];$indeks=0;}if($Fruktoza==""){$Fruktoza=0;}
if(isset($_POST['Galaktoza'])){$Galaktoza=$_POST['Galaktoza'];$indeks=0;}if($Galaktoza==""){$Galaktoza=0;}
if(isset($_POST['Malachoza_disacharydowa'])){$Malachoza_disacharydowa=$_POST['Malachoza_disacharydowa'];$indeks=0;}if($Malachoza_disacharydowa==""){$Malachoza_disacharydowa=0;}
if(isset($_POST['Trehaloza'])){$Trehaloza=$_POST['Trehaloza'];$indeks=0;}if($Trehaloza==""){$Trehaloza=0;}
if(isset($_POST['Sacharoza'])){$Sacharoza=$_POST['Sacharoza'];$indeks=0;}if($Sacharoza==""){$Sacharoza=0;}
if(isset($_POST['Laktoza'])){$Laktoza=$_POST['Laktoza'];$indeks=0;}if($Laktoza==""){$Laktoza=0;}
if(isset($_POST['Polisacharydy_Maltotriose'])){$Polisacharydy_Maltotriose=$_POST['Polisacharydy_Maltotriose'];$indeks=0;}if($Polisacharydy_Maltotriose==""){$Polisacharydy_Maltotriose=0;}
if(isset($_POST['Maltotetraoza'])){$Maltotetraoza=$_POST['Maltotetraoza'];$indeks=0;}if($Maltotetraoza==""){$Maltotetraoza=0;}
if(isset($_POST['Skrobia'])){$Skrobia=$_POST['Skrobia'];$indeks=0;}if($Skrobia==""){$Skrobia=0;}
if(isset($_POST['Maltodekstryna'])){$Maltodekstryna=$_POST['Maltodekstryna'];$indeks=0;}if($Maltodekstryna==""){$Maltodekstryna=0;}
if(isset($_POST['Alkohole_cukrowe_Maltitol'])){$Alkohole_cukrowe_Maltitol=$_POST['Alkohole_cukrowe_Maltitol'];$indeks=0;}if($Alkohole_cukrowe_Maltitol==""){$Alkohole_cukrowe_Maltitol=0;}
if(isset($_POST['Ksylitol'])){$Ksylitol=$_POST['Ksylitol'];$indeks=0;}if($Ksylitol==""){$Ksylitol=0;}
echo "blabla";
$indeks=($Glukoza*100+$Fruktoza*20+$Galaktoza*20+$Malachoza_disacharydowa*105+$Trehaloza*70+$Sacharoza*62+$Laktoza*47+$Polisacharydy_Maltotriose*110+$Maltotetraoza*110+$Skrobia*110+$Maltodekstryna*110+$Alkohole_cukrowe_Maltitol*35+$Ksylitol*12)/($Glukoza+$Fruktoza+$Galaktoza+$Malachoza_disacharydowa+$Trehaloza+$Sacharoza+$Laktoza+$Polisacharydy_Maltotriose+$Maltotetraoza+$Skrobia+$Maltodekstryna+$Alkohole_cukrowe_Maltitol+$Ksylitol);
$indeks_ob=$indeks;
echo $indeks_ob;
$indeks =0;
	}
echo $indeks;	


/////////zapytanie dodajace do bazy produktu
$SQLdodawanie="INSERT INTO `produkty` (`id`, `nazwa`, `indeks`, `opis`, `id_wlasc`, `Glukoza`, `Fruktoza`, `Galaktoza`, `Malachoza_disacharydowa`, `Trehaloza`, `Sacharoza`, `Laktoza`, `Polisacharydy_Maltotriose`, `Maltotetraoza`, `Skrobia`, `Maltodekstryna`, `Alkohole_cukrowe_Maltitol`, `Ksylitol`,`ig_obliczony`)
 VALUES (NULL, '$nazwa', '$indeks', '$opis',  '$ID', '$Glukoza','$Fruktoza','$Galaktoza','$Malachoza_disacharydowa','$Trehaloza','$Sacharoza','$Laktoza','$Polisacharydy_Maltotriose','$Maltotetraoza','$Skrobia','$Maltodekstryna','$Alkohole_cukrowe_Maltitol','$Ksylitol', '$indeks_ob')";
/////zapytanie pobierające produkty

$polaczenie->query($SQLdodawanie);

///////////// pobieranie produktów z bazy
//$wynik= $polaczenie->query($SQLpobieranie) ;

//while($wiersz= mysqli_fetch_row($wynik)) {
       
  //      echo  $wiersz[1]." ".$wiersz[2]." ".$wiersz[3]." ".$wiersz[4]." ".$wiersz[5]."<br>";

//}
}
$polaczenie->close();

header('Location:dodawanie.php');
?>

</body>
</html>