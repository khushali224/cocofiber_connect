<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | CocoFiber</title>
    <link rel="stylesheet" href="css/admin.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f5f0;
            margin: 0;
            padding: 0;
        }
        h1 {
            background: #8B5E3C;
            color: white;
            padding: 15px;
            margin: 0;
            text-align: center;
        }
        nav {
            background: #deb887;
            padding: 15px;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        ul li {
            margin: 10px 0;
        }
        ul li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        ul li a:hover {
            color: #8B5E3C;
        }
        .submenu {
            margin-left: 20px;
            padding-left: 10px;
            border-left: 2px solid #8B5E3C;
        }
        /* Back button styling */
        .back-btn {
            display: inline-block;
            margin-bottom: 15px;
            padding: 8px 12px;
            background: #8B5E3C;
            color: white;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
        }
        .back-btn:hover {
            background: #a76b48;
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <nav>
        <!-- Back button -->
        <a href="index.php" class="back-btn">⬅ Back to Home</a>
        
        <ul>
            <li>
                <h2>Home</h2>
                <ul class="submenu">
                    <li><a href="hero_manage.php">Manage Hero Section</a></li>
                    <li><a href="how_manage.php">Manage How It Works</a></li>
                </ul>
            </li>
            
            <li>
                <h2>About Us</h2>
                <ul class="submenu">
                    <li><a href="story_manage.php">Manage Our Story</a></li>
                    <li><a href="mission_manage.php">Manage Mission & Vision</a></li>
                    <li><a href="values_manage.php">Manage Core Values</a></li>
                    <li><a href="testimonials_manage.php">Manage Testimonials</a></li>
                </ul>
            </li>
            
            <li>
                <h2>Contact Us</h2>
                <ul class="submenu">
                    <li><a href="contact_manage.php">Manage Contact Info</a></li>
                    <li><a href="business_manage.php">Manage Business Hours</a></li>
                    <li><a href="review_manage.php">Manage Customer Reviews</a></li>
                </ul>
            </li>
            
            <li>
                <h2>Fiber Sourcing</h2>
                <ul class="submenu">
                    <li><a href="sourcing_hero.php">Manage Source Hero</a></li>
                    <li><a href="sourcing_benefits.php">Manage Benefits</a></li>
                    <li><a href="sourcing_process.php">Manage Process Steps</a></li>
                    <li><a href="sourcing_quality.php">Manage Quality Standards</a></li>
                </ul>
            </li>
            <li>
                <h2>Footer</h2>
                <ul class="submenu">
                    <li><a href="manage_footer.php">Manage Footer</a></li>
                    
                </ul>
            </li>
        </ul>
    </nav>
</body>
</html>
