STUDENT REGISTRATION SYSTEM
Technologies: HTML, PHP, MySQL

PROJECT FILES
- index.html     Student registration form
- submit.php     Receives, validates and stores form data
- db.php         Connects PHP to MySQL using PDO
- database.sql   Creates the database and students table

HOW TO RUN USING XAMPP
1. Install and open XAMPP.
2. Start Apache and MySQL.
3. Copy the student_registration_project folder into:
   C:\xampp\htdocs\
4. Open http://localhost/phpmyadmin in your browser.
5. Select the Import tab, choose database.sql, and click Import/Go.
   Alternatively, open the SQL tab and run its contents.
6. If your MySQL username/password differs from the XAMPP defaults,
   update those values in db.php.
7. Open:
   http://localhost/student_registration_project/
8. Fill in the form and click Register Student.
9. In phpMyAdmin, open student_registration > students > Browse
   to verify that the record was saved.

HOW DATA FLOWS
index.html -> POST request -> submit.php -> db.php -> MySQL database

IMPORTANT
- Use Apache to run PHP. Do not open index.html by double-clicking it.
- Prepared statements help protect database queries from SQL injection.
- Server-side validation checks submitted values before inserting them.
- For a public/production website, add CSRF protection, authentication,
  HTTPS, and stronger duplicate-email/business rules as appropriate.
