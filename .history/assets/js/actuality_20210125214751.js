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

class Lightbox{

    static init() {
        const links = document.querySelectorAll('a[href$=".png"], a[href$=".jpeg"], a[href$=".gif"], a[href$=".jpg"]')
            .forEach(link => link.addEventListener('click', e => 
                {
                    e.preventDefault()
                    new Lightbox(e.currentTarget.getAttribute('href'))
                }))
    }

    /**
     * @param {string} url URL de l'image
     */
    constructor (url) {
        const element = this.buildDOM(url)
        document.body.appendChild(element)
        
    }

    /**
     * Ferme la lightbox
     * @param {MouseEvent} e 
     */
    close (e) {
        e.preventDefault()
        $('#lightbox.close').classList.add('fadeOut')
        window.setTimeout(() => {
            this.element.remove()
        }, 500)
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