<?php
$mysqli = new mysqli("localhost", "root", "", "pet_health");

$records = [];

function fetchAll($mysqli, $table, $type) {
    $res = $mysqli->query("SELECT * FROM $table ORDER BY record_date DESC, record_time DESC");
    $data = [];
    while ($row = $res->fetch_assoc()) {
        $row['type'] = $type;
        $data[] = $row;
    }
    return $data;
}

$records = array_merge(
    fetchAll($mysqli, 'weight_logs', 'weight'),
    fetchAll($mysqli, 'vaccinations', 'vaccination'),
    fetchAll($mysqli, 'symptoms', 'symptom')
);

echo json_encode($records);
?>
