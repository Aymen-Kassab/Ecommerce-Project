let productManaging;
class Product{
    constructor(id, productName, orderDate, price, state, quantity, image){
        this.id = id;
        this.productName = productName;
        this.orderDate = orderDate;
        this.price = price;
        this.state = state;
        this.quantity = quantity;
        this.image = image;
    }

    render(){
        //CREATE CARD
        let card = document.createElement("div");
        card.classList.add("card", this.orderDate, this.price);
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
        //ORDERDATE
        let date = document.createElement("h6");
        date.innerText = `Order date: ${this.orderDate}`;
        //PRICE
        let price = document.createElement("h6");
        price.innerText = `Total Pirce: $${this.price}`;
        //QUANTITY
        let quantity = document.createElement("h6");
        quantity.innerText = `Quantity: ${this.quantity}`;
        //STATE
        let state = document.createElement("h6");
        state.innerText = `State: ${this.state}`;
        //BUTTON ELEMENT "CANCEL";
        let cancel = document.createElement('button');
        cancel.textContent = "Cancel Order";
        cancel.classList.add("cancel-btn");

        cancel.dataset.id = this.id;

        cancel.onclick = () => {
            fetch("cancel_order.php?nocache=" + new Date().getTime(), {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                    body: "id_order=" + this.id
            })
            .then(res => res.json())
            .then(data => {

                if (data.success) {
                    fetch('get_orders.php?nocache=' + new Date().getTime())
                    .then(res => res.json())
                    .then(productsData => {
                    productManaging = new ProductManaging(productsData);
                    productManaging.renderProducts();
            })
            .catch(err => console.log('Error:', err));
                    } else {
                    console.log(data.message);
                    }
            })
            .catch(error => {
                console.error("Error:", error);
            });
        }

        if (this.state == "CANCELED") {
            cancel.textContent = "canceled";
            cancel.style.pointerEvents = "none";
            cancel.style.cursor = 'not-allowed';
            cancel.disabled = true;
        }

        card.appendChild(imageContainer);
        imageContainer.appendChild(image);
        card.appendChild(container);
        container.appendChild(name);
        container.appendChild(price);
        container.appendChild(quantity);
        container.appendChild(state);
        container.appendChild(date);
        container.appendChild(cancel);
        return card;
    }
}

class ProductManaging{
    constructor(productsData){
        this.products = productsData.map(data => new Product(data.id_order, data.productName, data.order_date, data.total_price, data.order_state, data.quantity, data.image));
    }
    renderProducts(){
        const productContainer = document.getElementById("products");
        productContainer.innerHTML = '';

        this.products.forEach(product => {
            productContainer.appendChild(product.render());
        });
    }
}

fetch('get_orders.php?nocache=' + new Date().getTime())
.then(res => res.json())
.then(productsData => {
    productManaging = new ProductManaging(productsData);
    productManaging.renderProducts();
})
.catch(err => console.log('Error:', err));