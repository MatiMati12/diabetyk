<!DOCTYPE HTML>
<html lang="pl">
<head>

<body>
<?php 
session_start();
if(!isset($_SESSION['zalogowany'])){
header('Location:index.php');
exit();
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

$SQLpokazPosilkiZlozone=" SELECT DISTINCT pz.id, pz.nazwa, pz.opis, pz.ig FROM posilki_zlozone pz, posilki p WHERE p.id_usera=$id AND p.id_posilku=pz.id";

$wynik= $polaczenie->query($SQLpokazPosilkiZlozone);

echo '<table border="1"><tr><td>Nazwa posilku</td><td>opis</td><td>Ind. glik.</td><td>Poz. cukru przed</td><td>P. c. 30 minut po</td><td>P. c. 60 minut po</td><td>P. c. 90 minut po</td><td>P. c. 150 minut po</td><td></td></tr>';
while($wiersz= mysqli_fetch_row($wynik)) {
       
        echo  '<tr><td>'.$wiersz[1].'</td><td>'.$wiersz[2].'</td><td>'.$wiersz[3].'</td>
		<form action="button_danePosilkow.php" method="get">
		<td><input type="text" name="time0" size="5"></td>
		<td><input type="text" name="time30" size="5"></td>
		<td><input type="text" name="time60" size="5"></td>
		<td><input type="text" name="time90" size="5"></td>
		<td><input type="text" name="time150" size="5"></td>
		<input type="hidden" name="id_dodawanie" value="'.$wiersz[0].'"><td><input type="submit" value="Jem"></td></form></tr>';
		////Przekazujemy do pliku dodaj_button_kagtalog inromację o tym który z wyszukanych produktów mamy dodać do naszego posiłku
}
echo '</table>';

$polaczenie->close();

}
}
?>

</body>
</html>