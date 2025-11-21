<?php
session_start();
include "header.php";
include "config/db.php";

// Fetch hero section
$hero = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM hero_section ORDER BY id DESC LIMIT 1"));

// Fetch how it works steps
$steps = mysqli_query($con, "SELECT * FROM how_it_works ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cocofiber Connect</title>
  <link rel="stylesheet" href="css/index.css">
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      /* Use single fixed background image */
      background: url("css/bg.jpg") no-repeat center center fixed;
      background-size: cover; /* ensures one image covers screen */
      color: #333;
      line-height: 1.6;
    }
    footer {
      background: #5D4037;
      text-align: center;
      padding: 15px;
      color: #deaa88;
      font-size: 14px;
      margin-top: 40px;
    }

    /* Container */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 15px;
    }

    /* Hero Section */
    .hero-section {
      padding: 60px 0;
      background: transparent;
    }
    .hero-box {
      position: relative;
      border-radius: 20px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.1);
      padding: 40px;
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      overflow: hidden;
      background: rgba(255, 248, 240, 0.85); /* light overlay so text is readable */
    }
    .hero-text { flex: 1 1 50%; padding-right: 20px; }
    .hero-text h1 { font-size: 39px; font-weight: bold; color: #5D4037; margin-bottom: 15px; }
    .hero-text p { font-size: 18px; color: #4a4543; line-height: 1.6; }
    .hero-image { flex: 1 1 40%; text-align: right; }
    .hero-image img { max-width: 100%; border-radius: 15px; }

    /* Responsive Hero */
    @media (max-width: 768px) {
      .hero-box {
        flex-direction: column;
        text-align: center;
        padding: 30px 20px;
      }
      .hero-text { padding-right: 0; margin-bottom: 20px; }
      .hero-image { text-align: center; }
    }

    /* How It Works */
    .how-card {
      background: #ffebcd;
      border-radius: 20px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.08);
      padding: 30px;
      max-width: 1000px;
      margin: 40px auto;
    }
    .how-card h2 { font-size: 30px; font-weight: bold; margin-bottom: 18px; text-align: center; color: #5D4037; }
    .how-grid { display: grid; grid-template-columns: 1fr; gap: 40px; }
    .how-item { display: flex; flex-direction: column; align-items: center; text-align: center; }
    .how-item h3 { font-size: 20px; font-weight: bold; margin: 8px 0 6px; color: #4a4543; }
    .how-item p { font-size: 15px; margin: 0; color: #4a4543; line-height: 1.5; }
    .how-item img { margin-bottom: 12px; max-width: 80px; }
    @media (min-width: 680px) { .how-grid { grid-template-columns: repeat(3, 1fr); } }
  </style>
</head>
<body>

<main>
  <!-- Hero Section -->
  <section class="hero-section">
    <div class="container">
      <div class="hero-box">
        <div class="hero-text">
          <h1><?php echo htmlspecialchars($hero['title']); ?></h1>
          <p><?php echo htmlspecialchars($hero['subtitle']); ?></p>
        </div>
        <div class="hero-image">
          <?php if($hero['image']) { ?>
            <img src="uploads/<?php echo $hero['image']; ?>" alt="Hero">
          <?php } ?>
        </div>
      </div>
    </div>
  </section>

  <!-- How It Works -->
  <section class="how-card">
    <h2>How It Works</h2>
    <div class="how-grid">
      <?php while($row = mysqli_fetch_assoc($steps)) { ?>
      <div class="how-item">
        <?php if ($row['image']) { ?>
          <img src="uploads/<?php echo $row['image']; ?>" alt="Step">
        <?php } ?>
        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
        <p><?php echo htmlspecialchars($row['description']); ?></p>
      </div>
      <?php } ?>
    </div>
  </section>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
