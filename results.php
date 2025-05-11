<?php
// Include database connection configuration
include 'config.php';
require_once('vendor/tecnickcom/tcpdf/tcpdf.php'); // Updated TCPDF path

// Initialize variables for storing student data and marks
$student = null;
$marks = [];
$error = "";
$selected_ia = isset($_POST['ia_type']) ? $_POST['ia_type'] : '';

// Function to generate PDF
function generatePDF($student, $marks) {
    // Create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator('HKBK College');
    $pdf->SetAuthor('HKBK College');
    $pdf->SetTitle('Internal Assessment Results');

    // Remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // Set margins
    $pdf->SetMargins(15, 15, 15);
    $pdf->SetAutoPageBreak(TRUE, 15);

    // Add a page
    $pdf->AddPage();

    // Add border
    $pdf->SetLineWidth(1.5);
    $pdf->SetDrawColor(74, 111, 179); // Using your website's blue color
    $pdf->Rect(10, 10, 190, 277); // Draw rectangle border

    // College Logo and Header
    $pdf->Image('images/logo.png', 15, 15, 30);
    
    // College Name with improved styling
    $pdf->SetFont('helvetica', 'B', 24);
    $pdf->SetTextColor(74, 111, 179); // Using your website's blue color
    $pdf->Cell(0, 15, 'HKBK College of Engineering', 0, 1, 'C');
    
    // Subtitle
    $pdf->SetFont('helvetica', 'I', 14);
    $pdf->SetTextColor(100, 100, 100);
    $pdf->Cell(0, 10, 'Internal Assessment Results', 0, 1, 'C');
    $pdf->Ln(10);

    // Reset text color for content
    $pdf->SetTextColor(0, 0, 0);

    // Student Details
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 10, 'Student Details', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 12);
    
    // Student Name with better formatting
    $pdf->SetFillColor(240, 240, 240);
    $pdf->Cell(40, 10, 'Name:', 0, 0, 'L', true);
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, $student['name'], 0, 1);
    
    // USN with better formatting
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(40, 10, 'USN:', 0, 0, 'L', true);
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, $_POST['usn'], 0, 1);
    
    // Semester with better formatting
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(40, 10, 'Semester:', 0, 0, 'L', true);
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, $student['semester'], 0, 1);
    
    $pdf->Ln(10);

    // Marks Table
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 10, 'Marks Details', 0, 1, 'L');
    
    // Table Header
    $pdf->SetLineWidth(0.3); // Thinner line for better appearance
    $pdf->SetDrawColor(0, 0, 0); // Black color for lines
    $pdf->SetFillColor(240, 240, 240); // Light gray background for header
    $pdf->SetTextColor(0, 0, 0); // Black text
    $pdf->SetFont('helvetica', 'B', 12);
    
    // Calculate total width and center the table
    $totalWidth = 190; // Total width of the page
    $tableWidth = 190; // Width of the table
    $startX = ($totalWidth - $tableWidth) / 2 + 10; // Starting X position
    $pdf->SetX($startX);
    
    // Draw header cells with thin borders
    $pdf->Cell(80, 10, 'Subject', 1, 0, 'C', true);
    $pdf->Cell(35, 10, 'IA Type', 1, 0, 'C', true);
    $pdf->Cell(35, 10, 'Marks', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Remarks', 1, 1, 'C', true);

    // Table Data
    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetFillColor(255, 255, 255); // White background for data cells
    foreach ($marks as $mark) {
        $pdf->SetX($startX); // Reset X position for each row
        $pdf->Cell(80, 10, $mark['subject'], 1, 0, 'L');
        $pdf->Cell(35, 10, $mark['ia_type'], 1, 0, 'C');
        $pdf->Cell(35, 10, $mark['marks'], 1, 0, 'C');
        $pdf->Cell(40, 10, $mark['remark'], 1, 1, 'L');
    }

    // Add a line after the table
    $pdf->SetX($startX);
    $pdf->Cell($tableWidth, 0, '', 'T', 1);

    // Signatures with improved spacing
    $pdf->Ln(25);
    $pdf->SetFont('helvetica', '', 12);
    
    // Calculate signature positions
    $signatureWidth = 60;
    $signatureSpacing = ($totalWidth - (3 * $signatureWidth)) / 4;
    $startX = $signatureSpacing + 10;
    
    // Student Signature
    $pdf->SetX($startX);
    $pdf->Cell($signatureWidth, 10, 'Student Signature', 0, 0, 'C');
    
    // Class Teacher Signature
    $pdf->SetX($startX + $signatureWidth + $signatureSpacing);
    $pdf->Cell($signatureWidth, 10, 'Class Teacher Signature', 0, 0, 'C');
    
    // Parent Signature
    $pdf->SetX($startX + 2 * ($signatureWidth + $signatureSpacing));
    $pdf->Cell($signatureWidth, 10, 'Parent Signature', 0, 1, 'C');
    
    $pdf->Ln(5);
    
    // Signature lines
    $pdf->SetX($startX);
    $pdf->Cell($signatureWidth, 10, '_________________', 0, 0, 'C');
    $pdf->SetX($startX + $signatureWidth + $signatureSpacing);
    $pdf->Cell($signatureWidth, 10, '_________________', 0, 0, 'C');
    $pdf->SetX($startX + 2 * ($signatureWidth + $signatureSpacing));
    $pdf->Cell($signatureWidth, 10, '_________________', 0, 1, 'C');

    // Output the PDF
    $pdf->Output('HKBK_Results_' . $_POST['usn'] . '.pdf', 'D');
    exit;
}

