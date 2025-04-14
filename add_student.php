<?php
session_start();
include 'config.php';

// Redirect if faculty not logged in
if (!isset($_SESSION['faculty_id'])) {
    header("Location: faculty_login.php");
    exit();
}

// Handle student submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usn = strtoupper(trim($_POST['usn']));
    $name = trim($_POST['name']);
    $branch = trim($_POST['branch']);
    $semester = intval($_POST['semester']);

    $check_student = "SELECT * FROM students WHERE usn='$usn'";
    $result = $conn->query($check_student);

    if ($result->num_rows > 0) {
        $error = "Student with USN $usn already exists!";
    } else {
        $insert_student = "INSERT INTO students (usn, name, branch, semester) VALUES ('$usn', '$name', '$branch', '$semester')";
        if ($conn->query($insert_student) === TRUE) {
            $success = "Student added successfully!";
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
    <meta name="description" content="HKBK College Student Registration System">
    <meta name="keywords" content="HKBK College student registration, student management, academic records">
    <meta name="author" content="DEVIDAS CHINNARATHOD">
    <meta name="robots" content="noindex, follow">
    <link rel="canonical" href="https://hkbkcollege.edu.in/add_student.php" />
    <title>HKBK College Student Registration</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
        }
        header {
            background-color: #4a6fb3;
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
        }
        nav {
            background-color: #3a5795;
            overflow: hidden;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }
        nav ul li {
            display: inline;
        }
        nav ul li a {
            color: white;
            padding: 15px 20px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s ease;
        }
        nav ul li a:hover {
            background-color: #ff9a8b;
            transform: translateY(-3px);
        }
        .student-container {
            background: white;
            padding: 35px;
            width: 450px;
            margin: 50px auto;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            text-align: center;
            border-top: 5px solid #4a6fb3;
        }
        h2 {
            color: #4a6fb3;
            margin-bottom: 25px;
            font-size: 28px;
            font-weight: 600;
        }
        input, select {
            width: 100%;
            padding: 14px;
            margin: 12px 0;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
        input:focus, select:focus {
            border-color: #4a6fb3;
            outline: none;
            box-shadow: 0 0 0 3px rgba(74, 111, 179, 0.1);
        }
        button {
            padding: 14px;
            background-color: #4a6fb3;
            color: white;
            border: none;
            border-radius: 8px;
            width: 100%;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            margin-top: 10px;
        }
        button:hover {
            background-color: #ff9a8b;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 154, 139, 0.4);
        }
        .success {
            color: #27ae60;
            font-size: 16px;
            margin-bottom: 20px;
            background-color: rgba(39, 174, 96, 0.1);
            padding: 10px;
            border-radius: 8px;
            font-weight: 500;
        }
        .error {
            color: #e74c3c;
            font-size: 16px;
            margin-bottom: 20px;
            background-color: rgba(231, 76, 60, 0.1);
            padding: 10px;
            border-radius: 8px;
            font-weight: 500;
        }
        .form-footer {
            margin-top: 25px;
        }
        .form-footer a {
            color: #4a6fb3;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            padding: 10px 15px;
            border: 2px solid #4a6fb3;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .form-footer a:hover {
            background-color: #4a6fb3;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(74, 111, 179, 0.2);
        }
    </style>
</head>
<body>

    <header>
        <h1><i class="fas fa-chalkboard-teacher"></i> Faculty Dashboard</h1>
    </header>

    <nav>
        <ul>
            <li><a href="faculty_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="add_student.php"><i class="fas fa-user-plus"></i> Add Student</a></li>
            <li><a href="add_marks.php"><i class="fas fa-plus-circle"></i> Add Marks</a></li>
            <li><a href="view_results.php"><i class="fas fa-chart-line"></i> View Results</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </nav>

    <div class="student-container">
        <h2><i class="fas fa-user-plus"></i> Add New Student</h2>
        <?php if (isset($error)) echo "<p class='error'><i class='fas fa-exclamation-circle'></i> $error</p>"; ?>
        <?php if (isset($success)) echo "<p class='success'><i class='fas fa-check-circle'></i> $success</p>"; ?>
        
        <form action="" method="post">
            <div style="position: relative;">
                <i class="fas fa-id-card" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #4a6fb3;"></i>
                <input type="text" name="usn" placeholder="Enter USN" required style="padding-left: 35px;">
            </div>
            <div style="position: relative;">
                <i class="fas fa-user" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #4a6fb3;"></i>
                <input type="text" name="name" placeholder="Enter Student Name" required style="padding-left: 35px;">
            </div>
            <div style="position: relative;">
                <i class="fas fa-code-branch" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #4a6fb3;"></i>
                <input type="text" name="branch" placeholder="Enter Branch" required style="padding-left: 35px;">
            </div>
            <div style="position: relative;">
                <i class="fas fa-list-ol" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #4a6fb3;"></i>
                <input type="number" name="semester" placeholder="Enter Semester" required style="padding-left: 35px;">
            </div>
            <button type="submit"><i class="fas fa-save"></i> Add Student</button>
        </form>

        <div class="form-footer">
            <a href="faculty_dashboard.php"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </div>

</body>
</html>
<?php