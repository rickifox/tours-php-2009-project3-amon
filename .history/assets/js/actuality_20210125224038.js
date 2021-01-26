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
 * @property {string[]} images Path of images in lightbox
 * @property {strin} url Currently displayed image
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
     * @param {string} url Image URL
     * @param {string[]} images Path of images in lightbox
     */
    constructor (url, images) {
        this.element = this.buildDOM(url)
        this.images = images
        document.body.appendChild(this.element)
        
    }

    /**
     * 
     * @param {string} url Image URL 
     */
    loadImage (url) {
        this.url = null
        const image = new Image()
        const container = this.element.querySelector('.lightbox__container')
        const loader = document.createElement('div')
        loader.classList.add('lightbox__loader')
        container.innerHTML = ''
        container.appendChild(loader)
        image.onload = () => {
            container.removeChild(loader)
            container.appendChild(image)
            this.url = url
        }
        image.src = url
    } 

    /**
     * Close the lightbox
     * @param {MouseEvent|KeyboardEvent} e 
     */
    close (e) {
        e.preventDefault()
        this.element.classList.add('fadeOut')
        window.setTimeout(() => {
            this.element.remove()
        }, 500)
    }

    /**
     * Go to the Next image
     * @param {MouseEvent|KeyboardEvent} e 
     */
    next (e) {
        e.preventDefault()
        let pos = this.images.findIndex(image => image === this.url)
        if(pos === this.images.lenght) {
            pos = 1
        }
        this.loadImage(this.images[pos + 1])
    }

    /**
     * Go to the Previous image
     * @param {MouseEvent|KeyboardEvent} e 
     */
    prev (e) {
        e.preventDefault()
        let pos = this.images.findIndex(image => image === this.url)
        if(pos === 0) {
            pos = this.images.lenght
        }
        this.loadImage(this.images[pos - 1])
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
        dom.querySelector('.lightbox__next').addEventListener('click', this.next.bind(this))
        dom.querySelector('.lightbox__prev').addEventListener('click', this.prev.bind(this))
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