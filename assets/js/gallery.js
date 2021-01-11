/*
 * Welcome to your app's main JavaScript file!
 */

// any CSS you import will output into a single css file (gallery.css in this case)
import '../styles/gallery.css';

/* Set the width of the side navigation to 14rem (category button width) 
 * on click or toggle it back to 0 
 */
function toggleSideNav() {
    const sidenav = document.getElementById('mySidenav');
    if (sidenav.style.width === '14rem') {
        sidenav.style.width = '0';
    } else {
        sidenav.style.width = '14rem';
    }
}

/* Event listener to trigger the toggleSideNav function */

document.getElementById('categories-pop').addEventListener('click', toggleSideNav, false);
document.getElementById('closebtn').addEventListener('click', toggleSideNav, false);

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';
