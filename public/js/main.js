// ==== MENU BURGER (mobile) ====
const burger = document.getElementById('burger');

burger.addEventListener('click', function () {
    document.querySelector('header nav').classList.toggle('open');
    const ouvert = document.querySelector('.header-right').classList.toggle('open');

    // Informe les lecteurs d'écran de l'état du menu
    burger.setAttribute('aria-expanded', ouvert ? 'true' : 'false');
    burger.setAttribute('aria-label', ouvert ? 'Fermer le menu' : 'Ouvrir le menu');
});

// ==== APERÇU DE LA PHOTO (formulaires Ajouter / Modifier un livre) ====
const champImage = document.getElementById('image');

// Le champ n'existe que sur les pages formulaire livre
if (champImage) {
    champImage.addEventListener('change', function () {
        const fichier = this.files[0];
        if (fichier) {
            document.querySelector('.livre-form-photo img').src = URL.createObjectURL(fichier);
        }
    });
}
