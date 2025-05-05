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

├── index.php                 # Main home page ├── faculty_login.php         # Faculty login page ├── faculty_register.php      # Faculty registration ├── faculty_dashboard.php     # Faculty dashboard ├── add_student.php           # Add student functionality ├── add_marks.php             # Add marks functionality ├── results.php               # Results viewing page ├── view_results.php          # Results details page ├── config.php                # Database configuration ├── logout.php                # Logout functionality ├── Database.sql              # Database schema ├── LICENSE                   # License file (MIT) └── Project Screenshot/       # Project screenshots ├── Home Page.png ├── Results page.png ├── Faculty login page.png └── faculty dashboard.png

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

Author

DEVIDAS CHINNARATHOD

Email: devidaschinnarathod.25@gmail.com


Acknowledgments

This project was developed with the assistance of ChatGPT, an AI language model, to enhance the development process and implement best practices in web development.

License

This project is licensed under the MIT License.
You are free to use, modify, and distribute this software with proper attribution.

---

### LICENSE file (Create a file named `LICENSE` in your project folder with the following content):

```text
MIT License

Copyright (c) 2025 DEVIDAS CHINNARATHOD

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.