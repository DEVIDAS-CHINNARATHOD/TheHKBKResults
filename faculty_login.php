<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM faculty WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['faculty_id'] = $row['id'];
            $_SESSION['faculty_name'] = $row['name'];
            header("Location: faculty_dashboard.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HKBK College Faculty Login">
    <meta name="keywords" content="Faculty portal, login, HKBK College">
    <meta name="author" content="DEVIDAS CHINNARATHOD">
    <meta name="robots" content="noindex, follow">
    <link rel="canonical" href="https://hkbkcollege.edu.in/faculty_login.php" />
    <title>HKBK College Faculty Login | Internal Marks Management System</title>
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

        .login-container {
            background: #ffffff;
            padding: 35px 40px;
            width: 350px;
            margin: 100px auto;
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

        .login-container h2 {
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

        .home-btn {
            display: inline-block;
            padding: 12px 20px;
            margin-top: 25px;
            font-size: 16px;
            text-decoration: none;
            color: #4a6fb3;
            background-color: white;
            border: 2px solid #4a6fb3;
            border-radius: 8px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .home-btn:hover {
            background-color: #4a6fb3;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(74, 111, 179, 0.2);
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
        <a href="index.php" class="home-btn"><i class="fas fa-arrow-left"></i> Back to Home</a>
    </div>

    <div class="login-container">
        <h2><i class="fas fa-lock"></i> Faculty Login</h2>
        <?php if(isset($error)) echo "<p class='error'><i class='fas fa-exclamation-circle'></i> $error</p>"; ?>
        <form action="" method="post">
            <div style="position: relative;">
                <i class="fas fa-envelope" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #4a6fb3;"></i>
                <input type="email" name="email" placeholder="Enter Email" required style="padding-left: 35px;"><br>
            </div>
            <div style="position: relative;">
                <i class="fas fa-key" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #4a6fb3;"></i>
                <input type="password" name="password" placeholder="Enter Password" required style="padding-left: 35px;"><br>
            </div>
            <button type="submit"><i class="fas fa-sign-in-alt"></i> Login</button>
        </form>
    </div>

</body>
</html>
<?php