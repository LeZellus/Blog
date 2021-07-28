/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import AOS from 'aos';
import 'aos/dist/aos.css';

tinymce.init({
    selector: '.editor',
    plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    toolbar_mode: 'floating',
});

AOS.init();

if (document.querySelector('.copy')) {
    let button = document.querySelector('.copy');

    button.addEventListener('click', function () {
        /* Get the text field */
        var copyText = document.getElementById("copyInput");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        document.execCommand("copy");

        /* Alert the copied text */
        button.innerHTML = "Copié !";

        setTimeout(function () {
            button.innerHTML = "Copier le lien de partage";
        }, 3000);
    })
}

if (document.querySelector('#burgerButton')) {
    let burgerButton = document.querySelector('#burgerButton');
    let closeButton = document.querySelector('#closeButton');
    let menuMobile = document.querySelector('#mobileMenu')

    burgerButton.addEventListener('click', function () {
        menuMobile.classList.remove('hidden');
        burgerButton.classList.add('hidden');
        closeButton.classList.remove('hidden');
    })
    closeButton.addEventListener('click', function () {
        menuMobile.classList.add('hidden');
        closeButton.classList.add('hidden');
        burgerButton.classList.remove('hidden');
    })
}


