# Database Setup Instructions

Your NEO Printing and Advertising website requires a PostgreSQL database to function properly.

## Steps to Set Up the Database:

1. **Create PostgreSQL Database in Replit**
   - Look for the "Database" icon in the left sidebar of Replit
   - Click on it and create a new PostgreSQL database
   - Once created, Replit will automatically set the required environment variables:
     - `PGHOST`
     - `PGPORT`
     - `PGDATABASE`
     - `PGUSER`
     - `PGPASSWORD`

2. **Import the Database Schema**
   - After creating the database, you'll need to run the SQL schema
   - In the Replit Database panel, there should be an option to run SQL queries
   - Copy and paste the contents of `schema.sql` file into the query editor
   - Execute the SQL to create all tables and insert sample data

3. **Verify the Setup**
   - Once the schema is imported, the website should work automatically
   - The workflow "NEO Website" will restart and connect to the database
   - Visit your website to see it in action

## What the Database Includes:

### Tables:
- **admin_users**: Admin authentication (default login: admin/admin123)
- **services**: Service catalog with 12 sample services across 5 categories
- **portfolio**: Project showcase with 4 sample projects
- **contact_leads**: Contact form submissions storage

### Sample Data:
- 1 admin user (admin/admin123)
- 12 services across categories: Advertising, Management, Creative, Technology, Outreach
- 4 portfolio projects
- Ready for contact form submissions

## Admin Access:
- **URL**: `/admin/login`
- **Username**: admin
- **Password**: admin123

Once the database is set up, your website will be fully functional!
