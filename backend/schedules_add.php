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



  $strvisit  = "  INSERT INTO schedules(uhid,datestart,department,doctor,doctor_level,shift,time,dateadd) 
      VALUES('" . $uhid . "','" . $datestart . "','" . $department . "','" . $doctor . "','" . $doctor_level . "','" . $shift . "','" . $time . "',CURRENT_TIMESTAMP)";


  if ($conn->query($strvisit) === TRUE) {


    $return_message = array();
    $row_array['message'] = "เพิ่มข้อมูลสำเร็จ";
    array_push($return_message, $row_array);
  } else {
    // echo "Error: " . $sql . "<br>" . $conn->error;
    $return_message = array();
    $row_array['message'] = "เพิ่มข้อมูลไม่สำเร็จ";
    array_push($return_message, $row_array);
  }
}

mysqli_close($conn);

echo json_encode($return_message);