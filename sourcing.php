<?php
include 'config/db.php';

// Handle sourcing inquiry form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['company'])) {
    $company_name = mysqli_real_escape_string($con, $_POST['company']);
    $contact_person = mysqli_real_escape_string($con, $_POST['name']);
    $email_address = mysqli_real_escape_string($con, $_POST['email']);
    $phone_number = mysqli_real_escape_string($con, $_POST['phone']);
    $estimated_monthly_volume = mysqli_real_escape_string($con, $_POST['quantity']);
    $additional_requirement = mysqli_real_escape_string($con, $_POST['message']);

    $insert = "INSERT INTO sourcing_inquiries 
        (company_name, contact_person, email_address, phone_number, estimated_monthly_volume, additional_requirement) 
        VALUES ('$company_name', '$contact_person', '$email_address', '$phone_number', '$estimated_monthly_volume', '$additional_requirement')";

    if (mysqli_query($con, $insert)) {
        $success_message = "Thank you! Your sourcing inquiry has been submitted.";
    } else {
        $error_message = "Error: " . mysqli_error($con);
    }
}

// Fetch latest hero section
$hero = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM sourcing_hero ORDER BY id DESC LIMIT 1"));

// Fetch benefits dynamically
$benefits = mysqli_query($con, "SELECT * FROM sourcing_benefits ORDER BY id ASC");

// Fetch sourcing process dynamically
$process_steps = mysqli_query($con, "SELECT * FROM sourcing_process ORDER BY step_number ASC");

