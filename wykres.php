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
echo '<center><a href="main.php"><input type="button" value="STRONA GŁÓWNA"></a>
<a href="dodawanie.php"><input type="button" value="DODAJ PRODUKT"></a>
<a href="katalog.php"><input type="button" value="UTWÓRZ POSIŁEK"></a>
<a href="symulator.php"><input type="button" value="SYMULATOR KRZYWEJ CUKROWEJ"></a>
<a href="wykres.php"><input type="button" value="WYKRES KRZYWEJ CUKROWEJ"></a>
<a href="wyloguj.php"><input type="button" value="WYLOGUJ"></a>';

echo  '<form action="wyczysc_wykres.php" method="post"><input type="submit" value="ZRESETUJ WYKRES"><input type="hidden" name="id_dodawanie" value="wyczysc"><form>';		
		
$SQLwykres = "SELECT * FROM symulacja WHERE id_usera='$id'"	;
$wynik=$polaczenie->query($SQLwykres);

$temp_i=0;
while($wiersz= mysqli_fetch_row($wynik)) {	

if($wiersz[2]<=240){
$dataPoints[$temp_i]['label'] = $wiersz[2]*0.1;
}
else{
	$dataPoints[$temp_i]['label'] = ($wiersz[2]*0.1)-24;
}
$dataPoints[$temp_i]['y'] =$wiersz[3];
	$temp_i++;
}
 
//var_dump($dataPoints);
 






echo "<br><br><br>";

 
}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	title: {
		text: "Krzywa cukrowa na przestrzeni całego dnia"
	},
	axisY: {
		title: "Poziom cukru w mg/dl"
	},
	data: [{
		type: "line",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
</center>
<body bgcolor="#99ccff">
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html> 