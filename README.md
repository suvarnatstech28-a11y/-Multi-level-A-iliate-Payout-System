Project Overview
A Laravel-based PHP application that implements a 5-level affiliate payout system. When a sale is made by a user at the 6th level or below, the system distributes commission payouts up to 5 ancestor levels.

Commission Structure
Level 1 (Direct parent): 10%
Level 2: 5%
Level 3: 3%
Level 4: 2%
Level 5: 1%

Features
Manage users and their affiliate hierarchy (up to any depth; payouts limited to 5 levels).
Record sales and automatically calculate/distribute affiliate payouts.
MySQL database schema optimized for efficient ancestor queries.
Basic input validation and security best practices.

Repository
https://github.com/suvarnatstech28-a11y/-Multi-level-A-iliate-Payout-System.git

Requirements
PHP 8.1+ (or compatible with your Laravel version)
Composer
Node.js + npm (for frontend assets)
MySQL
Laravel 9+ (adjust for your app's Laravel version)
Database Schema (summary)
users — stores users and their id, name, email, parent_id (nullable), other fields.
sales — stores individual sales: id, user_id, amount, created_at, etc.
affiliate_payouts — (optional) stores computed payouts per sale: id, sale_id, ancestor_user_id, level, percentage, amount.
See the database/migrations/ folder for full migration files included in the project.

1.Clone the repo:
git clone https://github.com/suvarnatstech28-a11y/-Multi-level-A-iliate-Payout-System.git
cd -Multi-level-A-iliate-Payout-System

2.Install PHP dependencies:
composer install

3.Install Node dependencies & build assets:
npm install
npm run dev

4.Copy .env and set database credentials:
cp .env.example .env
php artisan key:generate
# edit .env: DB_DATABASE, DB_USERNAME, DB_PASSWORD
DB_DATABASE - payout_db

5.Run migrations and seeders (if provided):
php artisan migrate --seed
seeder added for products.

6.Serve the app locally:
php artisan serve
# visit http://127.0.0.1:8000

How the Affiliate Payout Works (high level)

When a sale is recorded (sales table), the system finds up to 5 ancestor users by following parent_id links.
For each ancestor (up to 5), the system applies the configured percentage for that level and records the payout (or directly credits the user's balance).
Optionally, a record in affiliate_payouts is created for auditing.

Security & Validation

Validate inputs on controllers and form requests.
Use parameterized queries / Eloquent to prevent SQL injection.
Sanitize and escape any user-provided HTML (Blade {{ }} is escaped by default).
Apply authentication and authorization (Laravel Auth + middleware) for admin endpoints.
Testing the Payout Logic (quick manual steps)
Create a chain of users (A → B → C → D → E → F). Each user should have parent_id pointing to their sponsor.
Create a sale for user F with an amount (e.g. 1000).
Run the payout calculation (either by creating the sale via UI or running the artisan command / job).
Confirm payouts credited/recorded for A (level5) → E (level1) according to percentages.
Useful Artisan Commands (example)
php artisan tinker — quick manual testing
php artisan migrate:fresh --seed — reset DB and run seeders (use carefully)

