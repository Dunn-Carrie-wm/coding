<?php
$username = 'root';
$password = 'root';

try{
    $dbh = new PDO("mysql:host=localhost;dbname=coding", $username, $password);
    $dbh-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    print "Connection failed: ". $e->getMessage();
    die();
}




$query ="SELECT * FROM employee";
$stmt = $dbh->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll();



