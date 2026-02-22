<?php require_once '../config.php'; ?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/css/services-catalog.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <title>Historial de Cotizaciones</title>
</head>
<body>
    <header class="header">
        <h1>HISTORIAL DE COTIZACIONES</h1>
        <nav>
            <ul class="nav-list">
                <li><a href="service-catalog.php" class="button-filter" style="text-decoration:none">Nuevo Catálogo</a></li>
            </ul>
        </nav>
    </header>
    <main class="grid-wrapper">
        <div class="grid-background"></div>
        <section class="content">
            <div class="table-card">
                <div class="table-header">
                    <h2>Clientes y Cotizaciones</h2>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Cliente</th>
                                <th>Empresa</th>
                                <th>Fecha</th>
                                <th class="text-right">Total</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($_SESSION['historial_cotizaciones']) && !empty($_SESSION['historial_cotizaciones'])): ?>
                                <?php foreach (array_reverse($_SESSION['historial_cotizaciones']) as $coti): 
                                    $cli = $coti->getCliente(); ?>
                                <tr>
                                    <td class="font-mono"><?php echo $coti->getCodigo(); ?></td>
                                    <td><?php echo $cli['nombre']; ?></td>
                                    <td><?php echo $cli['empresa']; ?></td>
                                    <td><?php echo $coti->getFecha(); ?></td>
                                    <td class="text-right font-mono"><strong>$<?php echo number_format($coti->getTotal(), 2); ?></strong></td>
                                    <td>
                                        <a href="view-table-quote.php?codigo=<?php echo $coti->getCodigo(); ?>" class="badge" style="text-decoration:none">
                                            <i class="fa-solid fa-eye"></i> Ver Detalle
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="text-align:center; padding: 2rem;">No hay cotizaciones registradas aún.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
</body>
</html>