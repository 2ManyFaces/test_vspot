# VibeSpot Project Structure & Setup Guide

VibeSpot is a community-powered venue and event discovery platform serving Dhaka's urban population. This document outlines the project architecture, tech stack, and complete folder structure for the application.

## 🚀 Tech Stack

*   **Frontend:** Next.js 16.2.4 (App Router), React, TypeScript, Tailwind CSS v4
*   **Backend:** Laravel 13, PHP 8.5
*   **Database:** PostgreSQL 18
*   **Authentication:** Clerk (Next.js integration)
*   **Environment:** Laragon

---

## 📁 Complete Folder Structure

```text
vibespot/
├── frontend/                        # Next.js 16 Frontend Application
│   ├── src/
│   │   ├── app/                     # Next.js App Router root
│   │   │   ├── (auth)/              # Clerk Authentication routes (login, register)
│   │   │   │   ├── sign-in/
│   │   │   │   │   └── [[...sign-in]]/page.tsx
│   │   │   │   └── sign-up/
│   │   │   │       └── [[...sign-up]]/page.tsx
│   │   │   ├── (main)/              # Main public layout (includes persistent Navbar/Footer)
│   │   │   │   ├── layout.tsx       # Main layout wrapper
│   │   │   │   ├── page.tsx         # FR-03: Homepage (Discovery Cards, Search)
│   │   │   │   ├── venues/
│   │   │   │   │   ├── page.tsx     # FR-04, FR-05: Venue listings, Search & Filter
│   │   │   │   │   └── [id]/page.tsx # FR-04: Single Venue Listing
│   │   │   │   ├── events/
│   │   │   │   │   ├── page.tsx     # FR-04: Events list
│   │   │   │   │   └── [id]/page.tsx # FR-04: Single Event Listing
│   │   │   │   ├── blog/            
│   │   │   │   │   ├── page.tsx     # FR-07: Articles & Blog Listing
│   │   │   │   │   └── [slug]/page.tsx # FR-07: Single Blog Post
│   │   │   │   ├── profile/
│   │   │   │   │   └── page.tsx     # FR-02: User Profile Management & Stats
│   │   │   │   └── wishlist/
│   │   │   │       └── page.tsx     # FR-06: Wishlist Management
│   │   │   └── admin/               # Admin dashboard layout
│   │   │       ├── layout.tsx
│   │   │       ├── page.tsx         # FR-09: Admin Panel root (Analytics)
│   │   │       ├── venues/page.tsx
│   │   │       ├── events/page.tsx
│   │   │       ├── users/page.tsx
│   │   │       └── blog/page.tsx
│   │   ├── components/              # Reusable React components
│   │   │   ├── ui/                  # Base UI components (Buttons, Inputs, Dialogs)
│   │   │   ├── shared/              # Shared components (Navbar, Footer, DarkModeToggle)
│   │   │   ├── cards/               # VenueCard, EventCard, BlogCard
│   │   │   ├── filters/             # Multi-dimensional search filters
│   │   │   └── admin/               # Admin-specific components (DataTables, Forms)
│   │   ├── lib/                     # Utility functions and wrappers
│   │   │   ├── api.ts               # Axios/Fetch wrapper for Laravel API
│   │   │   └── utils.ts             # Tailwind class mergers, date formatting, etc.
│   │   ├── hooks/                   # Custom React hooks (e.g., useWishlist, useAuth)
│   │   ├── types/                   # TypeScript interfaces (Venue, Event, User, Review)
│   │   ├── store/                   # Global state management if needed (Zustand context)
│   │   ├── styles/                  
│   │   │   └── globals.css          # Global styles and Tailwind configuration imports
│   │   └── middleware.ts            # Clerk Auth middleware to protect routes
│   ├── public/                      # Static assets (images, icons)
│   ├── .env.local                   # Frontend environment variables (Clerk keys, API URL)
│   ├── next.config.mjs
│   ├── tailwind.config.ts           # Tailwind CSS configuration rules
│   ├── tsconfig.json
│   └── package.json                 # Frontend dependencies
│
├── backend/                         # Laravel 13 Backend Application
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   └── Api/
│   │   │   │       ├── V1/          # Versioned API Controllers
│   │   │   │       │   ├── VenueController.php
│   │   │   │       │   ├── EventController.php
│   │   │   │       │   ├── UserController.php    # FR-02 Profile Sync
│   │   │   │       │   ├── ReviewController.php  # FR-08 Ratings/Reviews
│   │   │   │       │   ├── WishlistController.php
│   │   │   │       │   ├── BlogController.php
│   │   │   │       │   └── SearchController.php  # FR-05 Advanced Search/Filtering
│   │   │   ├── Requests/            # Custom FormRequests for validation
│   │   │   ├── Resources/           # API Resources (JSON transformations)
│   │   │   └── Middleware/          # Verify Clerk Webhook/JWT tokens
│   │   └── Models/                  # Eloquent Models
│   │       ├── User.php             # Syncs with Clerk via webhooks
│   │       ├── Venue.php
│   │       ├── Event.php
│   │       ├── Category.php
│   │       ├── Review.php
│   │       ├── Wishlist.php
│   │       └── BlogPost.php
│   ├── bootstrap/
│   ├── config/                      # Laravel configuration (cors, database, etc.)
│   ├── database/
│   │   ├── migrations/              # Database schema architecture
│   │   ├── seeders/                 # Seeders for dummy user, admin, venues, events
│   │   └── factories/               # Model factories for testing and seeding
│   ├── routes/
│   │   ├── api.php                  # API route definitions
│   │   └── web.php                  # (Rarely used since it's an API, maybe for Clerk webhooks)
│   ├── storage/                     # Log files, cached views, user uploaded files
│   ├── tests/                       # Unit and Feature tests via Pest/PHPUnit
│   ├── .env.example                 # Backend template for ENV vars
│   ├── database.sqlite              # Default fallback (to be changed to PostgreSQL)
│   ├── artisan                      # Laravel cli command runner
│   └── composer.json                # Backend dependencies
│
└── README.md                        # This project documentation file
```

