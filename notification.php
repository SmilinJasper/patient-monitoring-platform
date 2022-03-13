<?php

// Start session to be able to access session variables

SESSION_START();

// Include database connection

include 'database.php';
$array = array();
$rows = array();
$data = array();
$_SESSION['notification_ids'] = array();

// Select all notifications for user

$sql = $_SESSION['user_type'] === 'doctor' ? 'SELECT * FROM notifications WHERE doctor_id = '.$_SESSION['id'] : 'SELECT * FROM notifications WHERE doctor_id IS NULL AND patient_id = '.$_SESSION['id'];
$notifList = $conn->query($sql);

// Send notifications to javascript

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

    array_push($_SESSION['notification_ids'], $key['id']);
    
    $rows[] = $data;
}

$array['notif'] = $rows;
$array['result'] = true;
echo json_encode($array);

?>