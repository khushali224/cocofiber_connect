<?php 
include('config/db.php');   
session_start();  

$message = "";  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {     
    if (isset($_POST['register'])) {
        // Registration logic
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
        

        $query = "INSERT INTO registration (username, email, phone, password) 
                  VALUES ('$username', '$email', '$phone', '$password')";

        if (mysqli_query($con, $query)) {
            $message = "✅ Registration successful. You can now log in.";
        } else {
            $message = "❌ Error: " . mysqli_error($con);
        }
    }

    if (isset($_POST['login'])) {
        // Login logic
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        $result = mysqli_query($con, "SELECT * FROM registration WHERE username='$username' LIMIT 1");

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
      
                header("Location:home.php");
                exit();
            } else {
                $message = "❌ Invalid password.";
            }
        } else {
            $message = "❌ User not found.";
        }
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login/Signup Form</title>
  <link rel="stylesheet" href="css/style1.css"/>
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
</head>
<body>
  <div class="container">
    <?php if ($message): ?>
      <p style="color: red; text-align: center;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <!-- Login Form -->
    <div class="form-box login">
      <form method="POST">
        <h1>Login</h1>
        <div class="input-box">
          <input type="text" name="username" placeholder="Username" required />
          <i class="bx bxs-user"></i>
        </div>
        <div class="input-box">
          <input type="password" name="password" placeholder="Password" required />
          <i class="bx bxs-lock-alt"></i>
        </div>
      

        <button type="submit" name="login" class="btn">Login</button>
      </form>
    </div>

    <!-- Registration Form -->
    <div class="form-box register">
      <form method="POST">
        <h1>Registration</h1>
        <div class="input-box">
          <input type="text" name="username" placeholder="Username" required />
          <i class="bx bxs-user"></i>
        </div>
        <div class="input-box">
          <input type="email" name="email" placeholder="Email" required />
          <i class="bx bxs-envelope"></i>
        </div>
        <div class="input-box">
          <input type="text" name="phone" placeholder="Phone No" required />
          <i class="bx bxs-phone"></i>
        </div>
        <div class="input-box">
          <input type="password" name="password" placeholder="Password" required />
          <i class="bx bxs-lock-alt"></i>
        </div>
        <button type="submit" name="register" class="btn">Register</button>
      </form>
    </div>

    <!-- Toggle Panel -->
    <div class="toggle-box">
      <div class="toggle-panel toggle-left">
        <h1>Hello, Welcome!</h1>
        <p>Don't have an account?</p>
        <button class="btn register-btn">Register</button>
      </div>
      <div class="toggle-panel toggle-right">
        <h1>Welcome Back!</h1>
        <p>Already have an account?</p>
        <button class="btn login-btn">Login</button>
      </div>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>
