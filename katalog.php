<!DOCTYPE HTML>
<?php
 
session_start();
if(!isset($_SESSION['zalogowany'])){
header('Location:index.php');
exit();
}

require_once "connect.php";

?>
<html lang="pl">
<head>

<body bgcolor="#99ccff">
<center>
<a href="main.php"><input type="button" value="STRONA GŁÓWNA"></a>
<a href="dodawanie.php"><input type="button" value="DODAJ PRODUKT"></a>
<a href="katalog.php"><input type="button" value="UTWÓRZ POSIŁEK"></a>
<a href="symulator.php"><input type="button" value="SYMULATOR KRZYWEJ CUKROWEJ"></a>
<a href="wykres.php"><input type="button" value="WYKRES KRZYWEJ CUKROWEJ"></a>
<a href="wyloguj.php"><input type="button" value="WYLOGUJ"></a>

<br><br>
<form method="post">
Nazwa szukanego produktu
<input type="text" name="co">
<input type="submit" value="szukaj"><br>
</form>
<?php

if(isset($_SESSION['komunikat_usuniecie'])){
echo '<h2>'.$_SESSION['komunikat_usuniecie'].'</h2>';
$_SESSION['komunikat_usuniecie']="";
}


$polaczenie= @new mysqli($host,$db_user,$db_password, $db_name);
if ($polaczenie->connect_errno!=0)
{
echo "Błąd połączenia";
}
else{

if(isset($_POST['co'])){
$prod = $_POST['co'];


$id=$_SESSION['idusera'];
//////wyszukujemy te produkty które dodał admin (id wlasciciela to null), lub te które dodał sam użytkownik
	$SQLszukanie="SELECT * FROM produkty WHERE nazwa LIKE '$prod%' AND (`id_wlasc`='$id' OR `id_wlasc` IS NULL)";

///////////// pobieranie produktów z bazy
$wynik= $polaczenie->query($SQLszukanie) ;
$ileWyn=$wynik->num_rows;
if($ileWyn>0){
	echo '<table border="1" bgcolor="#99ff66"><tr><td>Nazwa produktu</td><td>Indeks glikemiczny</td><td>Opis produktu/wskazówka</td><td>Opis produktu/wskazówka</td><td></td><td></td><td></td></tr>';
while($wiersz= mysqli_fetch_row($wynik)) {
       
        echo  '<tr><td>'.$wiersz[1].'</td><td>';
		if($wiersz[2]>0){echo $wiersz[2];}else{echo $wiersz[17];}
		echo '</td><td>'.$wiersz[3].'</td><td>'.$wiersz[4].'</td><form action="button_katalog.php" method="get"><td><input type="text" name="ilosc"><input type="hidden" name="id_dodawanie" value="'.$wiersz[0].'"></td><td><input type="submit" value="dodaj"></td></form>
		<form action="button_katalog.php" method="get"><input type="hidden" name="usun_z_bazy" value="'.$wiersz[0].'"></td><td><input type="submit" value="usuń"></td></form>
		</tr>';
		////Przekazujemy do pliku dodaj_button_kagtalog inromację o tym który z wyszukanych produktów mamy dodać do naszego posiłku
}
echo '</table>';
}
else
{
echo "Brak wyników wyszukiwania, spróbuj jeszcze raz!";	
}
}


////////////////POBIERANIE WSZYSTKICH PRODUKTÓW Z KATALOFU NALEŻĄCYCH DO USERA LUB DODANYCH PRZEZ ADMINA
echo "<br><br>";  
$id=$_SESSION['idusera'];
$SQLpobieranie="SELECT * FROM produkty WHERE `id_wlasc`='$id' OR `id_wlasc` IS NULL ORDER BY nazwa ASC";
$wynik2= $polaczenie->query($SQLpobieranie);
echo '<table border="1" bgcolor="#99ffcc"><tr><td>Nazwa produktu</td><td>Indeks glikemiczny</td><td>Opis produktu/wskazówka</td><td>ilość<td></td></td></tr>';
while($wiersz= mysqli_fetch_row($wynik2)) {
       
        
        echo  '<tr><td>'.$wiersz[1].'</td><td>';
		if($wiersz[2]>0){echo $wiersz[2];}else{echo $wiersz[18];}
		echo '</td><td>'.$wiersz[3].'</td><form action="button_katalog.php" method="get"><td><input type="text" name="ilosc"><input type="hidden" name="id_dodawanie" value="'.$wiersz[0].'"></td><td><input type="submit" value="dodaj"></td></form>
		<form action="button_katalog.php" method="get"><input type="hidden" name="usun_z_bazy" value="'.$wiersz[0].'"></td><td><input type="submit" value="usuń"></td></form>
		</tr>';
}
echo '</table>';
//////////////////////////////////////////////////

echo '</br><h1>Kreator posiłków:</h1></br>';
/////////////////////////////////////////////////////////////
///Wyświetlamy pozycje które dodał użytkownik
$SQLjadlospis="SELECT p.nazwa,p.indeks,p.opis,j.id, @row_num:=@row_num+1 as 'Num', p.id, j.ilosc, p.ig_obliczony
FROM
`produkty` p, users u, jadlospis_temp j JOIN (SELECT @row_num := 0 FROM DUAL) as sub
WHERE 
j.id_usera=u.id
AND
j.id_produktu=p.id
AND
j.id_usera='$id'";
$i=0;
$tablica = array();
$wynik3= $polaczenie->query($SQLjadlospis);
echo '<table border="1" bgcolor="#ccffcc"><tr><td>Nazwa produktu</td><td>Indeks glikemiczny</td><td>Opis produktu/wskazówka</td><td>Waga(g)</td><td></td></tr>';
while($wiersz= mysqli_fetch_row($wynik3)) {
        ///tworzymy tablicę która przechowuje nasze zmienne - wiersz6 to id produktu, natomiast wiersz7 to waga którą podał użytkownik.
		$tablica[$wiersz[4]]['id']=$wiersz[5]; ///czym jest wiersz[5]? jest to numer wiersza wyniku. Nie możemy wstawiać tam dowolnej wartości (np $j), ponieważ przy usuwaniu wasrtości z tablicy nie wiedzielibysmy co usuwać (po usunięciu jednego produktu , indeksy nie zmieniają się!!!!)
		$tablica[$wiersz[4]]['waga']=$wiersz[6];
		$tablica[$wiersz[4]]['ig']=$wiersz[1];
	
		$i++;	
        echo '<tr><td>'.$wiersz[0]."</td><td>";
		if($wiersz[1]>0){echo $wiersz[1];}else{echo $wiersz[7];}
		echo "</td><td>".$wiersz[2]."</td><td>".$wiersz[6].'</td><td><a href="button_katalog.php?id_usuwanie='.$wiersz[3].'?iddd='.$wiersz[4].'">USUŃ</a></td></tr>';
///wyświetlamy to co dodał użytkownik wraz z buttonem "USUŃ" odpowiedzialnym za usunięcie zbędnej pozycji, np jesli użytkownik się pomyli i doda jakiś produkt przez pomyłkę. plik button_katalog obsługuje to zdarzenie i usuwa z tymczasowej tabelki nasz prodkukt
}
unset($i);
echo '</table>';


if(isset($_SESSION['doUsunieciaZKatalogu'])){
	unset($tablica[$_SESSION['doUsunieciaZKatalogu']]['id']);
	unset($_SESSION['doUsunieciaZKatalogu']);
}

$SQLidposilku="SELECT id FROM posilki_zlozone ORDER BY id DESC limit 1";
$wynik10= $polaczenie->query($SQLidposilku);

$wiersz= mysqli_fetch_row($wynik10);

if($wiersz[0]==NULL){
$_SESSION['id_DoBazy']=1;
$id_do_bazy=$_SESSION['id_DoBazy'];
}	
else{

$_SESSION['id_DoBazy'] = $wiersz[0]+1;
$id_do_bazy=$_SESSION['id_DoBazy'];
echo $_SESSION['id_DoBazy'];
}


$SQLfinalneDodanie="INSERT INTO `posilki` (`id`,`id_posilku`, `id_produktu`, `id_usera`, `ilosc`, `data`) VALUES" ;
$l=0;
$indeksy_do_bazy=[];
$ilosc_do_bazy=[];
foreach($tablica as $v1){
	
////	echo $v1['id'].'<br>';
///	echo $v1['waga'].'<br><br><br>';
 	$SQLfinalneDodanie=$SQLfinalneDodanie."(NULL, ".$id_do_bazy.",".$v1['id'].",".$id.",".$v1['waga'].", current_timestamp()),";
	$indeksy_do_bazy[$l]=$v1['id'];
	$ilosc_do_bazy[$l]=$v1['waga'];
	$l++;
}
$_SESSION['indeksy_do_bazy']=$indeksy_do_bazy;
$_SESSION['ilosc_do_bazy']=$ilosc_do_bazy;
$dlugosc=strlen($SQLfinalneDodanie); ///dlugosc naszego zapytanie select (dużego inserta)
$SQLfinalneDodanie[$dlugosc-1]=" ";


///usuwamy ostatni znak, którym jest przecinek (widac  to w foreachu)
if(isset($_SESSION['flaga'])){   ////dodawanie jedzenia do naszej historii dnia
	
	
	
	unset($_SESSION['flaga']);
}

echo '<br>';

		////Przekazujemy do pliku dodaj_button_kagtalog inromację o tym który z wyszukanych produktów mamy dodać do naszego posiłku

echo 'Podaj nazwę twojego posiłku';
echo '<form action="button_katalog.php" method="post"><input type="hidden" name="dodaniePosilku" value="'.$SQLfinalneDodanie.'"><input type="text" name="nazwa_posilku">
</br>Dodaj opis posiłku:</br>
<textarea name="opis_posilku" rows="10" cols="30"></textarea></br>
<table border="1"><tr><td>Poz. cukru przed</td><td>P. c. 30 minut po</td><td>P. c. 60 minut po</td><td>P. c. 90 minut po</td><td>P. c. 120 minut po</td><td>P. c. 150 minut po</td><td>P. c. 180 minut po</td></tr><tr>
		<td><input type="text" name="time0" size="5"></td>
		<td><input type="text" name="time30" size="5"></td>
		<td><input type="text" name="time60" size="5"></td>
		<td><input type="text" name="time90" size="5"></td>
		<td><input type="text" name="time150" size="5"></td>
		<td><input type="text" name="time300" size="5"></td>
		<td><input type="text" name="time500" size="5"></td>
		<input type="hidden" name="id_dodawanie" value="'.$id_do_bazy.'"></tr></table>
		<input type="submit" value="Dodaj posiłek"></form></center>';
		
		
$_SESSION['ile_w_tablicy']=count($tablica);
	
$polaczenie->close();
}

?>

</body>
</html>