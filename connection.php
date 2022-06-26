<?php

$server = 'localhost';
$username = 'id19156597_adminbengkalis';
$password = "*4rH{BVB%pQw6^DE";
$db = "id19156597_rental_mobil";

$response = [];

try{
    $dbConnection = mysqli_connect($server,$username,$password,$db) ;

} catch(Exception $exception) {
    $response['message'] = 'Error';
}
