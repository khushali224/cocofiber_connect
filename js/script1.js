document.addEventListener('DOMContentLoaded', function() {
    // Mobile Menu Toggle
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    const servicesDropdown = document.getElementById('servicesDropdown');
    const servicesMenu = document.getElementById('servicesMenu');

    if (mobileMenuButton) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }

    if (servicesDropdown) {
        servicesDropdown.addEventListener('click', function() {
            servicesMenu.classList.toggle('hidden');
            const icon = servicesDropdown.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-chevron-down');
                icon.classList.toggle('fa-chevron-up');
            }
        });
    }

    // Login Modal
    const loginBtn = document.getElementById('loginBtn');
    const loginModal = document.getElementById('loginModal');
    const closeLoginModal = document.getElementById('closeLoginModal');

    if (loginBtn) {
        loginBtn.addEventListener('click', function() {
            loginModal.classList.remove('hidden');
        });
    }

    if (closeLoginModal) {
        closeLoginModal.addEventListener('click', function() {
            loginModal.classList.add('hidden');
        });
    }

    // Close modal when clicking outside
    if (loginModal) {
        loginModal.addEventListener('click', function(e) {
            if (e.target === loginModal) {
                loginModal.classList.add('hidden');
            }
        });
    }

    // Services Section Tabs
    const sellTab = document.getElementById('sellTab');
    const buyTab = document.getElementById('buyTab');
    const sellSection = document.getElementById('sell');
    const buySection = document.getElementById('buy');

    function showSellSection() {
        sellSection.classList.remove('hidden');
        buySection.classList.add('hidden');
        sellTab.classList.add('active-tab');
        buyTab.classList.remove('active-tab');
    }

    function showBuySection() {
        buySection.classList.remove('hidden');
        sellSection.classList.add('hidden');
        buyTab.classList.add('active-tab');
        sellTab.classList.remove('active-tab');
    }

    if (sellTab) {
        sellTab.addEventListener('click', showSellSection);
    }
    if (buyTab) {
        buyTab.addEventListener('click', showBuySection);
    }

    // Handle direct links to sections (e.g., from navigation)
    const hash = window.location.hash;
    if (hash === '#buy') {
        showBuySection();
    } else if (hash === '#sell') {
        showSellSection();
    } else {
        // Default to showing sell section if no specific hash or invalid hash
        showSellSection();
    }

    // Update range slider values for Sell Fiber Form
    const lengthInput = document.getElementById('length');
    const lengthValueSpan = document.getElementById('lengthValue');
    const moistureInput = document.getElementById('moisture');
    const moistureValueSpan = document.getElementById('moistureValue');

    if (lengthInput && lengthValueSpan) {
        lengthInput.addEventListener('input', function() {
            lengthValueSpan.textContent = this.value + ' cm';
        });
    }

    if (moistureInput && moistureValueSpan) {
        moistureInput.addEventListener('input', function() {
            moistureValueSpan.textContent = this.value + '%';
        });
    }

    // Add Review Modal
    const addReviewBtn = document.getElementById('addReviewBtn');
    const reviewModal = document.getElementById('reviewModal');
    const closeReviewModal = document.getElementById('closeReviewModal');
    const ratingStars = document.getElementById('ratingStars');
    const ratingValueInput = document.getElementById('ratingValue');

    if (addReviewBtn) {
        addReviewBtn.addEventListener('click', function() {
            reviewModal.classList.remove('hidden');
        });
    }

    if (closeReviewModal) {
        closeReviewModal.addEventListener('click', function() {
            reviewModal.classList.add('hidden');
        });
    }

    // Close review modal when clicking outside
    if (reviewModal) {
        reviewModal.addEventListener('click', function(e) {
            if (e.target === reviewModal) {
                reviewModal.classList.add('hidden');
            }
        });
    }

    if (ratingStars && ratingValueInput) {
        ratingStars.addEventListener('click', function(e) {
            const clickedStar = e.target.closest('i');
            if (clickedStar && clickedStar.dataset.rating) {
                const rating = parseInt(clickedStar.dataset.rating);
                ratingValueInput.value = rating;

                // Update star appearance
                Array.from(ratingStars.children).forEach(star => {
                    if (star.tagName === 'I') {
                        const starRating = parseInt(star.dataset.rating);
                        if (starRating <= rating) {
                            star.classList.remove('far');
                            star.classList.add('fas');
                        } else {
                            star.classList.remove('fas');
                            star.classList.add('far');
                        }
                    }
                });
            }
        });
    }

    // Form submission (placeholder for actual AJAX/backend interaction)
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            // Prevent default form submission for demonstration
            // In a real app, you'd send this via fetch/XMLHttpRequest
            // e.preventDefault();
            // alert('Contact form submitted! (This is a demo, no actual email sent)');
            // You might want to add a success message or redirect here
        });
    }

    const sellFiberForm = document.getElementById('sellFiberForm');
    if (sellFiberForm) {
        sellFiberForm.addEventListener('submit', function(e) {
            // Prevent default form submission for demonstration
            // In a real app, you'd send this via fetch/XMLHttpRequest
            // e.preventDefault();
            // alert('Fiber listing submitted! (This is a demo, no actual data saved)');
            // You might want to add a success message or redirect here
        });
    }

    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            alert('Login attempt! (This is a demo, no actual login)');
            loginModal.classList.add('hidden'); // Hide modal after "login"
            // In a real application, you would send login credentials to a server
            // and handle the response (e.g., redirect, show error).
        });
    }

    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            const rating = ratingValueInput.value;
            const title = document.getElementById('reviewTitle').value;
            const text = document.getElementById('reviewText').value;

            if (rating > 0 && title && text) {
                alert(`Review Submitted!\nRating: ${rating} stars\nTitle: ${title}\nReview: ${text}`);
                reviewModal.classList.add('hidden');
                // In a real application, send this data to your backend
                // and dynamically add the new review to the list.
                // Reset form fields
                reviewForm.reset();
                Array.from(ratingStars.children).forEach(star => {
                    if (star.tagName === 'I') {
                        star.classList.remove('fas');
                        star.classList.add('far');
                    }
                });
                ratingValueInput.value = 0;
            } else {
                alert('Please provide a rating, title, and your review.');
            }
        });
    }
});
