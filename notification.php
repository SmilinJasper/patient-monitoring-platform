<?php

SESSION_START();

include 'database.php';
$array = array();
$rows = array();
$data = array();

$sql = $_SESSION['user_type'] === 'doctor' ? 'SELECT * FROM notifications WHERE doctor_id = '.$_SESSION['id'] : 'SELECT * FROM notifications WHERE doctor_id = 0 AND patient_id = '.$_SESSION['id'];
$notifList = $conn->query($sql);

foreach ($notifList as $key) {
    $data['title'] = $key['title'];
    $data['msg'] = $key['message'];
    $data['icon'] = 'img/notification.png';

    if ($key['to_user_type'] == 'doctor') {
        $data['url'] = 'view_patient.php?id=' . $key['patient_id'] . '&doctor_id=' . $key['doctor_id'];
    }

    if ($key['to_user_type'] == 'patient') {
        $data['url'] = 'view_patient.php?id=' . $key['patient_id'];
    }

    $notification_id = $key['id'];
    
    $sql = "DELETE FROM notifications WHERE id='$notification_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Medicine deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $rows[] = $data;
}

$array['notif'] = $rows;
$array['result'] = true;
echo json_encode($array);

?>