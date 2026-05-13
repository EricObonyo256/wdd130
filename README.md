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

# wdd130
https://ericobonyo256.github.io/wdd130
