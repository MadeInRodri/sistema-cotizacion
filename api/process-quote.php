<?php
require_once '../config.php';
header('Content-Type: application/json');

$entrada = json_decode(file_get_contents('php://input'), true);

//Validaciones de Backend
if (empty($_SESSION['quote_services'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "mensaje" => "El carrito no puede estar vacío"]);
    exit;
}

$nombre = $entrada['nombre'] ?? '';
$empresa = $entrada['empresa'] ?? '';
$correo = $entrada['correo'] ?? '';

if (empty($nombre) || empty($empresa) || empty($correo)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "mensaje" => "Todos los datos del cliente son obligatorios"]);
    exit;
}

//Calcular subtotal para validación
$subtotalTemporal = 0;
foreach ($_SESSION['quote_services'] as $item) {
    $subtotalTemporal += $item->getSubtotal();
}

if ($subtotalTemporal < 100) {
    http_response_code(400);
    echo json_encode(["status" => "error", "mensaje" => "El monto mínimo para cotizar es de $100.00"]);
    exit;
}

//Crear instancia de Quote
$cotizacion = new Quote([
    'nombre' => $nombre,
    'empresa' => $empresa,
    'correo' => $correo
], $_SESSION['quote_services']);

//Guardar en el historial de la sesión
if (!isset($_SESSION['historial_cotizaciones'])) {
    $_SESSION['historial_cotizaciones'] = [];
}
$_SESSION['historial_cotizaciones'][$cotizacion->getCodigo()] = $cotizacion;

// Guardar el código actual para la redirección
$_SESSION['ultimo_codigo_cotizacion'] = $cotizacion->getCodigo();

//Vaciar carrito
$_SESSION['quote_services'] = [];

echo json_encode([
    "status" => "success", 
    "codigo" => $cotizacion->getCodigo(),
    "mensaje" => "Cotización generada exitosamente"
]);