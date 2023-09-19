/*
    Show/hide the full-screen menu at narrow viewports
*/
const burgerLines = document.querySelector('g.primary-nav__menu-button-burger-lines');
const crossLines = document.querySelector('g.primary-nav__menu-button-cross-lines');
const primaryNav = document.querySelector('.primary-nav');
const body = document.querySelector('body');

function toggleFullScreenNavMenu() {

        // Toggle the icon on the menu button
        burgerLines.classList.toggle('primary-nav__menu-button-burger-lines--hidden');
        crossLines.classList.toggle('primary-nav__menu-button-cross-lines--hidden');
    
        // Toggle the visibility of the primary nav as a full-screen menu
        primaryNav.classList.toggle('primary-nav--hidden');
        primaryNav.classList.toggle('primary-nav--full-screen');
    
        // Prevent the page behind the full-screen menu from scrolling
        body.style.overflow = body.style.overflow === 'hidden' ? 'visible' : 'hidden';
}

document.querySelector('.primary-nav__menu-button').addEventListener('click', () => {

    // Toggle the full-screen primary-nav menu when the menu button is clicked
    toggleFullScreenNavMenu();
});

// Fixes a bug whereby the full-screen menu would not close when a link was clicked 
// if the link pointed to an id on the same page, on the homepage.
document.querySelector('.primary-nav__subpages-menu').addEventListener('click', event => {

    // Check if an <a> was clicked
    if (event.target.tagName === 'A') {

        const href = event.target.getAttribute('href');
        // If the link clicked points to an id
        if (href.includes('#') &&
            // & if the primary nav menu is currently full-screen
            document.querySelector('.primary-nav').classList.contains('primary-nav--full-screen')) {

                // Hide the full-screen menu, but in an expected way
                toggleFullScreenNavMenu();
        }
    }
});