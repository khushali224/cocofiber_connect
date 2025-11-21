<?php
include 'config/db.php';

// Fetch contact info
$contact = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM contact_footer LIMIT 1"));

// Fetch social links
$socials = mysqli_query($con, "SELECT * FROM social_links ORDER BY id ASC");
?>

<style>
    /* Footer Styles */
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
    footer {
        background-color: var(--primary);
        color: var(--white);
        padding: 5rem 5% 2rem;
        text-align: center;
    }
    
    .footer-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        max-width: 1400px;
        margin: 0 auto 3rem;
        text-align: left;
    }
    
    .footer-column h4 {
        font-size: 1.2rem;
        margin-bottom: 1.5rem;
    }
    
    .footer-column ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .footer-column ul li {
        margin-bottom: 0.8rem;
    }
    
    .footer-column ul li a {
        color: var(--primary-lighter);
        text-decoration: none;
        transition: var(--transition);
    }
    
    .footer-column ul li a:hover {
        color: var(--white);
    }
    
    .social-links {
        display: flex;
        gap: 1rem;
    }
    
    .social-links a img {
        display: block;
        width: 24px;
        height: 24px;
    }
    
    .copyright {
        padding-top: 2rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        font-size: 0.9rem;
        color: var(--primary-lighter);
    }
</style>

<footer>
    <div class="footer-content">
        <div class="footer-column">
            <h4>CocoFiber Connect</h4>
            <p>Innovating sustainable connectivity solutions since 2015. Our eco-friendly fiber optic technology is changing how the world gets online.</p>
        </div>

        <div class="footer-column">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="admin_product.php">Services</a></li>
                <li><a href="sourcing.php">Fiber Sourcing</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </div>

        <div class="footer-column">
            <h4>Contact</h4>
            <ul>
                <?php if(!empty($contact['email'])): ?>
                    <li><a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>"><?php echo htmlspecialchars($contact['email']); ?></a></li>
                <?php endif; ?>
                <?php if(!empty($contact['phone'])): ?>
                    <li><a href="tel:<?php echo htmlspecialchars($contact['phone']); ?>"><?php echo htmlspecialchars($contact['phone']); ?></a></li>
                <?php endif; ?>
                <?php if(!empty($contact['address'])): ?>
                    <li><a href="#"><?php echo htmlspecialchars($contact['address']); ?></a></li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="footer-column">
            <h4>Stay Connected</h4>
            <div class="social-links">
                <?php while($s = mysqli_fetch_assoc($socials)): ?>
                    <a href="<?php echo htmlspecialchars($s['url']); ?>" target="_blank" aria-label="<?php echo htmlspecialchars($s['platform']); ?>">
                        <img src="<?php echo htmlspecialchars($s['icon']); ?>" alt="<?php echo htmlspecialchars($s['platform']); ?>">
                    </a>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <div class="copyright">
        <p>© <?php echo date('Y'); ?> CocoFiber Connect. All rights reserved. Sustainable Connectivity Solutions.</p>
    </div>
</footer>
