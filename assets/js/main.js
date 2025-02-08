


// JavaScript to toggle the sticky class on scroll
window.addEventListener('scroll', function() {
    const header = document.getElementById('masthead');
    if (window.scrollY > 0) {
        header.classList.add('sticky');
    } else {
        header.classList.remove('sticky');
    }
});



const rotatingText = document.getElementById("rotating-text");
const texts = rotatingText.getAttribute("data-change-items").split("|"); // Get text list from the data attribute
let currentRotatingTextIndex = 0; // Track the index of the rotating text

// Function to show next rotating text with smooth transition
function showNextText() {
    // Fade out the current rotating text
    rotatingText.style.opacity = 0;

    // Wait for fade out to complete before changing the text
    setTimeout(() => {
        rotatingText.textContent = texts[currentRotatingTextIndex]; // Change the text
        rotatingText.style.opacity = 1; // Fade-in the new text
        currentRotatingTextIndex = (currentRotatingTextIndex + 1) % texts.length; // Loop back to the first text
    }, 500); // Wait for 0.5 seconds before changing text
}

const selectTyped = document.querySelector('.typed');
if (selectTyped) {
    let typedStrings = selectTyped.getAttribute('data-typed-items');
    typedStrings = typedStrings.split(',');

    let currentIndex = 0;
    let currentCharIndex = 0;
    let isDeleting = false;
    const typeSpeed = 100;
    const backSpeed = 50;
    const backDelay = 2000;

    // Function for typing effect
    function typeEffect() {
        const currentString = typedStrings[currentIndex];

        if (!isDeleting) {
            // Add characters
            selectTyped.textContent = currentString.substring(0, currentCharIndex + 1);
            currentCharIndex++;

            if (currentCharIndex === currentString.length) {
                isDeleting = true;
                setTimeout(typeEffect, backDelay); // Pause before deleting
                return;
            }
        } else {
            // Remove characters
            selectTyped.textContent = currentString.substring(0, currentCharIndex - 1);
            currentCharIndex--;

            if (currentCharIndex === 0) {
                isDeleting = false;
                currentIndex = (currentIndex + 1) % typedStrings.length; // Move to the next string
                onDeleteComplete(); // Change the rotating text after the typing-deleting cycle
            }
        }

        const speed = isDeleting ? backSpeed : typeSpeed;
        setTimeout(typeEffect, speed);
    }

    // Callback to handle text change after deleting
    function onDeleteComplete() {
        // Fade-out current rotating text and change to the next one
        showNextText();
    }

    // Show the first rotating text immediately and start the typing effect
    rotatingText.style.opacity = 1; // Ensure the text is visible initially
    showNextText(); // Display the first rotating text
    typeEffect(); // Start the typing effect
}


document.addEventListener("DOMContentLoaded", () => {
    
});


document.addEventListener("DOMContentLoaded", function () {
    const sections = document.querySelectorAll(".section-container");

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("animate-in");
                    entry.target.classList.remove("animate-out");
                } else {
                    entry.target.classList.add("animate-out");
                    entry.target.classList.remove("animate-in");
                }
            });
        },
        { threshold: 0.4 } // Adjust the threshold as needed
    );

    sections.forEach((section) => {
        observer.observe(section);
    });
});

