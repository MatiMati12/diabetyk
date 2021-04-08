

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

<a href="main.php"><input type="button" value="STRONA GŁÓWNA"></a>
<a href="dodawanie.php"><input type="button" value="DODAJ PRODUKT"></a>
<a href="katalog.php"><input type="button" value="UTWÓRZ POSIŁEK"></a>
<a href="symulator.php"><input type="button" value="SYMULATOR KRZYWEJ CUKROWEJ"></a>
<a href="wykres.php"><input type="button" value="WYKRES KRZYWEJ CUKROWEJ"></a>
<a href="wyloguj.php"><input type="button" value="WYLOGUJ"></a>
<br><br>
<?php

if(isset($_SESSION['user'])){
echo "<h1>Witaj ".$_SESSION['user']."!!!</h1>";
header('Location: symulator.php');
}
else 
{
	header('Location: index.php');
}

/* $tab1=[];
$tab2=[];
$tab3=[];

for($i=1;$i<21;$i++)
{
	$tab1[$i]['y']=5+$i*0.1;
	$tab1[$i]['label']=$i*1.5;
}

for($i=1;$i<21;$i++)
{
	$tab2[$i]['y']=6+$i*0.1;
	$tab2[$i]['label']=$i*1.75;
}

for($i=1;$i<21;$i++)
{
	$tab3[$i]['y']=10+$i*0.1;
	$tab3[$i]['label']=$i*1.33;
	
}
$tab23=[];

echo $tab3[1]['y']-$tab2[20]['y'];
if($tab3[1]['y']-$tab2[20]['y']>2)
{
$przedzial=$tab3[1]['y']-$tab2[20];
for($i=1;$i<$przedzial*10+1;$i){
	$tab23[$i]['y']=$tab2[20]+$i*0.1;
	$tab23[$i]['label']=0;
	

}
	
}
echo '<br>';
var_dump($tab23);
echo '<br>'; 

echo '<br>';
var_dump($tab2);

echo '<br><br><br>';

for($j=1;$j<21;$j++){
	for($i=1;$i<21;$i++)
	{
	//echo $tab1[$i]['y'].' '.$tab2[$j]['y'].'<br>';	
	if($tab1[$i]['y']==$tab2[$j]['y']){
	$tab2[$j]['label']=	$tab2[$j]['label']+$tab1[$i]['label'];}
	}
}

var_dump($tab2); */


?>

</body>
</html>