## 🗄️ Database Schema Design (PostgreSQL 18)

Based on the requirements, here are the primary core tables to be created via Laravel Migrations:

*   **`users`**: `id`, `clerk_id` (unique), `email`, `display_name`, `bio`, `profile_photo_url`, `role` (user/admin), `timestamps`
*   **`venues`**: `id`, `name`, `slug`, `category`, `address`, `zone` (DNCC/DSCC), `latitude`, `longitude`, `description`, `budget_tier`, `operating_hours` (jsonb), `is_active`, `timestamps`
*   **`venue_photos`**: `id`, `venue_id`, `image_url`, `is_primary`
*   **`events`**: `id`, `venue_id` (nullable), `title`, `slug`, `organiser_name`, `start_time`, `end_time`, `description`, `ticket_url`, `image_url`, `timestamps`
*   **`reviews`**: `id`, `user_id`, `reviewable_type` (Venue/Event), `reviewable_id`, `rating` (1-5), `content`, `is_checkin`, `timestamps`
*   **`wishlists`**: `id`, `user_id`, `wishlistable_type` (Venue/Event), `wishlistable_id`, `timestamps`
*   **`blog_posts`**: `id`, `author_id` (admin), `title`, `slug`, `content`, `featured_image_url`, `published_at`, `timestamps`

## 🛠️ Step-by-Step Implementation Map

1.  **Environment Setup:** Spin up Laragon, create `vibespot` PostgreSQL database.
2.  **Backend Initialization:** Run `composer create-project laravel/laravel backend` (targeting Laravel v13 config). Setup `.env` for DB.
3.  **Frontend Initialization:** Run `npx create-next-app@latest frontend` with Tailwind v4, App Router, TypeScript.
4.  **Authentication (FR-01):** Integrate Clerk in Next.js. Setup Clerk Webhooks in Laravel to sync created users to PostgreSQL.
5.  **Database Migrations & Models:** Create Laravel migrations and dummy DB seeders for UI testing.
6.  **Core API Development:** Build GET/POST routes for Venues, Events, Profiles, Search.
7.  **Frontend UI/UX System:** Setup global CSS, styling variables, and build the reusable layout (Nav, Footer, Dark Mode toggle).
8.  **Frontend Pages:** Develop Homepage (FR-03), Listings (FR-04), Profile (FR-02), and Wishlist (FR-06).
9.  **Interactive Elements:** Implement Search/Filters (FR-05) and Review submissions (FR-08).
10. **Admin Panel (FR-09):** Develop data tables and forms for entity management in the `/admin` route.
#   v s p o t  
 #   v s p o t  
 