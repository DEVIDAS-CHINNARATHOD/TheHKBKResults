<?php
session_start();
include 'config.php';

// Redirect if faculty not logged in
if (!isset($_SESSION['faculty_id'])) {
    header("Location: faculty_login.php");
    exit();
}

$student_name = "";

// Fetch student name by USN
if (isset($_POST['fetch_student'])) {
    $usn = $_POST['usn'];
    $stmt = $conn->prepare("SELECT name FROM students WHERE usn = ?");
    $stmt->bind_param("s", $usn);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $student_name = $row['name'];
    } else {
        $error = "❌ Student USN not found!";
    }
}

// Handle mark submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_marks'])) {
    $usn = $_POST['usn'];
    $subjects = $_POST['subject'];
    $marks = $_POST['marks'];
    $remarks = $_POST['remark'];

    $stmt = $conn->prepare("SELECT * FROM students WHERE usn = ?");
    $stmt->bind_param("s", $usn);
    $stmt->execute();
    $student_result = $stmt->get_result();

    if ($student_result->num_rows == 0) {
        $error = "❌ Student USN not found!";
    } else {
        $stmt = $conn->prepare("INSERT INTO marks (usn, subject, marks, remark) VALUES (?, ?, ?, ?)");
        for ($i = 0; $i < count($subjects); $i++) {
            $stmt->bind_param("ssis", $usn, $subjects[$i], $marks[$i], $remarks[$i]);
            $stmt->execute();
        }
        $success = "✅ Marks added successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HKBK College Marks Entry System - Faculty portal for entering and managing student internal marks and assessments for HKBK College of Engineering.">
    <meta name="keywords" content="HKBK College marks entry, HKBK College internal assessment, HKBK College faculty portal, HKBK College results management, HKBK College student grading, HKBK College academic evaluation, HKBK College marks system">
    <meta name="author" content="DEVIDAS CHINNARATHOD">
    <meta name="robots" content="noindex, follow">
    <link rel="canonical" href="https://hkbkcollege.edu.in/add_marks.php" />
    <title>HKBK College Marks Entry | Internal Assessment Management System</title>
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
            display: inline-block;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        nav ul li a:hover {
            background-color: #ff9a8b;
            transform: translateY(-3px);
        }

        .marks-container {
            width: 60%;
            margin: 40px auto;
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            border-top: 5px solid #4a6fb3;
        }

        h2 {
            color: #4a6fb3;
            margin-bottom: 25px;
            font-size: 28px;
            font-weight: 600;
        }

        input, button {
            margin: 10px;
            padding: 14px;
            width: 90%;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        input:focus {
            border-color: #4a6fb3;
            outline: none;
            box-shadow: 0 0 0 3px rgba(74, 111, 179, 0.1);
        }

        button {
            background-color: #4a6fb3;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: 500;
        }

        button:hover {
            background-color: #ff9a8b;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 154, 139, 0.4);
        }

        .subject-entry {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .subject-entry input {
            flex: 1;
            min-width: 120px;
        }

        .subject-entry button {
            background-color: #e74c3c;
            padding: 10px;
            width: auto;
        }

        .subject-entry button:hover {
            background-color: #c0392b;
        }

        .error { 
            color: #e74c3c; 
            font-size: 16px; 
            background-color: rgba(231, 76, 60, 0.1);
            padding: 10px;
            border-radius: 8px;
            margin: 15px 0;
            font-weight: 500;
        }

        .success { 
            color: #27ae60; 
            font-size: 16px; 
            background-color: rgba(39, 174, 96, 0.1);
            padding: 10px;
            border-radius: 8px;
            margin: 15px 0;
            font-weight: 500;
        }

        .form-footer { 
            margin-top: 25px; 
        }

        .form-footer a { 
            color: #4a6fb3; 
            text-decoration: none; 
            font-size: 16px;
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

        @media (max-width: 768px) {
            .marks-container {
                width: 90%;
                padding: 25px;
            }

            .subject-entry {
                flex-direction: column;
            }

            .subject-entry input {
                width: 100%;
                margin: 5px 0;
            }
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

    <div class="marks-container">
        <h2><i class="fas fa-plus-circle"></i> Add Student Marks</h2>
        <?php if (isset($error)) echo "<p class='error'><i class='fas fa-exclamation-circle'></i> $error</p>"; ?>
        <?php if (isset($success)) echo "<p class='success'><i class='fas fa-check-circle'></i> $success</p>"; ?>

        <form method="post">
            <div style="position: relative; width: 90%;">
                <i class="fas fa-id-card" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #4a6fb3;"></i>
                <input type="text" name="usn" placeholder="Enter Student USN" required value="<?= isset($_POST['usn']) ? $_POST['usn'] : '' ?>" style="padding-left: 35px;">
            </div>
            <button type="submit" name="fetch_student"><i class="fas fa-search"></i> Check Student</button>
        </form>

        <?php if ($student_name) { ?>
            <p><strong><i class="fas fa-user"></i> Student Name:</strong> <?= $student_name ?></p>

            <form action="" method="post">
                <input type="hidden" name="usn" value="<?= $_POST['usn'] ?>">
                
                <div id="subjects-container">
                    <div class="subject-entry">
                        <div style="position: relative; flex: 1;">
                            <i class="fas fa-book" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #4a6fb3;"></i>
                            <input type="text" name="subject[]" placeholder="Subject" required style="padding-left: 35px;">
                        </div>
                        <div style="position: relative; flex: 1;">
                            <i class="fas fa-graduation-cap" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #4a6fb3;"></i>
                            <input type="number" name="marks[]" placeholder="Marks" required style="padding-left: 35px;">
                        </div>
                        <div style="position: relative; flex: 1;">
                            <i class="fas fa-comment" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #4a6fb3;"></i>
                            <input type="text" name="remark[]" placeholder="Remark" required style="padding-left: 35px;">
                        </div>
                    </div>
                </div>

                <button type="button" onclick="addSubject()"><i class="fas fa-plus"></i> Add Subject</button><br>

                <button type="submit" name="submit_marks"><i class="fas fa-save"></i> Submit Marks</button>
            </form>
        <?php } ?>
    </div>

    <script>
        function addSubject() {
            let container = document.getElementById("subjects-container");
            let newEntry = document.createElement("div");
            newEntry.classList.add("subject-entry");
            newEntry.innerHTML = `
                <div style="position: relative; flex: 1;">
                    <i class="fas fa-book" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #4a6fb3;"></i>
                    <input type="text" name="subject[]" placeholder="Subject" required style="padding-left: 35px;">
                </div>
                <div style="position: relative; flex: 1;">
                    <i class="fas fa-graduation-cap" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #4a6fb3;"></i>
                    <input type="number" name="marks[]" placeholder="Marks" required style="padding-left: 35px;">
                </div>
                <div style="position: relative; flex: 1;">
                    <i class="fas fa-comment" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #4a6fb3;"></i>
                    <input type="text" name="remark[]" placeholder="Remark" required style="padding-left: 35px;">
                </div>
                <button type="button" onclick="removeSubject(this)"><i class="fas fa-trash-alt"></i> Remove</button>
            `;
            container.appendChild(newEntry);
        }

        function removeSubject(button) {
            button.parentElement.remove();
        }
    </script>

</body>
</html>
<?php