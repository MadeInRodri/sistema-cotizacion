<?php
require_once '../config.php';

//Cabecera de la petición
header('Content-Type: application/json');


$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? null;

if (!$id || !isset($_SESSION['quote_services'][$id])) {
    echo json_encode(["status" => "error", "message" => "Servicio no encontrado en la cotización"]);
    exit;
}

$service = $_SESSION['quote_services'][$id];

$name = $service->getName(); // Guardamos el nombre antes de borrarlo para el mensaje
    unset($_SESSION['quote_services'][$id]);

    echo json_encode([
        "status" => "success",
        "action" => "removed",
        "message" => "{$name} eliminado de la cotización",
        "total_unique_items" => count($_SESSION['quote_services'])
    ]);