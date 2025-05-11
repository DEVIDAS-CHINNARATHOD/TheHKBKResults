<?php
session_start();
include 'config.php';

// Redirect if faculty not logged in
if (!isset($_SESSION['faculty_id'])) {
    header("Location: faculty_login.php");
    exit();
}

$student_name = "";
$existing_marks = [];
$error = "";
$success = "";
$student_semester = "";

// Fetch student details and existing marks
if (isset($_POST['fetch_student'])) {
    $usn = $_POST['usn'];

    // Fetch student name and semester
    $stmt = $conn->prepare("SELECT name, semester FROM students WHERE usn = ?");
    $stmt->bind_param("s", $usn);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $student_name = $row['name'];
        $student_semester = $row['semester'];

        // Fetch existing marks
        $stmt_marks = $conn->prepare("SELECT id, subject, marks, remark, ia_type FROM marks WHERE usn = ?");
        $stmt_marks->bind_param("s", $usn);
        $stmt_marks->execute();
        $result_marks = $stmt_marks->get_result();
        while ($mark = $result_marks->fetch_assoc()) {
            $existing_marks[] = $mark;
        }
    } else {
        $error = "❌ Student USN not found!";
    }
}

// Submit or update marks
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_marks'])) {
    $usn = $_POST['usn'];
    $subjects = $_POST['subject'];
    $marks = $_POST['marks'];
    $remarks = $_POST['remark'];
    $mark_ids = $_POST['mark_id'];
    $ia_types = $_POST['ia_type'];
    $success = true;

    // Get student semester
    $stmt = $conn->prepare("SELECT semester FROM students WHERE usn = ?");
    $stmt->bind_param("s", $usn);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $semester = $student['semester'];

    for ($i = 0; $i < count($subjects); $i++) {
        $subject = $subjects[$i];
        $mark = $marks[$i];
        $remark = $remarks[$i];
        $ia_type = $ia_types[$i];
        $mark_id = $mark_ids[$i];

        // Validate marks
        if ($mark < 0 || $mark > 100) {
            $error = "❌ Marks must be between 0 and 100!";
            $success = false;
            break;
        }

        if (!empty($mark_id)) {
            $stmt = $conn->prepare("UPDATE marks SET subject = ?, marks = ?, remark = ?, ia_type = ? WHERE id = ? AND usn = ?");
            $stmt->bind_param("sissis", $subject, $mark, $remark, $ia_type, $mark_id, $usn);
            if (!$stmt->execute()) {
                $error = "❌ Error updating marks: " . $stmt->error;
                $success = false;
                break;
            }
        } else {
            $stmt = $conn->prepare("INSERT INTO marks (usn, subject, marks, remark, ia_type, semester, faculty_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssiisii", $usn, $subject, $mark, $remark, $ia_type, $semester, $_SESSION['faculty_id']);
            if (!$stmt->execute()) {
                $error = "❌ Error adding marks: " . $stmt->error;
                $success = false;
                break;
            }
        }
    }

    if ($success) {
        $success = "✅ Marks updated successfully!";
        header("Location: add_marks.php?usn=" . urlencode($usn));
        exit();
    }
}

