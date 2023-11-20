<?php 
require_once("../config.php");
require_once("../models/Auth.php");

$pdo = connectToDatabase();
$auth = new Auth($pdo);

$email = cleanString($_POST["username"] ?? "");
$password = cleanString($_POST["password"] ?? "");

switch ($_GET["op"]) {

    case "authenticateUser":
        $response = $auth->authenticateUser($email, $password);
        echo $response;
    break;
    case 'logout':
        session_start();
        session_unset();
        
        session_destroy();
        header("Location: ../views/login.php");
    break;
} 