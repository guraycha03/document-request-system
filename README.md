# Document Request and Generation System

A Laravel-based web application for submitting document requests and generating requested documents.

Laboratory 1 — ESTABLISH THE LARAVEL PROJECT AND MAP ITS DEVOPS WORKFLOW  
Laboratory 2 — PLAN AND IMPLEMENT THE REQUEST DATA MODEL  
Laboratory 3 — IMPLEMENT ROLE-BASED ACCESS AND USER ID OWNERSHIP

---

## Laboratory 3 Documentation

**Download (works for large files):**
**[Germina_Samantha_Bianca_Guray_Charisse_Lab3.docx — Download](https://github.com/guraycha03/document-request-system/raw/main/Germina_Samantha_Bianca_Guray_Charisse_Lab3.docx)**

**Copy stored in this repository:**
[Germina_Samantha_Bianca_Guray_Charisse_Lab3.docx](./Germina_Samantha_Bianca_Guray_Charisse_Lab3.docx)
— on the file page, click **Download raw file**

**External copy:** `[ PASTE YOUR LINK HERE ]`

The completed Laboratory 3 Word document submitted for this pair.

Direct file link:
`https://github.com/guraycha03/document-request-system/blob/main/Germina_Samantha_Bianca_Guray_Charisse_Lab3.docx`

---

## Screenshots

![Document Request and Generation System](screenshots/system-ui.png)


## Student Information

- Samantha Bianca Germina
- Charisse G. Guray
- **Course/Year/Section:** BSIT 4-3

## Driver and Reviewer Responsibilities (Laboratory 3)

| Role | Assigned to | Responsibilities |
| :--- | :--- | :--- |
| **Driver** | Charisse G. Guray (`guraycha03`) | Implements the change: policies, controllers, routes, Blade views, migrations, seeders, and tests. |
| **Reviewer** | Samantha Bianca Germina | Inspects and tests the change from her own GitHub account: authentication, policy enforcement, list scoping, trusted field assignment, validation, escaping, CSRF, secret exclusion, and test evidence. Adds review comments and gives the final approval. The author never approves their own change. |

### Who maintains what

| Area | File(s) | Maintained by |
| :--- | :--- | :--- |
| Authorization policy | `app/Policies/DocumentRequestPolicy.php` | Driver |
| Controller (list, view, create, update status) | `app/Http/Controllers/DocumentRequestController.php` | Driver |
| Routes | `routes/web.php` | Driver |
| Views (dashboard, detail, forms) | `resources/views/**` | Driver |
| Tests | `tests/Feature/DocumentRequestAccessTest.php` | Driver |
| Access policy (rules and acceptance checks) | GitHub Issue #1, this README | Reviewer verifies, driver records |

`.github/CODEOWNERS` marks the driver as the default code owner so every pull request routes to a reviewer.

## User Roles (Laboratory 3)

Laboratory 3 replaces the Laboratory 2 roles (requester, staff reviewer, record keeper) with two roles and three fictional accounts. Every request row now stores the `user_id` of its owner, so a user only reaches the records allowed by their role.

| Role | Value in `users.role` | Accounts | Access |
| :--- | :--- | :--- | :--- |
| Student | `student` | `maria.santos@school.edu` / `student123`<br>`juan.cruz@school.edu` / `student123` | Submits document requests and views **only their own** records (`requests.user_id = users.id`) |
| Administrator | `administrator` | `admin.reyes@school.edu` / `admin123` | Views **all** records, approves or rejects pending requests, and audits `created_at` / `updated_at` |

**User stories (Laboratory 3)**

1. **Student:** As a student, I want to submit a document request under my own user account so that only my requests are attached to my user id.
   - **AC1:** A logged-in student's request is saved with `user_id = auth()->id()` and `status = 'pending'`.
   - **AC2:** The student dashboard lists only the records whose `user_id` matches the logged-in student.

2. **Administrator:** As an administrator, I want to access every document request record based on my role so that I can review and audit the whole system.
   - **AC1:** The administrator dashboard shows all records, including other users' requests.
   - **AC2:** Only an administrator can change a request status to `approved` or `rejected`; students receive a 403 error.

## Secure Access Control (Laboratory 3)

### Ownership rules

1. A student lists **only** their own records, scoped in SQL with `where('user_id', $user->id)`.
2. The **owner or an administrator** may view a single record. Ownership is always taken from `requests.user_id`, never from `requester_name` or `requester_email`.
3. Any authenticated student may create a request. `user_id`, `requester_name`, `requester_email`, and the initial `status = 'pending'` are assigned **on the server** from the signed-in account.
4. **Only an administrator** may change a status. Students are denied even when they send a direct `PATCH` with a valid session and CSRF token.

### Denial response: 403 Forbidden

Another student's record returns **403 Forbidden** rather than 404. The record exists, so hiding its existence adds little protection inside an authenticated campus system, while 403 makes the ownership rule obvious and easy to evidence during testing. The choice is applied consistently in `DocumentRequestPolicy::view()` and `DocumentRequestPolicy::updateStatus()`.

### Route summary

| Method | URI | Purpose | Authorization |
| :--- | :--- | :--- | :--- |
| GET | `/login` | Login form | Guests only (`guest` middleware) |
| POST | `/login` | Submit credentials | Guests only |
| POST | `/logout` | Sign out | `auth` middleware |
| GET | `/` | List requests | `auth` + `viewAny`; content scoped by role |
| GET | `/document-requests/{id}` | View one request | `auth` + `view` (owner or administrator) |
| POST | `/document-requests` | Create a request | `auth` + `create` (students only) |
| PATCH | `/document-requests/{id}` | Change status | `auth` + `updateStatus` (administrator only) |

All request routes sit inside the `auth` middleware group in `routes/web.php`, so a guest is redirected to login and no request data is disclosed. GET is used for reads, POST for creation, and PATCH for status updates.

### Policy enforcement (server side)

> **Naming note:** the Laboratory 3 instruction sheet uses the generic name `ServiceRequestPolicy` / `ServiceRequest`. This project kept the Laboratory 2 model name `DocumentRequest` (mapped to the `requests` table), so the policy is `App\Policies\DocumentRequestPolicy`. It defines exactly the four abilities the instruction asks for.

`app/Policies/DocumentRequestPolicy.php` is auto-discovered for the `DocumentRequest` model (Laravel matches `App\Models\DocumentRequest` to `App\Policies\DocumentRequestPolicy` by convention, so no manual registration is needed). Every protected action calls `Gate::authorize()` before any data is returned or written:

```php
Gate::authorize('viewAny', DocumentRequest::class);   // list
Gate::authorize('view', $documentRequest);            // detail
Gate::authorize('create', DocumentRequest::class);    // submit form
Gate::authorize('updateStatus', $documentRequest);    // approve / reject
```

A Blade `@can('updateStatus', $documentRequest)` directive only hides the status form from non-administrators; the server-side check is what actually blocks the write.

### Validation and trusted field assignment

Student input is validated on the server against the Laboratory 2 field types:

| Field | Rules |
| :--- | :--- |
| `item_name` | `required`, `string`, `max:150` |
| `quantity` | `required`, `integer`, `min:1` |
| `purpose` | `required`, `string`, `max:2000` |

`user_id`, `requester_name`, `requester_email`, `status`, `is_admin`, and `role` are **prohibited** in student creation input. Only the three validated fields are read from the request, and the rest are written from the signed-in account:

```php
$documentRequest->user_id = $request->user()->id;
$documentRequest->requester_name = $request->user()->name;
$documentRequest->requester_email = $request->user()->email;
$documentRequest->status = 'pending';
```

`$request->all()` is never used for insertion or updating, no submitted value is concatenated into SQL, and `$fillable` on `DocumentRequest` only lists `item_name`, `quantity`, and `purpose` so the trusted columns cannot be mass-assigned.

### Escaping, CSRF, and safe errors

- User-provided text is printed with escaped Blade output (`{{ $documentRequest->purpose }}`), so `<b>LAB3</b>` and apostrophes render literally.
- Every POST and PATCH form carries `@csrf` and `@method('PATCH')`; web CSRF protection stays enabled. A missing or invalid token returns HTTP **419** and nothing is written.
- Account passwords use Laravel's `hashed` cast and `Hash::make()`.
- `.env` is listed in `.gitignore` and is never committed; `.env.example` contains no real credentials or application key.
- Debug output (`APP_DEBUG`) is left on only for the local lab machine. For any deployed or shared environment it must be set to `false` so visitors see a safe error page with no SQL details or secrets.

## Data Schema (`requests` Table)

| Field Name | Data Type | Constraints | Purpose |
| :--- | :--- | :--- | :--- |
| `id` | Big Integer | Primary Key, Auto-increment | Unique identifier for each request |
| `user_id` | Big Integer | Foreign Key → `users.id`, Nullable, `ON DELETE SET NULL` | Owner of the request (user id ownership); set on submission, used for role-based access |
| `requester_name` | String (100) | Required (NOT NULL) | Full name of the student submitting the request |
| `requester_email` | String (255) | Required (NOT NULL) | Contact email address of the student |
| `item_name` | String (150) | Required (NOT NULL) | Name of requested document or service |
| `quantity` | Unsigned Int | Required (NOT NULL), > 0 | Quantity of items requested (must be positive) |
| `purpose` | Text | Required (NOT NULL) | Detailed reason for the request |
| `status` | String (20) | Default: `'pending'` | Current status of the request |
| `created_at` | Timestamp | Nullable / Auto | Record creation timestamp |
| `updated_at` | Timestamp | Nullable / Auto | Record last update timestamp |

### Design Notes

- **Quantity > 0**: An `unsignedInteger` permits zero, but a request for zero items is meaningless. The application enforces `quantity >= 1` via validation (see `DocumentRequestController::store()`). Sample entries use positive quantities.
- **Default status = 'pending'**: New requests begin as `pending` so the administrator can triage them. The migration sets `DEFAULT 'pending'`; omitting `status` on insert relies on this default (verified by sample row 1).
- **User id ownership**: `DocumentRequestController::store()` writes `user_id = auth()->id()` on every submission. The student dashboard filters with `where('user_id', Auth::id())`, while the administrator dashboard loads all rows, so each role only reaches the records it is allowed to see.

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

### 3. Install JavaScript Dependencies and Build Assets

The Blade layout loads the compiled stylesheet with Vite, so the CSS must be built once:

```bash
npm install
npm run build
```

### 4. Configure the Environment

Copy `.env.example` to `.env`:

```bash
copy .env.example .env
```

Then generate the application key:

```bash
php artisan key:generate
```

### 5. Configure the Database

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

### 6. Run Migrations & Verification

To create the database tables (including the requests table):

```bash
php artisan migrate
```

Verify that the migrations executed successfully:

```bash
php artisan migrate:status
```

Laboratory 3 adds two **reversible** migrations on top of the Laboratory 2 tables. They never delete Laboratory 2 request records:

| Migration | What it does | How to reverse |
| :--- | :--- | :--- |
| `2026_10_08_050945_update_user_roles_for_lab3` | Changes `users.role` default to `student` and remaps the Laboratory 2 roles (`requester` → `student`, `staff_reviewer` / `record_keeper` → `administrator`) | `php artisan migrate:rollback` |
| `2026_10_08_050946_add_user_id_to_requests_table` | Adds the nullable `requests.user_id` foreign key (`ON DELETE SET NULL`) and links every existing row to its owner by matching `requester_email` | `php artisan migrate:rollback` |

Seed the two student accounts and one administrator account (trusted setup):

```bash
php artisan db:seed --class=RoleUserSeeder
```

| Account label | Role | Owns request IDs |
| :--- | :--- | :--- |
| Jane Lim — `jane.lim@school.edu` | student | 1, 2, 3 |
| Alon Cruz — `alon.cruz@school.edu` | student | 4, 5 |
| Mike Santos — `mike.s@gmail.com` | administrator | — (reviews all) |

To verify the table structure and data in phpMyAdmin:

1. Navigate to laravel_request_system_db > requests.
2. Execute the SQL query to verify stored records and their owners:

```sql
SELECT id, user_id, requester_name, item_name, quantity, status FROM requests;
```

### 7. Run the Development Server

```bash
php artisan serve
```

Open your browser and visit:

```
http://127.0.0.1:8000
```

## Project Structure

```
app/Http/Controllers/   DocumentRequestController (list, view, create, update status)
app/Models/             Eloquent models (User, DocumentRequest)
app/Policies/           DocumentRequestPolicy (viewAny, view, create, updateStatus)
database/migrations/    Database table migrations (including the two reversible Lab 3 migrations)
database/seeders/       RoleUserSeeder (two students and one administrator)
resources/views/        Blade views (dashboard, request detail, login)
tests/Feature/          DocumentRequestAccessTest (T01-T08 and T10 checks)
routes/web.php          Web route definitions
```

## Testing

### Automated tests

```bash
php artisan test --filter=DocumentRequestAccessTest
```

The suite uses an in-memory SQLite database and covers the access and input rules: guest redirect, student list scoping, 403 on another student's record, denied student status updates, administrator access, rejected invalid quantities and blank item names, ignored spoofed trusted fields, escaped markup, and rejected invalid statuses. CSRF (T09) is deliberately **not** covered by the automated suite because Laravel disables the CSRF middleware in feature tests; T09 is verified with a live browser request that returns HTTP 419.

### Manual access and input matrix

Each test is recorded with expected result, actual result, pass or fail, and an evidence reference in `lab3-test-matrix.md` and in the submitted Laboratory 3 document. Tests run on the local project with separate browser sessions (or a logout) between accounts:

| ID | Check |
| :--- | :--- |
| T01 | Guest opens the request list and a detail page |
| T02 | Student A and Student B each see only their own records |
| T03 | Each student opens the other student's record ID directly |
| T04 | Each student sends a status PATCH with a valid session and token |
| T05 | Administrator lists, views, and updates a request |
| T06 | Quantity 0, -1, non-integer, and blank item name |
| T07 | Student submits `user_id`, `status`, `is_admin`, or `role` |
| T08 | Text contains `<b>LAB3</b>` or an apostrophe |
| T09 | Missing or invalid CSRF token (live request, expect 419) |
| T10 | Administrator submits an invalid status |

Denied writes are confirmed by comparing the `requests` row in phpMyAdmin **before and after** each attempt.

## Dependency Audit and Secret Handling

Run the audits and record the actual output:

```bash
composer audit
npm audit
```

**Result recorded for Laboratory 3:**

- `composer audit` — *No security vulnerability advisories found.*
- `npm audit` — 2 critical advisories in `shell-quote` (pulled in by `concurrently`). Both are **development-only** tooling dependencies: `concurrently` is not referenced by any npm script and is never executed by the Laravel application or its visitors. The proposed follow-up is to review and upgrade `concurrently` to a release that depends on a patched `shell-quote`, then commit the updated `package-lock.json`. No unreviewed upgrade was applied during the lab.

**Secrets and safe errors**

- Passwords are stored only as Laravel hashes (`'password' => 'hashed'` cast plus `Hash::make()`); plaintext passwords never reach the database.
- `.env` is excluded by `.gitignore`, and `.env.example` holds no application key, database password, or token.
- If a secret is ever committed, deleting the file is **not** enough. The credential must be **revoked or rotated first**, then removed from the working tree, and the repository history cleaned (for example with `git filter-repo`) or the repository recreated, because old commits and forks still expose it.
- With `APP_DEBUG=false`, Laravel returns a generic error page without SQL, credentials, or stack traces.

## Summary of Commands

| Step | Command |
| ---- | ------- |
| Install PHP dependencies | `composer install` |
| Install JS dependencies and build assets | `npm install` && `npm run build` |
| Create `.env` file | `copy .env.example .env` |
| Generate app key | `php artisan key:generate` |
| Create migration file | `php artisan make:migration create_requests_table` |
| Run migrations | `php artisan migrate` |
| Check migration status | `php artisan migrate:status` |
| Seed Lab 3 accounts | `php artisan db:seed --class=RoleUserSeeder` |
| Run the automated access tests | `php artisan test --filter=DocumentRequestAccessTest` |
| Dependency audit | `composer audit` |
| Start the server | `php artisan serve` |
| Access the app | `http://127.0.0.1:8000` |

## License

This project is for academic purposes (Laboratory 1, Laboratory 2 & Laboratory 3, BSIT 4-3).


## Laboratory 3 Verification

Verification instruction: Test student ownership and deny access to another student's request.

Verification instruction: Test administrator access and administrator-only status updates.

