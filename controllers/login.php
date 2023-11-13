<?php 
require_once("../config.php");
require_once("../models/Auth.php");

$pdo = connectToDatabase();
$auth = new Auth($pdo);

$id_user =  $_SESSION['user'];
$name = $user['name'];


switch ($_GET["op"]) {

    case "getEvents":
        $response = $auth->authenticateUser($email, $password);
        echo $response;
    break;
} 