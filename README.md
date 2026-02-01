# Laravel 12 Multi-Tenant SaaS Application

A production-ready Laravel 12 SaaS application demonstrating clean architecture, single-database multi-tenancy, role-based access control (RBAC), subscription management, and secure REST APIs.

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Architecture](#architecture)
- [Technology Stack](#technology-stack)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [API Documentation](#api-documentation)
- [Subscription Plans](#subscription-plans)
- [Project Structure](#project-structure)
- [Security Considerations](#security-considerations)
- [Deployment](#deployment)
- [Contributing](#contributing)
- [License](#license)
- [Acknowledgments](#acknowledgments)

---

## 🎯 Overview

This application is a multi-tenant task management system where multiple companies (tenants) share a single database while maintaining complete data isolation. Each company can have multiple users with different roles, and companies are restricted by subscription plans that limit feature usage.

### Key Highlights

- **Single Database Multi-Tenancy**: All tenants share one database with strict data isolation
- **Clean Architecture**: Service layer, Repository pattern, and thin controllers
- **RBAC**: Policy-based authorization (no role checks in controllers)
- **Subscription Management**: Plan-based feature restrictions (Free/Pro)
- **Event-Driven**: Asynchronous notifications using Laravel Queue
- **RESTful API**: Token-based authentication with Laravel Sanctum

---

## ✨ Features

### Authentication & Authorization
- User registration and login
- Token-based authentication using Laravel Sanctum
- Policy-based authorization (Gates and Policies)
- Three-tier role system (Admin, Company Owner, Company Member)

### Multi-Tenancy
- Single database with tenant isolation
- Middleware-enforced tenant scoping
- Each user belongs to exactly one company
- Automatic tenant context resolution

### Task Management
- Full CRUD operations for tasks
- Task filtering by status and priority
- Search by title
- Soft deletes
- Due date tracking
- Tenant-scoped access

### Subscription System
- **Free Plan**: Maximum 5 tasks per company
- **Pro Plan**: Unlimited tasks
- Service-layer enforcement of plan limits
- Graceful error handling for limit violations

### Advanced Features
- Event-driven task creation notifications
- Queue-based email notifications
- API rate limiting (60 requests/minute)
- N+1 query prevention with eager loading
- Database indexing for performance

---

## 🏗️ Architecture

This application follows **Clean Architecture** principles with clear separation of concerns:

```
┌─────────────────────────────────────────────────────┐
│                   Controllers                        │
│            (Thin - Only HTTP concerns)              │
└─────────────────────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────┐
│                 Form Requests                        │
│              (Input Validation)                      │
└─────────────────────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────┐
│                   Policies                           │
│              (Authorization Logic)                   │
└─────────────────────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────┐
│                   Services                           │
│           (Business Logic Layer)                     │
└─────────────────────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────┐
│                 Repositories                         │
│            (Data Access Layer)                       │
└─────────────────────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────┐
│                 Eloquent Models                      │
│              (Domain Entities)                       │
└─────────────────────────────────────────────────────┘
```

### Architectural Patterns

1. **Service Layer Pattern**: Business logic isolated in service classes
2. **Repository Pattern**: Data access abstraction with interfaces
3. **Policy Pattern**: Authorization logic separated from controllers
4. **Event-Driven Architecture**: Asynchronous task handling with events and listeners
5. **Dependency Injection**: Interface-based dependency management

### Multi-Tenancy Implementation

- **Tenant Identification**: Via authenticated user's company relationship
- **Data Isolation**: Global scopes and middleware enforcement
- **Route Protection**: Middleware validates tenant ownership on all company-scoped routes

---

## 🛠️ Technology Stack

- **Framework**: Laravel 12.x
- **PHP**: 8.2+
- **Database**: MySQL 8.0+ / PostgreSQL 14+
- **Authentication**: Laravel Sanctum
- **Queue Driver**: Database (configurable to Redis)
- **Cache**: File/Redis
- **Frontend Assets**: Vite

---

## 📦 Installation

### Prerequisites

- PHP >= 8.2
- Composer
- Node.js >= 18.x
- MySQL >= 8.0 or PostgreSQL >= 14
- Redis (optional, for queue and cache)

### Step-by-Step Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd laravel-saas-app
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install && npm run build
   ```

4. **Environment configuration**
   ```bash
   cp .env.example .env
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Configure database** (Edit `.env`)
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel_saas
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. **Configure mail** (Edit `.env`)
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=mailpit
   MAIL_PORT=1025
   MAIL_USERNAME=null
   MAIL_PASSWORD=null
   MAIL_ENCRYPTION=null
   MAIL_FROM_ADDRESS="noreply@example.com"
   MAIL_FROM_NAME="${APP_NAME}"
   ```

8. **Configure queue** (Edit `.env`)
   ```env
   QUEUE_CONNECTION=database
   ```

9. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

10. **Start the queue worker** (In a separate terminal)
    ```bash
    php artisan queue:work
    ```

11. **Start the development server**
    ```bash
    php artisan serve
    ```

The application will be available at `http://localhost:8000`

---

## 💾 Database Setup

### Database Schema Overview

```
users
├── id
├── name
├── email
├── password
├── role (enum: admin, owner, member)
├── company_id (foreign key)
├── is_active
└── timestamps

companies
├── id
├── name
├── status (enum: active, inactive)
├── plan_id (foreign key)
└── timestamps

plans
├── id
├── name (Free, Pro)
├── max_tasks (nullable)
└── timestamps

tasks
├── id
├── company_id (foreign key)
├── title
├── description
├── status (enum: pending, in_progress, completed)
├── priority (enum: low, medium, high)
├── due_date
├── deleted_at (soft delete)
└── timestamps
```

### Seeded Data

After running `php artisan migrate --seed`, you'll have:

**Plans:**
- Free Plan (max 5 tasks)
- Pro Plan (unlimited tasks)

---

## 🔌 API Documentation

### Base URL
```
http://localhost:8000/api
```

### Authentication

All API endpoints (except login and register) require authentication via Bearer token.

**Headers:**
```
Authorization: Bearer {token}
Accept: application/json
Content-Type: application/json
```

---

### Endpoints

#### 1. Authentication

##### Login
```http
POST /api/login
```

**Request Body:**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response (200):**
```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "role": "owner"
  },
  "token": "2|xyz789..."
}
```

##### Get Current User
```http
GET /api/me
```

**Response (200):**
```json
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "role": "owner",
  "company_id": 1,
  "is_active": true
}
```

---

#### 2. Tasks

##### List Tasks (with filters)
```http
GET /api/tasks
```

**Query Parameters:**
- `status` (optional): `pending`, `in_progress`, `completed`
- `priority` (optional): `low`, `medium`, `high`
- `search` (optional): Search by title

**Example:**
```http
GET /api/tasks?status=pending&priority=high&search=urgent
```

**Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "title": "Complete project documentation",
      "description": "Write comprehensive docs",
      "status": "pending",
      "priority": "high",
      "due_date": "2026-02-15",
      "created_at": "2026-02-01T10:00:00.000000Z"
    }
  ]
}
```

##### Create Task
```http
POST /api/tasks
```

**Request Body:**
```json
{
  "title": "New Task",
  "description": "Task description here",
  "status": "pending",
  "priority": "medium",
  "due_date": "2026-02-15"
}
```

**Response (201):**
```json
{
  "data": {
    "id": 2,
    "title": "New Task",
    "description": "Task description here",
    "status": "pending",
    "priority": "medium",
    "due_date": "2026-02-15",
    "created_at": "2026-02-01T11:00:00.000000Z"
  }
}
```

**Error Response (422) - Plan Limit Exceeded:**
```json
{
  "message": "Task limit exceeded. Your Free plan allows maximum 5 tasks. Upgrade to Pro for unlimited tasks."
}
```

##### Show Task
```http
GET /api/tasks/{id}
```

**Response (200):**
```json
{
  "data": {
    "id": 1,
    "title": "Complete project documentation",
    "description": "Write comprehensive docs",
    "status": "pending",
    "priority": "high",
    "due_date": "2026-02-15"
  }
}
```

##### Update Task
```http
PUT /api/tasks/{id}
```

**Request Body:**
```json
{
  "title": "Updated Task Title",
  "status": "in_progress",
  "priority": "low"
}
```

**Response (200):**
```json
{
  "data": {
    "id": 1,
    "title": "Updated Task Title",
    "status": "in_progress",
    "priority": "low",
    "due_date": "2026-02-15"
  }
}
```

##### Delete Task
```http
DELETE /api/tasks/{id}
```

**Response (204):**
No content

---

### HTTP Status Codes

- `200 OK` - Successful GET, PUT requests
- `201 Created` - Successful POST request
- `204 No Content` - Successful DELETE request
- `401 Unauthorized` - Missing or invalid token
- `403 Forbidden` - Insufficient permissions
- `404 Not Found` - Resource not found
- `422 Unprocessable Entity` - Validation error
- `429 Too Many Requests` - Rate limit exceeded

---

### Rate Limiting

API endpoints are rate-limited to **60 requests per minute** per user.

**Rate Limit Headers:**
```
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
```

When limit exceeded (429):
```json
{
  "message": "Too Many Requests"
}
```

---

## 💳 Subscription Plans

### Free Plan
- **Price**: $0/month
- **Task Limit**: 5 tasks maximum
- **Features**:
  - Basic task management
  - Up to 5 active users
  - Email support

### Pro Plan
- **Price**: $29/month (example)
- **Task Limit**: Unlimited
- **Features**:
  - Unlimited tasks
  - Unlimited users
  - Priority support
  - Advanced reporting
  - API access

### Plan Enforcement

Task limits are enforced at the **service layer** using the `TaskService`:

```php
// Service checks plan limit before creation
if (!$this->canCreateTask($companyId)) {
    throw new \Exception('Task limit exceeded for your plan');
}
```

This ensures business rules are centralized and cannot be bypassed through different entry points.

---

## 📁 Project Structure

```
laravel-saas-app/
│
├── app/
│   ├── Enums/                      # Enumeration classes
│   │   ├── PlanType.php
│   │   ├── TaskPriority.php
│   │   ├── TaskStatus.php
│   │   └── UserRole.php
│   │
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/               # API controllers
│   │   │   │   ├── AuthController.php
│   │   │   │   └── TaskController.php
│   │   │   └── Web/               # Web controllers
│   │   │
│   │   ├── Middleware/            # Custom middleware
│   │   │   └── EnsureTenantAccess.php
│   │   │
│   │   ├── Requests/              # Form request validation
│   │   │   ├── LoginRequest.php
│   │   │   ├── RegisterRequest.php
│   │   │   ├── StoreTaskRequest.php
│   │   │   └── UpdateTaskRequest.php
│   │   │
│   │   └── Resources/             # API resources
│   │       ├── TaskResource.php
│   │       └── UserResource.php
│   │
│   ├── Models/                    # Eloquent models
│   │   ├── Company.php
│   │   ├── Plan.php
│   │   ├── Task.php
│   │   └── User.php
│   │
│   ├── Policies/                  # Authorization policies
│   │   ├── CompanyPolicy.php
│   │   ├── TaskPolicy.php
│   │   └── UserPolicy.php
│   │
│   ├── Providers/
│   │   ├── AppServiceProvider.php
│   │   ├── AuthServiceProvider.php   # Policy registration
│   │   └── EventServiceProvider.php  # Event registration
│   │
│   ├── Repositories/              # Repository pattern
│   │   ├── Eloquent/
│   │   │   ├── CompanyRepository.php
│   │   │   ├── TaskRepository.php
│   │   │   └── UserRepository.php
│   │   └── Interfaces/
│   │       ├── CompanyRepositoryInterface.php
│   │       ├── TaskRepositoryInterface.php
│   │       └── UserRepositoryInterface.php
│   │
│   └── Services/                  # Business logic services
│       ├── Implementations/
│       │   ├── CompanyService.php
│       │   ├── TaskService.php
│       │   └── UserService.php
│       └── Interfaces/
│           ├── CompanyServiceInterface.php
│           ├── TaskServiceInterface.php
│           └── UserServiceInterface.php
│
├── database/
│   ├── migrations/                # Database migrations
│   │   ├── 2024_01_01_000000_create_plans_table.php
│   │   ├── 2024_01_01_000001_create_companies_table.php
│   │   ├── 2024_01_01_000002_create_users_table.php
│   │   └── 2024_01_01_000003_create_tasks_table.php
│   │
│   └── seeders/                   # Database seeders
│       ├── DatabaseSeeder.php
│       ├── PlanSeeder.php
│       ├── CompanySeeder.php
│       └── UserSeeder.php
│
├── routes/
│   ├── api.php                    # API routes
│   └── web.php                    # Web routes
│
├── tests/
│   ├── Feature/                   # Feature tests
│   └── Unit/                      # Unit tests
│
├── .env.example                   # Environment example
├── composer.json
├── package.json
└── README.md
```

---

## 🔒 Security Considerations

1. **Token Management**: API tokens should be stored securely and rotated regularly
2. **Password Policy**: Enforce strong password requirements in production
3. **HTTPS**: Always use HTTPS in production environments
4. **Input Validation**: All user inputs are validated using Form Requests
5. **SQL Injection**: Protected by Laravel's query builder and Eloquent ORM
6. **XSS Protection**: Blade templating auto-escapes output
7. **CSRF Protection**: Enabled by default for web routes
8. **Rate Limiting**: Prevents brute force and DDoS attacks

---

## 🚀 Deployment

### Production Checklist

- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Generate new `APP_KEY`
- [ ] Configure production database
- [ ] Set up Redis for cache and queues
- [ ] Configure mail service (SendGrid, Mailgun, etc.)
- [ ] Enable HTTPS
- [ ] Set up queue workers with Supervisor
- [ ] Configure scheduled tasks (cron)
- [ ] Set up error tracking (Sentry, Bugsnag)
- [ ] Enable log rotation
- [ ] Run `composer install --optimize-autoloader --no-dev`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`

### Recommended Hosting
- Laravel Forge + AWS/DigitalOcean
- Laravel Vapor (serverless)
- Heroku
- Platform.sh

---

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

## 📄 License

This project is licensed under the MIT License.

---

## 🙏 Acknowledgments

- Laravel Framework - Taylor Otwell and contributors
- Laravel Sanctum - Authentication system
- Clean Architecture principles - Robert C. Martin
- Multi-tenancy patterns - Laravel community

---

**Built with ❤️ using Laravel 12**
