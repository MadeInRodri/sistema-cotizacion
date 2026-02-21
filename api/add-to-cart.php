<?php
require_once '../config.php';


//Cabecera de la petición
header('Content-Type: application/json');

//Si no existe el carrito en la sesión, lo crea
if (!isset($_SESSION['quote_services'])) {
    $_SESSION['quote_services'] = [];
}

//Toma el parámetro id de la petición
$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? null;

//Si no hay id
if (!$id) {
    echo json_encode(["status" => "error", "message" => "ID no proporcionado"]);
    exit;
}

if (isset($_SESSION['quote_services'][$id])) {
    // Si ya existe, recuperamos el objeto y aumentamos su cantidad
    $currentQuantity = $_SESSION['quote_services'][$id]->getQuantity();

    //VALIDACIÓN si hay 10 o más, no lo deja pasar
    if($currentQuantity >= 10){
         http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Límite alcanzado. No puedes cotizar más de 10 unidades de este servicio."]);
    exit;
    }

    //Sino suma uno a la instancia
    $_SESSION['quote_services'][$id]->setQuantity($currentQuantity + 1);
    //Y reescribe la instancia en el session
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