// Process the form submission to fetch results
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get USN from the form submission
    $usn = $_POST['usn'];

    // Fetch student details
    $stmt = $conn->prepare("SELECT name, semester FROM students WHERE usn = ?");
    $stmt->bind_param("s", $usn);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        
        // Fetch marks with IA type filter
        $sql = "SELECT m.subject, m.marks, m.remark, m.ia_type, m.semester 
                FROM marks m 
                WHERE m.usn = ?";
        $params = array($usn);
        $types = "s";
        
        if (!empty($selected_ia)) {
            $sql .= " AND m.ia_type = ?";
            $params[] = $selected_ia;
            $types .= "s";
        }
        $sql .= " ORDER BY m.subject";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $marks_result = $stmt->get_result();
        $marks = [];
        while ($row = $marks_result->fetch_assoc()) {
            $marks[] = $row;
        }

        // Handle PDF download
        if (isset($_POST['download_pdf'])) {
            generatePDF($student, $marks);
        }
    } else {
        $error = "Student not found!";
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
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
        }

        /* Header styling with responsive layout */
        header {
            background-color: #4a6fb3;
            color: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
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
            position: relative;
        }

        nav ul li a:hover {
            background-color: #ff9a8b;
            color: white;
            box-shadow: 0px 4px 10px rgba(255, 154, 139, 0.4);
        }
        
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
        
        nav ul li a:hover:after {
            width: 80%;
        }
        
        .active-link {
            background-color: rgba(255, 255, 255, 0.15);
            font-weight: 600;
        }
        
        .active-link:after {
            width: 80%;
            background-color: #fff;
        }

        .results-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-top: 5px solid #4a6fb3;
        }

        h2 {
            text-align: center;
            color: #4a6fb3;
            margin-bottom: 25px;
            font-size: 28px;
        }

        .center-form {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .input-container {
            position: relative;
            width: 300px;
        }

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

        .center-form input:focus {
            border-color: #4a6fb3;
            outline: none;
            box-shadow: 0 0 0 3px rgba(74, 111, 179, 0.1);
        }

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

        .filter-select {
            width: 100%;
            padding: 16px;
            padding-left: 45px;
            border: 2px solid #ddd;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-sizing: border-box;
            background-color: white;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%234a6fb3' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 15px;
        }

        .filter-select:focus {
            border-color: #4a6fb3;
            outline: none;
            box-shadow: 0 0 0 3px rgba(74, 111, 179, 0.1);
        }

        .filter-select:hover {
            border-color: #4a6fb3;
        }

        @media (max-width: 768px) {
            .center-form {
                flex-direction: column;
                align-items: stretch;
            }
            
            .input-container {
                width: 100%;
            }
            
            .center-form button {
                width: 100%;
            }
        }

        .download-btn {
            background-color: #4a6fb3;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(74, 111, 179, 0.2);
        }

        .download-btn:hover {
            background-color: #ff9a8b;
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(255, 154, 139, 0.4);
        }

        .download-btn i {
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .download-btn:hover i {
            transform: scale(1.2);
        }
    </style>
</head>
<body>
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

    <a href="index.php" class="home-btn"><i class="fas fa-arrow-left"></i> Back to Home</a>

    <div class="results-container">
        <h2><i class="fas fa-search"></i> Check Your Results</h2>
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
            <div class="input-container">
                <i class="fas fa-filter icon-input"></i>
                <select name="ia_type" class="filter-select">
                    <option value="">All IA Types</option>
                    <option value="1st IA" <?= ($selected_ia == "1st IA") ? 'selected' : '' ?>>1st IA</option>
                    <option value="2nd IA" <?= ($selected_ia == "2nd IA") ? 'selected' : '' ?>>2nd IA</option>
                    <option value="3rd IA" <?= ($selected_ia == "3rd IA") ? 'selected' : '' ?>>3rd IA</option>
                </select>
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
                    <p><strong><i class="fas fa-graduation-cap"></i> Semester:</strong> <?= htmlspecialchars($student['semester']) ?></p>
                    
                    <h3><i class="fas fa-chart-simple"></i> Marks</h3>
                    <table>
                        <tr>
                            <th><i class="fas fa-book"></i> Subject</th>
                            <th><i class="fas fa-graduation-cap"></i> IA Type</th>
                            <th><i class="fas fa-chart-bar"></i> Marks</th>
                            <th><i class="fas fa-comment"></i> Remark</th>
                        </tr>
                        <?php foreach ($marks as $mark) { ?>
                            <tr>
                                <td><?= htmlspecialchars($mark['subject']) ?></td>
                                <td><?= htmlspecialchars($mark['ia_type']) ?></td>
                                <td><?= htmlspecialchars($mark['marks']) ?></td>
                                <td><?= htmlspecialchars($mark['remark']) ?></td>
                            </tr>
                        <?php } ?>
                    </table>

                    <!-- Download Button -->
                    <form method="post" style="margin-top: 20px; text-align: center;">
                        <input type="hidden" name="usn" value="<?= htmlspecialchars($_POST['usn']) ?>">
                        <input type="hidden" name="ia_type" value="<?= htmlspecialchars($selected_ia) ?>">
                        <button type="submit" name="download_pdf" class="download-btn">
                            <i class="fas fa-download"></i> Download Results
                        </button>
                    </form>
                <?php } else { ?>
                    <p class="error"><i class="fas fa-exclamation-triangle"></i> No records found for this USN. Please check the USN and try again.</p>
                <?php } ?>
            </div>
        <?php } ?>
    </div>

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
