<?php

include 'config/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $fiber_type = mysqli_real_escape_string($con, $_POST['fiber_type']);
    $quantity = (int)$_POST['quantity_kg'];
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $price = (float)$_POST['price_per_kg'];
    $location = mysqli_real_escape_string($con, $_POST['location']);

    // Handle file upload
    $image = '';
    if ($_FILES['image']['name']) {
        $imageName = basename($_FILES["image"]["name"]);
        $targetDir = "uploads/";
        $targetFile = $targetDir . time() . "_" . $imageName;
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
        $image = $targetFile;
    }

    // Insert into fiber table
    $query = "INSERT INTO fiber (username, email, phone_no, fiber_type, quantity_kg, description, image, price_per_kg, location)
              VALUES ('$username', '$email', '$phone', '$fiber_type', $quantity, '$description', '$image', $price, '$location')";

    if (mysqli_query($con, $query)) {
        echo "<script>alert('Fiber listed successfully!');</script>";
    } else {
        echo "<script>alert('Error: Could not list fiber.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>List Fiber</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #EFEBE9;
      color: #3E2723;
      line-height: 1.6;
    }
    
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }
    
    /* Tab Navigation */
    .tab-nav {
      display: flex;
      justify-content: center;
      margin: 40px 0 30px;
      flex-wrap: wrap;
    }
    
    .tab-nav a {
      color: #8D6E63;
      text-decoration: none;
      padding: 12px 25px;
      margin: 0 10px;
      font-weight: 500;
      border-bottom: 3px solid transparent;
      transition: all 0.3s ease;
      position: relative;
    }
    
    .tab-nav a:hover {
      color: #795548;
    }
    
    .tab-nav a.active {
      color: #795548;
      border-bottom-color:#795548;
    }
    
    /* Steps Section */
    .steps-container {
      background-color: #DAA06D;
      border-radius: 12px;
      padding: 40px;
      margin-bottom: 40px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
      transform: translateY(0);
    }
    
    .steps-container:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .steps-container h2 {
      text-align: center;
      color: #795548;
      margin-bottom: 30px;
      font-size: 28px;
    }
    
    .steps-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 30px;
      margin-top: 30px;
    }
    
    .step-box {
      background-color: #EADDCA;
      border-radius: 10px;
      padding: 25px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      border-top: 4px solid #FF8A65;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    
    .step-box:hover {
      transform: translateY(-10px);
    }
    
    .step-number {
      display: inline-block;
      width: 40px;
      height: 40px;
      background-color: #795548;
      color: var(--white);
      border-radius: 50%;
      text-align: center;
      line-height: 40px;
      font-weight: 600;
      margin-bottom: 15px;
      position: relative;
      z-index: 1;
    }
    
    .step-box h3 {
      color: #5D4037;
      margin-bottom: 15px;
    }
    
    /* Form Section */
    .form-container {
      background-color: #F2D2BD;
      border-radius: 12px;
      padding: 40px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      margin-bottom: 40px;
      transform: translateY(0);
      transition: all 0.3s ease;
    }
    
    .form-container:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .form-container h2 {
      text-align: center;
      color: #795548;
      margin-bottom: 30px;
      font-size: 28px;
    }
    
    .form-box {
      max-width: 900px;
      margin: 0 auto;
    }
    
    .form-group {
      display: flex;
      flex-wrap: wrap;
      gap: 25px;
      margin-bottom: 25px;
    }
    
    .form-group > div {
      flex: 1;
      min-width: 200px;
    }
    
    label {
      display: block;
      margin-bottom: 10px;
      font-weight: 500;
      color: #5D4037;
    }
    
    input, select, textarea {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 16px;
      transition: all 0.3s ease;
      background-color: #f9f9f9;
    }
    
    input:focus, select:focus, textarea:focus {
      border-color: #795548;
      box-shadow: 0 0 0 2px rgba(121, 85, 72, 0.2);
      outline: none;
      background-color: #ffffff;
    }
    
    textarea {
      resize: vertical;
      min-height: 120px;
    }
    
    .image-upload {
      position: relative;
      width: 100%;
      margin-bottom: 20px;
    }
    
    .image-upload input[type="file"] {
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      opacity: 0;
      cursor: pointer;
    }
    
    .upload-area {
      border: 2px dashed #ddd;
      border-radius: 8px;
      padding: 25px;
      text-align: center;
      transition: all 0.3s ease;
      background-color: #f9f9f9;
      cursor: pointer;
    }
    
    .upload-area:hover {
      border-color: #795548;
    }
    
    .upload-icon {
      font-size: 48px;
      color: #8D6E63;
      margin-bottom: 15px;
    }
    
    .upload-text {
      color: #8D6E63;
    }
    
    .file-name {
      margin-top: 10px;
      font-size: 14px;
      color: #795548;
      display: none;
    }
    
    .preview-container {
      margin-top: 20px;
      display: none;
    }
    
    .image-preview {
      max-width: 200px;
      max-height: 200px;
      border-radius: 8px;
      border: 1px solid #eee;
      display: block;
      margin: 10px auto;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .submit-btn {
      background-color: #795548;
      color: var(--white);
      border: none;
      padding: 14px 30px;
      font-size: 16px;
      font-weight: 500;
      border-radius: 8px;
      cursor: pointer;
      transition:all 0.3s ease;
      display: block;
      margin: 30px auto 0;
      width: 200px;
      text-align: center;
    }
    
    .submit-btn:hover {
      background-color: #5D4037;
      transform: translateY(-2px);
    }
    
    /* Services Section */
    .services-container {
      background-color: #F2D2BD;
      border-radius: 12px;
      padding: 40px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      margin-bottom: 40px;
      transform: translateY(0);
      transition: all 0.3s ease;
    }
    
    .services-container:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .services-container h2 {
      text-align: center;
      color: #795548;
      margin-bottom: 30px;
      font-size: 28px;
    }
    
    .benefits-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 25px;
    }
    
    .benefit-box {
      background-color: #f9f9f9;
      border-radius: 8px;
      padding: 25px;
      display: flex;
      align-items: flex-start;
      transition: all 0.3s ease;
    }
    
    .benefit-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      background-color: #ffffff;
    }
    
    .benefit-icon {
      font-size: 24px;
      color: #795548;
      margin-right: 15px;
      margin-top: 5px;
    }
    
    .benefit-text h3 {
      color: #5D4037;
      margin-bottom: 10px;
      font-size: 18px;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
      .tab-nav a {
        margin: 0 5px;
        padding: 10px 15px;
      }
      
      .steps-grid, .benefits-grid {
        grid-template-columns: 1fr;
      }
      
      .form-container, .services-container, .steps-container {
        padding: 25px;
      }
    }
    
    @media (max-width: 480px) {
      .tab-nav {
        flex-direction: column;
        align-items: center;
      }
      
      .tab-nav a {
        margin: 5px 0;
        width: 100%;
        text-align: center;
      }
      
      .form-group {
        flex-direction: column;
      }
    }
    
    /* Animation Classes */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .fade-in {
      animation: fadeIn 0.6s ease forwards;
    }
    
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }
    .delay-5 { animation-delay: 0.5s; }
  </style>
