<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags for character set, responsive design, and SEO optimization -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HKBK College Internal Marks Portal - Check your semester results, view internal marks, download mark sheets, and track academic performance for B.Tech and Engineering courses at HKBK College of Engineering, Bangalore">
    <meta name="keywords" content="HKBK College result, HKBK College internal marks, HKBK College engineering result, HKBK College B.Tech result, HKBK College internal marks checker, HKBK College semester results, HKBK College exam result, HKBK College result 2025, HKBK College internal marks portal, HKBK College result online, HKBK College marks sheet, HKBK College result download, HKBK College engineering marks">
    <meta name="author" content="DEVIDAS CHINNARATHOD">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://hkbkcollege.edu.in/results" />
    <link rel="icon" href="hkbk_logo.jpg" type="image/jpeg">

    
    <!-- Page title and external resource links -->
    <title>HKBK College Internal Marks Portal | Result Checker 2025</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Basic Reset - Removing default browser styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Base body styling with modern gradient background */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2); /* Modern subtle gradient */
            color: #333;
            padding: 0;
            margin: 0;
        }

        /* Header styling with sticky positioning */
        header {
            display: flex;
            justify-content: space-between;
            padding: 20px 50px;
            background-color: #4a6fb3; /* Modern deep blue */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        /* Logo/Title styling */
        .title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #ffffff;
        }

        /* Navigation menu styling */
        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            margin: 0 15px;
        }

        /* Navigation link styling with transitions and hover effects */
        nav ul li a {
            color: #ffffff;
            font-size: 1rem;
            text-decoration: none;
            font-weight: 400;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
            position: relative;
            padding: 8px 12px;
            border-radius: 6px;
        }

        /* Hover effect for navigation links */
        nav ul li a:hover {
            color: #ff9a8b;
            transform: scale(1.05);
            background-color: rgba(255, 255, 255, 0.1);
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
            background-color: #ff9a8b;
            transition: width 0.3s ease;
        }
        
        /* Expanding underline on hover */
        nav ul li a:hover:after {
            width: 80%;
        }
        
        /* Styling for the currently active page link */
        .active-link {
            background-color: rgba(255, 255, 255, 0.15);
            color: #fff !important;
            font-weight: 500;
        }
        
        .active-link:after {
            width: 80%;
            background-color: #fff;
        }

        /* Main content area styling */
        main {
            padding: 50px;
            text-align: center;
        }

        /* Container to limit content width and center it */
        .content-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Main heading styling */
        h1 {
            font-size: 2.5rem;
            color: #4a6fb3;
            margin-bottom: 20px;
        }

        /* Cards container - flex layout for responsive alignment */
        .cards {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 40px auto;
            flex-wrap: wrap;
            max-width: 800px;
        }

        /* Individual card styling with hover effects */
        .card {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            width: 300px;
            text-align: center;
            transition: all 0.3s ease;
            border-top: 5px solid #4a6fb3;
            margin-bottom: 20px;
            flex: 1;
            min-width: 280px;
            max-width: 350px;
        }

        /* Card hover animation - lift effect */
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
        }

        /* Card heading styling */
        .card h2 {
            font-size: 1.8rem;
            color: #4a6fb3;
            margin-bottom: 15px;
        }

        /* Card paragraph styling */
        .card p {
            font-size: 1rem;
            margin-bottom: 25px;
            color: #555;
        }

        /* Button styling within cards */
        .card .btn {
            padding: 14px 25px;
            background-color: #4a6fb3;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 1rem;
            min-width: 180px;
        }

        /* Icon styling within buttons */
        .card .btn i {
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        /* Button hover effects - color change and lift */
        .card .btn:hover {
            background-color: #ff9a8b;
            transform: translateY(-5px);
            box-shadow: 0 7px 20px rgba(255, 154, 139, 0.5);
        }
        
        /* Icon animation on button hover */
        .card .btn:hover i {
            transform: scale(1.2);
        }

        /* Footer styling */
        footer {
            padding: 40px 30px;
            background-color: #4a6fb3;
            color: white;
            text-align: center;
            font-size: 1rem;
            margin-top: 50px;
            position: relative;
        }

        footer .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            flex-wrap: wrap;
            gap: 20px;
        }

        footer .footer-left {
            font-size: 0.95rem;
            text-align: left;
        }
        
        footer .college-info {
            margin-top: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        footer .college-info i {
            color: #ff9a8b;
        }

        footer .footer-right ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        footer .footer-right ul li {
            display: inline-block;
        }

        footer .footer-right ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        footer .footer-right ul li a:hover {
            color: #ff9a8b;
        }
        
        .footer-center {
            flex-grow: 1;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }
        
        .footer-logo {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                align-items: center;
                padding: 15px 20px;
            }
            
            .title {
                margin-bottom: 15px;
            }
            
            nav ul {
                gap: 10px;
                flex-wrap: wrap;
                justify-content: center;
            }

            main {
                padding: 30px 15px;
            }
            
            .content-container {
                width: 100%;
                padding: 0 10px;
            }
            
            h1 {
                font-size: 2rem;
            }

            .cards {
                flex-direction: row;
                align-items: center;
                gap: 20px;
                padding: 0 15px;
            }

            .card {
                width: 100%;
                max-width: 350px;
                margin: 0 auto 20px;
                padding: 25px 20px;
                min-width: 250px;
            }
            
            .project-info {
                padding: 20px 15px;
                margin-left: 15px;
                margin-right: 15px;
            }
            
            .students-container {
                gap: 30px;
                padding: 0 15px;
            }
            
            .student-card {
                width: 100%;
                max-width: 350px;
                margin: 0 auto 20px;
            }
            
            .upcoming-features {
                padding: 0 15px;
            }
            
            .feature-card {
                width: 100%;
                max-width: 350px;
                margin: 0 auto 20px;
                padding: 25px 20px;
            }
            
            .feature-tag {
                font-size: 0.85rem;
                padding: 6px 12px;
            }
            
            .section-title {
                font-size: 1.8rem;
                margin: 40px 0 25px 0;
            }

            footer {
                padding: 30px 15px;
            }
            
            footer .footer-content {
                flex-direction: column;
                text-align: center;
                gap: 25px;
            }
            
            footer .footer-left {
                text-align: center;
            }
            
            footer .college-info {
                justify-content: center;
            }

            footer .footer-right ul {
                justify-content: center;
                flex-wrap: wrap;
                margin-top: 10px;
            }
        }
        
        @media (max-width: 350px) {
            nav ul li a {
                font-size: 0.9rem;
                padding: 6px 8px;
            }
            
            .feature-tag {
                font-size: 0.8rem;
                padding: 5px 10px;
            }
        }

        .section-title {
            text-align: center;
            margin: 70px 0 30px 0;
            color: #4a6fb3;
            font-size: 2rem;
            position: relative;
            padding-bottom: 10px;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: #ff9a8b;
        }

        .project-info {
            text-align: center;
            margin-bottom: 40px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            background-color: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
        }

        .project-info p {
            color: #555;
            line-height: 1.7;
            margin-bottom: 15px;
        }

        .project-info .subject-code {
            display: inline-block;
            background-color: #4a6fb3;
            color: white;
            padding: 6px 18px;
            border-radius: 50px;
            font-weight: 600;
            margin: 15px 0;
            font-size: 1.1rem;
            box-shadow: 0 4px 8px rgba(74, 111, 179, 0.2);
        }
        
        .project-features {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        
        .feature-tag {
            background-color: #f0f4f8;
            color: #4a6fb3;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .feature-tag i {
            color: #ff9a8b;
        }

        .students-container {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
            margin: 0 auto 50px;
            max-width: 800px;
        }

        .student-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            width: 320px;
            text-align: center;
            transition: all 0.3s ease;
            border-top: 5px solid #ff9a8b;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .student-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
        }

        .student-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #f5f5f5;
            margin-bottom: 15px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 3px solid #3498db;
            transition: all 0.3s ease;
            color: #3498db;
        }

        .student-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .student-avatar i {
            font-size: 60px;  /* Size for the Font Awesome icon */
        }

        .student-card h3 {
            font-size: 1.5rem;
            color: #4a6fb3;
            margin-bottom: 10px;
        }

        .student-card .usn {
            font-size: 1.1rem;
            font-weight: 600;
            color: #555;
            margin-bottom: 15px;
        }

        .student-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
            flex-grow: 1;
        }

        .detail-item {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #666;
        }

        .detail-item i {
            color: #4a6fb3;
        }
        
        .contribution {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed #e0e0e0;
        }
        
        .contribution-title {
            font-weight: 600;
            color: #4a6fb3;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        /* Upcoming Features Section Styling */
        .upcoming-features {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            margin: 0 auto 50px;
            max-width: 1200px;
        }

        .feature-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            width: 320px;
            text-align: center;
            transition: all 0.3s ease;
            border-top: 5px solid #4a6fb3;
            margin-bottom: 20px;
            flex: 1;
            min-width: 280px;
            max-width: 350px;
            display: flex;
            flex-direction: column;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
        }

        .feature-icon {
            font-size: 48px;
            color: #4a6fb3;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            color: #ff9a8b;
            transform: scale(1.1);
        }

        .feature-card h3 {
            font-size: 1.5rem;
            color: #4a6fb3;
            margin-bottom: 15px;
        }

        .feature-card p {
            color: #555;
            line-height: 1.6;
            flex-grow: 1;
        }

    </style>
