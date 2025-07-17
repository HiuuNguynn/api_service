# CRUD Mini Backend Project

## Main Features
- User registration, login, JWT authentication, password change, forgot/reset password
- User and Person management (CRUD)
- Role-based access: Admin, User, account status check (active/deactive)
- RESTful API, input validation, error codes
- Batch email sending (queue/job)
- Data change logging
- Middleware for permission, status, data checks
- Observer for syncing User and Person status

## Technologies Used
- Laravel 8+, Eloquent ORM, Migration, Seeder
- JWT Auth, custom Middleware, Observer, Job/Queue
- Docker, Docker Compose, MySQL, Redis

## Highlights
- Clean, extensible code
- Robust error handling & validation
- Easy to integrate & expand

## How to Run
```bash
# Clone & enter project
 git clone <repo-url>
 cd <project-folder>

# Setup
 cp .env.example .env
 composer install
 npm install
 php artisan key:generate
 php artisan migrate --seed

# Start (Docker)
 docker-compose up -d
# Or local
 php artisan serve
```
- API: http://localhost:8000/api
- Edit `.env` for DB/mail config if needed.
