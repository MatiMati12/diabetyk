<!DOCTYPE HTML>
<?php 
session_start();
if(!isset($_SESSION['zalogowany'])){
header('Location:index.php');
exit();
}
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
<form action="dodawanieMechanika.php" method="post">
<br><br>
<h4>Podaj informacje o produkcie</h4>
<br><br>
Nazwa produktu
<input type="text" name="nazwaProduktu">
<br><br>

Indeks glikemiczny
<input type="text" name="indeksGlikemiczny">
<br><br>

Opis produktu(max 255 znaków): <br>
<textarea name="OpisProduktu" rows="10" cols="30">
</textarea>
<br><br>
<h4>Szczegółowa zawartość cukrów na 100g produktu(podaj tylko, w momencie gdy nie znasz indeksu glikemicznego): </h4>
<br>

<table>
<tr><td>Glukoza: </td>
<td><input type="text" name="Glukoza"></td></tr>

<tr><td>Fruktoza: </td>
<td><input type="text" name="Fruktoza"></td></tr>

<tr><td>Galaktoza: </td>
<td><input type="text" name="Galaktoza"></td></tr>

<tr><td>Malachoza: </td>
<td><input type="text" name="Malachoza_disacharydowa"></td></tr>

<tr><td>Trehaloza: </td>
<td><input type="text" name="Trehaloza"></td></tr>

<tr><td>Sacharoza: </td>
<td><input type="text" name="Sacharoza"></td></tr>

<tr><td>Laktoza: </td>
<td><input type="text" name="Laktoza"></td></tr>

<tr><td>Polisacharydy: </td>
<td><input type="text" name="Polisacharydy_Maltotriose"></td></tr>

<tr><td>Maltotetraoza: </td>
<td><input type="text" name="Maltotetraoza"></td></tr>

<tr><td>Skrobia:  </td>
<td><input type="text" name="Skrobia"></td></tr>

<tr><td>Maltodekstryna: </td>
<td><input type="text" name="Maltodekstryna"></td></tr>

<tr><td>Maltitol: </td>
<td><input type="text" name="Alkohole_cukrowe_Maltitol"></td></tr>

<tr><td>Ksylitol: </td>
<td><input type="text" name="Ksylitol"></td></tr>

<table>
</br><br>
<input type="submit" value="Dodaj produkt"></tr>
</form>

<br>
</center>


</body>
</html>