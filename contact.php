<?php
session_start();
include('config/db.php');

// Initialize messages
$success_message = '';
$error_message = '';

// Flash success message from session
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

// Handle Review Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_review'])) {
    $name        = trim($_POST['review-name'] ?? '');
    $title = trim($_POST['review-designation'] ?? '');
    $rating      = isset($_POST['review-rating']) ? (int)$_POST['review-rating'] : 0;
    $review     = trim($_POST['review-text'] ?? '');

    $is_valid = true;

    if (empty($name)) {
        $error_message = 'Name is required.';
        $is_valid = false;
    } elseif (empty($title)) {
        $error_message = 'title is required.';
        $is_valid = false;
    } elseif ($rating < 1 || $rating > 5) {
        $error_message = 'Please select a valid rating (1-5).';
        $is_valid = false;
    } elseif (empty($review)) {
        $error_message = 'Review text is required.';
        $is_valid = false;
    }

    if ($is_valid) {
        try {
            $stmt = $con->prepare("INSERT INTO contact_review (name, title, rating, review) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssis", $name, $title, $rating, $review);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = 'Review submitted successfully!';
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                $error_message = 'Failed to submit review. Please try again.';
            }
            $stmt->close();
        } catch (Exception $e) {
            $error_message = 'Database error: ' . $e->getMessage();
        }
    }
}

// Fetch Contact Info (latest entry)
$contact_info = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM contact_info ORDER BY id DESC LIMIT 1"));

// Fetch Business Hours (all)
$business_hours = mysqli_query($con, "SELECT * FROM business_hours ORDER BY id ASC");

