document.getElementById('burger').addEventListener('click', function() {
    document.querySelector('header nav').classList.toggle('open');
    document.querySelector('.header-right').classList.toggle('open');
});