import '../styles/home.css';

const slideSource = document.getElementById('header');

document.getElementById('button-down').onclick = function show() {
    slideSource.classList.toggle('fade');
};

document.getElementById('button-up').onclick = function hide() {
    slideSource.classList.toggle('fade');
};
