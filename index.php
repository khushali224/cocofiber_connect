<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cocofiber Connect</title>
  <link rel="stylesheet" href="css/main.css">
  <style>
    h1{
  font-size:5vw;
  margin:0;
  background-image:url("css/main1.jpg");
  background-size:cover;
  background-clip:text;
  -webkit-background-clip:text;
  color:transparent;
}
    </style>
</head>
<body>


  <!-- Header -->
  <header>
    <div class="container header-container">
      <div class="logo">
        <img src="css/logo2.png" alt="Cocofiber Connect Logo - Brown and white coconut fiber symbol">
        <h1>Cocofiber Connect</h1>
      </div> 
    </div>
  </header>

  <!-- Main Content -->
  <main class="container">
    <!-- Hero Slider -->
    <div class="hero">
      <div class="slider">
        <!-- Slide 1 -->
        <div class="slide">
          <img src="css/background.png" alt="Large scale coconut fiber production facility with workers processing raw materials">
          <div class="slide-content">
            <h2>Sustainable Cocofiber Solutions</h2>
            <p>Connecting global markets with premium quality coconut fiber products</p>
            <button class="get-start-btn" onclick="window.location.href='login_register.php'">Get Started</button>
          </div>
        </div>
        <!-- Slide 2 -->
        <div class="slide">
          <img src="css/back.png" alt="Assortment of cocofiber products including mats, ropes, and textiles on display">
          <div class="slide-content">
            <h2>Eco-Friendly Materials</h2>
            <p>Premium natural fibers for diverse industrial applications</p>
            <button class="get-start-btn" onclick="window.location.href='login_register.php'">Get Started</button>
          </div>
        </div>
        <!-- Slide 3 -->
        <div class="slide">
          <img src="css/background2.png" alt="World map with shipping routes connecting continents showing global cocofiber trade">
          <div class="slide-content">
            <h2>Global Network</h2>
            <p>Connecting producers with buyers worldwide</p>
            <button class="get-start-btn" onclick="window.location.href='login_register.php'">Get Started</button>
          </div>
        </div>
      </div>

      <!-- Slider Dots -->
      <div class="slider-controls">
        <div class="slider-control active" onclick="goToSlide(0)"></div>
        <div class="slider-control" onclick="goToSlide(1)"></div>
        <div class="slider-control" onclick="goToSlide(2)"></div>
      </div>
    </div>
  </main>

  <!-- Script -->
  <script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');
    const sliderControls = document.querySelectorAll('.slider-control');
    const slider = document.querySelector('.slider');

    function updateSlider() {
      slider.style.transform = `translateX(-${currentSlide * 100}%)`;
      sliderControls.forEach((control, index) => {
        control.classList.toggle('active', index === currentSlide);
      });
    }

    function nextSlide() {
      currentSlide = (currentSlide + 1) % slides.length;
      updateSlider();
    }

    function goToSlide(index) {
      currentSlide = index;
      updateSlider();
    }

    // Auto Slide every 3 seconds
    let slideInterval = setInterval(nextSlide, 3000);

    // Pause on hover
    const hero = document.querySelector('.hero');
    hero.addEventListener('mouseenter', () => clearInterval(slideInterval));
    hero.addEventListener('mouseleave', () => slideInterval = setInterval(nextSlide, 3000));

    // Initialize
    updateSlider();
  </script>

</body>
</html>
