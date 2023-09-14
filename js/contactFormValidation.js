/*
    Frontend validation for the contact form
*/

/* Utility functions to handle updating 'strong' signified state of form fields */

function showErrorIndicator(inputField) {
    inputField.parentElement.querySelector('.contact-form__error-indicator').classList.remove('contact-form__error-indicator--hidden');
}

function hideErrorIndicator(inputField) {
    inputField.parentElement.querySelector('.contact-form__error-indicator').classList.add('contact-form__error-indicator--hidden');
}

// Signify value is definitely valid 
function indicateHardValid(inputField) {
    inputField.classList.add('contact-form__input-field--definitely-valid');
}

// Signify value needs changing before submission
function indicateHardInvalid(inputField) {
    inputField.classList.add('contact-form__input-field--needs-changing');
}

// Remove strong visual signifiers on the form field
function removeHardValidate(inputField) {
    inputField.classList.remove('contact-form__input-field--definitely-valid', 'contact-form__input-field--needs-changing', 'contact-form__input-field--presubmission-invalid');
    hideErrorIndicator(inputField);
}

/* Event listeners for additional validation */

// Grab the contact form
const contactForm = document.querySelector('form#contact-form');
// Grab the <div> that contains form fields but not the submit <button>
const eventDelegatorDiv = contactForm.querySelector('.contact-form__validation-event-delegator');

// Per-field validation bound to 'focusout' event on form fields
eventDelegatorDiv.addEventListener('focusout', event => {
    
    if (event.target.checkValidity()) {
        indicateHardValid(event.target);
        hideErrorIndicator(event.target);
    }
    // Don't need an Else clause here, 
    // because `event.target.checkValidity()` causes an 'invalid' event if false
});

// If the user returns to a form field 
eventDelegatorDiv.addEventListener('focusin', event => {
    
    // Remove strong visual signifiers on the form field
    removeHardValidate(event.target);
});

// Overwrite the existing 'invalid' event with custom functionality
eventDelegatorDiv.addEventListener('invalid', event => {

    // Prevent the browser-native feedback bubbles from appearing
    event.preventDefault();

    // Signify invalid value needs changing
    indicateHardInvalid(event.target);
}, {
    // Capture-phase event, not a bubble-phase event
    capture: true
});

// Hide the error indicator if the user starts typing again
eventDelegatorDiv.addEventListener('input', event => {
    hideErrorIndicator(event.target);
});

// Deactivate default pre-submission validation behaviour
// (Browser native validation will still occur if JavaScript is disabled)
contactForm.setAttribute('novalidate', true);

// Final pre-submission validation
contactForm.addEventListener('submit', event => {

    if (!contactForm.checkValidity()) {

        // Manually prevent the form from submitting
        event.preventDefault();
        
        contactForm.querySelectorAll(':invalid').forEach(invalidField => {
            // Add a red border around each invalid field
            invalidField.classList.add('contact-form__input-field--presubmission-invalid');
            // Show the error indicator underneath each invalid field
            showErrorIndicator(invalidField);
        });

        // Ensure focus goes to the first invalid form field
        const nextInvalidFieldToFillIn = contactForm.querySelectorAll(':invalid')[0];
        nextInvalidFieldToFillIn.focus();
        showErrorIndicator(nextInvalidFieldToFillIn);

    } else {
        // If validation passes, submit the form!
        contactForm.submit();
    }
});