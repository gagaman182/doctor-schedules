<?php
header('Content-Type:application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization');
$data = json_decode(file_get_contents('php://input'), true);
$uhid = $data['uhid'];
$datestart = $data['datestart'];
$department = $data['department'];
$doctor = $data['doctor'];
$doctor_level = $data['doctor_level'];
$shift = $data['shift'];
$time = $data['time'];

include 'conn.php';
if (!empty($uhid)) {
  //เช้า
  if ($shift == '0' && $department == 'ER') {
    $dateplus = $datestart;
    $sql = "UPDATE schedules
SET datestart = DATE_FORMAT('" . $dateplus . "','%Y-%m-%d 08:31:00'),
department = '" . $department . "',
doctor = '" . $doctor . "',
doctor_level = '" . $doctor_level . "',
shift = '" . $shift . "',
time = '" . $time . "',
dateedit = CURRENT_TIMESTAMP
WHERE uhid = '" . $uhid . "' ";
  }
  //บ่าย
  else if ($shift == '1' && $department == 'ER') {
    $dateplus = $datestart;
    $sql = "UPDATE schedules
SET datestart = DATE_FORMAT('" . $dateplus . "','%Y-%m-%d 16:30:00'),
department = '" . $department . "',
doctor = '" . $doctor . "',
doctor_level = '" . $doctor_level . "',
shift = '" . $shift . "',
time = '" . $time . "',
dateedit = CURRENT_TIMESTAMP
WHERE uhid = '" . $uhid . "' ";
  }
  //ดึก
  else if ($shift == '2' && $department == 'ER') {
    $dateplus = date('Y-m-d', strtotime($datestart . ' + 1 days'));
    $sql = "UPDATE schedules
SET datestart = DATE_FORMAT('" . $dateplus . "','%Y-%m-%d 08:30:00'),
department = '" . $department . "',
doctor = '" . $doctor . "',
doctor_level = '" . $doctor_level . "',
shift = '" . $shift . "',
time = '" . $time . "',
dateedit = CURRENT_TIMESTAMP
WHERE uhid = '" . $uhid . "' ";
  }
  //ในเวลา
  else if ($shift == '0' && $department != 'ER') {
    $dateplus = $datestart;
    $sql = "UPDATE schedules
SET datestart = DATE_FORMAT('" . $dateplus . "','%Y-%m-%d 08:31:00'),
department = '" . $department . "',
doctor = '" . $doctor . "',
doctor_level = '" . $doctor_level . "',
shift = '" . $shift . "',
time = '" . $time . "',
dateedit = CURRENT_TIMESTAMP
WHERE uhid = '" . $uhid . "' ";
  }
  //นอกเวลา
  else if ($shift == '1' && $department != 'ER') {
    $dateplus = date('Y-m-d', strtotime($datestart . ' + 1 days'));
    $sql = "UPDATE schedules
SET datestart = DATE_FORMAT('" . $dateplus . "','%Y-%m-%d 08:30:00'),
department = '" . $department . "',
doctor = '" . $doctor . "',
doctor_level = '" . $doctor_level . "',
shift = '" . $shift . "',
time = '" . $time . "',
dateedit = CURRENT_TIMESTAMP
WHERE uhid = '" . $uhid . "' ";
  }
}







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