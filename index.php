<!DOCTYPE HTML>
<?php 
session_start();
if(isset($_SESSION['zalogowany'])){
header('Location:main.php');

}
?>
<html lang="pl">
<head>

<body>


<br>
<form action="logowanieMechanika.php" method="post">
Login:<input type="text" name="login"><br>
Hasło:<input type="text" name="haslo"><br>
<input type="submit" value="Zaloguj"><br>
</form>
<?php
if(isset($_SESSION['blad'])){
echo $_SESSION['blad'];}
?>

</body>
</html>