// Fetch Reviews (latest 6)
$reviews = mysqli_query($con, "SELECT * FROM review ORDER BY id DESC LIMIT 6");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CocoFiber Connect - Contact Us</title>
  <script src="css/tailwind.css"></script>
  <style>
    .gradient-bg { background: linear-gradient(135deg, #f4e7d7 0%, #d6c9b0 100%); }
    .card { transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .card:hover { transform: translateY(-5px); box-shadow: 0 10px 15px rgba(0,0,0,0.1); }
    .star { color: #FFD700; font-size: 1.2rem; }
    .info-box { background: white; border-radius: 0.5rem; padding: 1.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .contact-icon { background: #f5f0e6; padding: 0.75rem; border-radius: 50%; margin-right: 1rem; }
    .success-alert { background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; }
    .error-alert { background: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; }
  </style>
</head>
<body class="font-sans bg-gray-50">
<?php include 'header.php'; ?>

<!-- Hero -->
<section class="gradient-bg py-16 md:py-24">
  <div class="container mx-auto px-4 text-center">
    <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">Contact CocoFiber Connect</h1>
    <p class="text-xl text-gray-600 max-w-2xl mx-auto">We're here to help you with all your natural fiber needs. Reach out for inquiries, partnerships, or support.</p>
  </div>
</section>

<!-- Contact Info -->
<section class="py-16">
  <div class="container mx-auto px-4">
    <div class="flex flex-col lg:flex-row gap-8">
      <div class="lg:w-1/2 space-y-6">
        <div class="info-box">
          <h2 class="text-2xl font-bold text-gray-800 mb-6">Our Contact Information</h2>
          <?php if ($contact_info): ?>
            <div class="flex items-start mb-6">
              <div class="contact-icon"><img src="css/location.png" class="h-6 w-6 filter sepia brightness-75"></div>
              <div>
                <h3 class="text-lg font-medium text-gray-800">Headquarters</h3>
                <p class="text-gray-600"><?= nl2br(htmlspecialchars($contact_info['headquarters'])); ?></p>
              </div>
            </div>
            <div class="flex items-start mb-6">
              <div class="contact-icon"><img src="css/contact.png" class="h-6 w-6 filter sepia brightness-75"></div>
              <div>
                <h3 class="text-lg font-medium text-gray-800">Phone</h3>
                <p class="text-gray-600">Office: <?= htmlspecialchars($contact_info['phone_main']); ?><br>
                Support: <?= htmlspecialchars($contact_info['phone_support']); ?><br>
                Fax: <?= htmlspecialchars($contact_info['fax']); ?></p>
              </div>
            </div>
            <div class="flex items-start">
              <div class="contact-icon"><img src="css/email.png" class="h-6 w-6 filter sepia brightness-75"></div>
              <div>
                <h3 class="text-lg font-medium text-gray-800">Email</h3>
                <p class="text-gray-600">
                  General: <?= htmlspecialchars($contact_info['email_general']); ?><br>
                  Support: <?= htmlspecialchars($contact_info['email_support']); ?><br>
                  Sales: <?= htmlspecialchars($contact_info['email_sales']); ?>
                </p>
              </div>
            </div>
          <?php else: ?>
            <p class="text-gray-500">No contact information available.</p>
          <?php endif; ?>
        </div>

        <!-- Dynamic Business Hours -->
        <div class="info-box">
          <h3 class="text-xl font-bold text-gray-800 mb-4">Business Hours</h3>
          <div class="space-y-3">
            <?php if (mysqli_num_rows($business_hours) > 0): ?>
              <?php while ($row = mysqli_fetch_assoc($business_hours)): ?>
                <div class="flex justify-between py-2 border-b border-gray-100">
                  <span class="text-gray-700"><?= htmlspecialchars($row['day']); ?></span>
                  <span class="font-medium"><?= htmlspecialchars($row['hours']); ?></span>
                </div>
              <?php endwhile; ?>
            <?php else: ?>
              <p class="text-gray-500">Business hours not available.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Reviews -->
<section class="py-16 bg-white">
  <div class="container mx-auto px-4">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">What Our Customers Say</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php if (mysqli_num_rows($reviews) > 0): 
        while ($row = mysqli_fetch_assoc($reviews)): ?>
        <div class="card bg-white rounded-lg p-6 border border-gray-100 text-center">
          <?php if ($row['image']): ?>
            <img src="uploads/<?= htmlspecialchars($row['image']); ?>" alt="Reviewer" class="mx-auto mb-4 w-20 h-20 rounded-full object-cover">
          <?php endif; ?>
          <div class="flex justify-center mb-4">
            <?php for ($i=1; $i<=5; $i++): ?>
              <span class="star"><?= $i <= $row['rating'] ? '★' : '☆'; ?></span>
            <?php endfor; ?>
          </div>
          <p class="text-gray-600 mb-4">"<?= htmlspecialchars($row['message']); ?>"</p>
          <h4 class="font-medium text-gray-800"><?= htmlspecialchars($row['name']); ?></h4>
          <p class="text-sm text-gray-500"><?= htmlspecialchars($row['designation']); ?></p>
        </div>
      <?php endwhile; else: ?>
        <p class="text-center text-gray-500 col-span-3">No customer reviews yet.</p>
      <?php endif; ?>
    </div>

    <!-- Review Form -->
    <div class="max-w-2xl mx-auto mt-16 bg-gray-50 p-8 rounded-lg">
      <h3 class="text-xl font-bold text-gray-800 mb-6">Share Your Experience</h3>
      <?php if (!empty($success_message)): ?>
        <div class="success-alert"><?= $success_message; ?></div>
      <?php elseif (!empty($error_message)): ?>
        <div class="error-alert"><?= $error_message; ?></div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data" class="space-y-4">
        <div>
          <label for="review-name" class="block text-sm font-medium text-gray-700 mb-1">Your Name</label>
          <input type="text" id="review-name" name="review-name" required class="w-full px-4 py-2 border rounded-md">
        </div>
        <div>
          <label for="review-designation" class="block text-sm font-medium text-gray-700 mb-1">Your title</label>
          <input type="text" id="review-designation" name="review-designation" required class="w-full px-4 py-2 border rounded-md">
        </div>
        <div>
          <label for="review-rating" class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
          <select id="review-rating" name="review-rating" required class="w-full px-4 py-2 border rounded-md">
            <option value="5">5 - Excellent</option>
            <option value="4">4 - Very Good</option>
            <option value="3">3 - Good</option>
            <option value="2">2 - Fair</option>
            <option value="1">1 - Poor</option>
          </select>
        </div>
        <div>
          <label for="review-text" class="block text-sm font-medium text-gray-700 mb-1">Your Review</label>
          <textarea id="review-text" name="review-text" rows="4" required class="w-full px-4 py-2 border rounded-md"></textarea>
        </div>

        <button type="submit" name="submit_review" class="w-full bg-[#977669] text-white py-3 px-6 rounded-md hover:bg-[#846358] font-medium">Submit Review</button>
      </form>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>
</body>
</html>
