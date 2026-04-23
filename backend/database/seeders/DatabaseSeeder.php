<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Place;
use App\Models\Event;
use App\Models\BlogPost;
use App\Models\User;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::factory()->create([
            'email' => 'admin@vibespot.com',
            'display_name' => 'VibeSpot Editorial'
        ]);

        // Create a demo user for seeding reviews
        $user = User::create([
            'email' => 'demo@vibespot.com',
            'display_name' => 'Arif Rahman',
            'password_hash' => bcrypt('password'),
            'is_active' => true,
        ]);

        $user2 = User::create([
            'email' => 'nadia@vibespot.com',
            'display_name' => 'Nadia Hossain',
            'password_hash' => bcrypt('password'),
            'is_active' => true,
        ]);

        $user3 = User::create([
            'email' => 'karim@vibespot.com',
            'display_name' => 'Karim Uddin',
            'password_hash' => bcrypt('password'),
            'is_active' => true,
        ]);

        // ─── REAL DHAKA PLACES ───
        $places = [
            [
                'name' => 'North End Coffee Roasters',
                'category' => 'Food & Drinks',
                'area_name' => 'Gulshan',
                'area_zone' => 'DNCC',
                'address' => 'Road 103, Gulshan 2, Dhaka 1212',
                'description' => 'A premium third-wave coffee house in the heart of Gulshan. North End sources single-origin beans from Sylhet and Rangamati hill tracts, roasts in-house, and serves precision pour-overs alongside artisan pastries. The minimalist industrial interior — exposed brick, warm wood, Edison bulbs — draws remote workers, creatives, and coffee purists alike.',
                'cover_image_url' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/0b/5a/58/01/north-end-billing-counter.jpg?w=900&h=500&s=1',
                'budget_tier' => '$$$',
                'average_rating' => 4.7,
                'total_reviews' => 342,
                'tags' => ['Coffee', 'WiFi', 'Laptop-Friendly', 'Specialty Brews'],
                'is_published' => true,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Chillox',
                'category' => 'Food & Drinks',
                'area_name' => 'Dhanmondi',
                'area_zone' => 'DSCC',
                'address' => 'Road 27, Dhanmondi, Dhaka 1205',
                'description' => 'An iconic Dhanmondi café nestled beside Dhanmondi Lake. Known for its signature mango smoothies, continental breakfast platters, and lakeside terrace seating. A go-to for university students from nearby campuses and young professionals looking for a relaxed weekend brunch.',
                'cover_image_url' => 'https://lh3.googleusercontent.com/gps-cs-s/APNQkAFjCmcsGvFXxV8pKnH4brfIIRBYt2VPYM5rJWqz_bw6rOqGRJNT7lK-VDvpelHNOPi3mQkOfN9BUeLHKt7fceX3FviCp6AyEBKyjJeIN4gplhHb4IWmYbGelRs5kVORTryjpVtGpxevMk8=s680-w680-h510-rw',
                'budget_tier' => '$$',
                'average_rating' => 4.5,
                'total_reviews' => 528,
                'tags' => ['Lakeside', 'Brunch', 'Student-Friendly', 'Outdoor Seating'],
                'is_published' => true,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Star Kabab & Restaurant',
                'category' => 'Food & Drinks',
                'area_name' => 'Old Dhaka',
                'area_zone' => 'DSCC',
                'address' => 'Nazira Bazaar, Bangsal Road, Dhaka 1100',
                'description' => 'A legendary Old Dhaka institution serving the finest Mughlai cuisine for over five decades. Their mutton rezala, beef tehari, and the famous naan-e-kabab are not just meals — they are cultural experiences. The no-frills communal dining atmosphere is part of the charm.',
                'cover_image_url' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/07/e7/28/f7/star-kabab-restaurant.jpg?w=1200&h=-1&s=1',
                'budget_tier' => '$',
                'average_rating' => 4.8,
                'total_reviews' => 1205,
                'tags' => ['Mughlai', 'Heritage', 'Biriyani', 'Legendary'],
                'is_published' => true,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Lalbagh Fort',
                'category' => 'Landmarks & Heritage',
                'area_name' => 'Old Dhaka',
                'area_zone' => 'DSCC',
                'address' => 'Lalbagh Road, Dhaka 1211',
                'description' => 'A 17th-century Mughal fort complex begun by Prince Muhammad Azam in 1678. Though never completed, the fort contains the Mosque of Shaista Khan, the Tomb of Bibi Pari, and a museum. The well-maintained gardens offer a serene green haven amidst Old Dhaka\'s busy lanes. A must-visit for history enthusiasts and photographers.',
                'cover_image_url' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/31/fb/13/65/lalbagh-is-a-popular.jpg?w=1200&h=1200&s=1',
                'budget_tier' => '$',
                'average_rating' => 4.6,
                'total_reviews' => 890,
                'tags' => ['Mughal', 'History', 'Photography', 'Museum'],
                'is_published' => true,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Ahsan Manzil (Pink Palace)',
                'category' => 'Landmarks & Heritage',
                'area_name' => 'Old Dhaka',
                'area_zone' => 'DSCC',
                'address' => 'Kumartoli, Dhaka 1100',
                'description' => 'The iconic Pink Palace on the banks of the Buriganga River — once the seat of the Nawabs of Dhaka. Now a museum, Ahsan Manzil showcases the grandeur of Bengal\'s aristocratic past through 23 galleries filled with portraits, furniture, and artefacts. The palace glows magnificently under evening floodlights.',
                'cover_image_url' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/14/16/b2/fe/ahsan-monjil.jpg?w=1200&h=800&s=1',
                'budget_tier' => '$',
                'average_rating' => 4.7,
                'total_reviews' => 760,
                'tags' => ['Palace', 'Nawab', 'Buriganga', 'Museum'],
                'is_published' => true,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Hatirjheel Lakefront',
                'category' => 'Outdoors',
                'area_name' => 'Tejgaon',
                'area_zone' => 'DNCC',
                'address' => 'Hatirjheel Bridge, Tejgaon, Dhaka',
                'description' => 'Dhaka\'s most ambitious urban water body project spanning 302 acres. The beautifully lit pedestrian walkways, cycling paths, and the iconic bridge make Hatirjheel the city\'s favourite evening hangout. Street food vendors, boat rides during monsoon, and spectacular sunset views draw thousands daily.',
                'cover_image_url' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/18/59/9b/8b/hatirheel-lake.jpg?w=1200&h=800&s=1',
                'budget_tier' => '$',
                'average_rating' => 4.4,
                'total_reviews' => 1580,
                'tags' => ['Lake', 'Walking', 'Cycling', 'Night Views', 'Free Entry'],
                'is_published' => true,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Dhanmondi Lake Park',
                'category' => 'Outdoors',
                'area_name' => 'Dhanmondi',
                'area_zone' => 'DSCC',
                'address' => 'Road 15, Dhanmondi, Dhaka 1205',
                'description' => 'The green lung of Dhanmondi — a serene park surrounding the iconic lake. Popular for morning joggers, evening strollers, and couples. The recently renovated walkways, kids\' play zones, and lakeside benches make it Dhaka\'s most cherished urban park. The Rabindra Sarobar area hosts cultural events year-round.',
                'cover_image_url' => 'https://images.unsplash.com/photo-1632961745430-2fc391b74f4b?auto=format&fit=crop&w=1200&q=80',
                'budget_tier' => '$',
                'average_rating' => 4.3,
                'total_reviews' => 2100,
                'tags' => ['Lake', 'Park', 'Jogging', 'Family-Friendly', 'Free Entry'],
                'is_published' => true,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Dhaka Art Center',
                'category' => 'Culture',
                'area_name' => 'Dhanmondi',
                'area_zone' => 'DSCC',
                'address' => 'Road 6, Dhanmondi, Dhaka 1205',
                'description' => 'Dhaka\'s premier contemporary art space. The center hosts rotating exhibitions by emerging Bangladeshi artists, monthly open-mic nights, documentary film screenings, and art workshops. The gallery café on the second floor serves excellent espresso. A cultural anchor for the Dhanmondi creative community.',
                'cover_image_url' => 'https://images.unsplash.com/photo-1531243269054-5ebf6f34081e?auto=format&fit=crop&w=1200&q=80',
                'budget_tier' => '$$',
                'average_rating' => 4.5,
                'total_reviews' => 310,
                'tags' => ['Art', 'Gallery', 'Exhibitions', 'Workshops'],
                'is_published' => true,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Gulshan DCC Market Food Court',
                'category' => 'Food & Drinks',
                'area_name' => 'Gulshan',
                'area_zone' => 'DNCC',
                'address' => 'Gulshan 1 Circle, Dhaka 1212',
                'description' => 'A vibrant local hub for street food lovers. From hot momos to grilled chicken and fresh juices, this food court captures the fast-paced urban dining spirit of Gulshan.',
                'cover_image_url' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=1200&q=80',
                'budget_tier' => '$',
                'budget_label' => 'Low-Medium',
                'budget_range' => '150-500',
                'operating_hours' => [
                    'Monday' => '11:00 AM - 10:00 PM',
                    'Tuesday' => '11:00 AM - 10:00 PM',
                    'Wednesday' => '11:00 AM - 10:00 PM',
                    'Thursday' => '11:00 AM - 10:30 PM',
                    'Friday' => '11:00 AM - 10:30 PM',
                    'Saturday' => '11:00 AM - 10:00 PM',
                    'Sunday' => '11:00 AM - 10:00 PM',
                ],
                'tags' => ['Street Food', 'Budget', 'Gulshan', 'Evening'],
                'is_published' => true,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Bashundhara City Shopping Mall',
                'category' => 'Shopping',
                'area_name' => 'Panthapath',
                'area_zone' => 'DNCC',
                'address' => 'Panthapath, Dhaka',
                'description' => 'One of the largest shopping malls in South Asia, featuring over 2,500 retail stores, a massive food court, a multiplex cinema, and a theme park.',
                'cover_image_url' => 'https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?auto=format&fit=crop&w=1200&q=80',
                'budget_tier' => '$$',
                'budget_label' => 'Medium-High',
                'budget_range' => '500-15000',
                'operating_hours' => [
                    'Monday' => '10:00 AM - 8:00 PM',
                    'Tuesday' => '10:00 AM - 8:00 PM',
                    'Wednesday' => '10:00 AM - 8:00 PM',
                    'Thursday' => '10:00 AM - 8:00 PM',
                    'Friday' => '10:00 AM - 8:00 PM',
                    'Saturday' => '10:00 AM - 8:00 PM',
                    'Sunday' => 'Closed',
                ],
                'average_rating' => 4.3,
                'total_reviews' => 3200,
                'tags' => ['Shopping', 'Cinema & Screenings', 'Family', 'Ice Rink', 'Food Court'],
                'is_published' => true,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'National Parliament House',
                'category' => 'Landmarks & Heritage',
                'area_name' => 'Sher-e-Bangla Nagar',
                'area_zone' => 'DSCC',
                'address' => 'Sher-e-Bangla Nagar, Dhaka 1207',
                'description' => 'Designed by legendary architect Louis Kahn, the Jatiya Sangsad Bhaban is widely considered one of the 20th century\'s most significant works of architecture. The brutalist concrete complex, set within a vast artificial lake and landscaped grounds, is both a functioning parliament and an architectural pilgrimage site. The surrounding grounds are open for public walks.',
                'cover_image_url' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/09/49/57/25/national-parliament-house.jpg?w=1200&h=-1&s=1',
                'budget_tier' => '$',
                'budget_label' => 'Free',
                'budget_range' => '0-0',
                'operating_hours' => [
                    'Monday' => '9:00 AM - 5:00 PM',
                    'Tuesday' => '9:00 AM - 5:00 PM',
                    'Wednesday' => '9:00 AM - 5:00 PM',
                    'Thursday' => '9:00 AM - 5:00 PM',
                    'Friday' => 'Closed',
                    'Saturday' => 'Closed',
                    'Sunday' => '9:00 AM - 5:00 PM',
                ],
                'average_rating' => 4.9,
                'total_reviews' => 1850,
                'tags' => ['Architecture', 'Louis Kahn', 'Brutalist', 'Photography'],
                'is_published' => true,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Star Cineplex',
                'category' => 'Cinema & Screenings',
                'area_name' => 'Panthapath',
                'area_zone' => 'DNCC',
                'address' => 'Level 8, Bashundhara City, Panthapath, Dhaka',
                'description' => 'The first multiplex cinema in Bangladesh. Offering international standard movie viewing experience with multiple screens, premium seating, and state-of-the-art sound systems.',
                'cover_image_url' => 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?auto=format&fit=crop&w=1200&q=80',
                'budget_tier' => '$$$',
                'budget_label' => 'High',
                'budget_range' => '500-1500',
                'operating_hours' => [
                    'Monday' => '10:30 AM - 10:30 PM',
                    'Tuesday' => '10:30 AM - 10:30 PM',
                    'Wednesday' => '10:30 AM - 10:30 PM',
                    'Thursday' => '10:30 AM - 10:30 PM',
                    'Friday' => '10:30 AM - 11:00 PM',
                    'Saturday' => '10:30 AM - 10:30 PM',
                    'Sunday' => '10:30 AM - 8:00 PM',
                ],
                'average_rating' => 4.5,
                'total_reviews' => 310,
                'tags' => ['Movies', 'Multiplex', 'Dolly Atmos', 'Bashundhara City'],
                'is_published' => true,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Blockbuster Cinemas',
                'category' => 'Cinema & Screenings',
                'area_name' => 'Kuril',
                'area_zone' => 'DNCC',
                'address' => 'Jamuna Future Park, Kuril, Dhaka',
                'description' => 'A massive multiplex located within Jamuna Future Park, featuring 7 themed theaters including a premium VIP lounge and 3D screens.',
                'cover_image_url' => 'https://lh3.googleusercontent.com/gps-cs-s/APNQkAH-4IpoMQaXAdHduYF3jv1yOWdka3F4Rau7mcj9k_IoEfeZTqJPtQNU-6_AazbVHRBmi4eOy8OiywxHscwb3qBW_OLs5HGtcMWQfXTjdBZ7v_7hJD7zDjc-QMiR-T_ZOWWq7HSvvQWYrzIX=s680-w680-h510-rw',
                'budget_tier' => '$$$',
                'budget_label' => 'High',
                'budget_range' => '600-2000',
                'operating_hours' => [
                    'Monday' => '11:00 AM - 11:00 PM',
                    'Tuesday' => '11:00 AM - 11:00 PM',
                    'Wednesday' => '11:00 AM - 11:00 PM',
                    'Thursday' => '11:00 AM - 11:00 PM',
                    'Friday' => '11:00 AM - 11:30 PM',
                    'Saturday' => '11:00 AM - 11:00 PM',
                    'Sunday' => '11:00 AM - 8:30 PM',
                ],
                'average_rating' => 4.5,
                'total_reviews' => 310,
                'tags' => ['Movies', 'Multiplex', '3D', 'JFP'],
                'is_published' => true,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Jamuna Future Park',
                'category' => 'Shopping',
                'area_name' => 'Kuril',
                'area_zone' => 'DNCC',
                'address' => 'KA-244, Kuril, Pragati Sarani, Dhaka',
                'description' => 'The largest shopping mall in Bangladesh and one of the largest in the world. It features everything from global brands to an indoor theme park, bowling alley, and multiple swimming pools.',
                'cover_image_url' => 'https://images.unsplash.com/photo-1561633442-f85764d0bc7b?auto=format&fit=crop&w=1200&q=80',
                'budget_tier' => '$$$',
                'budget_label' => 'Medium-High',
                'budget_range' => '500-50000',
                'operating_hours' => [
                    'Monday' => '11:00 AM - 9:00 PM',
                    'Tuesday' => '11:00 AM - 9:00 PM',
                    'Wednesday' => 'Closed',
                    'Thursday' => '11:00 AM - 9:00 PM',
                    'Friday' => '11:00 AM - 9:00 PM',
                    'Saturday' => '11:00 AM - 9:00 PM',
                    'Sunday' => '11:00 AM - 9:00 PM',
                ],
                'average_rating' => 4.3,
                'total_reviews' => 3200,
                'tags' => ['Super Mall', 'Theme Park', 'Bowling', 'Global Brands'],
                'is_published' => true,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'New Market',
                'category' => 'Shopping',
                'area_name' => 'Azimpur',
                'area_zone' => 'DSCC',
                'address' => 'Mirpur Road, Dhaka',
                'description' => 'A historic and bustling traditional market. Famous for everything from books and stationery to clothing and household items at bargain prices.',
                'cover_image_url' => 'https://images.unsplash.com/photo-1621259182978-fbf93132d53d?auto=format&fit=crop&w=1200&q=80',
                'budget_tier' => '$',
                'budget_label' => 'Low-Medium',
                'budget_range' => '50-5000',
                'operating_hours' => [
                    'Monday' => '10:00 AM - 9:00 PM',
                    'Tuesday' => 'Closed',
                    'Wednesday' => '10:00 AM - 9:00 PM',
                    'Thursday' => '10:00 AM - 9:00 PM',
                    'Friday' => '10:00 AM - 9:00 PM',
                    'Saturday' => '10:00 AM - 9:00 PM',
                    'Sunday' => '10:00 AM - 9:00 PM',
                ],
                'average_rating' => 4.2,
                'total_reviews' => 920,
                'tags' => ['Traditional', 'Bargain', 'Historic', 'Old School'],
                'is_published' => true,
                'created_by' => $admin->id,
            ],
        ];

        foreach ($places as $v) {
            Place::create($v);
        }

        // ─── REAL DHAKA EVENTS ───
        $events = [
            [
                'title' => 'Ekushey Boi Mela 2026',
                'slug' => 'ekushey-boi-mela-2026',
                'category' => 'Culture',
                'area_name' => 'Bangla Academy',
                'area_zone' => 'DSCC',
                'organiser_name' => 'Bangla Academy',
                'description' => 'The nation\'s biggest book fair, held every February to commemorate the Language Movement martyrs. Over 500 publishers set up stalls across the Bangla Academy grounds and Suhrawardy Udyan.',
                'cover_image_url' => 'https://images.unsplash.com/photo-1491841573634-28140fc7ced7?auto=format&fit=crop&w=1200&q=80',
                'event_date' => '2026-05-01',
                'end_date' => '2026-05-31',
                'start_time' => '03:00 PM',
                'end_time' => '09:00 PM',
                'average_rating' => 4.8,
                'total_reviews' => 2400,
                'is_published' => true,
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Dhaka Lit Fest 2026',
                'slug' => 'dhaka-lit-fest-2026',
                'category' => 'Culture',
                'area_name' => 'Bangla Academy',
                'area_zone' => 'DSCC',
                'organiser_name' => 'Dhaka Lit Fest Foundation',
                'description' => 'South Asia\'s most prestigious English-language literary festival. Featuring over 200 speakers across 100+ sessions — panel discussions, readings, book launches, and performances.',
                'cover_image_url' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1200&q=80',
                'event_date' => '2026-11-14',
                'end_date' => '2026-11-16',
                'start_time' => '10:00 AM',
                'end_time' => '08:00 PM',
                'average_rating' => 4.9,
                'total_reviews' => 1800,
                'is_published' => true,
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Pohela Boishakh 1433',
                'slug' => 'pohela-boishakh-1433',
                'category' => 'Culture',
                'area_name' => 'Ramna Boothomul',
                'area_zone' => 'DSCC',
                'organiser_name' => 'Chhayanaut',
                'description' => 'The Bengali New Year celebrations at Ramna Botomul — Dhaka\'s most cherished cultural tradition.',
                'cover_image_url' => 'https://images.unsplash.com/photo-1767330855011-fc628d33caea?auto=format&fit=crop&w=1200&q=80',
                'event_date' => '2026-04-14',
                'end_date' => '2026-04-14',
                'start_time' => '06:00 AM',
                'end_time' => '10:00 PM',
                'average_rating' => 4.9,
                'total_reviews' => 5100,
                'is_published' => true,
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Spring Street Food Festival',
                'slug' => 'spring-food-fest-2026',
                'category' => 'Food & Drinks',
                'area_name' => 'Banani',
                'area_zone' => 'DNCC',
                'organiser_name' => 'Chef\'s Table',
                'description' => 'A 10-day celebration of Dhaka\'s vibrant street food culture with over 50 vendors from across the city.',
                'cover_image_url' => 'https://images.unsplash.com/photo-1729941506359-cf4924f023e5?auto=format&fit=crop&w=1200&q=80',
                'event_date' => '2026-04-20',
                'end_date' => '2026-04-30',
                'start_time' => '12:00 PM',
                'end_time' => '11:00 PM',
                'average_rating' => 4.5,
                'total_reviews' => 120,
                'is_published' => true,
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Contemporary Art Exhibit',
                'slug' => 'contemporary-art-2026',
                'category' => 'Culture',
                'area_name' => 'Dhanmondi',
                'area_zone' => 'DSCC',
                'organiser_name' => 'Dhaka Art Center',
                'description' => 'Showcasing the latest works by emerging artists from across Bangladesh.',
                'cover_image_url' => 'https://images.unsplash.com/photo-1531243269054-5ebf6f34081e?auto=format&fit=crop&w=1200&q=80',
                'event_date' => '2026-04-22',
                'end_date' => '2026-05-05',
                'start_time' => '10:00 AM',
                'end_time' => '08:00 PM',
                'average_rating' => 4.7,
                'total_reviews' => 45,
                'is_published' => true,
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Rock Dhaka 2026',
                'slug' => 'rock-dhaka-2026',
                'category' => 'Entertainment',
                'area_name' => 'International Convention City Bashundhara',
                'area_zone' => 'DNCC',
                'organiser_name' => 'LiveSquare Entertainment',
                'description' => 'The biggest rock concert of the year featuring top bands of Bangladesh.',
                'cover_image_url' => 'https://images.unsplash.com/photo-1459749411175-04bf5292ceea?auto=format&fit=crop&w=1200&q=80',
                'event_date' => '2026-05-15',
                'end_date' => '2026-05-15',
                'start_time' => '04:00 PM',
                'end_time' => '11:00 PM',
                'average_rating' => 0,
                'total_reviews' => 0,
                'is_published' => true,
                'created_by' => $admin->id,
            ],
        ];

        foreach ($events as $e) {
            Event::create($e);
        }

        // ─── SEED SOME REVIEWS ───
        $reviewData = [
            ['place_id' => 1, 'user_id' => $user->id, 'rating' => 5, 'body' => 'Best specialty coffee in Dhaka, hands down. The Ethiopian single-origin pour-over was phenomenal.'],
            ['place_id' => 1, 'user_id' => $user2->id, 'rating' => 4, 'body' => 'Great ambiance for working. WiFi is reliable and the cold brew is solid. Can get crowded on weekends.'],
            ['place_id' => 2, 'user_id' => $user->id, 'rating' => 5, 'body' => 'The lakeside terrace at sunset is magical. Mango smoothie is a must-try. Perfect brunch spot.'],
            ['place_id' => 2, 'user_id' => $user3->id, 'rating' => 4, 'body' => 'Love the vibe here. Affordable for students. The pasta could use improvement though.'],
            ['place_id' => 3, 'user_id' => $user2->id, 'rating' => 5, 'body' => 'The mutton biriyani here is genuinely the best I have ever had. A Dhaka institution. Come early or it sells out.'],
            ['place_id' => 3, 'user_id' => $user3->id, 'rating' => 5, 'body' => 'Five generations of perfection. The naan-e-kabab is otherworldly. Old Dhaka at its finest.'],
            ['place_id' => 4, 'user_id' => $user->id, 'rating' => 5, 'body' => 'Walking through the Mughal corridors at dawn was breathtaking. The gardens are so well maintained.'],
            ['place_id' => 4, 'user_id' => $user2->id, 'rating' => 4, 'body' => 'Beautifully preserved. The Tomb of Bibi Pari is hauntingly beautiful. Wish the museum had more English signage.'],
            ['place_id' => 5, 'user_id' => $user3->id, 'rating' => 5, 'body' => 'The Pink Palace at dusk, lit up against the Buriganga — absolutely stunning. Great little museum too.'],
            ['place_id' => 6, 'user_id' => $user->id, 'rating' => 4, 'body' => 'Best place in Dhaka for an evening walk. The bridge is beautifully lit. Street food vendors are a bonus.'],
            ['place_id' => 7, 'user_id' => $user2->id, 'rating' => 4, 'body' => 'Peaceful morning jog around the lake. The renovated walkways are great. Gets very crowded evenings.'],
            ['place_id' => 11, 'user_id' => $user->id, 'rating' => 5, 'body' => 'Louis Kahn\'s masterpiece. You feel the weight of history and architecture simultaneously. The grounds are perfect for photography.'],
            ['place_id' => 12, 'user_id' => $user3->id, 'rating' => 5, 'body' => 'Incredible live music under the stars. The acoustic sessions on Friday nights are not to be missed.'],
        ];

        foreach ($reviewData as $r) {
            Review::create([
                ...$r,
                'reviewable_type' => 'place',
            ]);
        }

        // ─── BLOG POSTS ───
        $posts = [
            [
                'title' => 'Best Rooftop Cafés in Dhanmondi',
                'slug' => 'best-rooftop-cafes-in-dhanmondi',
                'featured_image_url' => 'https://cosmosgroup.sgp1.digitaloceanspaces.com/news/details/8866773_Adda%20Multi-Cuisine%20Restaurant%20Dhanmondi%20Dhaka.jpg',
                'body' => "Dhanmondi has quietly become Dhaka's rooftop café capital. Perched above the city's leafy aplaces, these sky-high spots offer stunning views alongside world-class coffee and locally sourced bites.\n\n## Why Rooftops?\n\nDhaka's urban heat makes a breezy rooftop the ultimate escape. When the sun dips below the horizon, these terraces transform into social hubs buzzing with conversations, live acoustic sets, and the warm glow of string lights.\n\n## Our Top 5 Picks\n\n**1. The Perch** — Nestled above Satmasjid Road, The Perch serves specialty pour-overs and mezze platters as you look out over Lake Dhanmondi. A must-visit on weekend evenings.\n\n**2. Sky Garden Café** — A verdant rooftop paradise with hanging ferns and ambient lighting. Their cold brew and banana bread are legendary in the neighbourhood.\n\n**3. Altitude Lounge** — More upscale, Altitude caters to professionals unwinding after work. Think craft cocktails and sushi platters against the glittering city skyline.\n\n**4. Chai Stories** — For the tea enthusiast, Chai Stories curates 40+ single-origin blends alongside homemade snacks. Their evening storytelling sessions are a community favourite.\n\n**5. Roofscape** — The newest addition to the Dhanmondi scene, Roofscape prioritises local art. Gallery walls line the terrace perimeter, with rotating exhibitions every month.",
                'tags' => ['Rooftop', 'Café', 'Dhanmondi', 'Food & Drinks'],
            ],
            [
                'title' => 'A Night Out in Old Dhaka',
                'slug' => 'a-night-out-in-old-dhaka',
                'featured_image_url' => 'https://sarakhon.com/wp-content/uploads/2025/03/Image-2025-03-15at-05.50.16_59a4e.jpg',
                'body' => "Old Dhaka doesn't sleep. As the rest of the city winds down, Puran Dhaka comes alive — its narrow alleys filling with the clatter of rickshaws, the sizzle of biriani pots, and the laughter of friends gathering around centuries-old tea stalls.\n\n## Starting Your Evening\n\nBegin at **Chawkbazar** as dusk sets in. This ancient marketplace has been the heart of Old Dhaka trade for over 400 years.\n\n## The Food Trail\n\nNo night in Puran Dhaka is complete without a pilgrimage to **Haji Biriani** on Nalgola Road. Their 100-year-old recipe of slow-cooked mutton biriani is the stuff of legend.\n\n## Walking Ahsan Manzil at Dusk\n\nThe Pink Palace glows under floodlights against the Buriganga River. An evening stroll along the ghats here offers an entirely different perspective of Dhaka: quieter, contemplative, beautiful.",
                'tags' => ['Heritage', 'Food', 'Old Dhaka', 'Night Out'],
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::create([
                ...$post,
                'author_id' => $admin->id,
                'is_published' => true,
                'published_at' => now()->subDays(rand(1, 20)),
            ]);
        }

        // ─── FINAL SYNC ───
        // Recalculate ratings and counts for all places and events to ensure accuracy
        Place::all()->each(function($place) {
            $reviews = Review::where('place_id', $place->id);
            $place->average_rating = $reviews->avg('rating') ?: 0;
            $place->total_reviews = $reviews->count();
            $place->save();
        });
        
        Event::all()->each(function($event) {
            $reviews = Review::where('event_id', $event->id);
            $event->average_rating = $reviews->avg('rating') ?: 0;
            $event->total_reviews = $reviews->count();
            $event->save();
        });
    }
}
