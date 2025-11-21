<!-- header.php -->
<style>
:root {
  --primary-brown: #8D6E63;
  --secondary-brown: #795548;
  --accent-brown: #5D4037;
  --blanchedAlmond: #ffebcd;
  --tumbleweed: #deaa88;
}

/* ===== Header ===== */
header {
  background-color: var(--accent-brown);
  color: var(--blanchedAlmond);
  padding: 12px 30px;
}

.header-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 1400px;
  margin: 0 auto;
}

/* ===== Logo ===== */
.logo {
  display: flex;
  align-items: center;
  gap: 15px;
}
.logo img {
  height: 70px;
}
.logo h1 {
  font-size: 2rem;
  margin: 0;
  background-image: url("css/main1.jpg");
  background-size: cover;
  background-clip: text;
  -webkit-background-clip: text;
  color: transparent;
}

/* ===== Navigation ===== */
nav ul {
  list-style: none;
  display: flex;
  flex-wrap: nowrap;
  gap: 20px;
  margin: 0;
  padding: 0;
}
nav ul li a {
  color: var(--blanchedAlmond);
  text-decoration: none;
  font-size: 1.2rem;
  font-weight: 500;
  transition: color 0.3s;
}
nav ul li a:hover {
  color: var(--blanchedAlmond);
}
</style>

<header>
  <div class="header-container">
    <!-- Logo -->
    <div class="logo">
      <img src="css/logo2.png" alt="Cocofiber Connect Logo">
      <h1>Cocofiber Connect</h1>
    </div>

    <!-- Navigation -->
    <nav>
      <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="about.php">AboutUs</a></li>
        <li><a href="admin_product.php">Services</a></li>
        <li><a href="sourcing.php">FiberSourcing</a></li>
        <li><a href="contact.php">ContactUs</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </div>
</header>
