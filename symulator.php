<!DOCTYPE HTML>
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
	echo  '<br><form action="wyczysc_wykres.php" method="post"><input type="submit" value="ZRESETUJ WYKRES"><input type="hidden" name="id_dodawanie" value="wyczysc"><form>';
	$id=$_SESSION['idusera'];
	
	
	
	echo '<br>';
	
	$SQLposilki="SELECT DISTINCT p.id, p.nazwa, p.opis, p.ig FROM `posilki_zlozone` p, `posilki` a WHERE 
	a.id_usera=$id AND a.id_posilku=p.id";
	$wynik=$polaczenie->query($SQLposilki);
	
	echo '<table border="1"><tr><td>Usuń posiłek z bazy</td><td>Posilek</td><td>Opis</td><td>Indeks glikemiczny</td><td>Godzina</td><td></td></tr>';
while($wiersz= mysqli_fetch_row($wynik)) {
       
        
        echo  '<tr><td><form action="dodaj_sym.php" method="post">
		<center><input type="hidden" name="id_usuwanie" value="'.$wiersz[0].'">
		<input type="submit" value="usuń"></center>
		</form></td>
		<td>'.$wiersz[1].'</td><td>'.$wiersz[2].'</td><td>'.$wiersz[3].'<form action="dodaj_sym.php" method="post"><td>
	<select name="godzina">
	<option value="flaga">teraz</option>
	<option value="0">0:00</option>
	<option value="0.5">0:30</option>
	<option value="1">1:00</option>
	<option value="1.5">1:30</option>
	<option value="2">2:00</option>
	<option value="2.5">2:30</option>
	<option value="3">3:00</option>
	<option value="3.5">3:30</option>
	<option value="4">4:00</option>
	<option value="4.5">4:30</option>
	<option value="5">5:00</option>
	<option value="5.5">5:30</option>
	<option value="6">6:00</option>
	<option value="6.5">6:30</option>
	<option value="7">7:00</option>
	<option value="7.5">7:30</option>
	<option value="8">8:00</option>
	<option value="8.5">8:30</option>
	<option value="9">9:00</option>
	<option value="9.5">9:30</option>
	<option value="10">10:00</option>
	<option value="10.5">10:30</option>
	<option value="11">11</option>
	<option value="11.5">11:30</option>
	<option value="12">12:00</option>
	<option value="12.5">12:30</option>
	<option value="13">13:00</option>
	<option value="13.5">13:30</option>
	<option value="14">14:00</option>
	<option value="14.5">14:30</option>
	<option value="15">15:00</option>
	<option value="15.5">15:30</option>
	<option value="16">16:00</option>
	<option value="16.5">16:30</option>
	<option value="17">17:00</option>
	<option value="17.5">17:30</option>
	<option value="18">18:00</option>
	<option value="18.5">18:30</option>
	<option value="19">19:00</option>
	<option value="19.5">19:30</option>
	<option value="20">20:00</option>
	<option value="20.5">20:30</option>
	<option value="21">21:00</option>
	<option value="21.5">21:30</option>
	<option value="22">22:00</option>
	<option value="22.5">22:30</option>
	<option value="23">23:00</option>
	<option value="23.5">23:30</option>
	<option value="24">24:00</option>

</select>
		</td><input type="hidden" name="id_dodawanie" value="'.$wiersz[0].'">
		<td><input type="submit" value="dodaj"></td></form></td>
		</tr>';
}
echo '</table></center>';

//









}
}
$polaczenie->close();
?>

</body>
</html>