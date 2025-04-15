
# Adullam Seminary Web Application (adullam.ng)

> A full-featured Student Application & Management System for Adullam Seminary.  
> Built for both applicants, students, administrators, and superadmins.

---

## 📚 Project Overview

The Adullam Seminary Web Application was designed to automate and manage the entire student application and administration workflow from admission to hostel accommodation.

This project manages:

- Online Applications for Admission
- Multi-step Application Forms with Validations
- Dynamic Program & Mode of Study Logic
- Document Uploads & Verification
- Tuition Payment Proof Uploads & Management
- Hostel Reservation Management
- Role-based Dashboards (Student | Admin | Superadmin)
- Email Notifications (For Confirmation & Approval)
- Dynamic PDF Generation for Hostel Registration
- Filtering, Sorting & Searching Functionalities
- Student Profiles Management
- Backend Admin CRUD Operations
- Seamless Frontend/Backend Integration

---

## 🛠️ Tech Stack

| Technology | Purpose |
|------------|---------|
| PHP 8.x    | Core Backend Logic & Routing |
| MySQL      | Database Storage |
| Tailwind CSS | Frontend Styling |
| JavaScript (Vanilla) | Dynamic UI Interactions |
| SweetAlert2 | User-Friendly Alerts |
| DomPDF | Generate PDF Confirmation Files |
| PHPMailer | Email Notifications |
| WAMP/XAMPP | Local Development Environment |

---

## 📁 Folder Structure

```txt
adullam.ng/
├── assets/                 # Static assets (CSS, JS, Images)
├── components/             # Reusable components (Navbar, Sidebar)
├── dashboard/              # Student Dashboard pages
├── admin/                  # Admin Dashboard pages
├── superadmin/             # Superadmin Dashboard pages
├── uploads/                # Uploaded documents and generated PDFs
├── ajax/                   # AJAX Handlers
├── includes/               # Utility files (DB connection, mailer, logic)
├── vendor/                 # Composer packages (dompdf, phpmailer)
├── register_hostel.php     # Hostel Registration Form
├── hostel_submit.php       # Hostel Form Processing Logic
├── form_level1.php - form_level7.php  # Admission Multi-step Forms
└── README.md               # Project Documentation
```

---

## ⚙️ Installation Instructions

1. Clone the Project:

```bash
git clone https://github.com/Pinnacle96/Adullam-Admission-Management-System-2.0.git
```

2. Setup the Database:

- Import the provided `adullam.sql` into MySQL.
- Configure your `db.php` file with correct DB credentials.

3. Setup Environment:

- Place project inside WAMP or XAMPP `www/` directory.
- Ensure PHP extensions enabled:
    - `pdo_mysql`
    - `mbstring`
    - `gd`
    - `openssl`
    - `fileinfo`

4. Composer Install:

```bash
composer install
```

5. Configure Email (PHPMailer):

Edit `mailer.php`:

```php
$mail->Host = 'smtp.yourmailserver.com';
$mail->Username = 'your-email@example.com';
$mail->Password = 'your-email-password';
```

---

## ✨ Key Features

### Student Features:
- Dynamic Step-wise Admission Forms
- Program-specific Logic for MA Biblical Studies
- Document Upload with Validation
- Proof of Tuition Payment Upload
- Hostel Reservation Form
- Email Confirmation on Submission
- Downloadable Hostel Confirmation PDF

### Admin Features:
- Manage Tuition Payments
- Approve/Reject with Custom Reason
- View Uploaded Payment Proof
- Search, Filter & Sort Applicants
- View Student Profiles

### Superadmin Features:
- Manage All Hostel Reservations
- Filter by Program, Mode, Year, Semester, Gender, Nationality
- View Uploaded Documents
- No Approval Required for Hostel (Auto-Confirm)

---

## 🔐 Security Notes
- File Upload Validation
- Secure SQL Queries (Prepared Statements)
- Role-based Access Control
- Directory Protection
- CSRF Validation Removed (As per Client Request)

---

## 💡 Future Improvements

- API Endpoints for Mobile App
- Bulk PDF Report Generation for Admin
- Automated Payment Gateway Integration
- SMS Notification Integration
- Dark Mode for Dashboard

---

## 📧 Support Contact
For Technical Support, Contact:  
`support@adullam.ng`

---

> Developed with ❤️ by Pinnacle Tech Hub
> For any question on this project contact me on Whatsapp https:wa.me/+2348150829549/
