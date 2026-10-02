# Document Request and Generation System

A Laravel-based web application for submitting document requests and generating requested documents.

Laboratory 1 — ESTABLISH THE LARAVEL PROJECT AND MAP ITS DEVOPS WORKFLOW  
Laboratory 2 — PLAN AND IMPLEMENT THE REQUEST DATA MODEL

## Screenshots

![Document Request and Generation System](screenshots/system-ui.png)

> Screenshot to be added.

## Student Information

- Samantha Bianca Germina
- Charisse G. Guray
- **Course/Year/Section:** BSIT 4-3

## User Stories (Laboratory 2)

1. **Requester:** As a requester, I want to submit a document request online so that I can formally request items or services without needing to visit the office physically.
2. **Staff Reviewer:** As a staff reviewer, I want to view the list of pending document requests so that I can process, approve, or reject them in a timely manner.
3. **Record Keeper:** As a record keeper, I want all document request records stored with accurate creation and update timestamps so that I can maintain audit trails and historical reports.

## Data Schema (`requests` Table)

| Field Name | Data Type | Constraints | Purpose |
| :--- | :--- | :--- | :--- |
| `id` | Big Integer | Primary Key, Auto-increment | Unique identifier for each request |
| `requester_name` | String (100) | Required (NOT NULL) | Full name of the requester |
| `requester_email` | String (255) | Required (NOT NULL) | Contact email address of the requester |
| `item_name` | String (150) | Required (NOT NULL) | Name of requested document or service |
| `quantity` | Unsigned Int | Required (NOT NULL) | Quantity of items requested (> 0) |
| `purpose` | Text | Required (NOT NULL) | Detailed reason for the request |
| `status` | String (20) | Default: `'pending'` | Current status of the request |
| `created_at` | Timestamp | Nullable / Auto | Record creation timestamp |
| `updated_at` | Timestamp | Nullable / Auto | Record last update timestamp |

## Technologies Used

- Laravel 13.33.0
- PHP 8.3.16
- Composer 2.9.5
- MySQL
- XAMPP
- Git / GitHub

## Software Requirements (Prerequisites)

Before running the project, make sure the following are installed and available on your system:

| Software | Minimum Version | Purpose |
| -------- | --------------- | ------- |
| PHP | 8.3.0 or higher | Laravel runtime |
| Composer | 2.0 or higher | Dependency management |
| MySQL | 5.7 or higher | Database server |
| XAMPP | Latest | Provides Apache + MySQL (phpMyAdmin) |
| Git | Latest | Version control / cloning the repository |
| Web browser | Latest | Accessing the application |

## Installation & Setup

Follow these steps to run the project locally.

### 1. Clone the Repository

```bash
git clone [https://github.com/guraycha03/document-request-system.git](https://github.com/guraycha03/document-request-system.git)
cd document-request-system
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Configure the Environment

Copy `.env.example` to `.env`:

```bash
copy .env.example .env
```

Then generate the application key:

```bash
php artisan key:generate
```

### 4. Configure the Database

1. Start **Apache** and **MySQL** from the XAMPP Control Panel.
2. Open **phpMyAdmin** at `http://localhost/phpmyadmin`.
3. Create a database named:

```
laravel_request_system_db
```

Update the database settings in your `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_request_system_db
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run Migrations & Verification

To create the database tables (including the requests table):

```bash
php artisan migrate
```

Verify that the migrations executed successfully:

```bash
php artisan migrate:status
```

To verify the table structure and data in phpMyAdmin:

1. Navigate to laravel_request_system_db > requests.
2. Execute the SQL query to verify stored records:

```sql
SELECT id, requester_name, item_name, quantity, status FROM requests;
```

### 6. Run the Development Server

```bash
php artisan serve
```

Open your browser and visit:

```
http://127.0.0.1:8000
```

## Project Structure

```
app/Models/          Eloquent models (User, DocumentRequest)
database/migrations/ Database table migrations
routes/web.php       Web route definitions
resources/views/     Blade views/templates
```

## Summary of Commands

| Step | Command |
| ---- | ------- |
| Install dependencies | `composer install` |
| Create `.env` file | `copy .env.example .env` |
| Generate app key | `php artisan key:generate` |
| Create migration file | `php artisan make:migration create_requests_table` |
| Run migrations | `php artisan migrate` |
| Check migration status | `php artisan migrate:status` |
| Start the server | `php artisan serve` |
| Access the app | `http://127.0.0.1:8000` |

## License

This project is for academic purposes (Laboratory 1 & Laboratory 2, BSIT 4-3).
