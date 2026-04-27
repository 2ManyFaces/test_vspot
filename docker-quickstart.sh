#!/bin/bash

# VibeSpot Docker Quick Start Script
# This script sets up the Docker environment and initializes the application

set -e

echo "======================================"
echo "VibeSpot Docker Quick Start"
echo "======================================"
echo ""

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    echo "❌ Docker is not installed. Please install Docker first."
    exit 1
fi

echo "✓ Docker is installed"

# Check if Docker Compose is installed
if ! command -v docker-compose &> /dev/null; then
    echo "❌ Docker Compose is not installed. Please install Docker Compose first."
    exit 1
fi

echo "✓ Docker Compose is installed"
echo ""

# Copy environment files if they don't exist
if [ ! -f .env.docker.compose ]; then
    echo "📋 Creating .env.docker.compose from example..."
    cp .env.docker.example .env.docker.compose
    echo "✓ Created .env.docker.compose"
fi

if [ ! -f docker-compose.override.yml ]; then
    echo "📋 Creating docker-compose.override.yml from example..."
    cp docker-compose.override.yml.example docker-compose.override.yml
    echo "✓ Created docker-compose.override.yml"
fi

echo ""
echo "🐳 Building Docker images..."
docker-compose build

echo ""
echo "🚀 Starting containers..."
docker-compose up -d

echo ""
echo "⏳ Waiting for services to be ready..."
sleep 5

# Check if PHP container is healthy
echo "🔍 Checking PHP service..."
docker-compose exec -T php php --version || true

echo ""
echo "📦 Installing PHP dependencies..."
docker-compose exec -T php composer install

echo ""
echo "🗄️  Running database migrations..."
docker-compose exec -T php php artisan migrate --force

echo ""
echo "📦 Installing Node dependencies..."
docker-compose exec -T frontend npm install

echo ""
echo "======================================"
echo "✅ Setup Complete!"
echo "======================================"
echo ""
echo "Your application is now running:"
echo "  Frontend:  http://localhost"
echo "  API:       http://localhost/api"
echo "  Database:  localhost:5432"
echo "  Redis:     localhost:6379"
echo ""
echo "Useful commands:"
echo "  make logs          - View logs"
echo "  make php-shell     - Access PHP shell"
echo "  make db-shell      - Access database"
echo "  make migrate       - Run migrations"
echo "  make test          - Run tests"
echo ""
echo "For more information, see DOCKER.md"
