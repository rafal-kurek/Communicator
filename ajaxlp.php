<?php
$ile;

//dołączenie pliku z daanymi do logowania do bazy danych
include("tajne.php");  

//połączenie z bazą danych
try {
    $dbh = new PDO($host, $user, $passwd);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}



//dodanie wiadomości do bazy danych
if(isset($_POST['akcja']) && $_POST['akcja']=="dodaj"){
	

	$sth = $dbh->prepare('insert into polling(tresc,user,kolor,data1) values(:tresc,:user,:kolor,:data)');
	$sth->bindValue(':tresc', $_POST['tresc'], PDO::PARAM_STR);
        $sth->bindValue(':user', $_POST['user'], PDO::PARAM_STR);
         $sth->bindValue(':kolor', $_POST['kolor'], PDO::PARAM_STR);
    $sth->bindValue(':data', $_POST['czas'], PDO::PARAM_INT);
    $sth->execute();
    
    
    echo("OK");






}

//long pooling sprawdzający zmainy w bazie danych i odsyłający odpowiednią odpowiedź klientowi (plik html)
else if (isset($_POST['akcja']) && $_POST['akcja']=="poll") {
    
    $sth6 = $dbh->prepare('SELECT COUNT(*) FROM polling');
	$sth6->execute();
	$result = $sth6->fetchAll();
    $ile = $result[0][0]; 
    
 $time=time();
while(time() - $time <= 10){



	
    $sth1 = $dbh->prepare('SELECT COUNT(*) FROM polling');
	$sth1->execute();
	$result1 = $sth1->fetchAll();
    $tyle=$result1[0][0]; 


	if($tyle != $ile){

		echo("zmiana"); 
        break;
	}
 

usleep(1000);
	
}
    
    
    
}

//usuwanie starych wiadomości z bazy danych
else if(isset($_POST['akcja']) && $_POST['akcja']=="usun"){

$sth3 = $dbh->prepare('DELETE FROM `polling` WHERE data1 <= '.$_POST['od']);
	$sth3->execute();
echo("usunieto");
}



//pobranie tylko najnowszych wiadomości i wysłanie ich klientowi 
else if(isset($_POST['akcja']) && $_POST['akcja']=="up"){
    
    $sth9 = $dbh->prepare('SELECT * FROM polling WHERE data1 > '.$_POST['tutaj']);
	$sth9->execute();
	$result11 = $sth9->fetchAll();
     
    echo json_encode($result11);



}




?>
