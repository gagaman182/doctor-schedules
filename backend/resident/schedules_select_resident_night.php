<?php
header('Content-Type:application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization');


include '../conn.php';

$data = json_decode(file_get_contents('php://input'), true);
//$datastart = '2022-05-19';
$datastart = $data['datastart'];



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

  	DATE_FORMAT( datestart, '%Y-%m-%d %H:%i:%s' )
     BETWEEN 		DATE_FORMAT('" . $datastart . "','%Y-%m-%d 08:31:00')
      and 	DATE_FORMAT(DATE_ADD('" . $datastart . "', INTERVAL 1 DAY),'%Y-%m-%d 08:30:00')

and schedules.doctor_level = 1
   and schedules.shift = 2
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