/* 
    Show a happy message when the contact form is submitted successfully.
*/

function createFormSuccessIndicator() {

    // Create a 'success' message
    const successIndicator = document.createElement('div');
    successIndicator.className = 'contact-form__success-indicator';
    successIndicator.innerHTML = '<span class="contact-form__success-indicator-text">Thanks, your details have been saved!</span>';

    // Add the message to the <div> that contains the contact form
    document.querySelector('.contact-form').appendChild(successIndicator);

    successIndicator.classList.add('contact-form__success-indicator--visible');

    // Wait for 5 seconds, then fade out
    setTimeout(() => {

        successIndicator.classList.remove('contact-form__success-indicator--visible');

        // Remove the element from the DOM once the opacity transition has finished
        successIndicator.addEventListener('transitionend', function onEnd() {
            successIndicator.remove();
            successIndicator.removeEventListener('transitionend', onEnd);
        });
    }, 5000);
}