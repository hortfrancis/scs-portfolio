const burgerLines = document.querySelector('g.primary-nav__menu-button-burger-lines');
const crossLines = document.querySelector('g.primary-nav__menu-button-cross-lines');
const primaryNav = document.querySelector('.primary-nav');
const body = document.querySelector('body');

document.querySelector('.primary-nav__menu-button').addEventListener('click', () => {

    // Toggle the icon on the menu button
    burgerLines.classList.toggle('primary-nav__menu-button-burger-lines--hidden');
    crossLines.classList.toggle('primary-nav__menu-button-cross-lines--hidden');

    // Toggle the visibility of the primary nav as a full-screen menu
    primaryNav.classList.toggle('primary-nav--hidden');
    primaryNav.classList.toggle('primary-nav--full-screen');

    // Prevent the page behind the full-screen menu from scrolling
    body.style.overflow = body.style.overflow === 'hidden' ? 'visible' : 'hidden';
});
