<?php

class Event {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function saveEvent($id_user, $title, $description, $color, $start_datetime, $end_datetime, $notification,$notificationTime) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO events (id_user, title,description,color,start_datetime,end_datetime, notification, notification_time) VALUES (:id_user,:title,:description, :color, :start_datetime, :end_datetime, :notification, :notificationTime)");
            $stmt->bindParam(':id_user', $id_user);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':color', $color);
            $stmt->bindParam(':start_datetime', $start_datetime);
            $stmt->bindParam(':end_datetime', $end_datetime);
            $stmt->bindParam(':notification', $notification);
            $stmt->bindParam(':notificationTime', $notificationTime);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function getEvents($id_user){
        try {
            $status=1;
            $stmt = $this->pdo->prepare("SELECT * FROM events WHERE status = :status and id_user=:id_user");
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id_user', $id_user);
            $stmt->execute();
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$events) {
                return []; 
            }
            return $events;
        }catch (PDOException $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }

    public function getEvent($id_user, $id_event){
        try {
            $status=1;
            $stmt = $this->pdo->prepare("SELECT * FROM events WHERE status = :status and id_event=:id_event");
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id_event', $id_event);
            $stmt->execute();
            $events = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$events) {
                return []; 
            }
            return $events;
        }catch (PDOException $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }

    public function updateEvent($id_event, $title, $description, $color, $start_datetime, $end_datetime, $notification,$notificationTime) {
        try {
            $stmt = $this->pdo->prepare("UPDATE events SET title=:title, description=:description, color=:color, start_datetime=:start_datetime, end_datetime=:end_datetime, notification=:notification, notification_time=:notificationTime,update_date=NOW() WHERE id_event=:id_event");

            $stmt->bindParam(':id_event', $id_event);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':color', $color);
            $stmt->bindParam(':start_datetime', $start_datetime);
            $stmt->bindParam(':end_datetime', $end_datetime);
            $stmt->bindParam(':notification', $notification);
            $stmt->bindParam(':notificationTime', $notificationTime);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        
        }
    }

    public function deleteEvent($id_event) {
        try {
            $status= 0; 
            $stmt = $this->pdo->prepare("UPDATE events SET status=:status WHERE id_event=:id_event");
            $stmt->bindParam(':id_event', $id_event);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        
        }
    }

}
