 const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const nav = document.querySelector('nav');

        mobileMenuBtn.addEventListener('click', () => {
            nav.classList.toggle('active');
        });

        // Page Navigation
        function showPage(pageId) {
            // Hide all pages
            document.querySelectorAll('.page').forEach(page => {
                page.classList.remove('active');
            });
            
            // Show selected page
            document.getElementById(pageId).classList.add('active');
            
            // Close mobile menu if open
            nav.classList.remove('active');
            
            // Smooth scroll to top
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Slider Functionality
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const sliderControls = document.querySelectorAll('.slider-control');
        const slider = document.querySelector('.slider');

        function updateSlider() {
            slider.style.transform = `translateX(-${currentSlide * 100}%)`;
            
            // Update controls
            sliderControls.forEach((control, index) => {
                if (index === currentSlide) {
                    control.classList.add('active');
                } else {
                    control.classList.remove('active');
                }
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            updateSlider();
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            updateSlider();
        }

        function goToSlide(index) {
            currentSlide = index;
            updateSlider();
        }

        // Auto slide change
        let slideInterval = setInterval(nextSlide, 5000);

        // Pause on hover
        const hero = document.querySelector('.hero');
        hero.addEventListener('mouseenter', () => {
            clearInterval(slideInterval);
        });

        hero.addEventListener('mouseleave', () => {
            slideInterval = setInterval(nextSlide, 5000);
        });

        // Form Submission
        const contactForm = document.getElementById('contactForm');
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Thank you for your message! We will get back to you soon.');
            contactForm.reset();
        });

        // Initialize slider controls
        updateSlider();
