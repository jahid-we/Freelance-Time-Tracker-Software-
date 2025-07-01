# Freelance Time Tracker App (Laravel + Inertia.js + Vue.js)

A full-featured **freelance time tracking web application** built using **Laravel 12**, **Inertia.js**, and **Vue.js**. It enables freelancers to log working hours, manage clients/projects, generate reports, and receive email notifications.

## 🚀 Features Summary

- **Authentication (session-based)**
- **Client & Project Management**
- **Time Tracking (start, stop, manual)**
- **Reports and PDF Export**
- **Email Notification when logging >8 hours/day**
- **SPA experience using Inertia.js + Vue.js**

---

## 🛠️ Tech Stack

| Layer         | Technology                        |
| ------------- | --------------------------------- |
| Backend       | Laravel 12                        |
| Frontend      | Vue.js + Inertia.js               |
| Auth          | Laravel session (Auth)            |
| ORM           | Laravel Eloquent ORM              |
| Queue         | Laravel Queue (`database` driver) |
| PDF Export    | Laravel DomPDF                    |
| Notifications | Laravel Mail & Notification       |
| UI            | Bootstrap 5                       |

---

## ❗Important Notes

- ✅ Laravel's session-based auth is secure and works well with Inertia-based SPA
- ✅ Routes are defined in `web.php` and use middleware like `auth` and `guest`
- ✅ CSRF tokens are regenerated on login/logout and validated in forms

---
## 🔐 Authentication

This app uses **Laravel session-based authentication** (via `Auth::attempt`) instead of Sanctum or Passport.

### Key Features

- `POST /register` — Register new user
- `POST /login` — Login with session
- `GET /logout` — Logout (destroys session)
- `POST /reset-password-email` — Send password reset link
- `POST /reset-password` — Reset password using token

### Reset Password Flow

- Tokens are stored in `password_reset_tokens`
- Email is sent with a custom notification
- Reset uses a `confirmed` password field
- Once reset, the token is deleted

> ✅ CSRF protection and session regeneration are handled properly for secure login/logout.
> ⏰ Note: If a user logs more than 8 hours in a single day (via start, manual entry, or update), an email notification is automatically queued and sent.


---

## 🧱 Database Structure

### 👤 Users (Freelancers)

- `id` — Primary key  
- `name` — String (required)  
- `email` — String (unique, required)  
- `email_verified_at` — Timestamp (nullable)  
- `password` — String (hashed)  
- `remember_token` — String (used for "remember me" login)  
- `created_at` — Timestamp  
- `updated_at` — Timestamp  

### 👥 Clients

- `id` — Primary key  
- `user_id` — Foreign key referencing `users(id)`, with `ON DELETE CASCADE`  
- `name` — String (required)  
- `email` — String (unique, required)  
- `contact_person` — String (nullable)  
- `created_at` — Timestamp  
- `updated_at` — Timestamp  

### 📁 Projects

- `id` — Primary key  
- `client_id` — Foreign key referencing `clients(id)`, with `ON DELETE CASCADE`  
- `title` — String (required)  
- `description` — Text (nullable)  
- `status` — Enum: `active` (default) or `completed`  
- `deadline` — Date (nullable)  
- `created_at` — Timestamp  
- `updated_at` — Timestamp  

### ⏱️ Time Logs

- `id` — Primary key
- `is_running` — Boolean (default: false), indicates if the timer is currently active
- `user_id` — Foreign key referencing `users(id)`, with `ON DELETE CASCADE`
- `project_id` — Foreign key referencing `projects(id)`, with `ON DELETE CASCADE`
- `start_time` — Timestamp (nullable)
- `end_time` — Timestamp (nullable)
- `description` — Text (nullable)
- `hours` — Decimal(8,2), default `0`
- `tags` — Enum: `billable` or `non-billable` (nullable)
- `created_at` — Timestamp
- `updated_at` — Timestamp

---

## 🛠️ Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/jahid-we/Freelance-Time-Tracker-Api.git
cd Freelance-Time-Tracker-Api


# 2. Install Dependencies
composer install

# 3. Create .env File
cp .env.example .env

# 4. Generate App Key
php artisan key:generate

# 5. Migrate and Seed Database
php artisan migrate --seed

# 6. Start Queue Worker
php artisan queue:work

# 7. Start the Laravel Development Server
composer run dev

```
---

## 🧑‍💻 Developer

**Made by**: Jahid Hasan  
**Stack**: Laravel 12, Inertia, Vue, Bootstrap 5

---

## License

This project is open-sourced under the [MIT license](LICENSE).

### বাংলা লাইসেন্স (Bangla License)

আপনি এই প্রকল্পটি [MIT লাইসেন্সের অধীনে](LICENSE_BN.txt) ওপেন সোর্স হিসেবে ব্যবহার করতে পারবেন।

> © 2025 Jahid Hasan. All rights reserved.

