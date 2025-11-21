document.addEventListener('DOMContentLoaded', () => {
    // Mobile Menu Toggle
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    const servicesDropdown = document.getElementById('servicesDropdown');
    const servicesMenu = document.getElementById('servicesMenu');

    if (mobileMenuButton) {
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    if (servicesDropdown) {
        servicesDropdown.addEventListener('click', () => {
            servicesMenu.classList.toggle('hidden');
            servicesDropdown.querySelector('i').classList.toggle('fa-chevron-down');
            servicesDropdown.querySelector('i').classList.toggle('fa-chevron-up');
        });
    }

    // Login Modal
    const loginBtn = document.getElementById('loginBtn');
    const loginModal = document.getElementById('loginModal');
    const closeLoginModal = document.getElementById('closeLoginModal');

    if (loginBtn) {
        loginBtn.addEventListener('click', () => {
            loginModal.classList.remove('hidden');
        });
    }

    if (closeLoginModal) {
        closeLoginModal.addEventListener('click', () => {
            loginModal.classList.add('hidden');
        });
    }

    // Close modal when clicking outside
    if (loginModal) {
        loginModal.addEventListener('click', (e) => {
            if (e.target === loginModal) {
                loginModal.classList.add('hidden');
            }
        });
    }

    // Add Review Modal
    const addReviewBtn = document.getElementById('addReviewBtn');
    const reviewModal = document.getElementById('reviewModal');
    const closeReviewModal = document.getElementById('closeReviewModal');
    const ratingStars = document.getElementById('ratingStars');
    const ratingValueInput = document.getElementById('ratingValue');

    if (addReviewBtn) {
        addReviewBtn.addEventListener('click', () => {
            reviewModal.classList.remove('hidden');
        });
    }

    if (closeReviewModal) {
        closeReviewModal.addEventListener('click', () => {
            reviewModal.classList.add('hidden');
        });
    }

    // Close modal when clicking outside
    if (reviewModal) {
        reviewModal.addEventListener('click', (e) => {
            if (e.target === reviewModal) {
                reviewModal.classList.add('hidden');
            }
        });
    }

    // Star Rating functionality
    if (ratingStars) {
        ratingStars.addEventListener('click', (e) => {
            if (e.target.tagName === 'I') {
                const rating = e.target.dataset.rating;
                ratingValueInput.value = rating;
                Array.from(ratingStars.children).forEach(star => {
                    if (star.tagName === 'I') {
                        if (parseInt(star.dataset.rating) <= rating) {
                            star.classList.remove('far');
                            star.classList.add('fas', 'text-yellow-500');
                        } else {
                            star.classList.remove('fas', 'text-yellow-500');
                            star.classList.add('far');
                        }
                    }
                });
            }
        });
    }

    // Services Tab Switching
    const sellTab = document.getElementById('sellTab');
    const buyTab = document.getElementById('buyTab');
    const sellSection = document.getElementById('sell');
    const buySection = document.getElementById('buy');

    if (sellTab && buyTab && sellSection && buySection) {
        sellTab.addEventListener('click', () => {
            sellTab.classList.add('active-tab');
            buyTab.classList.remove('active-tab');
            sellSection.classList.remove('hidden');
            buySection.classList.add('hidden');
        });

        buyTab.addEventListener('click', () => {
            buyTab.classList.add('active-tab');
            sellTab.classList.remove('active-tab');
            buySection.classList.remove('hidden');
            sellSection.classList.add('hidden');
        });
    }

    // Fiber Length and Moisture Content Sliders
    const lengthSlider = document.getElementById('length');
    const lengthValueSpan = document.getElementById('lengthValue');
    const moistureSlider = document.getElementById('moisture');
    const moistureValueSpan = document.getElementById('moistureValue');

    if (lengthSlider && lengthValueSpan) {
        lengthSlider.addEventListener('input', (event) => {
            lengthValueSpan.textContent = `${event.target.value} cm`;
        });
    }

    if (moistureSlider && moistureValueSpan) {
        moistureSlider.addEventListener('input', (event) => {
            moistureValueSpan.textContent = `${event.target.value}%`;
        });
    }

    // Form Submission (for demonstration, actual processing would be server-side)
    const sellFiberForm = document.getElementById('sellFiberForm');
    if (sellFiberForm) {
        sellFiberForm.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Fiber listing submitted! (This is a demo, no actual data sent)');
            sellFiberForm.reset();
        });
    }

    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Message sent! (This is a demo, no actual data sent)');
            contactForm.reset();
        });
    }

    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Login attempt! (This is a demo, no actual login)');
            loginModal.classList.add('hidden');
            loginForm.reset();
        });
    }

    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
        reviewForm.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Review submitted! (This is a demo, no actual data sent)');
            reviewModal.classList.add('hidden');
            reviewForm.reset();
            // Reset stars
            Array.from(ratingStars.children).forEach(star => {
                if (star.tagName === 'I') {
                    star.classList.remove('fas', 'text-yellow-500');
                    star.classList.add('far');
                }
            });
            ratingValueInput.value = '0';
        });
    }
});
