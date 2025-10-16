# NEO Printing and Advertising Website

## Overview
Professional corporate website for NEO Printing and Advertising built with Pure PHP and PostgreSQL. Features a modern, responsive design with gold/tan branding and a fully functional admin dashboard for content management.

## Technology Stack
- **Backend**: Pure PHP 8.2 (no frameworks)
- **Database**: PostgreSQL (Replit managed)
- **Frontend**: HTML5, CSS3, JavaScript
- **Architecture**: MVC-style structure

## Project Structure
```
├── config/              # Database configuration
├── controllers/         # PublicController & AdminController
├── models/             # Service, Portfolio, ContactLead, AdminUser models
├── views/
│   ├── public/         # Public-facing pages
│   └── admin/          # Admin dashboard pages
├── public/
│   ├── index.php       # Application router
│   └── assets/
│       ├── css/        # Styles with gold/tan branding
│       ├── js/         # Admin modal functionality
│       ├── images/     # Logo and images
│       └── uploads/    # Portfolio image uploads
```

## Features

### Public-Facing Website
- **Home Page**: Hero section, service overview, CTAs, recent blog posts
- **Services Page**: All service categories with WhatsApp request buttons for each service
- **Portfolio Page**: Project showcase with images and descriptions
- **Contact Page**: Form with database storage
- **Blog Pages**: Blog listing and individual post pages
- **About Page**: Company information (editable via admin)

### Admin Dashboard
- **Secure Login**: Session-based authentication (default: admin/admin123)
- **Service Management**: CRUD operations for all services
- **Portfolio Management**: Upload/edit/delete projects with image handling
- **Lead Management**: View and manage contact form submissions
- **Blog Management**: Create, edit, and publish blog posts
- **Settings Management**: Configure contact information and social media links (Telegram, Facebook, Instagram, WhatsApp)

## Database Schema
- `admin_users`: Admin authentication
- `services`: Service catalog with categories
- `portfolio`: Project showcase
- `contact_leads`: Contact form submissions
- `blog_posts`: Blog posts and articles
- `site_settings`: Configurable site settings (contact info, social media links, etc.)

## Admin Access
- **URL**: `/admin`
- **Username**: admin
- **Password**: admin123

## Color Scheme
- Gold/Tan: #C9A961, #D4AF37
- Dark backgrounds: #1a1a1a, #0a0a0a
- Accent colors for status badges and alerts

## Matrix Effect
- **Animation**: Amharic falling code effect with numbers (፩፪፫፬፭፮፯፰፱፲) and letters (ሀለሐመሠረሰሸቀበተቸኀነኘአከኸወዐዘዠየደጀገጠጨጰፀ)
- **Font**: Noto Sans Ethiopic for proper Amharic character rendering
- **Locations**: Hero/page-header sections and footer on all pages
- **Styling**: Green (#00FF41) with 50% opacity for subtle appearance
- **Speed**: Slower falling animation (0.4 speed) for elegant effect
- **Containment**: Confined to specific sections with overflow:hidden

## Footer
- **Matrix Effect**: Same Amharic falling code as hero sections
- **Social Media Links**: Dynamically loaded from database settings
  - Telegram (configurable via admin)
  - WhatsApp (configurable via admin)
  - Facebook (configurable via admin)
  - Instagram (configurable via admin)
- **Styling**: Compact design with gold circular icons and hover effects
- **Security**: External links use rel="noopener noreferrer"

## WhatsApp Integration
- **Service Inquiries**: Each service has a "Request via WhatsApp" button
- **Pre-filled Messages**: WhatsApp links include the service name (e.g., "Hello! I'm interested in Graphic Design service. Can you provide more information?")
- **Dynamic Phone Number**: WhatsApp number managed through admin settings panel

## Recent Changes
- October 16, 2025: Added show/hide password toggle icon on admin login page
- October 16, 2025: Removed default credentials display from login page for better security
- October 16, 2025: Fixed admin logout button visibility - made sidebar navigation more compact
- October 16, 2025: Fixed admin logout functionality - removed session parameter from URLs to work with cookie-only sessions
- October 16, 2025: Enhanced session security - removed session IDs from URLs, implemented cookie-only sessions with HTTP-only and SameSite protection
- October 16, 2025: Fixed admin login routing - added `/admin/login` route
- October 16, 2025: Fixed service image display - added square aspect ratio styling with object-fit
- October 16, 2025: Updated database schema - added `slug` and `image_path` columns to services table
- October 16, 2025: Completed project import and database setup
- October 15, 2025: Initial project setup with complete feature set
- October 15, 2025: Matrix effect added to hero and footer sections (Amharic falling code)
- October 15, 2025: Social media links added to footer with security attributes
- October 15, 2025: Footer resized for compact appearance
- October 15, 2025: Matrix animation speed reduced for elegant effect
- October 15, 2025: Services section updated with horizontal scroll navigation
- October 15, 2025: Amharic matrix characters enhanced with proper font (Noto Sans Ethiopic) and expanded character set (numbers + letters)
- October 15, 2025: Database imported and fully configured with PostgreSQL (6 tables)
- October 15, 2025: Added social media link management to admin settings panel
- October 15, 2025: Implemented dynamic social media links in footer (loads from database)
- October 15, 2025: Enhanced WhatsApp integration with service-specific pre-filled messages
- All CRUD operations functional
- Responsive design with mobile support

## Development
The website runs on PHP's built-in server on port 5000. The workflow "NEO Website" is configured to automatically start the server.

## Security Features
- Password hashing with bcrypt
- Prepared statements for SQL injection prevention
- Session-based authentication with regeneration after login
- Secure cookie-only sessions (no session IDs in URLs)
- HTTP-only cookies with SameSite=Lax protection
- CSRF token protection on all admin forms
- Input sanitization with htmlspecialchars
- File upload validation
- Error display disabled in production (logging enabled)
