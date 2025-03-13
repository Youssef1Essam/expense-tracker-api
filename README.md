# Expense Tracker API

A RESTful API for managing expenses, categories, and budgets, built with Laravel 11.

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

## 🚀 Features
- User authentication using JWT.
- CRUD operations for expenses, categories, and budgets.
- Performance optimization with Redis Caching.
- API security with Rate Limiting.
- API documentation using Swagger/OpenAPI.

## 🛠️ Technologies Used
- Laravel 11
- MySQL
- Redis
- JWT Authentication
- Swagger/OpenAPI

## 📌 Installation & Setup
Follow these steps to set up the project on your local machine:

### 1️⃣ Clone the Repository
```bash
git clone https://github.com/Youssef1Essam/expense-tracker-api.git
cd expense-tracker-api
```

### 2️⃣ Install Dependencies
```bash
composer install
```

### 3️⃣ Set Up the Environment
```bash
cp .env.example .env
php artisan key:generate
```
Configure your **`.env`** file with your database and Redis settings.

### 4️⃣ Run Migrations & Seed Database
```bash
php artisan migrate --seed
```

### 5️⃣ Start the Server
```bash
php artisan serve
```

## 📚 API Documentation
The API is documented using Swagger.  
You can access it via:  
```
http://127.0.0.1:8000/api/documentation
```

## 🔐 Authentication
Use JWT for authentication.  
After login, include the token in your requests like this:
```bash
Authorization: Bearer YOUR_TOKEN_HERE
```
