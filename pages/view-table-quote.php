<?php 
require_once '../config.php';

// Obtener la cotización por código de la URL o la última generada
$codigo = $_GET['codigo'] ?? $_SESSION['ultimo_codigo_cotizacion'] ?? null;
$cotizacion = (isset($_SESSION['historial_cotizaciones'][$codigo])) ? $_SESSION['historial_cotizaciones'][$codigo] : null;

if (!$cotizacion) {
    header("Location: service-catalog.php");
    exit;
}

$cliente = $cotizacion->getCliente();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/css/services-catalog.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <title>Detalle de Cotización - <?php echo $cotizacion->getCodigo(); ?></title>
</head>

<body>
    <header class="header">
        <h1>DETALLE DE SU COTIZACIÓN</h1>
        <nav>
            <ul class="nav-list">
                <li><a href="service-catalog.php" class="button-filter" style="text-decoration:none">Volver al Catálogo</a></li>
                <li><a href="view-quotes.php" class="button-filter" style="text-decoration:none">Ver Historial</a></li>
            </ul>
        </nav>
    </header>
    <main class="grid-wrapper">
        <div class="grid-background"></div>
        <section class="content">
            <section class="products-view">
                <div class="table-card">
                    <div class="table-header">
                        <h2><?php echo "{$cliente['nombre']} - {$cliente['empresa']}"; ?></h2>
                        <p><strong>Código:</strong> <?php echo $cotizacion->getCodigo(); ?> | <strong>Vence:</strong> <?php echo $cotizacion->getFechaVencimiento(); ?></p>
                    </div>

                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Servicio</th>
                                    <th>Categoría</th>
                                    <th class="text-right">Cantidad</th>
                                    <th class="text-right">Precio Unit.</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cotizacion->getItems() as $item): ?>
                                <tr>
                                    <td data-label="Servicio">
                                        <strong><?php echo $item->getName(); ?></strong><br>
                                        <small><?php echo $item->getDescription(); ?></small>
                                    </td>
                                    <td data-label="Categoría">
                                        <span class="badge <?php echo strtolower($item->getCategory()); ?>">
                                            <?php echo $item->getCategory(); ?>
                                        </span>
                                    </td>
                                    <td data-label="Cantidad" class="text-right"><?php echo $item->getQuantity(); ?></td>
                                    <td data-label="Precio" class="text-right font-mono">$<?php echo number_format($item->getPrice(), 2); ?></td>
                                    <td data-label="Subtotal" class="text-right font-mono">$<?php echo number_format($item->getSubtotal(), 2); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="totals-container">
                        <div class="totals-wrapper">
                            <div class="total-row">
                                <span>Subtotal</span>
                                <span>$<?php echo number_format($cotizacion->getSubtotal(), 2); ?></span>
                            </div>
                            <div class="total-row">
                                <span>Descuento Aplicado</span>
                                <span>-$<?php echo number_format($cotizacion->getDescuento(), 2); ?></span>
                            </div>
                            <div class="total-row">
                                <span>IVA (13%)</span>
                                <span>$<?php echo number_format($cotizacion->getImpuesto(), 2); ?></span>
                            </div>
                            <div class="total-row grand-total">
                                <span>Total Final</span>
                                <span class="price-highlight">$<?php echo number_format($cotizacion->getTotal(), 2); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </main>
</body>
</html>