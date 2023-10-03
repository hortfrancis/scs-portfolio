/* 
    Handles showing and hiding the text content inside the 'accordion' sections on the subpages.
*/
document.querySelectorAll('.subpage__accordion-section').forEach(section => {

    section.querySelector('.subpage__accordion-section-open-close-button').addEventListener('click', () => {

        section.classList.toggle('subpage__accordion-section--open');
    });
});