<?php

header('Content-Type: application/json');
include '../inc/config.php';

if (mysqli_connect_errno($db)) {
    echo "Failed to connect to DataBase: " . mysqli_connect_error();
} else {
    $data_points = array();
    $result = mysqli_query($db, "SELECT * FROM `movimientosaldo` where `movimientosaldo`.`tipo_mmovimiento`='entrada' "); 
    while ($row = mysqli_fetch_array($result)) {
        $point = array("valorx" => $row['fecha_msaldo'], "valory" => $row['cantida_msaldo']);
        array_push($data_points, $point);
    }
    echo json_encode($data_points);
}
mysqli_close($db);


?>
