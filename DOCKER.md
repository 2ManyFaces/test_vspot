# Docker Setup for VibeSpot

This document explains the Docker setup for the VibeSpot project (Laravel 13 backend + Next.js 16 frontend).

## Project Stack

- **Backend**: Laravel 13 (PHP 8.5) with PostgreSQL 18 and Redis 7
- **Frontend**: Next.js 16.2.4 (React 19.2.4) with Node.js 24
- **Web Server**: Nginx (Alpine)
- **Cache**: Redis 7
- **Database**: PostgreSQL 18

## Prerequisites

- Docker Desktop (Windows, macOS) or Docker Engine (Linux)
- Docker Compose v2.0+
- At least 4GB RAM allocated to Docker

## Project Structure

```
vibespot/
├── backend/                    # Laravel 13 Application
│   ├── Dockerfile             # PHP 8.5-FPM Image
│   ├── docker-entrypoint.sh   # Auto-migration & Setup script
│   └── .dockerignore
├── frontend/                   # Next.js 16 Application
│   ├── Dockerfile             # Node.js 24 Image (Standalone Mode)
│   └── .dockerignore
├── nginx/                      # Nginx Configuration
│   └── nginx.conf             # Nginx proxy & FastCGI configuration
├── docker-compose.yml         # Main orchestration file
├── .env.docker.example        # Template for Docker environment
└── .env.docker.compose        # Docker Compose environment secrets
```

## Getting Started (Quick Run)

To run this project on a new device, follow these steps:

### 1. Clone and Prepare Environment

```bash
# 1. Copy the example environment file
cp .env.docker.example .env.docker.compose

# 2. (Optional) Edit .env.docker.compose to customize passwords/keys
# The default values are already configured for local Docker use.
```

### 2. Build and Start Containers

```bash
# Start all services
docker-compose up -d --build
```

This command will:
- Build the **optimized PHP 8.5** image for the backend.
- Build the **Next.js 16 Standalone** image for the frontend.
- Spin up **PostgreSQL 18** and **Redis 7**.
- Start the **Nginx** reverse proxy to glue everything together.

### 3. Automatic Initialization
The backend container is equipped with an **auto-entrypoint** script that will automatically:
- Wait for PostgreSQL to be ready.
- Generate an `APP_KEY` if missing.
- Run all database migrations.
- Clear and optimize Laravel caches.

### 4. Access Services

| Service | URL | Purpose |
|---------|-----|---------|
| **Frontend** | `http://localhost` | Main Next.js application |
| **Backend API** | `http://localhost/api` | Laravel API endpoints |
| **PostgreSQL** | `localhost:5432` | Direct database access |

---

## Common Management Commands

### Logs & Monitoring
```bash
# View logs from all services
docker-compose logs -f

# View specific service logs
docker-compose logs -f php
docker-compose logs -f frontend
```

### Accessing Shells
```bash
# Laravel Backend Shell
docker-compose exec php /bin/sh

# Frontend Shell
docker-compose exec frontend /bin/sh

# Database Shell
docker-compose exec postgres psql -U postgres
```

### Manual Database Operations
```bash
# Run a specific artisan command
docker-compose exec php php artisan migrate:status

# Refresh database with seeds
docker-compose exec php php artisan migrate:fresh --seed
```

## Troubleshooting

### "Permission Denied" on entrypoint
If the backend fails to start because of the entrypoint script, ensure it is executable:
```bash
chmod +x backend/docker-entrypoint.sh
```

### Build Failures (Next.js)
If the frontend build fails during `prerendering`, ensure that any pages using client-side hooks like `useSearchParams()` are marked with `export const dynamic = 'force-dynamic';` or wrapped in `<Suspense>`.

### Port Conflicts
If port `80` is already taken on your host machine, change the mapping in `docker-compose.yml`:
```yaml
services:
  nginx:
    ports:
      - "8080:80"  # Now accessible at http://localhost:8080
```

---
**Happy Coding!** 🚀
