<?php
require_once '../config.php';

//Cabecera de la petición
header('Content-Type: application/json');

//El id enviado
$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? null;

//Si no hay id o no está en la sesión, mandamos mensaje
if (!$id || !isset($_SESSION['quote_services'][$id])) {
    echo json_encode(["status" => "error", "message" => "Servicio no encontrado en la cotización"]);
    exit;
}

//Sino, lo buscamos en la sesión
$service = $_SESSION['quote_services'][$id];

//Obtenemos la cantidad 
$currentQuantity = $service->getQuantity();


if ($currentQuantity > 1) {
    // Si hay más de uno, restamos -1
    $service->setQuantity($currentQuantity - 1);
    
    //Mensaje de la petición
    echo json_encode([
        "status" => "success",
        "action" => "decreased",
        "message" => "Cantidad de {$service->getName()} reducida",
        "new_quantity" => $service->getQuantity(),
        "total_unique_items" => count($_SESSION['quote_services'])
    ]);
} else {
    // Si solo hay 1, eliminamos la instancia completa del carrito
    $name = $service->getName(); // Guardamos el nombre antes de borrarlo para el mensaje
    unset($_SESSION['quote_services'][$id]);

    //Mensaje para el cliente
    echo json_encode([
        "status" => "success",
        "action" => "removed",
        "message" => "{$name} eliminado de la cotización",
        "total_unique_items" => count($_SESSION['quote_services'])
    ]);
}