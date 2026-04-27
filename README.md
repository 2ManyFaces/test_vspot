# VibeSpot - Project Overview & Setup Guide

VibeSpot is a community-powered venue and event discovery platform serving Dhaka's urban population. It helps users find the best places to hang out, discover upcoming events, and share their experiences through reviews and check-ins.

## 🚀 Tech Stack

### Frontend
- **Framework:** Next.js 16.2.4 (App Router)
- **Library:** React 19.2.4
- **Styling:** Tailwind CSS v4
- **Animations:** Framer Motion
- **Icons:** Lucide React
- **Data Fetching:** Axios
- **State Management:** React Context API (Auth & Global State)

### Backend
- **Framework:** Laravel 13.0
- **Language:** PHP 8.3+
- **Authentication:** Laravel Sanctum (API Tokens)
- **OAuth:** Laravel Socialite (Google Authentication)
- **Database ORM:** Eloquent

### Database
- **Engine:** PostgreSQL 18
- **Management:** Migrations & Seeders

---

## 📁 Project Structure

### Frontend (`/frontend`)
```text
frontend/
├── public/                 # Static assets (images, icons)
└── src/
    ├── app/                # Next.js App Router root
    │   ├── (auth)/         # Authentication routes
    │   │   ├── login/      # User login page
    │   │   ├── register/   # User registration page
    │   │   ├── admin-login/# Dedicated admin login
    │   │   └── auth/callback # Google OAuth callback handler
    │   ├── admin/          # Admin Dashboard (Protected)
    │   │   ├── dashboard/  # Analytics & System stats
    │   │   ├── places/     # Manage Places (CRUD)
    │   │   ├── events/     # Manage Events (CRUD)
    │   │   ├── users/      # User management & status toggles
    │   │   ├── blog/       # Blog post management
    │   │   └── reviews/    # Review moderation
    │   ├── blog/           # Public Articles & Guides
    │   ├── events/         # Event listings & details
    │   ├── places/         # Venue/Place discovery & details
    │   ├── profile/        # User Profile & Activity history
    │   ├── wishlist/       # Saved places & events
    │   ├── layout.tsx      # Root layout (Navbar, Footer, Providers)
    │   └── page.tsx        # Homepage (Discovery Cards, Stats)
    ├── components/         # React Components
    │   ├── admin/          # Admin-specific UI components
    │   ├── cards/          # Entity cards (PlaceCard, EventCard)
    │   ├── home/           # Homepage sections (Hero, CategoryGrid)
    │   ├── shared/         # Common UI (Navbar, Footer, Sidebar)
    │   └── reviews/        # Review submission & display
    ├── constants/          # App-wide constants & config
    ├── context/            # Global state (AuthContext)
    └── globals.css         # Styling with Tailwind v4 & custom variables
```

### Backend (`/backend`)
```text
backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/Api/ # REST API Controllers
│   │   │   ├── Admin/       # Management API logic
│   │   │   └── V1/          # Versioned public/user APIs
│   │   └── Middleware/      # Auth & Role-based access control
│   └── Models/              # Eloquent Models
│       ├── Place.php        # Core venue/place model
│       ├── Event.php        # Event model with pricing/dates
│       ├── Review.php       # Ratings & Reviews
│       ├── CheckIn.php      # User visit history
│       ├── WishlistItem.php # Saved items
│       └── BlogPost.php     # Content management
├── database/
│   ├── migrations/          # Database schema (PostgreSQL)
│   ├── seeders/             # Initial & Testing data
│   └── factories/           # Model factories for testing
├── routes/
│   ├── api.php              # All API endpoint definitions
│   └── web.php              # Web routes for redirects
└── artisan                  # Laravel CLI
```

---

## 🗄️ Database Schema Design

The application uses a relational schema optimized for discovery and filtering:

- **`users`**: `id`, `display_name`, `email`, `role`, `profile_photo_url`, `bio`.
- **`places`**: `id`, `name`, `slug`, `category`, `address`, `zone`, `latitude`, `longitude`, `description`, `budget_details` (jsonb).
- **`events`**: `id`, `place_id` (nullable), `title`, `start_time`, `end_time`, `pricing`, `ticket_url`.
- **`reviews`**: `id`, `user_id`, `place_id`, `rating` (1-5), `content`.
- **`check_ins`**: `id`, `user_id`, `place_id`, `event_id`.
- **`wishlist_items`**: `id`, `user_id`, `place_id`, `event_id`.
- **`blog_posts`**: `id`, `author_id`, `title`, `content`, `excerpt`, `featured_image_url`.
- **`notifications`**: `id`, `user_id`, `type`, `data`, `read_at`.

---

## 🛠️ Local Development Setup

### Prerequisites
- **PHP 8.3+**
- **Node.js 20+** & **npm**
- **Composer**
- **PostgreSQL 18**
- **Laragon** (Recommended for Windows environments)

### 1. Backend Setup
```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
# Update .env with your PostgreSQL credentials
php artisan migrate --seed
php artisan serve
```

### 2. Frontend Setup
```bash
cd frontend
npm install
cp .env.example .env.local
# Update .env.local with NEXT_PUBLIC_API_URL=http://localhost:8000/api
npm run dev
```

---

#   v s p o t
#   v s p o t