class Product{
    constructor(id, productName, category, price, stock, image){
        this.id = id;
        this.productName = productName;
        this.category = category;
        this.price = price;
        this.stock = stock;
        this.image = image;
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
        //CONTAINER
        let container = document.createElement("div");
        container.classList.add("container");
        //PRODUCT NAME
        let name = document.createElement("h5");
        name.classList.add("product-name");
        name.innerText = this.productName.toUpperCase();
        //ARCHOR ELEMENT
        let archor = document.createElement("a");
        archor.href = `achatpage.php?id=${this.id}`;
        //PRICE
        let price = document.createElement("h4");
        price.innerText = `Price: $${this.price}`;
        //STOCK 
        let stock = document.createElement("h4");
        stock.innerText = `Stock: ${this.stock}`;

        card.appendChild(imageContainer);
        imageContainer.appendChild(image);
        card.appendChild(container);
        container.appendChild(archor);
        archor.appendChild(name);
        container.appendChild(price);
        container.appendChild(stock);


        return card;
    }
}

class ProductManaging{
    constructor(productsData){
        this.products = productsData.map(data => new Product(data.id, data.productName, data.category, data.price, data.stock, data.image));
    }
    renderProducts(){
        const productContainer = document.getElementById("products");
        productContainer.innerHTML = '';

        this.products.forEach(product => {
            productContainer.appendChild(product.render());
        });
    }
}

fetch('getProducts.php')
.then(res => res.json())
.then(productsData => {
    const productManaging = new ProductManaging(productsData);
    productManaging.renderProducts();
})
.catch(err => console.log('Error:', err));

//FILTER CATEGORY FUNCTIONALITY

function filterCat(value){
    let buttons = document.querySelectorAll(".filter-btn");

    buttons.forEach(button => {
        if (value.toUpperCase() == button.textContent.toUpperCase()){
            button.classList.add("active");
        }
        else{
            button.classList.remove("active");
        }
    })

    let elements = document.querySelectorAll(".card");

    elements.forEach(element => {
        if(element.classList.contains(value)){
            element.classList.add("show");
            element.classList.remove("hide");
        }
        else{
            element.classList.add("hide");
            element.classList.remove("show");
        }
    });
}

//SEARCHBAR FUNCTIONALITY

document.getElementById("search").addEventListener("click", () => {
    //INTIALIZATION
    let searchInput = document.getElementById("search-input").value.toLowerCase();
    let cards = document.querySelectorAll(".card");

    cards.forEach(card => {
        let productName = card.querySelector(".product-name").textContent.toLowerCase();
        if(productName.includes(searchInput)){
            card.classList.remove('hide');
            card.classList.add('show');
        }
        else{
            card.classList.add('hide');
            card.classList.remove('show');
        }
    });

    document.querySelectorAll(".filter-btn.active").forEach(btn => {
        btn.classList.remove("active");
    });
}); 