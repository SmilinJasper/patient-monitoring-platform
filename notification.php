<?php
SESSION_START();
include ('Push.php');
$push = new Push();
$array=array();
$rows=array();
$notifList = $push->listNotificationUser($_SESSION['username']);
$record = 0;
foreach ($notifList as $key) {
$data['title'] = $key['title'];
$data['msg'] = $key['notif_msg'];
$data['icon'] = 'img/notification.png';

if($key['user_type'] =='doctor') {
    $data['url'] = 'view_patient.php?id=' . $key['patient_id'] . '&doctor_id=' . $key['doctor_id'];
}

if($key['user_type'] =='patient') {
    $data['url'] = 'view_patient.php?id=' . $key['patient_id'];
}

$rows[] = $data;
$nextime = date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s'))+($key['notif_repeat']*60));
$push->updateNotification($key['id'],$nextime);
$record++;
}
$array['notif'] = $rows;
$array['count'] = $record;
$array['result'] = true;
echo json_encode($array);
?>