# 🎓 Student Result Management System (SRMS)

A full-stack web application developed as a **Web Technology Mini Project** for managing and viewing student academic results efficiently.

## 🌐 Live Demo
👉 [Click here to visit the website]  https://rutvilandge.rf.gd/srms/

---

## 📌 Project Overview
The Student Result Management System (SRMS) is a web-based application that allows educational institutions to manage student academic records digitally. Admins can add students, subjects, and results, while students can securely log in to view their own academic performance.

---

## ✨ Features

### 👨‍💼 Admin Panel
- Secure admin login
- Dashboard with total students, subjects and results count
- Add / Delete students
- Add / Delete subjects
- Add / Update student results
- Auto grade calculation based on marks

### 👨‍🎓 Student Panel
- Secure student login with roll number
- View subject-wise marks and grades
- View overall percentage and grade
- Pass/Fail status for each subject

### 📊 Grading System
| Grade | Percentage |
|-------|------------|
| O (Outstanding) | ≥ 90% |
| A | ≥ 80% |
| B+ | ≥ 70% |
| B | ≥ 60% |
| C | ≥ 50% |
| F (Fail) | < 50% |

---

## 🛠️ Technologies Used

| Technology | Purpose |
|------------|---------|
| HTML5 | Structure and layout |
| CSS3 | Styling and responsive design |
| PHP | Server-side scripting |
| MySQL | Database management |
| mysqli | Database connectivity |

---

## 🗄️ Database Structure

- **admin** — stores admin credentials
- **students** — stores student information
- **subjects** — stores subject details
- **results** — stores marks and grades

---

## 👤 Login Credentials

### Admin
- **Username:** `admin`
- **Password:** `admin123`

### Student (Sample)
| Roll No | Name | Password |
|---------|------|----------|
| CS2021001 | Rahul Sharma | student123 |
| CS2021002 | Priya Patel | student123 |
| CS2021003 | Amit Kumar | student123 |

---

## 📁 Project Structure
srms/
├── index.php
├── css/
│   └── style.css
├── php/
│   ├── config.php
│   ├── admin_login.php
│   ├── admin_dashboard.php
│   ├── admin_logout.php
│   ├── manage_students.php
│   ├── manage_subjects.php
│   ├── manage_results.php
│   ├── student_login.php
│   ├── student_dashboard.php
│   └── student_logout.php
└── sql/
└── database.sql---

## 🚀 How to Run Locally

1. Install **XAMPP**
2. Copy `srms` folder to `htdocs/`
3. Start **Apache** and **MySQL**
4. Open **phpMyAdmin** → create database `srms_db`
5. Import `sql/database.sql`
6. Visit `http://localhost/srms`

---

## 👩‍💻 Developer
**Rutvi Landge**
Web Technology Mini Project — 2026
