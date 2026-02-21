<?php
include_once '../config.php';

header('Content-Type: application/json');

$services = Service::getServices();

if ($services){
    echo json_encode([
        "status" => "success",
        "message" => "Servicios encontrados",
        "services" => $services
    ]);
}else {
    http_response_code(404);
    echo json_encode(["status" => "error", "message" => "Servicios no encontrados"]);
}