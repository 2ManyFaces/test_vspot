# 🚀 VibeSpot Docker Setup - Quick Start

Welcome! This project is fully Dockerized for easy development and deployment. Follow these simple steps:

## Prerequisites

- **Docker Desktop** (Windows/Mac) or **Docker Engine** (Linux)
- **Docker Compose** v2.0+ (included with Docker Desktop)

## 🎯 Quick Start (30 seconds)

### Windows
```powershell
.\docker-quickstart.bat
```

### Linux/macOS
```bash
chmod +x docker-quickstart.sh
./docker-quickstart.sh
```

### Manual Setup
```bash
# Copy environment files
copy .env.docker.example .env.docker.compose  # or: cp on Linux/Mac
copy docker-compose.override.yml.example docker-compose.override.yml

# Build and start
docker-compose up -d --build

# Wait ~30 seconds, then access your app at http://localhost
```

## ✅ Services Running

After setup completes, you'll have:

| Service | URL | Details |
|---------|-----|---------|
| **Frontend** | http://localhost | Next.js 16 + React 19 |
| **API** | http://localhost/api | Laravel 13 + PHP 8.3 |
| **Database** | localhost:5432 | PostgreSQL 16 |
| **Cache** | localhost:6379 | Redis 7 |

## 📝 Common Tasks

```bash
# View logs
make logs

# Run migrations
make migrate

# Access PHP shell
make php-shell

# Access database shell
make db-shell

# Run tests
make test

# Full list of commands
make help
```

## 🐛 Troubleshooting

**Port 80 already in use?**
```bash
# Edit docker-compose.yml and change:
# ports: - "8080:80"    # Use 8080 instead
```

**Containers won't start?**
```bash
# Check logs
docker-compose logs

# Rebuild without cache
docker-compose build --no-cache
docker-compose up -d
```

**Database connection failed?**
```bash
# Ensure PostgreSQL is running
docker-compose logs postgres

# Check if database exists
docker-compose exec postgres psql -U postgres -l
```

## 📚 Full Documentation

See [DOCKER.md](DOCKER.md) for comprehensive setup, configuration, and production deployment guide.

## 🎉 That's It!

Your application is ready to go. The entire setup is automated:
- ✅ Dependencies installed
- ✅ Database migrated
- ✅ All services running
- ✅ API connected to frontend

Start developing! 🚀
