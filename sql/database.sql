-- Student Result Management System Database
-- Create and use database
CREATE DATABASE IF NOT EXISTS srms_db;
USE srms_db;

-- Admin table
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Students table
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    roll_no VARCHAR(20) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    department VARCHAR(50) NOT NULL,
    semester INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Subjects table
CREATE TABLE subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_code VARCHAR(20) NOT NULL UNIQUE,
    subject_name VARCHAR(100) NOT NULL,
    department VARCHAR(50) NOT NULL,
    semester INT NOT NULL,
    max_marks INT DEFAULT 100
);

-- Results table
CREATE TABLE results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    subject_id INT NOT NULL,
    marks_obtained INT NOT NULL,
    exam_year VARCHAR(10) NOT NULL,
    grade VARCHAR(5),
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);

-- Default admin (password: admin123)
INSERT INTO admin (username, password) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Sample students (password: student123)
INSERT INTO students (roll_no, name, email, password, department, semester) VALUES
('CS2021001', 'Rahul Sharma', 'rahul@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Computer Science', 5),
('CS2021002', 'Priya Patel', 'priya@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Computer Science', 5),
('CS2021003', 'Amit Kumar', 'amit@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Computer Science', 5);

-- Sample subjects
INSERT INTO subjects (subject_code, subject_name, department, semester, max_marks) VALUES
('CS501', 'Web Technology', 'Computer Science', 5, 100),
('CS502', 'Database Management', 'Computer Science', 5, 100),
('CS503', 'Operating Systems', 'Computer Science', 5, 100),
('CS504', 'Computer Networks', 'Computer Science', 5, 100),
('CS505', 'Software Engineering', 'Computer Science', 5, 100);

-- Sample results
INSERT INTO results (student_id, subject_id, marks_obtained, exam_year, grade) VALUES
(1, 1, 85, '2024', 'A'),
(1, 2, 78, '2024', 'B+'),
(1, 3, 90, '2024', 'O'),
(1, 4, 72, '2024', 'B'),
(1, 5, 88, '2024', 'A'),
(2, 1, 92, '2024', 'O'),
(2, 2, 85, '2024', 'A'),
(2, 3, 79, '2024', 'B+'),
(2, 4, 88, '2024', 'A'),
(2, 5, 95, '2024', 'O');