</head>
<body>
<?php include 'header.php';?>
<!-- Sub Navigation Tabs -->
<div class="container">
  <div class="tab-nav">
    <a href="seller.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'seller.php' ? 'active' : ''; ?>">Sell Fiber</a>
    <a href="admin_product.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'admin_product.php' ? 'active' : ''; ?>">Purchase Products</a>
  </div>
</div>

<!-- Steps Section -->
<div class="container">
  <div class="steps-container fade-in">
    <h2>How to Supply Your Fiber</h2>
    <div class="steps-grid">
      <div class="step-box fade-in delay-1">
        <div class="step-number">1</div>
        <h3>Prepare Your Fiber</h3>
        <p>Ensure your coconut fiber meets quality standards before listing. Separate by type and quality.</p>
        <img src="css/first1.png" alt="Worker preparing coconut fiber bundles sorted by quality" style="width:100%; margin-top:15px; border-radius:8px;">
      </div>
      
      <div class="step-box fade-in delay-2">
        <div class="step-number">2</div>
        <h3>Complete Form</h3>
        <p>Fill out all details in our seller form accurately, including quantity, type, and price information.</p>
        <img src="css/second.png" alt="Digital form on a tablet showing fiber details being entered" style="width:100%; margin-top:15px; border-radius:8px;">
      </div>
      
      <div class="step-box fade-in delay-3">
        <div class="step-number">3</div>
        <h3>Upload Photos</h3>
        <p>Provide clear photos of your fiber to help buyers assess quality and characteristics.</p>
        <img src="css/third.png" alt="Hand holding smartphone taking picture of coconut fiber sample" style="width:100%; margin-top:15px; border-radius:8px;">
      </div>
      
      <div class="step-box fade-in delay-4">
        <div class="step-number">4</div>
        <h3>Submit & Confirm</h3>
        <p>Review your submission and confirm. Our team will verify and activate your listing.</p>
        <img src="css/four.png" alt="Computer screen showing confirmation message of successful fiber listing" style="width:100%; margin-top:15px; border-radius:8px;">
      </div>
    </div>
  </div>
