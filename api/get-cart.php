<?php
require_once '../config.php';
header('Content-Type: application/json');

// Verificamos si hay algo en el carrito
$cart = $_SESSION['quote_services'] ?? [];

// Calculamos el total general antes de enviar
$totalGeneral = 0;
foreach ($cart as $service) {
    $totalGeneral += $service->getSubtotal();
}

echo json_encode([
    "status" => "success",
    "cart" => array_values($cart),
    "total_general" => $totalGeneral,
    "items_count" => count($cart)
]);