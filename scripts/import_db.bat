@echo off
REM Import the database (Windows). Set DB credentials via environment variables or edit the file.
REM Usage: set DB_USER=root && set DB_PASS= && set DB_NAME=greengrow && import_db.bat
set DB_USER=%DB_USER%
set DB_PASS=%DB_PASS%
set DB_NAME=%DB_NAME%
if "%DB_USER%"=="" set DB_USER=root
if "%DB_PASS%"=="" set DB_PASS=
if "%DB_NAME%"=="" set DB_NAME=greengrow

mysql -u %DB_USER% -p%DB_PASS% %DB_NAME% < ..\database.sql
echo Imported database.sql into %DB_NAME%
pause
