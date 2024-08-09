let body = document.querySelector('body');
let navMenu = document.querySelector('.header-nav');
let navOpenBtn = document.querySelector('.menu-toggle');
let navCloseBtn = document.querySelector('.close-menu');
let searchBTn = document.querySelector('.search-btn');
let favBtn = document.querySelectorAll('.fav-btn');
let cartBtn = document.querySelectorAll('.product-card .cart-btn');


if(cartBtn) {
    cartBtn.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
        });
    })
}

if(searchBTn) {
    searchBTn.addEventListener('click', (e) => {
        e.currentTarget.classList.toggle('active');
    })
}


if(favBtn) {
    favBtn.forEach(fav => {
        fav.addEventListener('click', function (e) {
           this.classList.toggle('active');
        })
    })
}


if(navMenu) {
    navOpenBtn.addEventListener("click", () =>{
        navMenu.classList.add("show-menu");
        body.classList.add("overflow-toggle");
    });
}

if(navCloseBtn) {
    navCloseBtn.addEventListener("click", () =>{
        navMenu.classList.remove("show-menu");
        body.classList.remove("overflow-toggle");
    });
}

function increaseValue() {
    var valueInput = document.querySelector('.count .value');
    var value = parseInt(valueInput.value);
    valueInput.value = value + 1;
}

function decreaseValue() {
    var valueInput = document.querySelector('.count .value');
    var value = parseInt(valueInput.value);
    if (value > 1) {
        valueInput.value = value - 1;
    }
}

