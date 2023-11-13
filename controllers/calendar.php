<?php 
require_once("../config.php");
require_once("../models/Auth.php");

$pdo = connectToDatabase();
$auth = new Auth($pdo);

$email = cleanString($_POST["username"] ?? "");
$password = cleanString($_POST["password"] ?? "");


switch ($_GET["op"]) {

    case "getEvents":
        $events = [
            [
                'id' => 1,
                'title' => 'Evento 1',
                'start_datetime' => '2023-11-20T10:00:00',
                'end_datetime' => '2023-11-20T12:00:00',
                'color' => '#FF5733',
                'description' => 'Descripción del Evento 1',
            ],
            [
                'id' => 2,
                'title' => 'Evento 2',
                'start_datetime' => '2023-11-21T14:00:00',
                'end_datetime' => '2023-11-21T16:00:00',
                'color' => '#33FF57',
                'description' => 'Descripción del Evento 2',
            ],
            // Agrega más eventos según sea necesario
        ];

        // Devuelve los eventos en formato JSON
        echo json_encode($events);
    break;
} 