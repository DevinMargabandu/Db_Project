# DB Project Phase 3 / Phase 4 Setup

This project is a PHP + MySQL web app for the university database system.

## Project Layout

- `TaskB/`: web app files
- `TaskB/index.php`: local app entry point
- `TaskB/config/db_connect.php`: database connection settings
- `TaskC/create.sql`: table creation script
- `TaskC/load.sql`: data load script
- `TaskC/*.csv`: seed data files

## What Each Teammate Needs

- PHP for Windows
- MySQL Community Server
- PowerShell

`MySQL Workbench` is optional. The project can be set up from the MySQL command line.

## 1. Install PHP

Download the PHP zip for Windows, extract it, and use `php.exe` from that folder.

Verify PHP works:

```powershell
.\php.exe -v
```

If `mysqli` is missing, create or edit `php.ini` in the PHP folder and make sure these lines are enabled:

```ini
extension_dir = "ext"
extension=mysqli
extension=pdo_mysql
```

Check loaded PHP modules:

```powershell
.\php.exe -m
```

You should see `mysqli`.

## 2. Install MySQL Server

Install `MySQL Community Server` and make sure the MySQL service is running.

Check from PowerShell:

```powershell
Get-Service *mysql*
```

If needed, start it:

```powershell
Start-Service MySQL80
```

The exact service name may vary.

## 3. Create the Database

Open PowerShell and launch MySQL:

```powershell
mysql -u root -p
```

If `mysql` is not on your `Path`, run it with the full install path instead:

```powershell
& "C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe" -u root -p
```

Then run:

```sql
CREATE DATABASE university_db;
USE university_db;
SOURCE C:/Users/alarc/OneDrive/Documents/Academic/Spring_2026/Database_Systems/DB_Project_phase3/TaskC/create.sql;
SHOW TABLES;
```

Expected tables:

- `student`
- `club`
- `event`
- `registration`

## 4. Load the Seed Data

Try the provided load script first:

```sql
USE university_db;
SOURCE C:/Users/alarc/OneDrive/Documents/Academic/Spring_2026/Database_Systems/DB_Project_phase3/TaskC/load.sql;
```

On some MySQL installs this may fail with `secure-file-priv` because `load.sql` uses `LOAD DATA INFILE`.

After running it, verify whether rows were loaded:

```sql
SELECT COUNT(*) FROM Student;
SELECT COUNT(*) FROM Club;
SELECT COUNT(*) FROM Event;
SELECT COUNT(*) FROM Registration;
```

If the counts are `0`, the schema was created but the CSV files were not imported.

## 5. Configure PHP Database Credentials

Open `TaskB/config/db_connect.php` and make sure the credentials match your MySQL setup.

Current expected values:

```php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "university_db";
```

If your MySQL `root` account has a password, update `$password`.

## 6. Run the App Locally

From the PHP folder, start the built-in PHP server and point it at `TaskB`:

```powershell
.\php.exe -S localhost:8000 -t "C:\Users\alarc\OneDrive\Documents\Academic\Spring_2026\Database_Systems\DB_Project_phase3\TaskB"
```

Then open:

```text
http://localhost:8000
```

## 7. Common Errors

`Class "mysqli" not found`

- PHP is installed, but the `mysqli` extension is not enabled in `php.ini`.

`No connection could be made because the target machine actively refused it`

- MySQL server is not running, or PHP is trying to connect to the wrong host/port.

`Access denied for user`

- The username or password in `TaskB/config/db_connect.php` does not match your local MySQL account.

`Unknown database 'university_db'`

- The database has not been created yet.

The page loads but tables are empty

- The schema exists, but the CSV seed data was not imported successfully.

## 8. Notes for Phase 4

Per the assignment notes, Phase 4 requires:

- a working website
- database connectivity
- CRUD behavior
- query result pages
- input validation where needed

The SQL injection assignment should be handled as a controlled demo:

- one intentionally vulnerable `SELECT` form
- one fixed version using prepared statements

Do not make the whole site intentionally insecure just to demonstrate the injection requirement.
