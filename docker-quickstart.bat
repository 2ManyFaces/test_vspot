@echo off
REM VibeSpot Docker Quick Start Script (Windows)
REM This script sets up the Docker environment and initializes the application

setlocal enabledelayedexpansion

echo ======================================
echo VibeSpot Docker Quick Start
echo ======================================
echo.

REM Check if Docker is installed
docker --version >nul 2>&1
if errorlevel 1 (
    echo ❌ Docker is not installed. Please install Docker Desktop for Windows first.
    exit /b 1
)

echo ✓ Docker is installed

REM Check if Docker Compose is installed
docker-compose --version >nul 2>&1
if errorlevel 1 (
    echo ❌ Docker Compose is not installed. Please install Docker Desktop for Windows first.
    exit /b 1
)

echo ✓ Docker Compose is installed
echo.

REM Copy environment files if they don't exist
if not exist .env.docker.compose (
    echo 📋 Creating .env.docker.compose from example...
    copy .env.docker.example .env.docker.compose
    echo ✓ Created .env.docker.compose
)

if not exist docker-compose.override.yml (
    echo 📋 Creating docker-compose.override.yml from example...
    copy docker-compose.override.yml.example docker-compose.override.yml
    echo ✓ Created docker-compose.override.yml
)

echo.
echo 🐳 Building Docker images...
call docker-compose build

if errorlevel 1 (
    echo ❌ Docker build failed
    exit /b 1
)

echo.
echo 🚀 Starting containers...
call docker-compose up -d

if errorlevel 1 (
    echo ❌ Failed to start containers
    exit /b 1
)

echo.
echo ⏳ Waiting for services to be ready...
timeout /t 5 /nobreak

echo.
echo 🔍 Checking PHP service...
docker-compose exec -T php php --version >nul 2>&1

echo.
echo 📦 Installing PHP dependencies...
call docker-compose exec -T php composer install

echo.
echo 🗄️  Running database migrations...
call docker-compose exec -T php php artisan migrate --force

echo.
echo 📦 Installing Node dependencies...
call docker-compose exec -T frontend npm install

echo.
echo ======================================
echo ✅ Setup Complete!
echo ======================================
echo.
echo Your application is now running:
echo   Frontend:  http://localhost
echo   API:       http://localhost/api
echo   Database:  localhost:5432
echo   Redis:     localhost:6379
echo.
echo Useful commands:
echo   docker-compose logs          - View logs
echo   docker-compose exec php /bin/sh     - Access PHP shell
echo   docker-compose exec postgres psql -U postgres   - Access database
echo   docker-compose exec php php artisan migrate     - Run migrations
echo   docker-compose exec php php artisan test        - Run tests
echo.
echo For more information, see DOCKER.md
echo.
pause
