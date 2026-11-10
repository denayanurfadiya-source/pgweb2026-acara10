<?php
header('Content-Type: application/json; charset=utf-8');

$conn = new mysqli("localhost", "root", "", "latihan"); 
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => $conn->connect_error]);
    exit;
}

$result = $conn->query("SELECT ogc_fid, namobj, koor_x, koor_y, wadmkc FROM titik_perumahan");

$features = [];
while ($row = $result->fetch_assoc()) {
    $features[] = [
        "type" => "Feature",
        "geometry" => [
            "type" => "Point",
            "coordinates" => [floatval($row["koor_x"]), floatval($row["koor_y"])]  ],
        "properties" => [
            "id" => $row["ogc_fid"],
            "namobj" => $row["namobj"],
            "wadmkc" => $row["wadmkc"]
        ]
    ];
}

echo json_encode([
    "type" => "FeatureCollection",
    "features" => $features
]);
$conn->close();