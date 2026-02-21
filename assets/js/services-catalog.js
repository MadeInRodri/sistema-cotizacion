console.log("Working!");

//ALERTAS

const cartAlert = () => {
  Swal.fire({
    title: "¡Enhorabuena!",
    text: "El item ha sido añadido al carrito",
    icon: "success",
    timer: 2000,
    timerProgressBar: true,
  });
};

const buyMinAlert = () => {
  Swal.fire({
    title: "¡Carro vacío!",
    text: "No puedes generar una cotización con el carro vacío",
    icon: "error",
    timer: 2000,
    timerProgressBar: true,
  });
};

const buyMaxAlert = () => {
  Swal.fire({
    title: "¡Carro lleno!",
    text: "Has sobrepasado el límite de items que puedes agregar",
    icon: "error",
    timer: 2000,
    timerProgressBar: true,
  });
};

const genericErrorAlert = (message) => {
  Swal.fire({
    title: "¡Error!",
    text: `${message}`,
    icon: "error",
    timer: 2000,
    timerProgressBar: true,
  });
};

const genericSuccessAlert = () => {
  Swal.fire({
    title: "¡Enhorabuena!",
    text: "El item ha sido añadido al carrito",
    icon: "success",
    timer: 2000,
    timerProgressBar: true,
  });
};

//OBTENER LA DATA DE LA API

//SERVICIOS
const getServicesData = async () => {
  try {
    let url = "../api/get-services.php";
    const response = await fetch(url);
    const data = await response.json();

    console.log(data);
    sessionStorage.setItem("services", JSON.stringify(data.services));
  } catch (error) {
    console.error("Error al contactar a la api", error);
  }
};

//CARRITO EN SESSION
const getCartData = async () => {
  try {
    let url = "../api/get-cart.php";
    const response = await fetch(url);
    const data = await response.json();

    return data;
  } catch (error) {
    console.error("Error al contactar a la api", error);
  }
};

//AGREGAR AL CARRITO
const addToCart = async (serviceId, isInCart = false) => {
  let url = "../api/add-to-cart.php";

  try {
    const response = await fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      // Enviamos el ID en el cuerpo de la petición
      body: JSON.stringify({ id: serviceId }),
    });

    // Verificamos si hubo un error de servidor (404, 500, etc)
    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.message || "Error al agregar al carrito");
    }

    const data = await response.json();

    if (data.status === "success") {
      console.log(data);
      await fillCart();
      if (!isInCart) {
        cartAlert();
      }
    }
  } catch (error) {
    console.error("Error en la comunicación con la API:", error.message);
    genericErrorAlert(error.message);
  }
};

//DECREMENTAR EN EL CARRITO
const decreaseQuantity = async (serviceId) => {
  try {
    const response = await fetch("../api/update-cart.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id: serviceId }),
    });

    const data = await response.json();

    if (data.status === "success") {
      console.log(data.message);
      await fillCart();
    } else {
      console.log(data);
    }
  } catch (error) {
    console.error("Error al actualizar cantidad:", error);
  }
};

//REMOVER ITEM DEL CARRITO
const removeFromCart = async (serviceId) => {
  try {
    const response = await fetch("../api/remove-from-cart.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id: serviceId }),
    });

    const data = await response.json();

    if (data.status === "success") {
      console.log(data);
      await fillCart();
    } else {
      console.log(data);
    }
  } catch (error) {
    console.error("Error al actualizar cantidad:", error);
  }
};

//LLENAR LOS SERVICIOS EN PANTALLA
const fillServices = async (category = null) => {
  await getServicesData();

  const cardsContainer = document.getElementById("cards");
  let servicesData = JSON.parse(sessionStorage.getItem("services"));

  if (!servicesData) return;

  if (category !== null) {
    servicesData = servicesData.filter(
      (service) => service.categoria === category,
    );
  }

  const servicesCards = servicesData
    .map((service) => {
      return `
      <article class="card">
        <button class="card-header ${service.categoria.toLowerCase()}" onclick="addToCart(${service.id})">
          <h3>${service.nombre}</h3>
        </button>
        <div class="card-body">
          <p>${service.descripcion}</p>
          <div class="card-footer">
            <span class="price">$${service.precio_base}</span>
            <span class="tag ${service.categoria.toLowerCase()}">${service.categoria}</span>
          </div>
        </div>
      </article>
    `;
    })
    .join("");

  cardsContainer.innerHTML = servicesCards;
  //console.log(servicesCards);
};

//ACTUALIZAR CARRITO
const fillCart = async () => {
  try {
    const data = await getCartData();

    const cartContainer = document.querySelector(".cart-items");
    const totalPriceElement = document.querySelector(".total-price");

    if (data.status === "success") {
      cartContainer.innerHTML = data.cart
        .map(
          (item) => `
        <div class="cart-item">
          <div class="item-info">
            <h4>${item.name}</h4>
            <p>$${item.price.toFixed(2)} x ${item.quantity}</p>
          </div>
          <div class="item-actions">
          <button class="action add-item" onclick="decreaseQuantity(${item.id})">
              <i class="fa-solid fa-caret-left"></i>
            </button>
            <button class="action remove-item" onclick="removeFromCart(${item.id})">
              <i class="fa-solid fa-trash"></i>
            </button>
            <button class="action add-item" onclick="addToCart(${item.id},${true})">
              <i class="fa-solid fa-caret-right"></i>
            </button>
          </div>
        </div>
      `,
        )
        .join("");

      totalPriceElement.textContent = `$${data.total_general.toFixed(2)}`;
    }
  } catch (error) {
    console.error("Error al llenar el carrito:", error);
  }
};

//EJECUCIÓN DE MÉTODOS
fillServices();
fillCart();

//MANEJO DEL CARRITO

const toggleCart = () => {
  const cart = document.getElementById("shopping-cart");
  const overlay = document.getElementById("cart-overlay");

  cart.classList.toggle("active");
  overlay.classList.toggle("active");
};

// Abrir el modal desde el botón del carrito
document.querySelector(".checkout-btn").addEventListener("click", () => {
  document.getElementById("quote-modal").style.display = "flex";
});

// Manejar el envío del formulario
document.getElementById("quote-form").addEventListener("submit", function (e) {
  e.preventDefault();

  console.log("Datos enviados, redirigiendo...");

  window.location.href = "tabla.html";
});

// Cerrar modal si se hace clic fuera del contenido
window.onclick = function (event) {
  let modal = document.getElementById("quote-modal");
  if (event.target == modal) {
    modal.style.display = "none";
  }
};
