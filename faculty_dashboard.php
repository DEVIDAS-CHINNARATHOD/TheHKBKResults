<?php
session_start();
include 'config.php';

// Check login
if (!isset($_SESSION['faculty_id'])) {
    header("Location: faculty_login.php");
    exit();
}

$faculty_id = $_SESSION['faculty_id'];
$faculty_name = $_SESSION['faculty_name']; // Assumes name is stored in session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HKBK College Faculty Dashboard - Secure portal for faculty members to manage student records, internal marks, and academic assessments at HKBK College of Engineering.">
    <meta name="keywords" content="HKBK College faculty dashboard, HKBK College teacher portal, HKBK College faculty management, HKBK College internal marks system, HKBK College academic administration, HKBK College results management, HKBK College faculty interface">
    <meta name="author" content="DEVIDAS CHINNARATHOD">
    <meta name="robots" content="noindex, follow">
    <link rel="canonical" href="https://hkbkcollege.edu.in/faculty_dashboard.php" />
    
    <title>HKBK College Faculty Dashboard | Academic Management System</title>
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

        .dashboard-container {
            background: #ffffff;
            padding: 35px 40px;
            width: 400px;
            margin: 50px auto;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            text-align: center;
            border-top: 5px solid #4a6fb3;
        }

        .dashboard-container a {
            display: block;
            padding: 14px;
            margin: 15px 0;
            text-decoration: none;
            color: white;
            background-color: #4a6fb3;
            border-radius: 8px;
            font-size: 18px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .dashboard-container a:hover {
            background-color: #ff9a8b;
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .logout {
            background-color: #e74c3c;
        }

        .logout:hover {
            background-color: #c0392b;
        }

        .dashboard-container h2 {
            color: #4a6fb3;
            font-size: 28px;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .dashboard-container p {
            font-size: 18px;
            color: #555;
            margin-bottom: 15px;
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

    <div class="dashboard-container">
        <h2><i class="fas fa-tachometer-alt"></i> Faculty Dashboard</h2>
        <p><i class="fas fa-id-badge"></i> Welcome, Faculty ID: <b><?php echo $faculty_id; ?></b></p>
        <p><i class="fas fa-user"></i> Faculty Name: <b><?php echo $faculty_name; ?></b></p>

        <a href="add_student.php"><i class="fas fa-user-plus"></i> Add Student</a>
        <a href="add_marks.php"><i class="fas fa-plus-circle"></i> Add Marks</a>
        <a href="view_results.php"><i class="fas fa-chart-line"></i> View Results</a>
        <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

</body>
</html>
