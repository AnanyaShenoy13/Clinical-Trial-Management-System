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

- Clone the repository:
git clone https://github.com/yourusername/Clinical-Trial-Management-System.git
- Place the cloned folder inside the htdocs/ directory of your XAMPP installation.
- Start Apache and MySQL from the XAMPP Control Panel.
- Open your browser and go to:
http://localhost/phpmyadmin/
- Create a new MySQL database named: clinical_trials
- Import the SQL schema:
    - If a file like clinical_trials.sql is provided, import it via phpMyAdmin.
    - If not, manually create the required tables:
        - participant
        - researcher
        - trial
        (and any additional ones used in your code)

---

### 🧪 Sample Use Cases<br>
‍⚕️ Real-world simulation of managing participants in clinical drug trials<br>
📊 Academic or research-oriented trial data management system<br>
💾 Demonstrates full-stack CRUD operations using PHP and MySQL<br>


### 🙋 Author
Ananya Shenoy