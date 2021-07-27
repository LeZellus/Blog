/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import 'animate.css/animate.min.css';

tinymce.init({
    selector: '.editor',
    plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    toolbar_mode: 'floating',
});


if (document.body.classList.contains('copy')){
    console.log("oui")
}else {
    console.log("non")
}
let button = document.querySelector('.copy');

button.addEventListener('click', function(){
    /* Get the text field */
    var copyText = document.getElementById("copyInput");

    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile devices */

    /* Copy the text inside the text field */
    document.execCommand("copy");

    /* Alert the copied text */
    button.innerHTML = "Copié !";

    setTimeout(function(){ button.innerHTML = "Copier le lien de partage"; }, 3000);
})