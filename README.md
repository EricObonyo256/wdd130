# Development & deployment

Steps to prepare and test locally:

- Import the database (Windows):

```bat
set DB_USER=root
set DB_PASS=
set DB_NAME=greengrow
scripts\import_db.bat
```

- Start a local PHP server from project root for quick testing:

```powershell
php -S localhost:8000
```

- Submit a test contact message (run after starting server):

```bash
php tests/send_contact_test.php http://localhost:8000/contact_process.php
```

- Default admin credentials (for local/dev): username `admin`, password `changeme`.
	Set `SITE_ADMIN_USER` and `SITE_ADMIN_PASS` environment variables on production systems.

Security note: The simple admin auth uses environment variables; do not use default credentials in production. Consider integrating a proper user system for multi-admin support.

Additional setup and CI

- To use SMTP email notifications, install dependencies and set SMTP env vars:

```powershell
composer install
set SMTP_HOST=smtp.example.com
set SMTP_PORT=587
set SMTP_USER=your-smtp-user
set SMTP_PASS=your-smtp-pass
set SITE_EMAIL=info@yourdomain.com
```

- To create a hashed admin user in the database:

```powershell
php admin_setup.php admin StrongPasswordHere
```

- A GitHub Actions workflow (`.github/workflows/ci.yml`) is included to run a simple contact POST test on pushes to `ggr` and PRs targeting `main`.

# wdd130
https://ericobonyo256.github.io/wdd130