</div>

<!-- Form Section -->
<div class="container">
  <div class="form-container fade-in delay-5">
    <h2>List Your Coconut Fiber</h2>
    <div class="form-box">
      <form method="POST" enctype="multipart/form-data" id="fiberForm">
        <div class="form-group">
          <div>
            <label for="username">Your Name</label>
            <input type="text" id="username" name="username" placeholder="Enter your full name" required>
          </div>
          <div>
            <label for="email">Email Address</label>
            <input type="text" id="email" name="email" placeholder="Your active email" required>
          </div>
        </div>
        
        <div class="form-group">
          <div>
            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" placeholder="Mobile number with country code" required>
          </div>
          <div>
            <label for="fiber_type">Fiber Type</label>
            <select id="fiber_type" name="fiber_type" required>
              <option value="">Select Fiber Type</option>
              <option value="brown">Brown Fiber</option>
              <option value="white">White Fiber</option>
              <option value="mattress">Mattress Fiber</option>
              <option value="bristle">Bristle Fiber</option>
            </select>
          </div>
        </div>
        
        <div class="form-group">
          <div>
            <label for="quantity_kg">Available Quantity (kg)</label>
            <input type="number" id="quantity_kg" name="quantity_kg" placeholder="Weight in kilograms" required>
          </div>
          <div>
            <label for="price_per_kg">Price per kg (USD)</label>
            <input type="text" id="price_per_kg" name="price_per_kg" placeholder="Set your price per kg" required>
          </div>
        </div>
        
        <div class="form-group">
          <div>
            <label for="location">Location</label>
            <input type="text" id="location" name="location" placeholder="City, Country" required>
          </div>
        </div>
        
        <div class="form-group">
          <div style="width:100%;">
            <label for="description">Fiber Description</label>
            <textarea id="description" name="description" placeholder="Describe fiber quality, origin, processing method, moisture content, and any special characteristics"></textarea>
          </div>
        </div>
        
        <div class="form-group">
          <div style="width:100%;">
            <label>Fiber Image (Required)</label>
            <div class="image-upload">
              <div class="upload-area">
                <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                <div class="upload-text">Click to upload or drag & drop</div>
                <div class="file-name" id="fileName"></div>
              </div>
              <input type="file" name="image" id="imageUpload" accept="image/*" required>
            </div>
            <div class="preview-container" id="previewContainer">
              <img class="image-preview" id="imagePreview" alt="Preview of selected fiber image will appear here">
            </div>
          </div>
        </div>
        
        <button type="submit" class="submit-btn">
          <i class="fas fa-paper-plane" style="margin-right:8px;"></i> List Fiber
        </button>
      </form>
    </div>
  </div>
</div>

