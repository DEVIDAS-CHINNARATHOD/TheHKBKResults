<?php
// Include database connection configuration
include 'config.php';

// Initialize variables for storing student data, marks, and calculations
$student = null;
$marks = [];
$total_marks = 0;
$max_possible = 0;
$percentage = 0;

// Process the form submission to fetch results
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get USN from the form submission
    $usn = $_POST['usn'];

    // Prepare and execute query to fetch student details using prepared statement for security
    $stmt = $conn->prepare("SELECT * FROM students WHERE usn = ?");
    $stmt->bind_param("s", $usn);
    $stmt->execute();
    $student_result = $stmt->get_result();

    // Prepare and execute query to fetch student marks using prepared statement
    $stmt = $conn->prepare("SELECT * FROM marks WHERE usn = ?");
    $stmt->bind_param("s", $usn);
    $stmt->execute();
    $marks_result = $stmt->get_result();

    // Check if student exists in the database
    if ($student_result->num_rows > 0) {
        $student = $student_result->fetch_assoc();
    }

    // Process marks data if available
    if ($marks_result->num_rows > 0) {
        while ($row = $marks_result->fetch_assoc()) {
            // Add each mark record to the marks array
            $marks[] = $row;
            // Add marks to the total
            $total_marks += $row['marks'];
            // Assuming max marks per subject is 100, adjust if needed
            $max_possible += 100;
        }
        
        // Calculate percentage if max_possible is not zero (to avoid division by zero)
        if ($max_possible > 0) {
            $percentage = ($total_marks / $max_possible) * 100;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags for character set, responsive design, and SEO optimization -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Check HKBK College internal marks, view semester results, and download your exam marks. The official HKBK College result checker for B.Tech, Engineering and all departments (2025).">
    <meta name="keywords" content="HKBK College result checker, HKBK College internal marks checker, HKBK College exam result, HKBK College result 2025, HKBK College internal marks verification, HKBK College semester results, HKBK College marks download, HKBK College B.Tech result check, HKBK College internal assessment results">
    <meta name="author" content="DEVIDAS CHINNARATHOD">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://hkbkcollege.edu.in/results.php" />
    
    <!-- Page title and external resource links -->
    <title>HKBK College Results | Check Internal Marks & Semester Results | 2025</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Base body styling with modern gradient background */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2); /* Modern subtle gradient */
        }

        /* Header styling with responsive layout */
        header {
            background-color: #4a6fb3; /* Modern deep blue */
            color: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Title/Logo styling */
        .title {
            font-size: 26px;
            font-weight: 600;
            letter-spacing: 2px;
        }

        /* Navigation menu container */
        nav ul {
            list-style-type: none;
            display: flex;
            gap: 20px;
        }

        /* Navigation link styling with transitions and hover effects */
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
            position: relative;
        }

        /* Hover effect for navigation links */
        nav ul li a:hover {
            background-color: #ff9a8b;
            color: white;
            box-shadow: 0px 4px 10px rgba(255, 154, 139, 0.4);
        }
        
        /* Underline animation for navigation links */
        nav ul li a:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background-color: #fff;
            transition: width 0.3s ease;
        }
        
        /* Expanding underline on hover */
        nav ul li a:hover:after {
            width: 80%;
        }
        
        /* Styling for the currently active page link */
        .active-link {
            background-color: rgba(255, 255, 255, 0.15);
            font-weight: 600;
        }
        
        .active-link:after {
            width: 80%;
            background-color: #fff;
        }

        /* Main results container styling with shadow and border accent */
        .results-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-top: 5px solid #4a6fb3;
        }

        /* Heading styling */
        h2 {
            text-align: center;
            color: #4a6fb3;
            margin-bottom: 25px;
            font-size: 28px;
        }

        /* Form container for centered layout */
        .center-form {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        /* Input field container for positioning icon */
        .input-container {
            position: relative;
            width: 300px;
        }

        /* Input field styling with padding for icon */
        .center-form input {
            width: 100%;
            padding: 16px;
            padding-left: 45px;
            border: 2px solid #ddd;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        /* Focus state for input field */
        .center-form input:focus {
            border-color: #4a6fb3;
            outline: none;
            box-shadow: 0 0 0 3px rgba(74, 111, 179, 0.1);
        }

        /* Submit button styling with icon */
        .center-form button {
            padding: 16px 30px;
            background-color: #4a6fb3;
            color: white;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            min-width: 180px;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 6px rgba(74, 111, 179, 0.2);
        }

        .center-form button:hover {
            background-color: #ff9a8b;
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(255, 154, 139, 0.4);
        }

        .center-form button i {
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .center-form button:hover i {
            transform: scale(1.2);
        }

        .icon-input {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #4a6fb3;
            font-size: 18px;
        }

        .result-box {
            margin-top: 30px;
        }

        .result-box h3 {
            color: #4a6fb3;
            font-size: 22px;
            margin-bottom: 15px;
        }

        .result-box p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        table th, table td {
            padding: 15px;
            border: 1px solid #eee;
            text-align: left;
        }

        table th {
            background-color: #4a6fb3;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f5fd;
        }

        .error {
            color: #e74c3c;
            font-size: 16px;
            font-weight: bold;
            background-color: rgba(231, 76, 60, 0.1);
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }

        footer {
            background-color: #4a6fb3;
            color: white;
            padding: 20px;
            text-align: center;
            margin-top: 50px;
        }

        .home-btn {
            display: inline-block;
            padding: 12px 20px;
            margin: 25px 0 0 50px;
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

        .instructions {
            background-color: rgba(74, 111, 179, 0.1);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            text-align: left;
            border-left: 4px solid #4a6fb3;
        }

        .instructions h4 {
            color: #4a6fb3;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .instructions ul {
            margin-left: 30px;
            color: #555;
        }

        .instructions li {
            margin-bottom: 5px;
        }

        .usn-examples {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
            font-style: italic;
        }

        .result-summary {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            border: 1px solid #eee;
        }

        .summary-item {
            text-align: center;
            padding: 10px;
            min-width: 150px;
        }

        .summary-item .label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .summary-item .value {
            font-size: 22px;
            font-weight: bold;
            color: #4a6fb3;
        }

        .percentage-good {
            color: #27ae60;
        }

        .percentage-average {
            color: #f39c12;
        }

        .percentage-poor {
            color: #e74c3c;
        }

        .loading {
            display: none;
            text-align: center;
            margin: 20px 0;
            color: #4a6fb3;
        }
        
        .loading i {
            animation: spin 1s linear infinite;
            font-size: 2rem;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <header>
        <div class="title"><i class="fas fa-graduation-cap"></i> HKBK</div>
        <nav>
            <ul>
                <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="results.php" class="active-link"><i class="fas fa-chart-bar"></i> Check Results</a></li>
                <li><a href="faculty_login.php"><i class="fas fa-user-tie"></i> Faculty Login</a></li>
                <li><a href="faculty_register.php"><i class="fas fa-user-plus"></i> Registration</a></li>
            </ul>
        </nav>
    </header>

    <!-- Home Button Below Header -->
    <a href="index.php" class="home-btn"><i class="fas fa-arrow-left"></i> Back to Home</a>

    <!-- Results Section -->
    <div class="results-container">
        <h2><i class="fas fa-search"></i> Check Your Results</h2>
        <h3>4th Sem 1st Internal Results 2025</h3>
        <div class="instructions">
            <h4><i class="fas fa-info-circle"></i> How to check your results</h4>
            <ul>
                <li>Enter your complete USN (University Seat Number) in the field below</li>
                <li>Your USN should be in the format: <strong>1HK23CS056</strong> or similar</li>
                <li>Click on the "Check Results" button to view your marks</li>
            </ul>
            <div class="usn-examples">Examples: 1HK23CS050, 1HK23CS027, 1HK23CS055, etc.</div>
        </div>
        
        <form action="" method="post" class="center-form" id="resultsForm">
            <div class="input-container">
                <i class="fas fa-id-card icon-input"></i>
                <input type="text" name="usn" placeholder="Enter Your USN" required autocomplete="off" value="<?= isset($_POST['usn']) ? htmlspecialchars($_POST['usn']) : '' ?>">
            </div>
            <button type="submit">
                <i class="fas fa-search"></i>
                <span>Check Results</span>
            </button>
        </form>

        <div class="loading" id="loadingIndicator">
            <i class="fas fa-spinner"></i>
            <p>Fetching your results...</p>
        </div>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { ?>
            <div class="result-box">
                <?php if ($student && count($marks) > 0) { ?>
                    <h3><i class="fas fa-user"></i> Student Details</h3>
                    <p><strong><i class="fas fa-user-graduate"></i> Name:</strong> <?= htmlspecialchars($student['name']) ?></p>
                    <p><strong><i class="fas fa-code-branch"></i> Branch:</strong> <?= htmlspecialchars($student['branch']) ?></p>
                    <p><strong><i class="fas fa-list-ol"></i> Semester:</strong> <?= htmlspecialchars($student['semester']) ?></p>

                    <h3><i class="fas fa-chart-simple"></i> Marks</h3>
                    <table>
                        <tr>
                            <th><i class="fas fa-book"></i> Subject</th>
                            <th><i class="fas fa-graduation-cap"></i> Marks</th>
                            <th><i class="fas fa-comment"></i> Remark</th>
                        </tr>
                        <?php foreach ($marks as $mark) { ?>
                            <tr>
                                <td><?= htmlspecialchars($mark['subject']) ?></td>
                                <td><?= htmlspecialchars($mark['marks']) ?></td>
                                <td><?= htmlspecialchars($mark['remark']) ?></td>
                            </tr>
                        <?php } ?>
                    </table>

                    <div class="result-summary">
                        <div class="summary-item">
                            <div class="label"><i class="fas fa-calculator"></i> Total Marks</div>
                            <div class="value"><?= $total_marks ?> / <?= $max_possible ?></div>
                        </div>
                        <div class="summary-item">
                            <div class="label"><i class="fas fa-percent"></i> Percentage</div>
                            <div class="value <?= $percentage >= 70 ? 'percentage-good' : ($percentage >= 40 ? 'percentage-average' : 'percentage-poor') ?>">
                                <?= number_format($percentage, 2) ?>%
                            </div>
                        </div>
                    </div>

                <?php } else { ?>
                    <p class="error"><i class="fas fa-exclamation-triangle"></i> No records found for this USN. Please check the USN and try again.</p>
                <?php } ?>
            </div>
        <?php } ?>
    </div>

    <!-- Footer Section -->
    <footer>
        <p><i class="far fa-copyright"></i> 2025 Student Internal Marks Portal. All rights reserved.</p>
    </footer>

    <script>
        document.getElementById('resultsForm').addEventListener('submit', function() {
            document.getElementById('loadingIndicator').style.display = 'block';
        });
    </script>
</body>
</html>
