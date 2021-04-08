<!DOCTYPE HTML>
<?php 
session_start();
?>
<html lang="pl">
<head>

<body>

<?php
unset($_SESSION['zalogowany']);
header('Location:index.php');
?>

</body>
</html>