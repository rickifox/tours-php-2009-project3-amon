import '../styles/home.css';
let button1 = document.querySelector('#button-down');
let button2 = document.querySelector('#button-up');

button1.addEventListener("click", show);
button2.addEventListener("click", hide);

function show() {
    document.getElementById("header").style.display = "block";
}

function hide() {
    document.getElementById("header").style.display = "none";
}
