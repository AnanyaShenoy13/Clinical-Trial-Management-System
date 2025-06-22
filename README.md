# Clinical Trial Management System

A web-based application designed to streamline the management of clinical trials. It allows researchers to register participants, create and manage trials, record medical data, and securely store and retrieve participant information using a MySQL database backend.

---

## 🩺 Features

- 👥 Participant and Researcher registration with role-based access
- 📝 Secure login system for both users
- 📋 Add, view, and update participant records
- 🧪 Create, assign, and manage clinical trials
- 💊 Record medical history and trial progress
- 🔐 Session management and authentication
- 📁 Clean modular PHP backend with structured database integration

---

## 🛠️ Technologies Used

- **Frontend:** HTML, CSS  
- **Backend:** PHP  
- **Database:** MySQL (via phpMyAdmin)  
- **Server:** XAMPP (Apache, MySQL)  
- **Tools:** VS Code, phpMyAdmin

---

## ⚙️ Setup Instructions

### 1. Requirements
- XAMPP installed (Apache + MySQL)
- phpMyAdmin access

### 2. Clone and Setup

git clone https://github.com/yourusername/Clinical-Trial-Management-System.git
Place the folder in htdocs/ directory of XAMPP

Start Apache and MySQL in XAMPP Control Panel

Open http://localhost/phpmyadmin/ and create a new database named:

clinical_trials

Import the SQL schema:
Use clinical_trials.sql provided (if any) or manually create tables:
participant, researcher, trial, etc.

### 3. Run the application
Open in browser:

http://localhost/Clinical-Trial-Management-System/login.php

🧪 Sample Use Cases
🧑‍⚕️ Real-world simulation of managing participants in clinical drug trials<br>
📊 Academic or research-oriented trial data management system<br>
💾 Demonstrates full-stack CRUD operations using PHP and MySQL<br>

### 🙋 Author
Ananya Shenoy