// Fetch quality standards dynamically
$quality_standards = mysqli_query($con, "SELECT * FROM sourcing_quality ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cocofiber Connect | Sustainable Fiber Sourcing</title>
<script src="css/tailwind.css"></script>
<style>
    .hero-gradient { background: linear-gradient(to right, #8B5A2B, #A67C52); }
    .process-step { position: relative; }
    .process-step:not(:last-child):after {
        content: '';
        position: absolute;
        top: 50%;
        right: -30px;
        width: 60px;
        height: 2px;
        background: #8B5A2B;
    }

    /* === Hover Effects with Brown === */
    .hover-card:hover {
        transform: translateY(-6px);
        transition: all 0.3s ease-in-out;
        box-shadow: 0 8px 20px rgba(139, 90, 43, 0.4);
        border-color: #8B5A2B !important;
        background: #fdf6f0;
    }
    .process-step:hover .rounded-full {
        background: #5C4033;
        transition: background 0.3s;
    }
    .quality-card:hover {
        background: #fdf6f0;
        transform: translateY(-4px);
        border-color: #8B5A2B;
        transition: all 0.3s ease;
    }
    button:hover {
        transform: scale(1.05);
        transition: all 0.3s ease-in-out;
        background: #8B5A2B !important;
        color: #fff !important;
    }
    input:hover, select:hover, textarea:hover {
        border-color: #8B5A2B !important;
        transition: border 0.3s ease;
    }
</style>
</head>
<body class="bg-amber-50">
<?php include 'header.php'; ?>

<!-- Hero Section -->
<section class="hero-gradient text-white py-20">
    <div class="container mx-auto px-6 flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 mb-10 md:mb-0">
            <h1 class="text-4xl md:text-5xl font-bold mb-6"><?= htmlspecialchars($hero['title'] ?? 'Sustainable Cocofiber Sourcing'); ?></h1>
            <p class="text-xl mb-8"><?= htmlspecialchars($hero['subtitle'] ?? 'Connecting eco-conscious manufacturers with premium quality coconut fiber from ethical sources.'); ?></p>
        </div>
        <div class="md:w-1/2">
            <?php if (!empty($hero['image'])): ?>
                <img src="uploads/<?= htmlspecialchars($hero['image']); ?>" alt="Hero Image" class="rounded-lg shadow-2xl" />
            <?php else: ?>
                <img src="css/main.png" alt="Cocofiber image" class="rounded-lg shadow-2xl" />
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-amber-900 mb-12">Why Source Cocofiber With Us?</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <?php while($row = mysqli_fetch_assoc($benefits)): ?>
            <div class="bg-amber-50 p-6 rounded-lg shadow-md border-l-4 border-amber-800 hover-card">
                <div class="text-amber-800 text-2xl mb-4"><?= htmlspecialchars($row['icon']); ?></div>
                <h3 class="font-bold text-xl mb-3 text-amber-900"><?= htmlspecialchars($row['title']); ?></h3>
                <p class="text-amber-800"><?= htmlspecialchars($row['description']); ?></p>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- Sourcing Process Section -->
<section class="py-16 bg-amber-50">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-amber-900 mb-12">Our Sourcing Process</h2>
        <div class="flex flex-col md:flex-row justify-between items-center mb-20">
            <?php while($step = mysqli_fetch_assoc($process_steps)): ?>
            <div class="process-step flex flex-col items-center mb-10 md:mb-0 md:w-1/5 hover-card">
                <div class="rounded-full bg-amber-800 text-white w-16 h-16 flex items-center justify-center mb-3 text-2xl font-bold"><?= htmlspecialchars($step['step_number']); ?></div>
                <h3 class="font-bold text-lg text-center text-amber-900"><?= htmlspecialchars($step['title']); ?></h3>
                <p class="text-center text-amber-800"><?= htmlspecialchars($step['description']); ?></p>
            </div>
            <?php endwhile; ?>
        </div>
        <div class="text-center">
            <img src="css/info.png" alt="Flowchart showing cocofiber journey from farm to factory with quality checkpoints" class="mx-auto rounded-lg" />
        </div>
    </div>
</section>

<!-- Quality Standards Section (Dynamic) -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-amber-900 mb-12">Quality Assurance Standards</h2>
        <div class="grid md:grid-cols-2 gap-8">
            <?php while($q = mysqli_fetch_assoc($quality_standards)): ?>
            <div class="p-6 rounded-lg shadow-md bg-amber-50 border-l-4 border-amber-800 quality-card">
                <h3 class="font-bold text-xl mb-3 text-amber-900"><?= htmlspecialchars($q['title']); ?></h3>
                <p class="text-amber-800"><?= htmlspecialchars($q['description']); ?></p>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- Inquiry Form Section -->
<section class="py-16 bg-amber-900 text-white">
    <div class="container mx-auto px-6 max-w-4xl">
        <h2 class="text-3xl font-bold text-center mb-2">Start Sourcing With Us</h2>
        <p class="text-center text-amber-200 mb-10">Fill out our sourcing inquiry form and our team will contact you within 24 hours</p>

        <?php if (!empty($success_message)): ?>
            <div class="bg-green-600 text-white p-4 rounded mb-6 text-center"><?php echo $success_message; ?></div>
        <?php elseif (!empty($error_message)): ?>
            <div class="bg-red-600 text-white p-4 rounded mb-6 text-center"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 font-medium">Company Name</label>
                    <input type="text" name="company" required class="w-full px-4 py-2 rounded bg-amber-800 border border-amber-700">
                </div>
                <div>
                    <label class="block mb-2 font-medium">Contact Person</label>
                    <input type="text" name="name" required class="w-full px-4 py-2 rounded bg-amber-800 border border-amber-700">
                </div>
            </div>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 font-medium">Email Address</label>
                    <input type="email" name="email" required class="w-full px-4 py-2 rounded bg-amber-800 border border-amber-700">
                </div>
                <div>
                    <label class="block mb-2 font-medium">Phone Number</label>
                    <input type="tel" name="phone" required class="w-full px-4 py-2 rounded bg-amber-800 border border-amber-700">
                </div>
            </div>
            <div>
                <label class="block mb-2 font-medium">Estimated Monthly Volume (kg)</label>
                <select name="quantity" required class="w-full px-4 py-2 rounded bg-amber-800 border border-amber-700">
                    <option value="">Select volume range</option>
                    <option value="100-500">100-500 kg</option>
                    <option value="500-2000">500-2,000 kg</option>
                    <option value="2000-5000">2,000-5,000 kg</option>
                    <option value="5000+">5,000+ kg</option>
                </select>
            </div>
            <div>
                <label class="block mb-2 font-medium">Additional Requirements</label>
                <textarea name="message" rows="4" class="w-full px-4 py-2 rounded bg-amber-800 border border-amber-700"></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="bg-white text-amber-900 px-8 py-3 rounded-full font-semibold">Submit Inquiry</button>
            </div>
        </form>
    </div>
</section>

<?php include 'footer.php'; ?>
<script>
    const mobileMenuButton = document.querySelector('.mobile-menu-button');
    const mobileMenu = document.querySelector('.mobile-menu');
    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>
</body>
</html>
