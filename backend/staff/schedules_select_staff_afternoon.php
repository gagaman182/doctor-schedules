<?php
header('Access-Control-Allow-Origin: *');

include '../conn.php';



// $sql = "SELECT doc_code,concat(doc_code,'-',name) as name  from doctor
$sql = "SELECT
	schedules.uhid,
	schedules.datestart,
	schedules.department,
	schedules.doctor,
	doctor.name as doctor_name,
	schedules.doctor_level,
	type_er.name as doctor_level_name,
	schedules.shift,
	shift.name as shift_name,
	schedules.time as time
FROM
	schedules 
LEFT JOIN doctor on schedules.doctor = doctor.doc_code
LEFT JOIN type_er on schedules.doctor_level = type_er.code
LEFT JOIN shift on 	schedules.shift = shift.code
WHERE
	DATE_FORMAT( datestart, '%Y-%m-%d' ) = DATE_FORMAT(
	now(),
	'%Y-%m-%d')
  and schedules.doctor_level = 0
  and schedules.shift = 1
  and schedules.department = 'ER'
     
      ";


$return_arr = array();

if ($result = mysqli_query($conn, $sql)) {
  while ($row = mysqli_fetch_array($result)) {
    $a['uhid'] = $row['uhid'];
    $a['datestart'] = $row['datestart'];
    $a['department'] = $row['department'];
    $a['doctor'] = $row['doctor'];
    $a['doctor_name'] = $row['doctor_name'];
    $a['doctor_level'] = $row['doctor_level'];
    $a['doctor_level_name'] = $row['doctor_level_name'];
    $a['shift'] = $row['shift'];
    $a['shift_name'] = $row['shift_name'];
    $a['time2'] =  explode(', ', $row['time']);
    //แยก เอาข้างในมา
    $a['time3'] =  '[' . $a['time2'][0]  . ']';
    // แปลงเป็น json
    $a['time4'] = array_map('intval', json_decode($a['time3'], true));
    array_push($return_arr, $a);
  }
}

mysqli_close($conn);

echo json_encode($return_arr);