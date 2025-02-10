document.addEventListener("DOMContentLoaded", function () {
    const sections = document.querySelectorAll(".section-container:not(.modal)");


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

document.addEventListener('DOMContentLoaded', function () {
    const toggler = document.getElementById('navbar-toggler');
    const togglerIcon = document.getElementById('navbar-toggler-icon');
    const navbarMenu = document.getElementById('primary-menu');

    if (!toggler || !togglerIcon || !navbarMenu) {
        console.error('Navbar toggler, icon, or menu not found!');
        return;
    }

    // Toggle icon and menu visibility on click
    toggler.addEventListener('click', function () {
        const isExpanded = toggler.getAttribute('aria-expanded') === 'true';

        // Toggle `aria-expanded` attribute
        toggler.setAttribute('aria-expanded', !isExpanded);

        // Update icon
        if (!isExpanded) {
            togglerIcon.classList.remove('bi-list');
            togglerIcon.classList.add('bi-x');
            navbarMenu.classList.add('show'); // Show the menu
        } else {
            togglerIcon.classList.remove('bi-x');
            togglerIcon.classList.add('bi-list');
            navbarMenu.classList.remove('show'); // Hide the menu
        }
    });

    // Optional: Close menu when clicking outside
    document.addEventListener('click', function (event) {
        if (!navbarMenu.contains(event.target) && !toggler.contains(event.target)) {
            if (toggler.getAttribute('aria-expanded') === 'true') {
                toggler.setAttribute('aria-expanded', 'false');
                togglerIcon.classList.remove('bi-x');
                togglerIcon.classList.add('bi-list');
                navbarMenu.classList.remove('show');
            }
        }
    });

    // Optional: Reset to initial state on window resize
    window.addEventListener('resize', function () {
        if (window.innerWidth >= 992) { // Adjust based on your breakpoint
            toggler.setAttribute('aria-expanded', 'false');
            togglerIcon.classList.remove('bi-x');
            togglerIcon.classList.add('bi-list');
            navbarMenu.classList.remove('show');
        }
    });

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                let el = entry.target;
                el.classList.add(el.dataset.animation);
                el.style.opacity = 1;
                observer.unobserve(el); // Stop observing after animation starts
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll(".hidden_animate").forEach(el => observer.observe(el));
});



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
if (rotatingText){
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

}


document.addEventListener("DOMContentLoaded", () => {
    
});





document.addEventListener("DOMContentLoaded", function () {
    const noticeBar = document.querySelector(".notice-bar");

    function toggleNoticeBar() {
        if (window.scrollY === 0) {
            // Page is at the top, show notice bar
            noticeBar.style.transform = "translateY(0)";
        } else {
            // Page is scrolled down, hide notice bar
            noticeBar.style.transform = "translateY(-100%)";
        }
    }

    // Run function on scroll
    window.addEventListener("scroll", toggleNoticeBar);

    // Run function on load to ensure correct state
    toggleNoticeBar();
});


function animateCountUp(element) {
    const text = element.innerText;
    const number = parseInt(text.replace(/\D/g, "")); // Extract numbers only
    let current = 0;
    const increment = Math.ceil(number / 100); // Adjust speed
    
    function updateCount() {
        if (current < number) {
            current += increment;
            if (current > number) current = number;
            element.innerText = current.toLocaleString();
            requestAnimationFrame(updateCount);
        }
    }
    
    updateCount();
}

document.addEventListener("DOMContentLoaded", function () {
    const counterElement = document.querySelector("h1.h1");
    if (counterElement) {
        animateCountUp(counterElement);
    }
});


