function typewriterText(element) {

    // Get each letter of the heading as an array
    const elementCharacters = element.innerText.split('');

    // Clear the element text
    element.innerText = '';

    // Add each character back into the DOM, one by one
    elementCharacters.forEach((character, index) => {
        setTimeout(() => {
            // If the character is a space, handle it explicitly, 
            // because `.innerHTML` has trouble otherwise
            if (character === ' ') {
                element.innerHTML += '&nbsp;';
            } else {
                element.innerText += character;
            }
        }, index * 100);  // Delay per letter = 0.1 second
    });
}

typewriterText(document.querySelector('.banner__heading'));
typewriterText(document.querySelector('.banner__subheading'));