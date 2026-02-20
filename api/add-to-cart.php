<?php
require_once '../config.php';


//Cabecera de la petición
header('Content-Type: application/json');

//Si no existe el carrito en la sesión, lo crea
if (!isset($_SESSION['quote_services'])) {
    $_SESSION['quote_services'] = [];
}

$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? null;

if (!$id) {
    echo json_encode(["status" => "error", "message" => "ID no proporcionado"]);
    exit;
}

if (isset($_SESSION['quote_services'][$id])) {
    // Si ya existe, recuperamos el objeto y aumentamos su cantidad
    $currentQuantity = $_SESSION['quote_services'][$id]->getQuantity();

    $_SESSION['quote_services'][$id]->setQuantity($currentQuantity + 1);
    
    $service = $_SESSION['quote_services'][$id];
} else {
    // Si no existe, lo buscamos y lo agregamos por primera vez
    $service = Service::findById($id);
    if ($service) {
        $_SESSION['quote_services'][$id] = $service;
    }
}

if ($service) {
    echo json_encode([
        "status" => "success",
        "message" => "Cantidad de {$service->getName()} actualizada: {$service->getQuantity()}",
        "total_unique_items" => count($_SESSION['quote_services'])
    ]);
} else {
    http_response_code(404);
    echo json_encode(["status" => "error", "message" => "Servicio no encontrado"]);
}

?>