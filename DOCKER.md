# Docker Setup for VibeSpot

This document explains the Docker setup for the VibeSpot project (Laravel 13 backend + Next.js 16 frontend).

## Project Stack

- **Backend**: Laravel 13 (PHP 8.3) with PostgreSQL 16 and Redis 7
- **Frontend**: Next.js 16.2.4 (React 19.2.4) with Node.js 20
- **Web Server**: Nginx (Alpine)
- **Cache**: Redis 7
- **Database**: PostgreSQL 16

## Prerequisites

- Docker Desktop (Windows, macOS) or Docker Engine (Linux)
- Docker Compose v2.0+
- At least 4GB RAM allocated to Docker

## Project Structure

```
vibespot/
├── backend/                    # Laravel 13 Application
│   ├── Dockerfile             # PHP 8.3-FPM Image
│   ├── docker/                # Docker config files
│   │   └── php/               # PHP configuration
│   │       ├── php.ini
│   │       └── www.conf
│   └── .dockerignore
├── frontend/                   # Next.js 16 Application
│   ├── Dockerfile             # Node.js 20 Image
│   └── .dockerignore
├── nginx/                      # Nginx Configuration
│   └── nginx.conf             # Nginx proxy configuration
├── docker-compose.yml         # Main orchestration file
├── .env.docker                # Docker environment (backend)
├── .env.docker.compose        # Docker Compose environment
├── .dockerignore
└── Makefile                   # Helper commands
```

## Getting Started

### 1. Build and Start Containers

```bash
# Using Make (recommended)
make up

# Or using Docker Compose directly
docker-compose up -d --build
```

This will:
- Build PHP-FPM image with Laravel
- Build Next.js image
- Start PostgreSQL 16
- Start Redis 7
- Start Nginx reverse proxy
- Create all necessary networks and volumes

### 2. Initialize Database

```bash
# Run migrations
make migrate

# Or with seed data
make migrate-fresh
```

### 3. Access Services

| Service | URL | Purpose |
|---------|-----|---------|
| Frontend | `http://localhost` | Next.js application |
| Backend API | `http://localhost/api/*` | Laravel API endpoints |
| PostgreSQL | `localhost:5432` | Database |
| Redis | `localhost:6379` | Cache/Queue |

### 4. Access Container Shells

```bash
# PHP Container
make php-shell
docker-compose exec php /bin/sh

# PostgreSQL Container
make db-shell
docker-compose exec postgres psql -U postgres

# Frontend Container
docker-compose exec frontend /bin/sh
```

## Common Commands

### Development

```bash
# Start all containers
make up

# Stop all containers
make down

# Restart containers
make start
make stop

# View logs from all containers
make logs

# View specific service logs
make logs-php
make logs-nginx
make logs-frontend
```

### Database Operations

```bash
# Run migrations
make migrate

# Fresh migration with seeding
make migrate-fresh

# Run seeders
make seed

# Access database shell
make db-shell
```

### PHP/Laravel Commands

```bash
# Run tests
make test

# Access Tinker REPL
make tinker

# Inside PHP container, use artisan directly
docker-compose exec php php artisan <command>
```

### Node.js/Frontend Commands

```bash
# Install dependencies
docker-compose exec frontend npm install

# Build production bundle
docker-compose exec frontend npm run build

# Access frontend container
docker-compose exec frontend /bin/sh
```

## Configuration

### Backend Environment (.env.docker)

The backend uses `.env.docker` with Docker-specific settings:

```
DB_HOST=postgres          # Use Docker service name
REDIS_HOST=redis          # Use Docker service name
CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

### Frontend Environment

Create `.env.local` in the frontend directory for API URL:

```
NEXT_PUBLIC_API_URL=http://localhost/api
```

## Volumes and Persistence

- **Database**: PostgreSQL data persists in `postgres_data` volume
- **Laravel Storage**: `/app/storage` is mounted from host
- **Laravel Cache**: `/app/bootstrap/cache` is mounted from host
- **Frontend Build**: `.next` and `node_modules` are excluded from host mounts

## Networking

All services connect through the `vibespot_network` Docker network:
- Services communicate using their container names
- Example: `postgres:5432`, `redis:6379`, `php:9000`

## Production Deployment

### Enable HTTPS

Uncomment the HTTPS server block in `nginx/nginx.conf` and provide:
- `nginx/ssl/cert.pem` - SSL certificate
- `nginx/ssl/key.pem` - SSL private key

### Environment Variables

Use `.env.docker.compose` for production secrets:
```bash
docker-compose --env-file .env.docker.compose up -d
```

### Database Backup

```bash
# Backup PostgreSQL
docker-compose exec postgres pg_dump -U postgres postgres > backup.sql

# Restore from backup
docker-compose exec -T postgres psql -U postgres postgres < backup.sql
```

## Troubleshooting

### Containers won't start

```bash
# Check logs
docker-compose logs

# Rebuild without cache
docker-compose build --no-cache
docker-compose up -d
```

### Database connection issues

```bash
# Verify PostgreSQL is running
docker-compose logs postgres

# Check if database exists
docker-compose exec postgres psql -U postgres -l
```

### Port already in use

Change port mappings in `docker-compose.yml`:
```yaml
ports:
  - "8080:80"    # Use port 8080 instead of 80
```

### PHP extensions missing

Update `backend/Dockerfile` to include additional extensions:
```dockerfile
RUN docker-php-ext-install <extension-name>
```

## Performance Tips

1. **Development Mode**: Use `.dockerignore` to exclude node_modules
2. **Caching**: Use Redis for sessions and cache
3. **Opcache**: Enabled in production PHP config
4. **Volume Mounts**: In production, use only necessary volumes

## Resource Limits

To limit container resources in `docker-compose.yml`:

```yaml
services:
  php:
    deploy:
      resources:
        limits:
          cpus: '1'
          memory: 512M
        reservations:
          cpus: '0.5'
          memory: 256M
```

## Additional Resources

- [Docker Compose Documentation](https://docs.docker.com/compose/)
- [Laravel Docker Guide](https://laravel.com/docs/deployment)
- [Next.js Docker Guide](https://nextjs.org/docs/deployment/docker)
- [PostgreSQL Docker Hub](https://hub.docker.com/_/postgres)
- [Redis Docker Hub](https://hub.docker.com/_/redis)

## Support

For issues or questions, check the logs with `make logs` or `docker-compose logs -f [service-name]`.