<!-- Services Section -->
<div class="container">
  <div class="services-container">
    <h2>Our Services for Suppliers</h2>
    <div class="benefits-grid">
      <div class="benefit-box">
        <div class="benefit-icon"><i class="fas fa-money-bill-wave"></i></div>
        <div class="benefit-text">
          <h3>Competitive Pricing</h3>
          <p>Get fair market prices based on current demand and your fiber quality.</p>
        </div>
      </div>
      
      <div class="benefit-box">
        <div class="benefit-icon"><i class="fas fa-truck"></i></div>
        <div class="benefit-text">
          <h3>Logistics Support</h3>
          <p>We coordinate transportation and handle documentation for efficient delivery.</p>
        </div>
      </div>
      
      <div class="benefit-box">
        <div class="benefit-icon"><i class="fas fa-check-circle"></i></div>
        <div class="benefit-text">
          <h3>Quality Assurance</h3>
          <p>Our experts verify all fiber meets industry standards before payment.</p>
        </div>
      </div>
      
      <div class="benefit-box">
        <div class="benefit-icon"><i class="fas fa-credit-card"></i></div>
        <div class="benefit-text">
          <h3>Flexible Payments</h3>
          <p>Choose from multiple payment methods with secure transactions.</p>
        </div>
      </div>
      
      <div class="benefit-box">
        <div class="benefit-icon"><i class="fas fa-bullhorn"></i></div>
        <div class="benefit-text">
          <h3>Marketing Support</h3>
          <p>We promote your fiber to our global network of buyers.</p>
        </div>
      </div>
      
      <div class="benefit-box">
        <div class="benefit-icon"><i class="fas fa-users"></i></div>
        <div class="benefit-text">
          <h3>Direct Buyer Access</h3>
          <p>Connect with manufacturers and processors from around the world.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Image Upload Preview
  const imageUpload = document.getElementById('imageUpload');
  const previewContainer = document.getElementById('previewContainer');
  const imagePreview = document.getElementById('imagePreview');
  const fileName = document.getElementById('fileName');
  
  imageUpload.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      
      reader.onload = function(e) {
        imagePreview.src = e.target.result;
        previewContainer.style.display = 'block';
      }
      
      reader.readAsDataURL(file);
      fileName.textContent = file.name;
      fileName.style.display = 'block';
    }
  });
  
  // Drag and Drop for Image Upload
  const uploadArea = document.querySelector('.upload-area');
  
  uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.style.borderColor = '#795548';
    uploadArea.style.backgroundColor = '#f0e6e2';
  });
  
  uploadArea.addEventListener('dragleave', () => {
    uploadArea.style.borderColor = '#ddd';
    uploadArea.style.backgroundColor = '#f9f9f9';
  });
  
  uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.style.borderColor = '#ddd';
    uploadArea.style.backgroundColor = '#f9f9f9';
    
    if (e.dataTransfer.files.length) {
      imageUpload.files = e.dataTransfer.files;
      const event = new Event('change');
      imageUpload.dispatchEvent(event);
    }
  });
  
  // Form Validation
  document.getElementById('fiberForm').addEventListener('submit', function(e) {
    let isValid = true;
    const requiredFields = document.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
      if (!field.value) {
        field.style.borderColor = 'red';
        isValid = false;
      } else {
        field.style.borderColor = '#ddd';
      }
    });
    
    if (!isValid) {
      e.preventDefault();
      alert('Please fill all required fields.');
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    }
  });
  
  // Animation on Scroll
  const animateOnScroll = function() {
    const elements = document.querySelectorAll('.fade-in');
    
    elements.forEach(element => {
      const elementPosition = element.getBoundingClientRect().top;
      const windowHeight = window.innerHeight;
      
      if (elementPosition < windowHeight - 100) {
        element.style.opacity = '1';
        element.style.transform = 'translateY(0)';
      }
    });
  };
  
  window.addEventListener('load', animateOnScroll);
  window.addEventListener('scroll', animateOnScroll);
</script>
<?php
include 'footer.php';
?>
</body>
</html>
