<?php
session_start();
include 'config.php';

// Redirect to login if faculty is not logged in
if (!isset($_SESSION['faculty_id'])) {
    header("Location: faculty_login.php");
    exit();
}

// Get filter values
$selected_ia = isset($_GET['ia_type']) ? $_GET['ia_type'] : '';
$selected_semester = isset($_GET['semester']) ? $_GET['semester'] : '';
$search_usn = isset($_GET['search_usn']) ? trim($_GET['search_usn']) : '';

// Build the query with filters
$sql = "SELECT students.usn, students.name, students.semester, marks.subject, marks.marks, marks.remark, marks.ia_type 
        FROM students 
        JOIN marks ON students.usn = marks.usn 
        WHERE 1=1";

$params = array();
$types = "";

if (!empty($search_usn)) {
    $sql .= " AND students.usn LIKE ?";
    $params[] = "%$search_usn%";
    $types .= "s";
}

if (!empty($selected_ia)) {
    $sql .= " AND marks.ia_type = ?";
    $params[] = $selected_ia;
    $types .= "s";
}

if (!empty($selected_semester)) {
    $sql .= " AND students.semester = ?";
    $params[] = $selected_semester;
    $types .= "i";
}

$sql .= " ORDER BY students.semester, students.usn";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Get unique semesters for filter
$semesters_query = "SELECT DISTINCT semester FROM students ORDER BY semester";
$semesters_result = $conn->query($semesters_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HKBK College Results Dashboard - Faculty portal for viewing all student internal marks, assessments, and academic performance at HKBK College of Engineering.">
    <meta name="keywords" content="HKBK College results dashboard, HKBK College internal marks report, HKBK College faculty portal, HKBK College student performance, HKBK College academic records, HKBK College assessment results, HKBK College marks database">
    <meta name="author" content="DEVIDAS CHINNARATHOD">
    <meta name="robots" content="noindex, follow">
    <link rel="canonical" href="https://hkbkcollege.edu.in/view_results.php" />
    
    <title>HKBK College Results Dashboard | Internal Assessment Reports</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2); /* Modern subtle gradient */
            margin: 0;
            padding: 0;
        }

        /* Header */
        header {
            background-color: #4a6fb3; /* Modern deep blue */
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

        /* Container */
        .container {
            width: 90%;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
            overflow-x: auto;
            border-top: 5px solid #4a6fb3;
        }

        h2 {
            color: #4a6fb3;
            margin-bottom: 25px;
            font-size: 28px;
            font-weight: 600;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        th, td {
            border: 1px solid #eee;
            padding: 15px;
            text-align: center;
        }

        th {
            background-color: #4a6fb3;
            color: white;
            font-weight: 500;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f5fd;
        }

        /* Back Button */
        .back-btn {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 20px;
            background-color: #4a6fb3;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .back-btn:hover {
            background-color: #ff9a8b;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 154, 139, 0.4);
        }

        .filters {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 500;
        }

        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

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

        .no-results {
            text-align: center;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-top: 20px;
            color: #6c757d;
        }

        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 20px;
            }

            .filters {
                flex-direction: column;
                gap: 15px;
            }

            .filter-group {
                width: 100%;
            }

            table {
                display: block;
                overflow-x: auto;
            }
        }

        .search-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
            outline: none;
        }

        .search-input::placeholder {
            color: #999;
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <header>
        <div class="title"><i class="fas fa-graduation-cap"></i> HKBK Student Portal</div>
        <nav>
            <ul>
                <li><a href="faculty_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="add_student.php"><i class="fas fa-user-plus"></i> Add Student</a></li>
                <li><a href="add_marks.php"><i class="fas fa-plus-circle"></i> Add Marks</a></li>
                <li><a href="view_results.php"><i class="fas fa-chart-line"></i> View Results</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content Section -->
    <div class="container">
        <h2><i class="fas fa-table"></i> View Results</h2>

        <form method="get" class="filters">
            <div class="filter-group">
                <label><i class="fas fa-search"></i> Search by USN:</label>
                <input type="text" name="search_usn" value="<?= htmlspecialchars($search_usn) ?>" placeholder="Enter USN" class="search-input">
            </div>

            <div class="filter-group">
                <label><i class="fas fa-filter"></i> Filter by IA Type:</label>
                <select name="ia_type">
                    <option value="">All IA Types</option>
                    <option value="1st IA" <?= $selected_ia === '1st IA' ? 'selected' : '' ?>>1st IA</option>
                    <option value="2nd IA" <?= $selected_ia === '2nd IA' ? 'selected' : '' ?>>2nd IA</option>
                    <option value="3rd IA" <?= $selected_ia === '3rd IA' ? 'selected' : '' ?>>3rd IA</option>
                </select>
            </div>

            <div class="filter-group">
                <label><i class="fas fa-graduation-cap"></i> Filter by Semester:</label>
                <select name="semester">
                    <option value="">All Semesters</option>
                    <?php while ($sem = $semesters_result->fetch_assoc()) { ?>
                        <option value="<?= $sem['semester'] ?>" <?= $selected_semester == $sem['semester'] ? 'selected' : '' ?>>
                            Semester <?= $sem['semester'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <button type="submit"><i class="fas fa-search"></i> Apply Filters</button>
        </form>

        <?php if ($result->num_rows > 0) { ?>
            <table>
                <tr>
                    <th><i class="fas fa-id-card"></i> USN</th>
                    <th><i class="fas fa-user"></i> Name</th>
                    <th><i class="fas fa-list-ol"></i> Semester</th>
                    <th><i class="fas fa-book"></i> Subject</th>
                    <th><i class="fas fa-graduation-cap"></i> IA Type</th>
                    <th><i class="fas fa-chart-bar"></i> Marks</th>
                    <th><i class="fas fa-comment"></i> Remark</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['usn']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['semester']) ?></td>
                        <td><?= htmlspecialchars($row['subject']) ?></td>
                        <td><?= htmlspecialchars($row['ia_type']) ?></td>
                        <td><?= htmlspecialchars($row['marks']) ?></td>
                        <td><?= htmlspecialchars($row['remark']) ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <div class="no-results">
                <i class="fas fa-info-circle"></i> No results found for the selected filters.
            </div>
        <?php } ?>

        <a href="faculty_dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
    </div>

</body>
</html>
