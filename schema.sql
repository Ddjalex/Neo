-- NEO Printing and Advertising Database Schema
-- PostgreSQL Database Setup

-- Admin Users Table
CREATE TABLE IF NOT EXISTS admin_users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Services Table
CREATE TABLE IF NOT EXISTS services (
    id SERIAL PRIMARY KEY,
    category VARCHAR(100) NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    order_position INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Portfolio Table
CREATE TABLE IF NOT EXISTS portfolio (
    id SERIAL PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    image_path VARCHAR(500),
    category VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Contact Leads Table
CREATE TABLE IF NOT EXISTS contact_leads (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    message TEXT,
    status VARCHAR(20) DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user (username: admin, password: admin123)
-- Password hash generated with PHP password_hash('admin123', PASSWORD_DEFAULT)
INSERT INTO admin_users (username, password_hash) 
VALUES ('admin', '$2y$10$RIu8YvzC2nP/gmTfJWTmw.2bZCMhGMdvuTGxh3xvcADzNBBcHGmVW')
ON CONFLICT (username) DO NOTHING;

-- Insert sample services
INSERT INTO services (category, title, description, order_position) VALUES
('Advertising', 'Digital Marketing', 'Comprehensive digital marketing solutions to boost your online presence', 1),
('Advertising', 'Print Advertising', 'High-quality print materials for all your advertising needs', 2),
('Advertising', 'Outdoor Advertising', 'Eye-catching billboards and outdoor displays', 3),
('Management', 'Brand Management', 'Strategic brand development and management services', 1),
('Management', 'Campaign Management', 'End-to-end marketing campaign planning and execution', 2),
('Creative', 'Graphic Design', 'Professional graphic design services for all media', 1),
('Creative', 'Content Creation', 'Engaging content creation for digital and print platforms', 2),
('Creative', 'Video Production', 'Professional video production and editing services', 3),
('Technology', 'Web Development', 'Custom website design and development', 1),
('Technology', 'Digital Solutions', 'Innovative digital technology solutions', 2),
('Outreach', 'Social Media Marketing', 'Strategic social media campaigns and management', 1),
('Outreach', 'Email Marketing', 'Targeted email marketing campaigns', 2)
ON CONFLICT DO NOTHING;

-- Insert sample portfolio projects
INSERT INTO portfolio (title, description, category) VALUES
('Corporate Brand Identity', 'Complete brand identity package for a leading corporate client', 'Branding'),
('Digital Marketing Campaign', 'Successful multi-channel digital marketing campaign', 'Digital Marketing'),
('Billboard Campaign', 'City-wide billboard advertising campaign', 'Outdoor Advertising'),
('Website Redesign', 'Modern website redesign for e-commerce platform', 'Web Development')
ON CONFLICT DO NOTHING;
