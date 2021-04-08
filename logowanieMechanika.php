<!DOCTYPE HTML>
<?php
session_start();
require_once "connect.php";

?>
<html lang="pl">
<head>

<body>

<?php

$polaczenie= @new mysqli($host,$db_user,$db_password, $db_name);
if ($polaczenie->connect_errno!=0)
{
echo "Błąd połączenia";
}
else{
	
	$login=$_POST['login'];
	$haslo=$_POST['haslo'];
	$SQLzapytanie="SELECT * FROM users WHERE login='$login' AND haslo='$haslo'"; //sprawdzamy czy user istnieje
	if($rezultat=@$polaczenie->query($SQLzapytanie))
	{
	$ilu_userow= $rezultat->num_rows;
	if($ilu_userow>0)
		{  
	    $_SESSION['zalogowany']=true;  /////token, który informuje że jestesmy zalogowani
		$wiersz=$rezultat->fetch_assoc();
		$_SESSION['idusera']=$wiersz['id']; ///////id usera widoczne podczas korzystania z bazy danych
		$_SESSION['user']=$wiersz['login']; 
		$_SESSION['cukier']=$wiersz['cukier']; ; 
	
		$rezultat->close();
		echo $_SESSION['user'];
		unset($_SESSION['blad']);
		header('Location:main.php'); ///jeżeli znaleźliśmy 
		//dopasowanie(w zmiennej rezultat mamy minimum jeden rząd, to przekieruj nas do strony głównej main.php
		}
	else 
		{ ///jesli nie znajdziemy dopasoania, to wyrzuć błąd pod ekranem logowania, że podano złe dane
	$_SESSION['blad']='Nieprawidłowy login lub hasło';
	header('Location: index.php');
	
	exit();
		
		}	
		 $polaczenie->close();
	}
	

}
?>

</body>
</html>