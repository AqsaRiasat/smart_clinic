# 🏥 Smart Clinic - Modern Healthcare & Clinic Management System

A full-stack, responsive web application designed for modern clinics and hospitals to streamline patient appointment booking, doctor scheduling, and clinic administration.

Built with **PHP (Condition-based Architecture)**, **MySQL**, **Bootstrap 5**, and **Modern Vanilla CSS/JavaScript**.

---

## 🌟 Key Features

### 👤 Patient Portal (`dashboard.php`)
* **Patient Registration & Authentication**: Secure sign-up and login with condition-based input validation.
* **2-Step Forgot Password Recovery**: Verify registered email and full name, followed by secure password reset without requiring external SMTP services.
* **Interactive Patient Dashboard**:
  * Real-time statistics (Total Appointments, Upcoming Visits, Finished Consultations, Member Since).
  * Dynamic Time-based Greeting badge (Good Morning / Afternoon / Evening).
  * Appointments History Table with status indicators (`Today`, `Upcoming`, `Completed`).
* **Appointment Management**:
  * **View Modal**: Quick view of appointment details (Doctor, Department, Schedule, Contact, Notes).
  * **Cancel Appointment**: Instant cancellation with custom confirmation popup.
  * **Print / PDF Slip (`print_appointment.php`)**: Clean, printable token receipt with unique Token Number (`SC-0000X`), clinic branding, and verification stamp.
* **Profile & Security Settings**:
  * Update personal details (Full Name, Email).
  * Change account password with current password verification.
* **Dark / Light Mode**: Persistent theme switcher across the dashboard and main website.

---

### 🛡️ Admin Management Panel (`admin.php`)
* **Secure Admin Authentication**: Dedicated administrator access protection.
* **KPI Metrics Overview**: Real-time counter cards for Total Appointments, Inbox Messages, and Active Doctors.
* **Dynamic Interactive Calendar**: Interactive monthly calendar widget with day click-to-book sync for quick scheduling.
* **Heart Health Widget**: Medical awareness card with clean anatomical illustrations.
* **Full CRUD Appointment Manager**:
  * Create new appointments.
  * Edit existing appointment schedules, patient details, and doctor departments.
  * Delete appointments with custom compact confirmation modal.
* **Contact Inbox Manager**: View and manage incoming inquiries from website visitors.
* **Collapsible Navigation Sidebar & Theme Toggler**.

### ⚡ Dynamic AJAX Powered Features
* **Live Admin Search (`ajax_search_admin.php`)**: Instant search across appointments by patient name, department, email, or date without page reloads.
* **Real-time Email Availability Checker (`ajax_check_email.php`)**: Instant feedback during patient signup indicating whether an email is available or already registered.
* **Asynchronous Contact Form Submission (`ajax_contact.php`)**: Send inquiries without page refresh, with instant feedback alerts.

---

### 🌐 Public Clinic Website
* **Home (`index.php`)**: Hero section, services preview, featured doctors, quick appointment form, patient testimonials, and AJAX contact section.
* **About Us (`about.php`)**: Clinic history, modern facilities, mission & vision statements.
* **Services (`services.php`)**: Detailed list of specialties (Cardiology, Pediatrics, Neurology, Orthopedics, Dermatology, Laboratory, General Medicine).
* **Doctors Directory (`doctors.php`)**: Medical specialist profiles with departments and social handles.
* **Testimonials (`testimonials.php`)**: Patient reviews and star ratings.
* **Contact Us (`contact.php`)**: Contact information, location details, and asynchronous messaging form.

---

## 🛠️ Technology Stack

| Layer | Technologies Used |
|---|---|
| **Frontend** | HTML5, CSS3, Bootstrap 5.2.3, Font Awesome 6, AOS (Animate on Scroll) |
| **Backend** | Native PHP (Pure condition-based validation & session management) |
| **Database** | MySQL / MariaDB (via `mysqli`) |
| **Server Environment** | Apache (XAMPP / WAMP / LAMP) |

---

## 📂 Project Directory Structure

```text
smart_clinic/
│
├── database/
│   ├── db.php                    # MySQL Database connection configuration
│   └── smart_clinic_db.sql       # Database schema & sample seed data
│
├── ajax/
│   ├── ajax_check_email.php      # Live email availability check endpoint
│   ├── ajax_contact.php          # Async contact form submission endpoint
│   └── ajax_search_admin.php     # Real-time admin table search endpoint
│
├── css/
│   ├── style.css                 # Main website styling & components
│   ├── dashboard.css             # Patient dashboard & dark mode styles
│   ├── admin.css                 # Admin panel & analytics widgets styles
│   └── auth.css                  # Login, Signup & Forgot Password styles
│
├── js/
│   ├── main.js                   # Navbar, scroll effects & popup handlers
│   └── theme-toggle.js           # Dark/Light mode theme state controller
│
├── images/                       # Clinic assets, avatars, and doctor photos
│
├── includes/
│   ├── header.php                # Meta tags, fonts, stylesheets & theme preload
│   ├── navbar.php                # Responsive navigation bar with auth states
│   ├── footer.php                # Universal clinic footer
│   └── scripts.php               # Core JavaScript libraries & scripts
│
├── index.php                     # Landing page
├── about.php                     # About Us page
├── services.php                  # Clinic services page
├── doctors.php                   # Doctors directory page
├── testimonials.php              # Patient reviews page
├── contact.php                   # Contact inquiries page
│
├── appointment.php               # Online appointment booking page
├── user_login.php                # Unified login (Patient & Admin)
├── signup.php                    # Patient registration page
├── forgot_password.php           # 2-Step identity verification & password reset
├── dashboard.php                 # Patient portal & appointment management
├── admin.php                     # Clinic administration & scheduling panel
├── print_appointment.php         # Printable appointment token slip
├── logout.php                    # Admin session logout handler
└── logout_user.php               # Patient session logout handler
```

---

## 🚀 Installation & Setup Guide

### 1. Prerequisites
Ensure you have **XAMPP** (or any local web server with Apache & MySQL) installed on your system.

### 2. Clone or Copy Project
Place the project folder in your XAMPP web root directory:
```bash
C:\xampp\htdocs\smart_clinic
```

### 3. Start Apache & MySQL
1. Open **XAMPP Control Panel**.
2. Click **Start** for both **Apache** and **MySQL** modules.

### 4. Database Setup
1. Open your browser and navigate to `http://localhost/phpmyadmin/`.
2. Create a new database named `smart_clinic_db`.
3. Click on the **Import** tab.
4. Choose the `smart_clinic_db.sql` file located in the project root directory.
5. Click **Go** / **Import** to create all tables and populate sample records.

### 5. Run the Application
Open your browser and visit:
```text
http://localhost/smart_clinic/
```

---

## 🔑 Default Login Credentials

### 👨‍💼 Administrator Account
* **Login URL**: `http://localhost/smart_clinic/user_login.php`
* **Email**: `admin@smartclinic.com`
* **Password**: `admin123`

### 👤 Sample Patient Accounts
* **Login URL**: `http://localhost/smart_clinic/user_login.php`
* **Sample 1**:
  * **Email**: `aqsa@gmail.com`
  * **Password**: `123456`
* **Sample 2**:
  * **Email**: `hamza.ali@gmail.com`
  * **Password**: `123456`
* **Sample 3**:
  * **Email**: `zainab.khan@gmail.com`
  * **Password**: `123456`

---

## 📄 License & Credits
* Developed for **Smart Clinic Management**.
* All UI layouts and components are tailored for high performance, accessibility, and modern aesthetics.
