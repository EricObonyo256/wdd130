# GreenGrow PHP/MySQL Setup

## Recommended Windows setup: XAMPP

1. Download XAMPP from https://www.apachefriends.org/index.html.
2. Install XAMPP and start the `Apache` and `MySQL` modules from the XAMPP Control Panel.
3. Move this project into XAMPP's web root or point Apache to it:
   - Recommended: copy `c:\green-grow` to `C:\xampp\htdocs\green-grow`
   - Or update Apache `httpd.conf` DocumentRoot to `c:\green-grow` and restart Apache.
4. Open `http://localhost/green-grow/index.php` in your browser.

## Import the database

Use phpMyAdmin or command line:

- phpMyAdmin: open `http://localhost/phpmyadmin`, create a database named `greengrow`, then import `database.sql`.
- Command line (if available):
  ```powershell
  mysql -u root -p < "c:\green-grow\database.sql"
  ```

## Notes for the project

- `connect.php` is configured for:
  - host: `localhost`
  - user: `root`
  - password: `` (blank)
  - database: `greengrow`
- If your MySQL uses a password, update `connect.php` or set environment variables `DB_USER`, `DB_PASS`, `DB_NAME`, `DB_HOST`.
- The site entry points are:
  - `http://localhost/green-grow/index.php`
  - `http://localhost/green-grow/contact.php`
  - `http://localhost/green-grow/admin.php`

## Five Server / Static server note

- Five Server is only for static HTML/CSS/JS.
- To run the PHP site, use XAMPP, WAMP, Laragon, or PHP + MySQL directly.

## Optional: PHP built-in server

If you install PHP separately, you can run:
```powershell
cd c:\green-grow
php -S localhost:8000
```
Then visit `http://localhost:8000/index.php`.
