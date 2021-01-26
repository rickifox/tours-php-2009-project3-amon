/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../styles/actuality.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

/**
 * @property {HTMLElement} element
 * @property {string[]} element
 */

class Lightbox{

    static init() {
        const links = Array.from(document.querySelectorAll('a[href$=".png"], a[href$=".jpeg"], a[href$=".gif"], a[href$=".jpg"]'))
        const gallery = links.map(link => link.getAttribute('href'))    
        
        links.forEach(link => link.addEventListener('click', e => 
                {
                    e.preventDefault()
                    new Lightbox(e.currentTarget.getAttribute('href'), gallery)
                }))
    }

    /**
     * @param {string} url URL de l'image
     * @param {string[]} images Chemins des images de la lightbox
     */
    constructor (url, images) {
        const element = this.buildDOM(url)
        document.body.appendChild(element)
        
    }

    
    /**
     * @param {string} url URL de l'image
     * @return {HTMLElement}
     */
    buildDOM (url) {
        const dom = document.createElement('div')
        dom.classList.add('lightbox')
        dom.innerHTML = `<button class="lightbox__close">Fermer</button>
        <button class="lightbox__next">Suivant</button>
        <button class="lightbox__prev">Précédent</button>
        <div class="lightbox__container">
            <img src="${url}" alt"">
        </div>`
        dom.querySelector('.lightbox__close').addEventListener('click', this.close.bind(this))
        return dom
    }

     /**
     * Ferme la lightbox
     * @param {MouseEvent} e 
     */
    close (e) {
        e.preventDefault()
        this.element.classList.add('fadeOut')
        window.setTimeout(() => {
            this.element.remove()
        }, 500)
    }

}

/**
 * <div class="lightbox">
          <button class="lightbox__close">Fermer</button>
          <button class="lightbox__next">Suivant</button>
          <button class="lightbox__prev">Précédent</button>
          <div class="lightbox__container">
            <img src="">
          </div>
        </div>
 */

Lightbox.init()