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
	$cukier=$_SESSION['cukier'];

$SQLwyczyscWykres="UPDATE `symulacja` SET `label` = '$cukier' WHERE id_usera = $id; ";

$polaczenie->query($SQLwyczyscWykres);
header('Location:wykres.php');

}
}
$polaczenie->close();
?>

</body>
</html>