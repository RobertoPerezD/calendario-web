<?php 
session_start();

require_once("../config.php");
require_once("../models/Event.php");

$pdo = connectToDatabase();
$event = new Event($pdo);

$id_user = isset ($_SESSION['id_user']) ? $_SESSION['id_user'] : "" ;
$name = isset($user['name']) ? $user['name'] : "";
$title = cleanString($_POST["title"] ?? "");
$description = cleanString($_POST["description"] ?? "");
$color = cleanString($_POST["color"] ?? "");
$start_datetime = cleanString($_POST["start_datetime"] ?? "");
$end_datetime = cleanString($_POST["end_datetime"] ?? "");
$notification = cleanString($_POST["notification"] ?? "");
$notificationTime = cleanString($_POST["notification_time"] ?? "");

$id_event = cleanString($_POST["id_event"] ?? "");

switch ($_GET["op"]) {
    case 'saveEvent':
        if(empty($id_event)){
            $response = $event->saveEvent($id_user, $title, $description, $color, $start_datetime, $end_datetime, $notification, $notificationTime);
            echo $response ? "Evento guardado exitosamente" : "No se pudo guardar";
        }else{
            $response = $event->updateEvent($id_event, $title, $description, $color, $start_datetime, $end_datetime, $notification, $notificationTime);
            echo $response ? "Datos actualizados exitosamente" : "No se pudo actualizar";
        }
    break;
    case 'getEvents':
        $data = array();
        $response = $event->getEvents($id_user);
        foreach ($response as $value){
           $data[] = array(
                "id" => $value['id_event'],
                "title" =>$value['title'],
                "start_datetime" => $value['start_datetime'],
                "end_datetime" => $value['end_datetime'],
                "color" => $value['color'],
                "description" => $value['description'],
           );
        }
        
    echo json_encode($data);
    break;
    case 'getEvent':
        $data = array();
        $response = $event->getEvent($id_user, $id_event);
        echo json_encode($response);
    break;
    case 'deleteEvent':
        $response = $event->deleteEvent($id_event);
        echo $response ? "Evento eliminado correctamente" : "No se pudo no eliminar";
    break;
    case 'getUpcomingEvents':
        $data = array();
        $response = $event->getUpcomingEvents($id_user);
        
        break;
}