# ASA Backend

ASA Backend is a Laravel 13 REST API that powers the **AI-powered Educational Assistant** application. It provides authentication, role-based access control, AI chat functionality, knowledge base management, dashboard analytics, and chat session management.

---

## Features

- Secure Authentication using Laravel Sanctum
- Role & Permission Management (Spatie Permission)
- AI Chat Session Management
- AI Response Generation
- Program Knowledge Base
- Dashboard Analytics
- Conversation History
- Follow-up & Resolution Workflow
- RESTful APIs
- Role-based Authorization

---

## Technology Stack

- Laravel 13
- PHP 8.3+
- MySQL
- Laravel Sanctum
- Spatie Laravel Permission
- Laravel AI
- OpenAI / Gemini (Configurable)

---

## Installation

### Clone Repository

```bash
git clone <repository-url>
```

Navigate to the project directory.

```bash
cd asa_backend
```

---

## Install Dependencies

```bash
composer install
```

---

## Environment Configuration

Copy the example environment file.

```bash
cp .env.example .env
```

Generate the application key.

```bash
php artisan key:generate
```

---

## Configure Database

Update the following values in `.env`.

```env
APP_NAME=ASA
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=asa
DB_USERNAME=root
DB_PASSWORD=
```

---

## AI Configuration

Configure your AI provider.

Example using Gemini:

```env
GEMINI_API_KEY=your_gemini_api_key
```

---

## Run Database Migrations

```bash
php artisan migrate
```

---

## Seed Database

```bash
php artisan db:seed
```

Or migrate and seed together.

```bash
php artisan migrate:fresh --seed
```

---

## Serve Application

```bash
php artisan serve
```

Backend API

```
http://localhost:8000
```

---

# Project Structure

```
app
├── Http
│   ├── Controllers
│   ├── Middleware
│
├── Models
│
├── Repositories
│
├── Services
│
├── AI
│
├── Providers
│
database
├── migrations
├── seeders
│
routes
├── api.php
```

---

# Authentication

The application uses **Laravel Sanctum**.

After login, every protected API requires

```
Authorization: Bearer <token>
```

---

# Roles

Two roles are available.

## Admin

- Dashboard
- User Management
- Knowledge Base Management
- Review Conversations
- Resolve Follow-up Chats
- View Analytics

## User / Counselor

- Login
- Create Chat Sessions
- Ask Questions
- View Own Chat History

---

# Main Modules

## Authentication

- Login
- Logout
- Current User

---

## User Management

- Create User
- Update User
- Delete User
- List Users
- Assign Roles
- Activate / Deactivate Users

---

## AI Chat

- Create Chat Session
- Send Message
- Generate AI Response
- Retrieve Chat History
- Resolve Chat
- Delete Chat

---

## Knowledge Base

Stores educational program information.

Examples

- Eligibility
- Fees
- Duration
- Certificates
- Support Process
- Admission Timeline

---

## Dashboard

Provides analytics including

- Total Sessions
- Active Sessions
- Follow-up Sessions
- Resolved Sessions
- Recent Conversations
- Session Trend

---

# AI Integration

The application uses **Laravel AI** for AI-powered responses.

Current implementation supports:

- Google Gemini

The AI assistant answers questions using the seeded Program Knowledge Base.

If a question cannot be answered confidently, the conversation is marked for follow-up.

---

# Seeded Data

The application seeds:

- Roles
- Permissions
- Admin User
- User / Counselor
- Program Knowledge Base

---

# Development Commands

Install dependencies

```bash
composer install
```

Run migrations

```bash
php artisan migrate
```

Run seeders

```bash
php artisan db:seed
```

Fresh migration with seed

```bash
php artisan migrate:fresh --seed
```

Start server

```bash
php artisan serve
```

Clear cache

```bash
php artisan optimize:clear
```

---

## Fake AI Response Configuration

During development, you can configure the application to return fake AI responses instead of calling the actual AI provider.

Add the following to your `.env` file:

```env
FAKE_API_RESPONSE=true
```

### Available Options
`true` : Returns a predefined fake AI response. No API calls are made to the AI provider. Useful for local development and testing. 
`false` : Sends the request to the configured AI provider (OpenAI/Gemini) and returns the actual AI-generated response. 

# Security

- Laravel Sanctum Authentication
- Role-based Access Control
- Permission-based Authorization
- Protected API Routes
- Input Validation
- Eloquent ORM Protection

---

# Future Improvements

- Conversation Summaries
- AI Feedback & Rating
- File Upload Support
- Conversational History

---

# Author

**Sanat Gawade**