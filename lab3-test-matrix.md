# Laboratory 3 — Access and Input Test Matrix

Project: Document Request and Generation System
Database: `laravel_request_system_db`
Driver: Charisse G. Guray · Reviewer: Samantha Bianca Germina
Denial response chosen: **403 Forbidden**

Fill the **Actual result**, **Pass/Fail**, and **Evidence** columns while testing in the browser.
Log out (or use a separate browser session) between accounts. Take one screenshot per test and
number the files `T01`, `T02`, ... so they match the Evidence column.

| ID | Test | Expected result | Actual result | Pass/Fail | Evidence |
| :-- | :--- | :--- | :--- | :--- | :--- |
| T01 | Guest opens `/` and `/document-requests/1` | Redirect to the login page; no request data disclosed | | | |
| T02 | Jane Lim (Student A) and Alon Cruz (Student B) open the list and their own detail pages | Each sees only their own records and can open their own details | | | |
| T03 | Jane Lim opens Alon's record ID directly, then Alon opens Jane's | **403 Forbidden**; no other-student details disclosed | | | |
| T04 | Jane Lim sends `PATCH /document-requests/{Alon's ID}` with `status=approved`, valid session and CSRF token | Denied (403); database status still `pending` (check phpMyAdmin before/after) | | | |
| T05 | Mike Santos (administrator) lists, views, and updates a request | All records visible; status change saved (`pending` → `approved`) | | | |
| T06 | Create with quantity `0`, `-1`, `abc`, and with a blank item name | Server rejects each; validation errors shown; no invalid row saved | | | |
| T07 | Create while also submitting `user_id`, `status`, `is_admin`, `role` | Request saved for the signed-in student with `status = pending`; ownership, role, and status not spoofed | | | |
| T08 | Purpose contains `<b>LAB3</b>` and an apostrophe (`O'Brien`) | Markup and apostrophe shown literally in the detail page; row stored safely | | | |
| T09 | POST or PATCH with a missing/invalid CSRF token (live browser) | HTTP **419**; database unchanged | | | |
| T10 | Administrator sends `status=banana` | Validation rejects; existing status unchanged | | | |

## Database verification

For T04, T06, T07, and T10, capture the `requests` row in phpMyAdmin **before** and **after**:

```sql
SELECT id, user_id, requester_name, requester_email, item_name, quantity, status, updated_at
FROM requests ORDER BY id;
```

## Automated suite (supporting evidence)

```bash
php artisan test --filter=DocumentRequestAccessTest
```

Covers T01–T08 and T10 with 9 tests. T09 is live-only because Laravel disables CSRF
middleware inside feature tests.