// Handle mark deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_marks'])) {
    $mark_id = $_POST['mark_id'];
    $usn = $_POST['usn'];
    
    $stmt = $conn->prepare("DELETE FROM marks WHERE id = ? AND usn = ?");
    $stmt->bind_param("is", $mark_id, $usn);
    
    if ($stmt->execute()) {
        $success = "✅ Marks deleted successfully!";
        header("Location: add_marks.php?usn=" . urlencode($usn));
        exit();
    } else {
        $error = "❌ Failed to delete marks: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HKBK College Faculty Dashboard - Add and manage student marks, internal assessments, and academic records at HKBK College of Engineering.">
    <meta name="keywords" content="HKBK College marks management, HKBK College internal marks, HKBK College faculty portal, HKBK College academic records, HKBK College student marks">
    <meta name="author" content="DEVIDAS CHINNARATHOD">
    <meta name="robots" content="noindex, follow">
    <link rel="canonical" href="https://hkbkcollege.edu.in/add_marks.php" />
    
    <title>HKBK College | Add Marks</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            margin: 0;
            padding: 0;
        }

        /* Header */
        header {
            background-color: #4a6fb3;
            color: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
        }

        header .title {
            font-size: 26px;
            font-weight: 600;
            letter-spacing: 2px;
        }

        header nav ul {
            list-style-type: none;
            display: flex;
            gap: 20px;
        }

        header nav ul li a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        header nav ul li a:hover {
            background-color: #ff9a8b;
            color: white;
            box-shadow: 0px 4px 10px rgba(255, 154, 139, 0.4);
            transform: translateY(-3px);
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

        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-form {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .search-form label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 500;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 15px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
            outline: none;
        }

        button {
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        button:hover {
            background-color: #2980b9;
            transform: translateY(-1px);
        }

        .subject-entry {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 2fr auto;
            gap: 15px;
            margin-bottom: 15px;
            align-items: center;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .subject-entry:hover {
            background: #f0f2f5;
        }

        .subject-entry button {
            background-color: #e74c3c;
            padding: 10px;
            width: auto;
        }

        .subject-entry button:hover {
            background-color: #c0392b;
        }

        .student-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .student-info p {
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .student-info i {
            color: #3498db;
            font-size: 18px;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            margin: 20px 0;
        }

        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 20px;
            }

            .subject-entry {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .student-info {
                grid-template-columns: 1fr;
            }
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
                <li><a href="view_results.php"><i class="fas fa-list"></i> View All Results</a></li>
                <li><a href="faculty_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>
    </header>

    <div style="text-align: center; margin-top: 20px;">
        <a href="faculty_dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
    </div>

    <div class="container">
        <h2><i class="fas fa-edit"></i> Add / Edit Student Marks</h2>

        <?php if ($error) echo "<p class='error'><i class='fas fa-exclamation-circle'></i> $error</p>"; ?>
        <?php if ($success) echo "<p class='success'><i class='fas fa-check-circle'></i> $success</p>"; ?>

        <form method="post" class="search-form">
            <label><i class="fas fa-id-card"></i> Enter Student USN:</label>
            <input type="text" name="usn" required value="<?= isset($_POST['usn']) ? htmlspecialchars($_POST['usn']) : '' ?>">
            <button type="submit" name="fetch_student"><i class="fas fa-search"></i> Fetch Student</button>
        </form>

        <?php if ($student_name) { ?>
            <div class="student-info">
                <p><i class="fas fa-user"></i> <strong>Student Name:</strong> <?= htmlspecialchars($student_name) ?></p>
                <p><i class="fas fa-graduation-cap"></i> <strong>Semester:</strong> <?= htmlspecialchars($student_semester) ?></p>
            </div>

            <form method="post">
                <input type="hidden" name="usn" value="<?= htmlspecialchars($_POST['usn']) ?>">

                <div id="subjects-container">
                    <?php foreach ($existing_marks as $mark) { ?>
                        <div class="subject-entry">
                            <input type="hidden" name="mark_id[]" value="<?= $mark['id'] ?>">
                            <input type="text" name="subject[]" value="<?= htmlspecialchars($mark['subject']) ?>" required>
                            <input type="number" name="marks[]" value="<?= htmlspecialchars($mark['marks']) ?>" min="0" max="100" required>
                            <select name="ia_type[]" required>
                                <option value="1st IA" <?= ($mark['ia_type'] == "1st IA") ? 'selected' : '' ?>>1st IA</option>
                                <option value="2nd IA" <?= ($mark['ia_type'] == "2nd IA") ? 'selected' : '' ?>>2nd IA</option>
                                <option value="3rd IA" <?= ($mark['ia_type'] == "3rd IA") ? 'selected' : '' ?>>3rd IA</option>
                            </select>
                            <input type="text" name="remark[]" value="<?= htmlspecialchars($mark['remark']) ?>" required>
                            <button type="button" onclick="removeSubject(this)"><i class="fas fa-trash-alt"></i> Remove</button>
                        </div>
                    <?php } ?>

                    <div class="subject-entry">
                        <input type="hidden" name="mark_id[]" value="">
                        <input type="text" name="subject[]" placeholder="Subject" required>
                        <input type="number" name="marks[]" placeholder="Marks" min="0" max="100" required>
                        <select name="ia_type[]" required>
                            <option value="1st IA">1st IA</option>
                            <option value="2nd IA">2nd IA</option>
                            <option value="3rd IA">3rd IA</option>
                        </select>
                        <input type="text" name="remark[]" placeholder="Remark" required>
                        <button type="button" onclick="removeSubject(this)"><i class="fas fa-trash-alt"></i> Remove</button>
                    </div>
                </div>

                <div class="action-buttons">
                    <button type="button" onclick="addSubject()"><i class="fas fa-plus"></i> Add Subject</button>
                    <button type="submit" name="submit_marks"><i class="fas fa-save"></i> Submit Marks</button>
                </div>
            </form>
        <?php } ?>
    </div>

    <script>
    function addSubject() {
        let container = document.getElementById("subjects-container");
        let newEntry = document.createElement("div");
        newEntry.classList.add("subject-entry");
        newEntry.innerHTML = `
            <input type="hidden" name="mark_id[]" value="">
            <input type="text" name="subject[]" placeholder="Subject" required>
            <input type="number" name="marks[]" placeholder="Marks" min="0" max="100" required>
            <select name="ia_type[]" required>
                <option value="1st IA">1st IA</option>
                <option value="2nd IA">2nd IA</option>
                <option value="3rd IA">3rd IA</option>
            </select>
            <input type="text" name="remark[]" placeholder="Remark" required>
            <button type="button" onclick="removeSubject(this)"><i class="fas fa-trash-alt"></i> Remove</button>
        `;
        container.appendChild(newEntry);
    }

    function removeSubject(button) {
        if (confirm('Are you sure you want to remove this subject?')) {
            button.parentElement.remove();
        }
    }
    </script>
</body>
</html>
