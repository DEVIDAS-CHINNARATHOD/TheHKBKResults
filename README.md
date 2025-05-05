# HKBK Results Management System

A comprehensive web-based application for managing student results, developed with PHP and MySQL.

## 🌐 Live Demo

👉 [Check out the live demo here](https://thehkbkresults.42web.io/)

## Project Overview

This project is a Student Results Management System designed for educational institutions to efficiently manage and track student academic performance. The system provides a user-friendly interface for faculty members to add students, manage marks, and view results.

## Technologies Used

- **Frontend:**
  - HTML5
  - CSS3
  - JavaScript
  - Bootstrap (for responsive design)

- **Backend:**
  - PHP
  - MySQL Database

- **Server:**
  - Apache Web Server

## Features

1. **Faculty Management**
   - Faculty registration and login
   - Secure authentication system
   - Faculty dashboard

2. **Student Management**
   - Add new students
   - View student details
   - Manage student records

3. **Results Management**
   - Add student marks
   - View results
   - Generate result reports

4. **User Interface**
   - Responsive design
   - Intuitive navigation
   - Clean and professional layout

## Screenshots

### Home Page
![Home Page](Project%20Screenshot/Home%20Page.png)

### Results Page
![Results Page](Project%20Screenshot/Results%20page.png)

### Faculty Login
![Faculty Login](Project%20Screenshot/Faculty%20login%20page.png)

### Faculty Dashboard
![Faculty Dashboard](Project%20Screenshot/faculty%20dashboard.png)

## Project Structure

```
├── index.php                 # Main home page
├── faculty_login.php         # Faculty login page
├── faculty_register.php      # Faculty registration
├── faculty_dashboard.php     # Faculty dashboard
├── add_student.php          # Add student functionality
├── add_marks.php            # Add marks functionality
├── results.php              # Results viewing page
├── view_results.php         # Results details page
├── config.php               # Database configuration
├── logout.php               # Logout functionality
├── Database.sql             # Database schema
└── Project Screenshot/      # Project screenshots
    ├── Home Page.png
    ├── Results page.png
    ├── Faculty login page.png
    └── faculty dashboard.png
```

## Installation

1. Clone the repository
2. Import the `Database.sql` file into your MySQL database
3. Configure the database connection in `config.php`
4. Deploy the project on a web server with PHP and MySQL support

## Configuration

Update the database credentials in `config.php`:
```php
$host = "localhost";
$username = "your_username";
$password = "your_password";
$database = "your_database";
```

## Author

**J M PAVAN KALYAN**
- Email: pavankalyan9945545793@gmail.com

## Acknowledgments

This project was developed with the assistance of ChatGPT, an AI language model, to enhance the development process and implement best practices in web development.

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Contact

For any queries or support, please contact:
- Email: pavankalyan9945545793@gmail.com