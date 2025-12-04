# 📚 Bookstore

A bookstore management system built with Laravel that enables efficient book inventory management and borrowing operations with role-based access control. The application automatically tracks book stock levels when books are issued or returned, ensuring accurate inventory management. Features include advanced filtering capabilities, user authentication and separate interfaces for administrators and members.

## ✨ Features

- Role-based access control (Admin/Member)
- Book inventory management with stock tracking
- Automatic stock updates on issue/return
- Book category management
- Advanced filtering (by category, price range, title search)
- Borrowing system with due date tracking
- Overdue, Low stock warnings
- Admin dashboard with statistics
- Responsive design

## 🛠️ Technologies Used

## Tables

| Technology  | Purpose |
| ------------- |:-------------:|
| Laravel 12      | Backend PHP Framework     |
| MySQL      | Relational Database     |
| Eloquent ORM      | Database interactions     |
| Blade Templates      | View rendering engine     |
| Laravel Routing      | RESTful route management     |
| Laravel Breeze      | Authentication scaffolding     |
| Tailwind CSS      | Frontend styling     |
| Vite      | Asset bundling     |

## 🚀 Getting Started

### Prerequisites

- XAMPP (Apache + MySQL + PHP 8.1+)
- Composer (PHP dependency manager)
- Node.js & npm (for asset compilation)
- Git (optional, for cloning)

### 1. Start XAMPP
```bash
1) Open XAMPP Control Panel
2) Start Apache server
3) Start MySQL server
```
### 2. Clone or Download Project
- Clone
```bash
cd YOUR_PATH\xampp\htdocs
git clone https://github.com/SasinduDananjaya/Laravel-Bookstore-App
cd laravel-bookstore
```

- Download
```bash
Download ZIP from GitHub
Extract to YOUR_PATHxampp\htdocs\laravel-bookstore
```

### 3. Install Dependencies
Open Command Prompt or Git Bash in project directory
```bash
# Navigate to project folder
cd YOUR_PATH\xampp\htdocs\laravel-bookstore

# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 4. Create Database
- Open browser and go to: http://localhost/phpmyadmin
- Click "New" in left sidebar
- Create database:
```bash
Database name: bookstore
Collation: utf8mb4_unicode_ci
Click "Create"
```

### 5. Configure Environment
- Copy .env.example to .env
- Edit .env with your database details:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=YOUR_DB_PORT
DB_DATABASE=YOUR_DB_NAME
DB_USERNAME=YOUR_USERNAME
DB_PASSWORD=YOUR_PASSWORD

SESSION_DRIVER=database

```

### 6. Run Migrations

```bash
php artisan migrate

```

### 7. Seed Database

```bash
php artisan db:seed

```

### 8. Build Frontend Assets

```bash
# For development (with hot reload)
npm run dev

# Or for production (one-time build)
npm run build

```

### 9. Run the Application

```bash
# Run this command in a separate terminal
php artisan serve

```

### 🔑 Login Credentials
- Admin Account
```bash
Email: admin@bookstore.com
Password: password
Access: Full system access
```

- You can create member accounts or use the user credentials in "database/seeders/UserSeeder.php" to log in as a member.
