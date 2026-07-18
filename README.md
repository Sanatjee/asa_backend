# Program Operations Dashboard - Backend

## Overview

The Program Operations Dashboard backend is built using **Laravel 13** and provides REST APIs for managing programs, learners, registrations, payments, users, roles, and permissions.

---

## Tech Stack

- Laravel 13
- PHP 8.4
- MySQL
- Laravel Sanctum
- Spatie Laravel Permission
- Repository Pattern
- Service Layer Architecture

---

## Features

- Authentication
- Role Based Access Control (RBAC)
- Program Management
- User Management
- Learner Registration
- Payment Management
- Dashboard Statistics
- Validation
- API Responses
- Pagination
- Search & Filters

---

## Roles

- Admin
- Program Manager
- Operations User
- Learner

---

## Installation

Clone the repository

```bash
git clone <repository-url>
```

Move inside project

```bash
cd program_operations_dashboard
```

Install dependencies

```bash
composer install
```

Copy environment file

```bash
cp .env.example .env
```

Generate application key

```bash
php artisan key:generate
```

Configure your database inside `.env`

```env
DB_DATABASE=program_operations
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations and seeders

```bash
php artisan migrate:fresh --seed
```

Start the application

```bash
php artisan serve
```


## Default Admin

Email : senthil@iitbeo.com
Password : password


## API Modules

### Authentication

- Login
- Logout

### Dashboard

- Statistics

### Programs

- Create Program
- Update Program
- Delete Program
- List Programs

### Users

- Create User
- Update User
- Delete User
- List Users

### Registrations

- Register Learner
- Update Registration
- Delete Registration
- Search Registration

### Payments

- Make Payment
- Payment History

---

## Permissions

Examples

```
dashboard.view

program.view
program.create
program.edit
program.delete

registration.view
registration.create
registration.edit
registration.delete

payment.view
payment.create

user.view
user.create
user.edit
user.delete
```

---

## Commands

Reset database

```bash
php artisan migrate:fresh --seed
```

Clear cache

```bash
php artisan optimize:clear
```

Reset permission cache

```bash
php artisan permission:cache-reset
```