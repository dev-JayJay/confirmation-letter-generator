CREATE DATABASE IF NOT EXISTS udus_admissions CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE udus_admissions;

CREATE TABLE IF NOT EXISTS students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  jamb_number VARCHAR(100) UNIQUE NOT NULL,
  surname VARCHAR(120),
  firstname VARCHAR(120),
  othername VARCHAR(120),
  dob DATE,
  gender ENUM('Male','Female') DEFAULT NULL,
  religion VARCHAR(60),
  email VARCHAR(255),
  marital_status VARCHAR(50),
  phone VARCHAR(50),
  state VARCHAR(100),
  lga VARCHAR(100),
  nin VARCHAR(50),
  residential_address TEXT,
  home_address TEXT,
  sponsor_name VARCHAR(255),
  sponsor_email VARCHAR(255),
  sponsor_phone VARCHAR(50),
  sponsor_state VARCHAR(100),
  sponsor_lga VARCHAR(100),
  sponsor_address TEXT,
  kin_name VARCHAR(255),
  kin_email VARCHAR(255),
  kin_phone VARCHAR(50),
  kin_state VARCHAR(100),
  kin_lga VARCHAR(100),
  kin_address TEXT,
  course VARCHAR(255),
  admission_number VARCHAR(100),
  department VARCHAR(255),
  status ENUM('pending','submitted','approved','rejected') DEFAULT 'pending',
  passport_path VARCHAR(500),
  signature_path VARCHAR(500),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS students_education (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT NOT NULL,
  primary_school VARCHAR(255),
  primary_year YEAR,
  secondary_school VARCHAR(255),
  secondary_year YEAR,
  olevel_type VARCHAR(50),
  FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

ALTER TABLE students_education
ADD COLUMN birth_cert VARCHAR(255) AFTER olevel_type,
ADD COLUMN primary_cert VARCHAR(255) AFTER birth_cert,
ADD COLUMN olevel_original VARCHAR(255) AFTER primary_cert,
ADD COLUMN jamb_letter VARCHAR(255) AFTER olevel_original,
ADD COLUMN jamb_result VARCHAR(255) AFTER jamb_letter,
ADD COLUMN indigene_cert VARCHAR(255) AFTER jamb_result;


CREATE TABLE IF NOT EXISTS olevel_subjects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT NOT NULL,
  subject_order TINYINT NOT NULL,
  subject_name VARCHAR(100),
  grade VARCHAR(20),
  FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS student_documents (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT NOT NULL,
  doc_type VARCHAR(100) NOT NULL,
  file_path VARCHAR(500) NOT NULL,
  uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);