</head>

<body>

    <!-- Header Section -->
    <header>
        <div class="title"><i class="fas fa-graduation-cap"></i> HKBK</div>

        <nav>
            <ul>
                <li><a href="index.php" class="active-link"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="results.php"><i class="fas fa-chart-bar"></i> Check Results</a></li>
                <li><a href="faculty_login.php"><i class="fas fa-user-tie"></i> Faculty Login</a></li>
                <li><a href="faculty_register.php"><i class="fas fa-user-plus"></i> Faculty Registration</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <div class="content-container">
            <h1><i class="fas fa-school"></i> Welcome to the Student Internal Marks Portal</h1>
            <p>This platform allows students to check their internal marks, and faculty to manage student results easily.</p>

            <div class="cards">
                <div class="card">
                    <h2><i class="fas fa-user-graduate"></i> For Students</h2>
                    <p>Check your internal marks, view your performance, and stay updated on your progress.</p>
                    <a href="results.php" class="btn">
                        <i class="fas fa-search"></i>
                        <span>Check Results</span>
                    </a>
                </div>

                <div class="card">
                    <h2><i class="fas fa-chalkboard-teacher"></i> For Faculty</h2>
                    <p>Log in to add or update student marks, and manage internal assessments efficiently.</p>
                    <a href="faculty_login.php" class="btn">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Faculty Login</span>
                    </a>
                </div>
            </div>

            <div class="content-container">
                <h2 class="section-title"><i class="fas fa-rocket"></i> Upcoming Features</h2>
                
                <div class="upcoming-features">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-file-excel"></i>
                        </div>
                        <h3>Excel Import</h3>
                        <p>Faculty members will be able to import student lists and marks directly from Excel spreadsheets, making data entry faster and more efficient.</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <h3>PDF Reports</h3>
                        <p>Students will be able to download their marks and academic reports in PDF format for easy sharing and printing.</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>Performance Analytics</h3>
                        <p>Visualized performance trends and analytics to help students track their academic progress over time.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer Section -->
    <footer>
        <div class="footer-content">
            <div class="footer-left">
                <p><i class="far fa-copyright"></i> 2025 Student Internal Marks Portal. All rights reserved.</p>
                <div class="college-info">
                    <i class="fas fa-university"></i>
                    <span>HKBK College of Engineering, Bangalore</span>
                </div>
            </div>
            
            <div class="footer-center">
                <div class="footer-logo">
                    <i class="fas fa-graduation-cap"></i>
                    <span>HKBK</span>
                </div>
                <p>Student Academic Management System</p>
            </div>
            
            <div class="footer-right">
                <ul>
                    <li><a href="#"><i class="fas fa-info-circle"></i> About</a></li>
                    <li><a href="#"><i class="fas fa-question-circle"></i> Help</a></li>
                    <li><a href="#"><i class="fas fa-envelope"></i> Contact</a></li>
                </ul>
            </div>
        </div>
    </footer>

</body>

</html>
