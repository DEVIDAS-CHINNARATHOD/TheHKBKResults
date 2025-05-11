<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check_sql = "SELECT * FROM faculty WHERE email='$email'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        $error = "Email already registered!";
    } else {
        $sql = "INSERT INTO faculty (name, email, password) VALUES ('$name', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            $success = "Registration successful! <a href='faculty_login.php'>Login here</a>";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HKBK College Faculty Registration Portal - Register to access the internal marks management system for HKBK College of Engineering. Manage student results and academic records.">
    <meta name="keywords" content="HKBK College faculty registration, HKBK College teacher signup, HKBK College faculty portal, HKBK College internal marks system, HKBK College result management, HKBK College academic staff registration">
    <meta name="author" content="DEVIDAS CHINNARATHOD">
    <meta name="robots" content="noindex, follow">
    <link rel="canonical" href="https://hkbkcollege.edu.in/faculty_register.php" />
    <title>HKBK College Faculty Registration | Internal Marks Management System</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #4a6fb3;
            color: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
        }

        .title {
            font-size: 26px;
            font-weight: 600;
            letter-spacing: 2px;
        }

        nav ul {
            list-style-type: none;
            display: flex;
            gap: 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s ease-in-out;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        nav ul li a:hover {
            background-color: #ff9a8b;
            color: white;
            box-shadow: 0px 4px 10px rgba(255, 154, 139, 0.4);
        }

        .back-btn {
            display: inline-block;
            padding: 12px 20px;
            margin: 25px 0;
            background-color: #4a6fb3;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 18px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .back-btn:hover {
            background-color: #ff9a8b;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 154, 139, 0.4);
        }

        .register-container {
            background: #ffffff;
            padding: 35px 40px;
            width: 350px;
            margin: 50px auto;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            text-align: center;
            animation: slideIn 0.5s ease-out;
            border-top: 5px solid #4a6fb3;
        }

        @keyframes slideIn {
            0% {
                transform: translateY(-50px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .register-container h2 {
            color: #4a6fb3;
            font-size: 28px;
            margin-bottom: 25px;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 14px;
            margin: 12px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        input:focus {
            border-color: #4a6fb3;
            outline: none;
            box-shadow: 0 0 0 3px rgba(74, 111, 179, 0.1);
        }

        button {
            padding: 14px;
            background-color: #4a6fb3;
            color: white;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 8px;
            font-size: 18px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        button:hover {
            background-color: #ff9a8b;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 154, 139, 0.4);
        }

        .error {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 10px;
            font-weight: bold;
            background-color: rgba(231, 76, 60, 0.1);
            padding: 10px;
            border-radius: 8px;
        }

        .success {
            color: #27ae60;
            font-size: 14px;
            margin-top: 10px;
            font-weight: bold;
            background-color: rgba(39, 174, 96, 0.1);
            padding: 10px;
            border-radius: 8px;
        }

        .password-container {
            position: relative;
            width: 100%;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: #4a6fb3;
        }

        .password-container input {
            padding-right: 40px; /* Make room for the icon */
        }
    </style>
</head>
<body>

    <header>
        <div class="title"><i class="fas fa-graduation-cap"></i> HKBK</div>
        <nav>
            <ul>
                <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="results.php"><i class="fas fa-chart-bar"></i> Check Results</a></li>
                <li><a href="faculty_login.php"><i class="fas fa-user-tie"></i> Faculty Login</a></li>
                <li><a href="faculty_register.php"><i class="fas fa-user-plus"></i> Registration</a></li>
            </ul>
        </nav>
    </header>

    <div style="text-align: center; margin-top: 20px;">
        <a href="index.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Home</a>
    </div>

    <div class="register-container">
        <h2><i class="fas fa-user-plus"></i> Faculty Registration</h2>
        
        <?php if (isset($error)) echo "<p class='error'><i class='fas fa-exclamation-circle'></i> $error</p>"; ?>
        <?php if (isset($success)) echo "<p class='success'><i class='fas fa-check-circle'></i> $success</p>"; ?>
        
        <form action="" method="post">
            <div style="position: relative;">
                <i class="fas fa-user" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #4a6fb3;"></i>
                <input type="text" name="name" placeholder="Enter Full Name" required style="padding-left: 35px;"><br>
            </div>
            <div style="position: relative;">
                <i class="fas fa-envelope" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #4a6fb3;"></i>
                <input type="email" name="email" placeholder="Enter Email" required style="padding-left: 35px;"><br>
            </div>
            <div class="password-container">
                <input type="password" name="password" placeholder="Enter Password" required style="padding-left: 35px;">
                <i class="fas fa-eye password-toggle" onclick="togglePassword(this)"></i>
            </div>
            <div class="password-container">
                <input type="password" name="confirm_password" placeholder="Confirm Password" required style="padding-left: 35px;">
                <i class="fas fa-eye password-toggle" onclick="togglePassword(this)"></i>
            </div>
            <button type="submit"><i class="fas fa-user-plus"></i> Register</button>
        </form>
    </div>

    <script>
    function togglePassword(icon) {
        const passwordInput = icon.previousElementSibling;
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
    </script>

</body>
</html>
