/*
 * Welcome to your app's main JavaScript file!
 */

// any CSS you import will output into a single css file (gallery.css in this case)
import '../styles/gallery.css';

/*
 * Set the width of the side navigation to 14rem (category button width)
 * on click or toggle it back to 0
 */
function toggleSideNav() {
    const sidenav = document.getElementById('mySidenav');
    if (sidenav.style.width === '14rem') {
        sidenav.style.width = '0';
        sidenav.style.marginLeft = '-2px';
    } else {
        sidenav.style.width = '14rem';
        sidenav.style.marginLeft = '0';
    }
}

/* Event listener to trigger the toggleSideNav function */

document.getElementById('categories-pop').addEventListener('click', toggleSideNav, false);
document.getElementById('closebtn').addEventListener('click', toggleSideNav, false);

/*
 * Article overlay on click maker
 */

/*
const images = document.getElementsByClassName('gallery-img');

function overlayer() {
    const imageId = this.id;

    const request = new Request('/article/', imageId, { method: 'GET' });

    fetch(request)
        .then((response) => response.json());
    // .then((data) => alert(data))
    // .catch(() => alert('error'));
}

for (let i = 0; i < images.length; i += 1) {
    images[i].addEventListener('click', overlayer, false);
}*/

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

/*
 * Article overlay on click maker
 */

function overlayer(imageId, currentSrc, images) {
    const request = new Request('/article/' + imageId, { method: 'GET' });
    let articleStuff = [];
    fetch(request)
        .then(response => response.json())
        .then(articleStuffObj => {
            articleStuff.push(articleStuffObj);
            new Lightbox(articleStuff[0], currentSrc, images);
        })
}

/**
 * @property {HTMLElement} element
 * @property {string[]} images Path of images in lightbox
 * @property {string} url Currently displayed image
 */

class Lightbox{

    static init(){
        const links = Array.from(document.getElementsByClassName('gallery-img'));
        const images = links.map(link => link.getAttribute('src'));
        links.forEach(link => link.addEventListener('click', e =>
                {
                    e.preventDefault();
                    const currentSrc = e.currentTarget.getAttribute('src');
                    const imageId = e.currentTarget.id;
                    overlayer(imageId, currentSrc, images);
                }))
    }

    /**
     * @param {mixed[]} articleStuff content of the article associated to the clicked image
     * @param {string} url Image URL
     * @param {string[]} images Path of images in lightbox
     */
    constructor (articleStuff, url, images){
        this.element = this.buildDOM(articleStuff, url);
        this.images = images;
        document.body.appendChild(this.element);
    }

    /**
     * 
     * @param {string} url Image URL
     */
    loadImage(url){
        this.url = null;
        const image = new Image();
        const container = this.element.querySelector('.lightbox__container');
        const loader = document.createElement('div');
        loader.classList.add('lightbox__loader');
        container.innerHTML = '';
        container.appendChild(loader);
        image.onload = ()=>{
            container.removeChild(loader);
            container.appendChild(image);
            this.url = url;
        }
        image.src = url;
    }

    /**
     * Close the lightbox
     * @param {MouseEvent} e
     */
    close (e) {
        e.preventDefault();
        this.element.classList.add('fadeOut');
        window.setTimeout(()=>{
            this.element.remove();
        }, 500);
    }

    /**
     * @param {mixed[]} articleStuff content of the article associated to the clicked image
     * @param {string} url URL de l'image
     * @return {HTMLElement}
     */
    buildDOM (articleStuff, url){
        console.log(articleStuff);
        let images = '';
        if (articleStuff['data']['images']) {
            for (let i = 0; i < articleStuff['data']['images'].length; i++) {
                images = images + `<img class="lightbox_mini" src="${articleStuff['data']['images'][i]['url']}" alt="${articleStuff['data']['images'][i]['texteAltenatif']}"> `;
            };
        };
        const dom = document.createElement('div');
        dom.classList.add('lightbox');
        dom.innerHTML = `<button class="lightbox__close"></button>
        <div class="lightbox__container">
            <h2 id="article_title">${articleStuff["data"]["titre"]}</h2>
            <div class="lightbox_image-border">
                <div class="lightbox_main-image-container">
                    <img class="lightbox_image" src="${url}" alt="">
                </div>
                <div class="lightbox_image-list">` + images +` </div>
            </div>
            <p class="lightbox_text">
                ${articleStuff['data']['description']}   
            </p>
        </div>`;
        dom.querySelector('.lightbox__close').addEventListener('click', this.close.bind(this));
        return dom;
    }
}
Lightbox.init()

    /*fetch(request)
        .then((response) => response.json())
        .then((data) => console.log(data["images"][0]["url"]))
        .catch(() => alert('error'));*/
