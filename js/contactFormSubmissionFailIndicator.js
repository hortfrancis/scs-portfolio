/* 
    Show a popup message when the contact form did not submit successfully.
*/

function createFormSubmissionFailIndicator() {

    // Create a 'fail' message
    const failIndicator = document.createElement('div');
    failIndicator.className = 'contact-form__submission-fail-indicator';
    failIndicator.innerHTML = '<span>Form submission failed. Please check your details are correct and try again.</span>';

    // Add the message to the <div> that contains the contact form
    document.querySelector('.contact-form').appendChild(failIndicator);

    failIndicator.classList.add('contact-form__fail-indicator--visible');

    // Wait for 5 seconds, then fade out
    setTimeout(() => {

        failIndicator.classList.remove('contact-form__fail-indicator--visible');

        // Remove the element from the DOM once the opacity transition has finished
        failIndicator.addEventListener('transitionend', function onEnd() {
            failIndicator.remove();
            failIndicator.removeEventListener('transitionend', onEnd);
        });
    }, 5000);

    // Declared in `contactFormValidation.js`
    // Call twice to get the red border to display on the first invalid field
    findAndStyleInvalidFormFields();
    findAndStyleInvalidFormFields();
}
