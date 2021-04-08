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
	
	$godzina = $_POST['godzina'];
	
	 if($godzina=='flaga'){
	 $god=date('H')+(date('i')/60);
	 $godzina= round($god,1);
	 }
	 echo $godzina;
	$id_posilku_zlozonego=$_POST['id_dodawanie'];
	
	
	$id_posilku_zlozonego_do_usuniecia=$_POST['id_usuwanie'];
	
	if(isset($_POST['id_usuwanie'])){
	$SQLusun1="DELETE FROM posilki WHERE id_posilku='$id_posilku_zlozonego_do_usuniecia'";
	$SQLusun2="DELETE FROM posilki_zlozone WHERE id='$id_posilku_zlozonego_do_usuniecia'";
	$SQLusun3="DELETE FROM model_posilku WHERE id_posilku='$id_posilku_zlozonego_do_usuniecia'"; 
	//echo $godzina.' '.$id_posilku_zlozonego;
	
	$polaczenie->query($SQLusun1);
	$polaczenie->query($SQLusun2);
	$polaczenie->query($SQLusun3);
	
	unset($id_posilku_zlozonego_do_usuniecia);
	
	header('Location: symulator.php');
	}
	else{
$SQLmodel="SELECT * FROM `model_posilku` WHERE id_posilku=$id_posilku_zlozonego";	
	
$wynik=$polaczenie->query($SQLmodel);	

while($wiersz= mysqli_fetch_row($wynik)) {	
	$time0=$wiersz[2];
	$time30=$wiersz[3];
	$time60=$wiersz[4];
	$time90=$wiersz[5];
	$time120=$wiersz[6];
	$time150=$wiersz[7];
	$time180=$wiersz[8];
}	



$wynikkk=[];
$wyniki=[];
$argumenty=[];
$x=[];
$y=[];
for($i=1; $i<31; $i++){
	$argumenty[$i]=$i*0.1;
}
for($i=0; $i<30; $i++){
	$wyniki[$i]=0;
}


	$y[0]=0;
	$y[1]=$time30-$time0;
	$y[2]=$time60-$time0;
	$y[3]=$time90-$time0;
	$y[4]=$time120-$time0;
	$y[5]=$time150-$time0;
	$y[6]=$time180-$time0;
	

	$x[0]=0;
	$x[1]=0.5;
	$x[2]=1.0;
	$x[3]=1.5;
	$x[4]=2.0;
	$x[5]=2.5;
	$x[6]=3.0;




function interpolacja($xs, $ys, $x){
	$t=0;
	$y=0;
	$a=0;
	
	for($k=0; $k<7; $k++){
		$t=1;
		for($j=0;$j<7; $j++){
			if($j!=$k){
				$t=$t*(($x-$xs[$j])/($xs[$k]-$xs[$j]));
			}
			
		}
		$y=$y+$t*$ys[$k];
	}
$a=intval($y);
	return $a;
	
}

$przyklad=0.71;
for($i=1;$i<31;$i++){
$wynikkk[$i]= interpolacja($x,$y, $argumenty[$i]);
 
}

$cukier=$_SESSION['cukier'];


$SQLczyIstnieje="SELECT * FROM symulacja WHERE id_usera='$id'";

if($rezultat=@$polaczenie->query($SQLczyIstnieje))
	{
	$ilu_userow= $rezultat->num_rows;
	if($ilu_userow==0)
		{	
	
for($i=0;$i<271;$i++)
			{
			$a=$i;
			$zapytanie= "INSERT INTO `symulacja` (`id`, `id_usera`, `y`, `label`) VALUES (NULL, '$id', '$a', '$cukier')";
//echo $zapytanie.'<br>';
			$polaczenie->query($zapytanie);
			}	
		}
	}
	
	
	
	
$dodaj='';
for($i=1;$i<31;$i++){
	
	$a=$godzina*10+($argumenty[$i]*10);
	$b=$wynikkk[$i];
	
$dodaj= "UPDATE `symulacja` SET `label` = (`label`+$b) WHERE y = $a; ";
$polaczenie->query($dodaj);

}
//	echo $dodaj.'<br>';
	
echo '<br><br><br>'; 	
//var_dump($polaczenie);
header('Location: wykres.php');
}
}
}
$polaczenie->close();
?>

</body>
</html>