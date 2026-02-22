<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/css/services-catalog.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <title>L&&R'S</title>
</head>

<body>
    <header class="header">
        <h1>LEO'S && RODRI'S SOLUTIONS</h1>
        <nav>
            <ul class="nav-list">
                <li><button class="button-filter" onclick="fillServices('Web')">Web</button></li>
                <li><button class="button-filter" onclick="fillServices('Backend')">Backend</button></li>
                <li><button class="button-filter" onclick="fillServices('Mobile')">Mobile</button></li>
                <li><button class="button-filter" onclick="fillServices('DevOps')">DevOps</button></li>
                <li><button class="button-filter" onclick="fillServices()">Todos</button></li>
            </ul>
        </nav>
    </header>
    <main class="grid-wrapper">
        <div class="grid-background"></div>
        <section class="content">
            <h2>Nuestros servicios son:</h2>

            <section class="cards" id="cards">
            </section>
        </section>
    </main>

    <button class="cart-toggle" onclick="toggleCart()">
        <i class="fa-solid fa-cart-shopping"></i>
    </button>

    <button class="cart-toggle list-btn" onclick="redirectList()">
        <i class="fa-solid fa-table-list"></i>
    </button>

    <aside id="shopping-cart" class="cart-sidebar">
        <div class="cart-header">
            <h3>Tu Carrito</h3>
            <button class="close-btn" onclick="toggleCart()">×</button>
        </div>

        <div class="cart-items">

        </div>

        <div class="cart-footer">
            <div class="total">
                <span>Total:</span>
                <span class="total-price">$500.00</span>
            </div>
            <button class="checkout-btn">Finalizar Compra</button>
        </div>
    </aside>

    <div id="cart-overlay" class="overlay" onclick="toggleCart()"></div>
    <div id="quote-modal" class="modal-overlay">
        <div class="modal-content">
            <h3>Ingrese sus datos</h3>

            <form id="quote-form" class="quote-grid">
                <div class="input-group">
                    <label>Nombre Completo</label>
                    <input type="text" placeholder="Ej. Rodrigo Mejía" required />
                </div>

                <div class="input-group">
                    <label>Empresa</label>
                    <input type="text" placeholder="Ej. Apple" required />
                </div>

                <div class="input-group full-width">
                    <label>Correo personal</label>
                    <input type="email" placeholder="Ej. rodrigo@ejemplo.com" required />
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-btn">Crear cotización</button>
                </div>
            </form>
        </div>
    </div>
</body>
<script src="../assets/js/services-catalog.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>