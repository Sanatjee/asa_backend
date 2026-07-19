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

## AI Prompt Design

The AI-powered Educational Assistant uses a carefully designed prompt to ensure responses are accurate, consistent, and strictly based on the Program Knowledge Base (KB).

### Prompt Objective

The prompt instructs the AI model to:

- Answer questions **only** using the information available in the Program Knowledge Base.
- Never fabricate or infer information that is not present in the KB.
- Return responses in a fixed JSON structure for easy backend processing.
- Identify queries that require human intervention by marking them as follow-up.

### Prompt Structure

The AI is instructed to return the following JSON format:

```json
{
    "answer": "string",
    "needs_followup": true | false
}
```

### Response Rules

#### Case 1: Information Found

If the requested information exists in the Knowledge Base:

- `answer` contains a concise response.
- `needs_followup` is set to `false`.

Example:

```json
{
    "answer": "The program fee is ₹25,000.",
    "needs_followup": false
}
```

---

#### Case 2: Information Not Found

If the answer is unavailable or the AI is uncertain:

- The AI returns a predefined response.
- `needs_followup` is set to `true`.

Example:

```json
{
    "answer": "I don't have enough information to answer this question.",
    "needs_followup": true
}
```

The backend detects this flag and automatically marks the chat session as **Follow-up**, allowing an administrator to review and respond later.

### Why JSON Output?

Returning structured JSON instead of plain text provides several advantages:

- Easy parsing by the Laravel backend.
- Eliminates ambiguity in AI responses.
- Prevents unnecessary string matching.
- Enables reliable automation of follow-up workflows.
- Keeps the frontend independent of AI response formatting.

### Hallucination Prevention

To minimize AI hallucinations, the prompt explicitly instructs the model to:

- Use **only** the supplied Knowledge Base.
- Never use external knowledge.
- Never guess missing information.
- Return a follow-up response whenever sufficient information is unavailable.

This ensures the assistant behaves as a **retrieval-based educational assistant** rather than a general-purpose chatbot.

### Overall Flow

```
User Question
      │
      ▼
Program Knowledge Base
      │
      ▼
Construct Prompt
      │
      ▼
AI Model
      │
      ▼
JSON Response
      │
      ├── needs_followup = false
      │        │
      │        ▼
      │   Display Answer
      │
      └── needs_followup = true
               │
               ▼
      Mark Chat Session as Follow-up
               │
               ▼
      Administrator Reviews Query
```

This prompt design ensures the Educational Assistant provides reliable, deterministic, and production-ready responses while enabling seamless escalation of unanswered queries to administrators.

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