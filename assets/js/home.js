import '../styles/home.css';

var slideSource = document.getElementById('header');

document.getElementById('button-down').onclick = function () {
  slideSource.classList.toggle('fade');
  diminuer();
}

document.getElementById('button-up').onclick = function () {
    slideSource.classList.toggle('fade');
  }
