<?php
$host = "localhost";
$dbname = "avansapp";
$user = "root";
$password = ""; 
try{
    
	$con = new PDO("mysql:host=$host;dbname=$dbname",$user,$password);
		echo "";
		} catch(PDOException $ex){
		echo "Verbinding mislukt!";
}