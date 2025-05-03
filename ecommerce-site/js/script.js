// Fonctionnalité de recherche
document.getElementById('searchButton').addEventListener('click', function() {
    let searchQuery = document.getElementById('searchInput').value.trim().toLowerCase();
    if (searchQuery !== "") {
        window.location.href = `recherche.php?q=${searchQuery}`;
    } else {
        alert("Veuillez entrer un terme de recherche");
    }
});

// Fonction pour ajouter un produit au panier
function addToCart(productId, productName, productPrice) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let product = {
        id: productId,
        name: productName,
        price: productPrice,
        quantity: 1
    };

    let productIndex = cart.findIndex(item => item.id === productId);

    if (productIndex === -1) {
        cart.push(product);
    } else {
        cart[productIndex].quantity++;
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    alert(`${productName} a été ajouté au panier !`);
    updateCartIcon();
}

// Fonction pour afficher les produits dans le panier
function displayCart() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let cartContainer = document.getElementById('cartContainer');
    cartContainer.innerHTML = "";

    if (cart.length === 0) {
        cartContainer.innerHTML = "<p>Votre panier est vide.</p>";
    } else {
        let totalPrice = 0;
        cart.forEach(item => {
            totalPrice += item.price * item.quantity;
            cartContainer.innerHTML += `
                <div class="cart-item">
                    <h4>${item.name}</h4>
                    <p>Prix: ${item.price} €</p>
                    <p>Quantité: ${item.quantity}</p>
                    <button onclick="removeFromCart(${item.id})">Supprimer</button>
                </div>
            `;
        });
        cartContainer.innerHTML += `<p>Total: ${totalPrice} €</p>`;
    }
}

// Fonction pour supprimer un produit du panier
function removeFromCart(productId) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart = cart.filter(item => item.id !== productId);
    localStorage.setItem('cart', JSON.stringify(cart));
    displayCart();
    updateCartIcon();
}

// Fonction pour mettre à jour l'icône du panier
function updateCartIcon() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let cartCount = cart.reduce((total, item) => total + item.quantity, 0);
    document.getElementById('cartCount').innerText = cartCount;
}

// Fonction de validation du panier (sur la page de validation)
document.getElementById('validateCartButton')?.addEventListener('click', function() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    if (cart.length === 0) {
        alert("Votre panier est vide. Veuillez ajouter des produits.");
        return;
    }
    
    let userConfirmed = confirm("Êtes-vous sûr de vouloir passer à la commande ?");
    if (userConfirmed) {
        localStorage.removeItem('cart');
        alert("Merci pour votre commande !");
        window.location.href = "commande.php";
    }
});

// Fonction pour afficher l'historique des commandes (sur la page historique.php)
function displayOrderHistory() {
    // Supposons que l'historique des commandes soit récupéré depuis une base de données
    // (en utilisant PHP, par exemple), ici nous simulons avec un tableau statique.
    
    let orders = [
        { orderId: 1, date: "2025-04-10", total: 150 },
        { orderId: 2, date: "2025-04-15", total: 200 }
    ];

    let historyContainer = document.getElementById('orderHistory');
    orders.forEach(order => {
        historyContainer.innerHTML += `
            <div class="order-item">
                <h4>Commande #${order.orderId}</h4>
                <p>Date: ${order.date}</p>
                <p>Total: ${order.total} €</p>
            </div>
        `;
    });
}

// Fonction pour afficher les produits lors de la recherche (recherche.php)
document.getElementById('searchForm')?.addEventListener('submit', function(event) {
    event.preventDefault();
    let searchQuery = document.getElementById('searchInput').value.trim().toLowerCase();
    let resultsContainer = document.getElementById('searchResults');
    resultsContainer.innerHTML = "<p>Chargement des résultats...</p>";

    // Simuler un appel AJAX pour obtenir les résultats de la recherche
    setTimeout(function() {
        let results = [
            { id: 1, name: "Plaquette de frein", price: 30 },
            { id: 2, name: "Filtre à air", price: 20 }
        ];

        let filteredResults = results.filter(product => 
            product.name.toLowerCase().includes(searchQuery)
        );

        if (filteredResults.length === 0) {
            resultsContainer.innerHTML = "<p>Aucun produit trouvé.</p>";
        } else {
            resultsContainer.innerHTML = "";
            filteredResults.forEach(product => {
                resultsContainer.innerHTML += `
                    <div class="search-result-item">
                        <h4>${product.name}</h4>
                        <p>Prix: ${product.price} €</p>
                        <button onclick="addToCart(${product.id}, '${product.name}', ${product.price})">Ajouter au panier</button>
                    </div>
                `;
            });
        }
    }, 1000); // Simulation d'un délai pour l'appel API
});

// Initialiser le panier au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    updateCartIcon();
});
