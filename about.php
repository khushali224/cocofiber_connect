<?php
session_start();
include 'config/db.php'; // DB connection

// --- Fetch Story (latest one) ---
$story = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM company_story ORDER BY id DESC LIMIT 1"));

// --- Fetch Mission & Vision ---
$mission = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM mission_vision WHERE type='mission' ORDER BY id DESC LIMIT 1"));
$vision  = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM mission_vision WHERE type='vision' ORDER BY id DESC LIMIT 1"));

// --- Fetch Core Values ---
$values = mysqli_query($con, "SELECT * FROM core_values ORDER BY id ASC");

// --- Fetch Testimonials ---
$testimonials = mysqli_query($con, "SELECT * FROM testimonials ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us | CocoFiber Connect</title>
  
  <style>
    /* Hero Section */
    :root {
    --primary: #5D4037;
    --primary-light: #8D6E63;
    --primary-lighter: #D7CCC8;
    --text: #3E2723;
    --text-light: #5D4037;
    --bg-light: #EFEBE9;
    --white: #FFFFFF;
    --transition: all 0.3s ease;
    
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    color: var(--text);
    line-height: 1.6;
    background-color: var(--primary-lighter);
}

/* Hero Section */
.hero {
    padding: 10rem 5% 5rem;
    background: linear-gradient(rgba(208, 103, 71, 0.8), rgba(100, 43, 26, 0.8)), 
             no-repeat center center/cover;
    color: var(--white);
    text-align: center;
}

.hero h1 {
    font-size: 3rem;
    margin-bottom: 1.5rem;
    max-width: 900px;
    margin-left: auto;
    margin-right: auto;
}

.hero p {
    font-size: 1.2rem;
    max-width: 700px;
    margin: 0 auto 2rem;
}

/* About Section */
.section {
    padding: 5rem 5%;
    max-width: 1400px;
    margin: 0 auto;
}

.section-title {
    text-align: center;
    margin-bottom: 3rem;
    color: var(--primary);
}

.section-title h2 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.section-title .underline {
    height: 4px;
    width: 80px;
    background-color: var(--primary-light);
    margin: 0 auto;
}

/* Our Story */
.our-story {
    display: flex;
    align-items: center;
    gap: 4rem;
    margin-bottom: 5rem;
}

.our-story img {
    width: 50%;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.our-story-content {
    width: 50%;
}

.our-story h3 {
    font-size: 2rem;
    margin-bottom: 1.5rem;
    color: var(--primary);
}

/* Mission & Vision */
.mission-vision {
    display: flex;
    gap: 2rem;
    margin-bottom: 5rem;
}

.mission, .vision {
    flex: 1;
    padding: 2.5rem;
    border-radius: 10px;
    background-color: var(--white);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    transition: var(--transition);
}

.mission:hover, .vision:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.mission h3, .vision h3 {
    color: var(--primary);
    margin-bottom: 1.5rem;
    font-size: 1.5rem;
}

.mission-icon, .vision-icon {
    font-size: 2.5rem;
    color: var(--primary-light);
    margin-bottom: 1.5rem;
}

/* Values */
.values {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    margin-bottom: 5rem;
}

.value-card {
    padding: 2rem;
    border-radius: 10px;
    background-color: var(--white);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    text-align: center;
    transition: var(--transition);
}

.value-card:hover {
    background-color: var(--primary);
    color: var(--white);
}

.value-card h4 {
    margin-bottom: 1rem;
    font-size: 1.5rem;
}

/* Testimonials */
.testimonials {
    display: flex;
    gap: 2rem;
    overflow-x: auto;
    padding: 1rem;
    margin-bottom: 5rem;
}

.testimonial-card {
    min-width: 300px;
    padding: 2rem;
    border-radius: 10px;
    background-color: var(--white);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.testimonial-card img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 1rem;
}

.testimonial-card p {
    font-style: italic;
    margin-bottom: 1rem;
}

.testimonial-card h5 {
    color: var(--primary);
}

/* Stats */
.stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    text-align: center;
    margin-bottom: 5rem;
}

.stat-card h3 {
    font-size: 3rem;
    color: var(--primary);
    margin-bottom: 0.5rem;
}

/* CTA */
.cta {
    padding: 5rem;
    text-align: center;
    background-color: var(--primary);
    color: var(--white);
    border-radius: 10px;
}

.cta h3 {
    font-size: 2rem;
    margin-bottom: 1.5rem;
}

.cta .btn {
    background-color: var(--white);
    color: var(--primary);
}

.cta .btn:hover {
    background-color: var(--bg-light);
}

/* Responsive */
@media (max-width: 768px) {
    .mobile-menu {
        display: block;
    }

    .hero h1 {
        font-size: 2.2rem;
    }

    .our-story {
        flex-direction: column;
        align-items: center;
    }

    .our-story img, .our-story-content {
        width: 100%;
    }

    .mission-vision {
        flex-direction: column;
    }

    .mission, .vision {
        margin-bottom: 2rem; /* Added margin for spacing */
    }

    .testimonials {
        flex-direction: column; /* Stack testimonials vertically */
        overflow-x: hidden; /* Disable horizontal scroll */
    }

    .testimonial-card {
        min-width: 100%; /* Full width for mobile */
    }

    .cta {
        padding: 3rem; /* Reduced padding for smaller screens */
    }

    .cta h3 {
        font-size: 1.5rem; /* Smaller font size for mobile */
    }
}
  .hero {
      position: relative;
      background: url('css/bg.jpg') no-repeat center center/cover;
      height: 70vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      color: white;
    }
    .hero::after {
      content: "";
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
    }
    .hero h1, .hero p {
      position: relative;
      z-index: 1;
    }
    .hero h1 { font-size: 3rem; margin-bottom: 1rem; }
    .hero p { font-size: 1.2rem; max-width: 800px; }

    /* Our Story */
    .our-story {
      display: flex;
      gap: 40px;
      align-items: center;
      margin: 20px auto;
      max-width: 1000px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .our-story img {
      max-width: 550px;
      border-radius: 35px;
      transition: transform 0.3s ease;
    }
    

    /* Mission & Vision */
    .mission-vision {
      display: flex;
      justify-content: center;
      gap: 30px;
      flex-wrap: wrap;
      margin-top: 20px;
    }
    .mission, .vision {
      background: #f9f9f9;
      padding: 20px;
      border-radius: 12px;
      text-align: center;
      width: 280px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      transition: all 0.3s ease-in-out;
      cursor: pointer;
    }
    .mission:hover, .vision:hover {
      background: #DAA06D;
      color: white;
      transform: translateY(-8px);
      box-shadow: 0 6px 15px rgba(0,0,0,0.25);
    }
    .mission-icon, .vision-icon {
      font-size: 2rem;
      margin-bottom: 10px;
      transition: color 0.3s ease;
    }
    .mission:hover .mission-icon,
    .vision:hover .vision-icon {
      color: #FFD700;
    }

    /* Core Values */
    .values {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
      margin-top: 20px;
    }
    .value-card {
      background: #fff8f0;
      padding: 20px;
      border-radius: 12px;
      width: 260px;
      text-align: center;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      transition: all 0.3s ease-in-out;
      cursor: pointer;
    }
    .value-card:hover {
      background: #8B5E3C;
      color: white;
      transform: translateY(-8px);
      box-shadow: 0 6px 15px rgba(0,0,0,0.25);
    }

    /* Testimonials */
    .testimonials {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
      margin-top: 20px;
    }
    .testimonial-card {
      background: #f9f9f9;
      padding: 20px;
      border-radius: 12px;
      width: 280px;
      text-align: center;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      transition: all 0.3s ease-in-out;
    }
    .testimonial-card img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      margin-bottom: 10px;
      transition: transform 0.3s ease;
    }
    .testimonial-card:hover {
      background: #DAA06D;
      color: white;
      transform: translateY(-8px);
      box-shadow: 0 6px 15px rgba(0,0,0,0.25);
    }
    .testimonial-card:hover img {
      transform: scale(1.1);
    }
  </style>
</head>
<body>
<?php include 'header.php'; ?>

<!-- Hero Section -->
<section class="hero">
  <h1>Growing Connections, Building Communities</h1>
  <p>CocoFiber Connect is revolutionizing internet connectivity with sustainable fiber optic solutions.</p>
</section>

<!-- Our Story -->
<section class="section">
  <div class="section-title"><h2>Our Story</h2><div class="underline"></div></div>
  <?php if ($story) { ?>
    <div class="our-story">
      <?php if (!empty($story['image'])) { ?>
        <img src="uploads/<?php echo htmlspecialchars($story['image']); ?>" alt="Our Story">
      <?php } ?>
      <div class="our-story-content">
        <h3><?php echo htmlspecialchars($story['title']); ?></h3>
        <p><?php echo nl2br(htmlspecialchars($story['description'])); ?></p>
      </div>
    </div>
  <?php } else { ?>
    <p style="text-align:center;">Our story will be updated soon.</p>
  <?php } ?>
</section>

<!-- Mission & Vision -->
<section class="section">
  <div class="section-title"><h2>Our Mission & Vision</h2><div class="underline"></div></div>
  <div class="mission-vision">
    <?php if ($mission) { ?>
      <div class="mission">
        <div class="mission-icon">
          <?php echo !empty($mission['icon']) ? $mission['icon'] : "🌱"; ?>
        </div>
        <h3><?php echo htmlspecialchars($mission['title']); ?></h3>
        <p><?php echo nl2br(htmlspecialchars($mission['description'])); ?></p>
      </div>
    <?php } ?>
    <?php if ($vision) { ?>
      <div class="vision">
        <div class="vision-icon">
          <?php echo !empty($vision['icon']) ? $vision['icon'] : "👁️"; ?>
        </div>
        <h3><?php echo htmlspecialchars($vision['title']); ?></h3>
        <p><?php echo nl2br(htmlspecialchars($vision['description'])); ?></p>
      </div>
    <?php } ?>
  </div>
</section>

<!-- Core Values -->
<section class="section">
  <div class="section-title"><h2>Our Core Values</h2><div class="underline"></div></div>
  <div class="values">
    <?php if (mysqli_num_rows($values) > 0) { 
      while($val = mysqli_fetch_assoc($values)) { ?>
        <div class="value-card">
          <h4><?php echo htmlspecialchars($val['title']); ?></h4>
          <p><?php echo nl2br(htmlspecialchars($val['description'])); ?></p>
        </div>
    <?php } } else { ?>
      <p style="text-align:center;">Core values will be updated soon.</p>
    <?php } ?>
  </div>
</section>

<!-- Testimonials -->
<section class="section">
  <div class="section-title"><h2>What Our Customers Say</h2><div class="underline"></div></div>
  <div class="testimonials">
    <?php if (mysqli_num_rows($testimonials) > 0) { 
      while($t = mysqli_fetch_assoc($testimonials)) { ?>
        <div class="testimonial-card">
          <?php if (!empty($t['image'])) { ?>
            <img src="uploads/<?php echo htmlspecialchars($t['image']); ?>" alt="<?php echo htmlspecialchars($t['name']); ?>">
          <?php } ?>
          <p>"<?php echo nl2br(htmlspecialchars($t['message'])); ?>"</p>
          <h5><?php echo htmlspecialchars($t['name']); ?></h5>
          <p><?php echo htmlspecialchars($t['role']); ?></p>
        </div>
    <?php } } else { ?>
      <p style="text-align:center;">No testimonials available yet.</p>
    <?php } ?>
  </div>
</section>

<?php include 'footer.php'; ?>
</body>
</html>
