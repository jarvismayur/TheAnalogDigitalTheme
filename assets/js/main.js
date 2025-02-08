document.addEventListener("DOMContentLoaded", function () {
    // Section Animations
    const sections = document.querySelectorAll(".section-container");
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("animate-in");
                entry.target.classList.remove("animate-out");
            } else {
                entry.target.classList.add("animate-out");
                entry.target.classList.remove("animate-in");
            }
        });
    }, { threshold: 0.4 });

    sections.forEach((section) => observer.observe(section));

    // Navbar Toggle
    const toggler = document.getElementById('navbar-toggler');
    const togglerIcon = document.getElementById('navbar-toggler-icon');
    const navbarMenu = document.getElementById('navbar-menu');

    if (toggler && togglerIcon && navbarMenu) {
        toggler.addEventListener('click', function () {
            const isExpanded = toggler.getAttribute('aria-expanded') === 'true';
            toggler.setAttribute('aria-expanded', !isExpanded);
            togglerIcon.classList.toggle('bi-list', isExpanded);
            togglerIcon.classList.toggle('bi-x', !isExpanded);
            navbarMenu.classList.toggle('show', !isExpanded);
        });

        document.addEventListener('click', function (event) {
            if (!navbarMenu.contains(event.target) && !toggler.contains(event.target) && navbarMenu.classList.contains('show')) {
                toggler.setAttribute('aria-expanded', 'false');
                togglerIcon.classList.add('bi-list');
                togglerIcon.classList.remove('bi-x');
                navbarMenu.classList.remove('show');
            }
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth >= 992) {
                toggler.setAttribute('aria-expanded', 'false');
                togglerIcon.classList.add('bi-list');
                togglerIcon.classList.remove('bi-x');
                navbarMenu.classList.remove('show');
            }
        });
    }

    // Sticky Header
    window.addEventListener('scroll', function () {
        const header = document.getElementById('masthead');
        if (header) {
            header.classList.toggle('sticky', window.scrollY > 0);
        }
    });

    // Rotating Text Animation
    const rotatingText = document.getElementById("rotating-text");
    if (rotatingText) {
        const texts = rotatingText.getAttribute("data-change-items").split("|");
        let currentRotatingTextIndex = 0;

        function showNextText() {
            rotatingText.style.opacity = 0;
            setTimeout(() => {
                rotatingText.textContent = texts[currentRotatingTextIndex];
                rotatingText.style.opacity = 1;
                currentRotatingTextIndex = (currentRotatingTextIndex + 1) % texts.length;
            }, 500);
        }

        showNextText();
        setInterval(showNextText, 3000);
    }

    // Typing Effect
    const selectTyped = document.querySelector('.typed');
    if (selectTyped) {
        let typedStrings = selectTyped.getAttribute('data-typed-items').split(',');
        let currentIndex = 0, currentCharIndex = 0, isDeleting = false;
        const typeSpeed = 100, backSpeed = 50, backDelay = 2000;

        function typeEffect() {
            const currentString = typedStrings[currentIndex];
            selectTyped.textContent = currentString.substring(0, currentCharIndex + (isDeleting ? -1 : 1));
            currentCharIndex += isDeleting ? -1 : 1;

            if (!isDeleting && currentCharIndex === currentString.length) {
                isDeleting = true;
                setTimeout(typeEffect, backDelay);
            } else if (isDeleting && currentCharIndex === 0) {
                isDeleting = false;
                currentIndex = (currentIndex + 1) % typedStrings.length;
                showNextText();
            } else {
                setTimeout(typeEffect, isDeleting ? backSpeed : typeSpeed);
            }
        }

        showNextText();
        typeEffect();
    }

    // Notice Bar Visibility on Scroll
    const noticeBar = document.querySelector(".notice-bar");
    if (noticeBar) {
        function toggleNoticeBar() {
            noticeBar.style.transform = window.scrollY === 0 ? "translateY(0)" : "translateY(-100%)";
        }
        window.addEventListener("scroll", toggleNoticeBar);
        toggleNoticeBar();
    }
});
