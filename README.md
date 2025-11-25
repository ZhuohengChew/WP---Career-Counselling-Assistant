# Career Counselling Assistant

A full-stack web application that guides users through interactive career assessments and provides personalized career suggestions with AI-powered insights and chatbot support.

## What It Does

Career Counselling Assistant is a comprehensive platform designed to help users discover their ideal career path through intelligent assessments. The application combines customizable quiz questions, intelligent analysis, and a chatbot interface to provide personalized career guidance.

**Key Capabilities:**
- Interactive career assessment quizzes (multiple choice and scale-based questions)
- AI-powered career suggestion engine
- Real-time chatbot for career consultation
- PDF export of quiz responses and results
- User profile management with secure authentication
- Admin dashboard for quiz content management

## Why Use It

### For Users
- **Personalized Guidance**: Get career suggestions tailored to your assessment responses
- **Comprehensive Assessment**: Answer both multiple-choice and scale-based questions to capture your preferences holistically
- **Easy Documentation**: Export your quiz responses and results as PDF reports
- **Anytime Support**: Chat with an AI-powered bot for career consultation anytime
- **Progress Tracking**: View your complete quiz attempt history with detailed results
- **Secure Experience**: Email-verified registration and encrypted password protection

### For Organizations
- **Customizable Content**: Admins can add, edit, and delete quiz questions without code changes
- **User Management**: View, edit, and manage user profiles and registrations
- **Scalable Solution**: Role-based access control for users and administrators
- **Modern UX**: Dark/light theme support and responsive mobile design

## Getting Started

### Prerequisites

- **Web Server**: Apache or Nginx with PHP 7.4+ support
- **Database**: MySQL 5.7+
- **PHP Extensions**: PDO, PDO MySQL
- **Composer**: For dependency management (optional for development)

### Installation

1. **Clone or Download the Project**
   ```bash
   git clone <repository-url>
   cd career_counselling_assistant
   ```

2. **Set Up the Database**
   - Open your MySQL client (phpMyAdmin, MySQL CLI, etc.)
   - Import the database schema:
     ```sql
     SOURCE db.sql;
     ```
   - This creates the `career_counsellor` database with all required tables

3. **Configure Database Connection**
   - Edit `includes/db.php`
   - Update connection credentials if different from defaults:
     ```php
     $host = 'localhost';
     $db = 'career_counsellor';
     $user = 'root';
     $pass = ''; // Add your MySQL password if needed
     ```

4. **Install Dependencies** (Optional - for production use)
   ```bash
   composer install
   ```
   This installs PHPMailer (for email verification) and DOMPDF (for PDF export).

5. **Configure Email Settings** (Optional)
   - Edit `includes/mailer.php` to set up SMTP configuration for OTP verification
   - By default, email verification may be disabled in development

6. **Deploy to Web Server**
   - Copy all files to your web server's document root
   - Ensure proper file permissions (755 for directories, 644 for files)
   - Create an `uploads/` directory with write permissions for profile pictures

### Quick Start

1. **Start Your Web Server**
   - Local development: Use PHP's built-in server
     ```bash
     php -S localhost:8000
     ```
   - Or configure your Apache/Nginx virtual host

2. **Access the Application**
   - Open your browser to `http://localhost:8000` (or your server URL)
   - Click **User Register** to create a new account
   - Verify your email (if enabled) and log in

3. **User Workflow**
   - Complete the career assessment quiz
   - View personalized career suggestions
   - Use the chatbot for additional guidance
   - Download quiz results as PDF
   - Update your profile anytime

4. **Admin Workflow** (if you have admin credentials)
   - Log in via Admin Login
   - Manage Quiz Questions: Add MCQ and scale-based questions
   - Manage Users: View and edit user information
   - Monitor assessment data and user progress

## Application Structure

```
├── index.html                 # Landing page
├── dashboard.php              # User/Admin dashboard
├── features.html              # Features overview
├── about.html                 # About the project
├── profile.php                # User profile management
├── style.css                  # Global styles
├── theme-toggle.js            # Dark/light mode functionality
├── nav.js                     # Navigation menu behavior
│
├── includes/
│   ├── db.php                 # Database connection
│   ├── auth.php               # Authentication checks
│   └── mailer.php             # Email/OTP service
│
├── process/
│   ├── login_user.php         # User login handler
│   ├── login_admin.php        # Admin login handler
│   ├── register_user.php      # User registration
│   └── verify_otp.php         # OTP verification
│
├── quiz/
│   ├── start_quiz.php         # Quiz interface
│   ├── start.php              # Chatbot interface
│   ├── submit_quiz.php        # Quiz submission handler
│   ├── result.php             # Quiz results page
│   ├── history.php            # Quiz attempt history
│   ├── view_attempt.php       # View past attempts
│   ├── export_pdf.php         # PDF generation
│   ├── download_attempt_pdf.php
│   └── save_chat.php          # Chatbot message handler
│
├── admin/
│   ├── login.php              # Admin login page
│   ├── dashboard.php          # Admin dashboard
│   ├── manage_quiz.php        # Question management
│   ├── add_question.php       # Add quiz questions
│   ├── delete_question.php    # Remove quiz questions
│   ├── view_users.php         # View all users
│   ├── edit_user.php          # Edit user details
│   └── delete_user.php        # Remove user accounts
│
├── user/
│   ├── login.php              # User login page
│   ├── register.html          # User registration form
│   └── style.css              # Auth pages styling
│
├── uploads/                   # User profile pictures
├── vendor/                    # PHP dependencies (Composer)
├── db.sql                     # Database schema
└── composer.json              # Dependency manifest
```

