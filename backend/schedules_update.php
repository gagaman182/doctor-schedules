<?php
header('Content-Type:application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization');
$data = json_decode(file_get_contents('php://input'), true);
$uhid = $data['uhid'];
$datestart = $data['datestart'];
$department = $data['er'];
$doctor = $data['doctor'];
$doctor_level = $data['doctor_level'];
$shift = $data['shift'];
$time = $data['time'];




include 'conn.php';

$sql = "UPDATE schedules
SET datestart = '" . $datestart . "',
department = '" . $department . "',
doctor = '" . $doctor . "',
doctor_level = '" . $doctor_level . "',
shift = '" . $shift . "',
time = '" . $time . "',
dateedit = CURRENT_TIMESTAMP
WHERE uhid = '" . $uhid . "' ";





$return_arr = array();

if ($conn->query($sql) === TRUE) {


  $row_array['message'] = "แก้ไขข้อมูลสำเร็จ";
  array_push($return_arr, $row_array);
} else {
  $row_array['message'] =  "แก้ไขข้อมูลไม่สำเร็จ ";
  array_push($return_arr, $row_array);
}


mysqli_close($conn);

echo json_encode($return_arr);