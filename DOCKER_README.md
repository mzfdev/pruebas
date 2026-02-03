# Docker Setup for Laravel API

This document provides instructions on how to dockerize and run the Laravel API application using Docker and Docker Compose.

## Prerequisites

- Docker installed on your system
- Docker Compose installed on your system

## Quick Start

1. Generate an application key:
   ```bash
   php artisan key:generate --show
   ```
   Copy the generated key and replace `YOUR_APP_KEY_HERE` in the `docker-compose.yml` file.

2. Build and start the containers:
   ```bash
   docker-compose up -d --build
   ```

3. Wait for all services to be ready (this may take a few minutes on first run):
   ```bash
   docker-compose logs -f app
   ```
   You should see "PostgreSQL is ready!" followed by migration messages.

4. Access the API:
   - API URL: http://localhost:8000
   - API Documentation: http://localhost:8000/api/documentation
   - MailHog (Email Testing): http://localhost:8025
   - PostgreSQL Database: localhost:5432 (username: laravel, password: laravel_password, database: laravel)
   - Redis: localhost:6379

## Container Services

The Docker setup includes the following services:

### Main Application
- **app**: The Laravel API application with PHP-FPM, Nginx, and Supervisor
- Runs on port 8000

### Required Services
- **postgres**: PostgreSQL 15 database server (port 5432)
  - Database: laravel
  - Username: laravel
  - Password: laravel_password
  - Data persists in a Docker volume

### Additional Services
- **redis**: Redis server for caching and sessions (port 6379)
- **mailhog**: Email testing service (SMTP on port 1025, Web UI on port 8025)

## Detailed Instructions to Run the Project

### First Time Setup

1. **Generate Application Key**:
   ```bash
   php artisan key:generate --show
   ```
   Copy the generated key and replace `YOUR_APP_KEY_HERE` in the `docker-compose.yml` file.

2. **Build and Start Containers**:
   ```bash
   docker-compose up -d --build
   ```
   This command will:
   - Build the Docker image for the Laravel application
   - Start PostgreSQL, Redis, MailHog, and the Laravel application
   - Automatically run database migrations
   - Set up Redis for caching and sessions

3. **Verify Services are Running**:
   ```bash
   docker-compose ps
   ```
   All services should show as "Up" or "running".

4. **Check Application Logs**:
   ```bash
   docker-compose logs -f app
   ```
   Look for messages indicating successful database connection and migrations.

5. **Seed the Database (Optional)**:
   ```bash
   docker-compose exec app php artisan db:seed
   ```

### Accessing the Application

- **API Endpoints**: http://localhost:8000/api/
- **Swagger Documentation**: http://localhost:8000/api/documentation
- **MailHog (Email Testing)**: http://localhost:8025
- **Direct Database Access**: Connect to localhost:5432 with:
  - Host: localhost
  - Port: 5432
  - Database: laravel
  - Username: laravel
  - Password: laravel_password

## Docker Compose Commands

- Start all services:
  ```bash
  docker-compose up -d
  ```

- Stop all services:
  ```bash
  docker-compose down
  ```

- Rebuild and restart:
  ```bash
  docker-compose down && docker-compose up -d --build
  ```

- View logs:
  ```bash
  docker-compose logs -f app
  docker-compose logs -f postgres
  ```

- Execute commands in the application container:
  ```bash
  docker-compose exec app sh
  ```

- Run Laravel artisan commands:
  ```bash
  docker-compose exec app php artisan migrate
  docker-compose exec app php artisan tinker
  docker-compose exec app php artisan db:seed
  ```

- Access PostgreSQL directly:
  ```bash
  docker-compose exec postgres psql -U laravel -d laravel
  ```

## Development Workflow

1. Make changes to your code locally
2. The changes are automatically reflected in the container due to volume mounting
3. If you change composer dependencies:
   ```bash
   docker-compose exec app composer install
   ```
4. If you change npm dependencies:
   ```bash
   docker-compose exec app npm install
   docker-compose exec app npm run build
   ```

## Production Considerations

For production deployment:

1. Update environment variables in `docker-compose.yml`:
   - Set `APP_ENV=production`
   - Set `APP_DEBUG=false`
   - Change default database passwords
   - Set up proper mail configuration
   - Configure proper Redis password

2. Set up proper volume mounts for persistent data

3. Configure proper SSL certificates

4. Set up proper backup strategies for PostgreSQL

5. Consider using environment files instead of hardcoding values in docker-compose.yml

## Troubleshooting

### Permission Issues
If you encounter permission issues with storage directories:
```bash
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
```

### Database Connection Issues
If the application can't connect to PostgreSQL:
1. Check if PostgreSQL is running:
   ```bash
   docker-compose ps postgres
   ```
2. Check PostgreSQL logs:
   ```bash
   docker-compose logs postgres
   ```
3. Test connection from app container:
   ```bash
   docker-compose exec app sh
   nc -z postgres 5432
   ```

### Migration Issues
If migrations fail:
1. Check if the database exists:
   ```bash
   docker-compose exec postgres psql -U laravel -d laravel -c "\l"
   ```
2. Reset migrations (WARNING: This will delete all data):
   ```bash
   docker-compose exec app php artisan migrate:fresh
   ```

### Clearing Caches
If changes are not reflecting:
```bash
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
```

### Performance Issues
For better performance in production:
1. Run queue workers separately:
   ```bash
   docker-compose exec app php artisan queue:work --daemon
   ```
2. Use Redis for caching and sessions (already configured)

## API Endpoints

Once the application is running, you can access the following endpoints:

- `GET /api/students` - Get all students
- `GET /api/students/{id}/grade-report` - Get grade report for a student
- `POST /api/reports/generate-pdf` - Generate PDF report
- `GET /api/reports/download/{fileName}` - Download PDF report
- `POST /api/reports/send-by-email` - Send report by email
- `POST /api/reports/print` - Print report

## Environment Variables

The application can be configured using environment variables in the `docker-compose.yml` file. Key variables include:

### Application
- `APP_NAME`: Application name
- `APP_ENV`: Environment (local, production)
- `APP_KEY`: Application encryption key
- `APP_DEBUG`: Debug mode
- `APP_URL`: Application URL

### Database
- `DB_CONNECTION`: Database connection type (pgsql)
- `DB_HOST`: Database hostname (postgres)
- `DB_PORT`: Database port (5432)
- `DB_DATABASE`: Database name (laravel)
- `DB_USERNAME`: Database username (laravel)
- `DB_PASSWORD`: Database password (laravel_password)

### Cache and Sessions
- `CACHE_STORE`: Cache driver (redis)
- `SESSION_DRIVER`: Session driver (redis)
- `REDIS_HOST`: Redis hostname (redis)
- `REDIS_PORT`: Redis port (6379)

### Queue
- `QUEUE_CONNECTION`: Queue driver (database)

### Mail
- `MAIL_MAILER`: Mail driver (smtp)
- `MAIL_HOST`: SMTP host (mailhog)
- `MAIL_PORT`: SMTP port (1025)
- `MAIL_FROM_ADDRESS`: Default from email address
- `MAIL_FROM_NAME`: Default from name