## Features

### User Features
- ✅ **Career Assessment Quiz**: Answer customized questions to get career insights
- ✅ **AI Chatbot**: Real-time career consultation and guidance
- ✅ **PDF Export**: Download quiz responses and results in PDF format
- ✅ **Progress Tracking**: View full history of quiz attempts with timestamps
- ✅ **Profile Management**: Upload profile picture, update personal information
- ✅ **Dark/Light Theme**: Toggle between themes for comfortable viewing
- ✅ **Email OTP Verification**: Secure registration with email verification

### Admin Features
- ✅ **Quiz Management**: Add, edit, and delete assessment questions
- ✅ **Question Types**: Support for multiple-choice and 1-5 scale questions
- ✅ **User Management**: View all users, edit profiles, manage permissions
- ✅ **User Deletion**: Remove inactive or problematic accounts
- ✅ **Dashboard**: Overview of platform activity and statistics

## Usage Examples

### For Users: Taking a Quiz
1. Log in to your account
2. Navigate to "Chatbot" in the menu (or click the quiz link on the dashboard)
3. Answer each question carefully
4. Click "Submit Quiz" to view personalized career suggestions
5. Use the "Export to PDF" button to save your results

### For Users: Accessing the Chatbot
1. Go to the quiz section's chatbot interface
2. Ask questions about your career path
3. Receive AI-powered guidance based on your assessment profile

### For Admins: Adding a Quiz Question
1. Log in with admin credentials
2. Click "Manage Quiz" on the admin dashboard
3. Fill in the question text
4. Select question type:
   - **MCQ**: Provide comma-separated options
   - **Scale**: Automatically creates a 1-5 scale
5. Click "Add Question"

### For Admins: Managing Users
1. Click "View Users" on the admin dashboard
2. See all registered users and their details
3. Click "Edit" to modify user information
4. Click "Delete" to remove a user account

## Database Schema

The application uses six main tables:

- **users**: User accounts with authentication and profile data
- **quizzes**: Assessment questions with type and options
- **quiz_attempts**: Records of when users completed assessments
- **responses**: Individual answers to quiz questions
- **career_suggestions**: Logged career path recommendations
- **chat_history**: Chatbot conversation logs

See `db.sql` for the complete schema with field definitions.

## Technologies Used

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript
- **Email**: PHPMailer 6.10
- **PDF Generation**: DOMPDF 3.1
- **Package Manager**: Composer

## Support & Documentation

### Getting Help
- Check the [Features page](features.html) for an overview of all capabilities
- Review the [About page](about.html) for project background
- Consult inline code comments for implementation details

### Common Issues

**Database Connection Error**
- Verify MySQL is running
- Check credentials in `includes/db.php`
- Ensure the `career_counsellor` database exists

**Email Verification Not Working**
- Configure SMTP settings in `includes/mailer.php`
- Check email service provider SMTP credentials
- Verify from email address is authorized

**File Upload Issues**
- Ensure `uploads/` directory has write permissions (755)
- Check PHP `upload_max_filesize` configuration
- Verify sufficient disk space

**PDF Export Fails**
- Ensure DOMPDF is installed via Composer
- Check file permissions on `vendor/` directory
- Verify sufficient server memory for PDF generation

### Development Resources
- **Code Comments**: Inline documentation throughout source files
- **Database Schema**: See `db.sql` for table structure and relationships
- **Configuration Files**: Check each module's configuration at the top of files

## Contributing

We welcome contributions to improve the Career Counselling Assistant!

### How to Contribute
1. Fork the repository
2. Create a feature branch (`git checkout -b feature/improvement`)
3. Make your changes with clear commit messages
4. Test thoroughly before submitting
5. Submit a pull request with a description of changes

### Areas for Contribution
- Additional AI career suggestion algorithms
- Enhanced chatbot functionality
- Mobile app development
- Localization to other languages
- Additional assessment question types
- Performance optimization

### Code Standards
- Follow PSR-12 PHP coding standards
- Use consistent indentation (2 spaces)
- Add comments for complex logic
- Test user authentication flows before submitting
- Validate all user inputs

## License

This project is part of an academic initiative. Please refer to the LICENSE file for usage terms and conditions.

## Maintainers

**Career Counselling Assistant** is maintained as part of a Year 3, Semester 1 academic project.

### Primary Developer
- Project developed as an educational initiative for web development and database design

### Contact & Support
For questions, suggestions, or bug reports, please reach out through the project's issue tracker or contact the development team.

---

**Last Updated**: 2025-01-15  
**Version**: 1.0.0  
**Status**: Active Development

