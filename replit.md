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
- **Home Page**: Hero section, service overview, CTAs
- **Services Page**: All service categories (Advertising, Management, Creative, Tech, Outreach)
- **Portfolio Page**: Project showcase with images and descriptions
- **Contact Page**: Form with database storage

### Admin Dashboard
- **Secure Login**: Session-based authentication (default: admin/admin123)
- **Service Management**: CRUD operations for all services
- **Portfolio Management**: Upload/edit/delete projects with image handling
- **Lead Management**: View and manage contact form submissions

## Database Schema
- `admin_users`: Admin authentication
- `services`: Service catalog with categories
- `portfolio`: Project showcase
- `contact_leads`: Contact form submissions

## Admin Access
- **URL**: `/admin/login`
- **Username**: admin
- **Password**: admin123

## Color Scheme
- Gold/Tan: #C9A961, #D4AF37
- Dark backgrounds: #1a1a1a, #0a0a0a
- Accent colors for status badges and alerts

## Matrix Effect
- **Animation**: Amharic falling code effect (Amharic numbers: ፩፪፫፬፭፮፯፰፱፲)
- **Locations**: Hero/page-header sections and footer on all pages
- **Styling**: Green (#00FF41) with 50% opacity for subtle appearance
- **Speed**: Slower falling animation (0.4 speed) for elegant effect
- **Containment**: Confined to specific sections with overflow:hidden

## Footer
- **Matrix Effect**: Same Amharic falling code as hero sections
- **Social Media Links**: 
  - Telegram: https://t.me/neoprinting
  - WhatsApp: https://wa.me/251911234567
  - Facebook: https://facebook.com/neoprinting
  - Instagram: https://instagram.com/neoprinting
- **Styling**: Compact design with gold circular icons and hover effects
- **Security**: External links use rel="noopener noreferrer"

## Recent Changes
- October 15, 2025: Initial project setup with complete feature set
- October 15, 2025: Matrix effect added to hero and footer sections (Amharic falling code)
- October 15, 2025: Social media links added to footer with security attributes
- October 15, 2025: Footer resized for compact appearance
- October 15, 2025: Matrix animation speed reduced for elegant effect
- Database: PostgreSQL with 4 tables and sample data
- All CRUD operations functional
- Responsive design with mobile support

## Development
The website runs on PHP's built-in server on port 5000. The workflow "NEO Website" is configured to automatically start the server.

## Security Features
- Password hashing with bcrypt
- Prepared statements for SQL injection prevention
- Session-based authentication with regeneration after login
- Secure session cookies (httponly, secure, SameSite=Strict)
- CSRF token protection on all admin forms
- Input sanitization with htmlspecialchars
- File upload validation
- Error display disabled in production (logging enabled)
