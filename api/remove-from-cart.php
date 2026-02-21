<?php
require_once '../config.php';

//Cabecera de la petición
header('Content-Type: application/json');

//id
$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? null;

//Si no hay id o no existe en sesión, aviso
if (!$id || !isset($_SESSION['quote_services'][$id])) {
    echo json_encode(["status" => "error", "message" => "Servicio no encontrado en la cotización"]);
    exit;
}

//sino lo traemos
$service = $_SESSION['quote_services'][$id];

$name = $service->getName(); // Guardamos el nombre antes de borrarlo para el mensaje
    //Eliminamos de la sesión
    unset($_SESSION['quote_services'][$id]);

    //Aviso al cliente
    echo json_encode([
        "status" => "success",
        "action" => "removed",
        "message" => "{$name} eliminado de la cotización",
        "total_unique_items" => count($_SESSION['quote_services'])
    ]);