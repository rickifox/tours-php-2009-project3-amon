import '../styles/home.css';

const button1 = document.querySelector('#button-down');
const button2 = document.querySelector('#button-up');

function show() {
    document.getElementById('header').style.display = 'block';
}

function hide() {
    document.getElementById('header').style.display = 'none';
}

button1.addEventListener('click', show);
button2.addEventListener('click', hide);
