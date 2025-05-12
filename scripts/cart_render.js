let productManaging;
class Product{
    constructor(id, productName, category, price, quantity, image, ordered){
        this.id = id;
        this.productName = productName;
        this.category = category;
        this.price = price;
        this.quantity = quantity;
        this.image = image;
        this.ordered = ordered;
    }

    render(){
        //CREATE CARD
        let card = document.createElement("div");
        card.classList.add("card", this.category, this.price);
        //CREATE IMAGE CONTAINER
        let imageContainer = document.createElement("div");
        imageContainer.classList.add("image-container");
        //CREATE IMAGE ELEMENT
        let image = document.createElement("img");
        image.setAttribute("src", "uploads/" + this.image);
        //APPENDING EACH ELEMENT TO THE OTHER
        card.appendChild(imageContainer);
        imageContainer.appendChild(image);
        //CONTAINER
        let container = document.createElement("div");
        container.classList.add("container");
        //PRODUCT NAME
        let name = document.createElement("h5");
        name.classList.add("product-name");
        name.innerText = this.productName.toUpperCase();
        //PRICE
        let price = document.createElement("h6");
        price.innerText = `$${this.price}`;
        //QUANTITY
        let quantity = document.createElement("h6");
        quantity.innerText = `Quantity: ${this.quantity}`;
        //ANCHOR ELEMENT "BUTTON"
        let buy = document.createElement("a");
        buy.textContent = "Order Item";
        buy.classList.add("buy-btn");
        buy.dataset.productId = this.id; //THIS IS IMPORTANT
        //ANCHOR ELEMENT "REMOVE";
        let remove = document.createElement('button');
        remove.textContent = "Remove From Cart";
        remove.classList.add("remove-btn");;

        remove.onclick = () => {
            fetch(`remove_cart.php?id=${this.id}`)
            .then(res => res.text())
            .then(text => {
                if(text == "success") {
                    fetch('get_items_cart.php?nocache=' + new Date().getTime())
                    .then(res => res.json())
                    .then(productsData => {
                        productManaging = new ProductManaging(productsData);
                        productManaging.renderProducts();

                        let totalPrice = 0;
                        productsData.forEach(product => {
                            totalPrice += product.price * product.quantity;
                        });

                        const total_price = document.getElementById("total-price");
                        total_price.textContent = `Total price: $${totalPrice}`;
                    });
                }
                else console.error("Failed to remove items", text);
            })
            .catch(err => console.error(err));
        };

        buy.onclick = () => {
            fetch("place_order.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                    body: "product_id=" + this.id + "&quantity=" + this.quantity
            })
            .then(res => res.json())
            .then(data => {
                
                console.log(data.message);

                if (data.success) {
                    buy.textContent = "Ordred ✅";

                    fetch('get_items_cart.php?nocashe=' + new Date().getTime())
                    .then(res => res.json())
                    .then(productsData => {
                        let totalPrice = 0;
                            productsData.forEach(product => {
                                totalPrice += product.price * product.quantity;
                            });

                            const total_price = document.getElementById("total-price");
                            total_price.textContent = `Total price: $${totalPrice}`;
                    });

                    setTimeout(() => {
                        fetch('get_items_cart.php?nocache=' + new Date().getTime())
                        .then(res => res.json())
                        .then(productsData => {
                            productManaging = new ProductManaging(productsData);
                            productManaging.renderProducts();
                        });
                    }, 4000)
                    } else {
                    console.log(data.message);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                });
        }

        if (this.ordered == 'CANCELED') {
            buy.textContent = "Ordred ✅";
            buy.style.pointerEvents = "none";
            buy.style.cursor = 'not-allowed';
            buy.disabled = true;
        }

        card.appendChild(imageContainer);
        imageContainer.appendChild(image);
        card.appendChild(container);
        container.appendChild(name);
        container.appendChild(price);
        container.appendChild(quantity);
        container.appendChild(buy);
        container.appendChild(remove);
        return card;
    }
}

class ProductManaging{
    constructor(productsData){
        this.products = productsData.map(data => new Product(data.id, data.productName, data.category, data.price, data.quantity, data.image, data.ordered));
    }
    renderProducts(){
        const productContainer = document.getElementById("products");
        productContainer.innerHTML = '';

        this.products.forEach(product => {
            productContainer.appendChild(product.render());
        });
    }
}

fetch('get_items_cart.php?nocache=' + new Date().getTime())
.then(res => res.json())
.then(productsData => {
    productManaging = new ProductManaging(productsData);
    productManaging.renderProducts();
})
.catch(err => console.log('Error:', err));