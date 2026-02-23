# Sistema de Cotizaciones - Web Services

Este módulo es una solución integral para la gestión de servicios técnicos y profesionales, permitiendo a los usuarios navegar por un catálogo dinámico, gestionar un carrito de compras y generar cotizaciones formales con cálculos automatizados de impuestos y descuentos.

---

## Tecnologías Utilizadas

- Backend: PHP 8.x (Programación Orientada a Objetos - POO).
- Frontend: JavaScript (Fetch API, ES6+), HTML5, CSS3.
- Almacenamiento: Sesiones de PHP ($\_SESSION) para persistencia de datos y sessionStorage para caché de servicios.
- Componentes Externos:
  - SweetAlert2: Notificaciones y alertas interactivas.
  - FontAwesome 6: Iconografía para la interfaz de usuario.

---

## Funcionalidades Clave

### Catálogo Dinámico y Carrito

- Carga Asíncrona: Los servicios se obtienen desde una API interna (get-services.php).
- Gestión Total: El usuario puede agregar, disminuir cantidades o eliminar ítems del carrito sin recargar la página.
- Persistencia: El carrito se mantiene activo durante toda la sesión del usuario.

### Lógica de Negocio (Clase Quote)

El sistema aplica reglas automáticas basadas en el subtotal acumulado:

- Descuentos Escalables:
  - Subtotal >= $2,500.00 -> 15% de descuento.
  - Subtotal >= $1,000.00 -> 10% de descuento.
  - Subtotal >= $500.00 -> 5% de descuento.
- Impuestos: Cálculo automático del 13% de IVA sobre el total neto tras aplicar descuentos.
- Validación de Monto Mínimo: Solo se procesan cotizaciones cuyo subtotal sea mayor o igual a $100.00.

### Generación e Historial

- Código Correlativo: Generación automática de folios únicos (ejemplo: COT-2024-0001).
- Historial de Clientes: Una vista dedicada para revisar todas las cotizaciones generadas en la sesión actual.
- Vencimiento: Las cotizaciones calculan automáticamente una fecha de validez de 7 días a partir de su creación.

---

## Arquitectura y Patrones de Diseño

El proyecto sigue una arquitectura de **Separación de responsabilidades** dividida en dos capas principales:

### 🔹 Frontend (Capa de Presentación)

- Tecnologías: HTML, CSS y JavaScript moderno (ES6+ Modules, async/await).
- Responsabilidad:
  - Renderizar la interfaz de usuario.
  - Consumir la API interna mediante `fetch`.
  - Manejar la interacción del usuario y actualización dinámica del DOM.

### 🔹 Backend (Capa Lógica y API)

- Tecnología: PHP puro.
- Responsabilidad:
  - Actuar como API RESTful.
  - Procesar peticiones en formato JSON.
  - Gestionar sesiones.
  - Aplicar reglas de negocio.

---

## Estructura del Módulo

```text
├── api/
│   ├── add-to-cart.php       # Procesa y valida los datos del cliente
│   ├── get-cart.php          # Procesa y valida los datos del cliente
│   ├── get-services.php      # Obtiene todos los servicios del JSON
│   ├── process-quote.php     # Crea la cotización
│   ├── remove-from-cart.php  # Borra un item del carrito
│   └── update-cart.php       # Entrega la data de servicios
├── assets/
│   ├── css/
│   │   └── services-catalog.css # Diseño responsivo y tablas
│   │── js/
│   │   └── services-catalog.js  # Lógica de carrito y comunicación API
│   └── services.json            # Data externa
├── classes/
│   ├── Quote.class.php          # Objeto Cotización (Cálculos y Getters)
│   ├── Service.class.php        # Objeto Cotización (Cálculos y Getters)
│── pages/    ├── service-catalog.php    # Interfaz de usuario (Catálogo)
│   ├── view-quotes.php        # Tabla de historial de cotizaciones
│   └── view-table-quote.php   # Detalle final de la cotización
├── autoload.php # Autoload para las clases
├── config.php   # Carga el autoload y abre la sesión
└── index.php    # Redirecciona a la vista service-catalog
```
