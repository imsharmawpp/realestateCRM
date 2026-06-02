-- Demo data for first Hostinger test.
-- Admin login: admin@example.com / Admin@12345

INSERT INTO users (name, email, mobile, password_hash, role, status, email_verified_at, mobile_verified_at, created_at, updated_at) VALUES
('Super Admin', 'admin@example.com', '9999999999', '$2y$12$sd5sxrs6RJ7TO5FNVRXfAuR7RfGLPK2CoEtMdiRLycl.knZal4W..', 'super_admin', 'active', NOW(), NOW(), NOW(), NOW());

INSERT INTO agents (agent_name, mobile, email, license_number, commission_rate, service_city, status, created_at, updated_at) VALUES
('Amit Sharma', '9876543210', 'amit@example.com', 'RERA-MH-1001', 1.50, 'Mumbai', 'active', NOW(), NOW()),
('Priya Nair', '9876543211', 'priya@example.com', 'RERA-KA-1002', 1.75, 'Bengaluru', 'active', NOW(), NOW()),
('Rahul Verma', '9876543212', 'rahul@example.com', 'RERA-DL-1003', 1.25, 'Delhi NCR', 'active', NOW(), NOW());

INSERT INTO properties (agent_id, title, slug, description, price, location, city, state, pincode, property_type, bhk, carpet_area, built_up_area, furnishing_status, construction_status, possession_date, status, featured_image, amenities, meta_title, meta_description, created_at, updated_at) VALUES
(1, 'Premium 3 BHK Sea View Apartment', 'premium-3-bhk-sea-view-apartment', 'Luxury apartment with sea-facing balcony, modular kitchen, clubhouse access and excellent connectivity to business districts.', 28500000, 'Worli', 'Mumbai', 'Maharashtra', '400018', 'Apartment', 3, 1250, 1650, 'Semi Furnished', 'Ready To Move', NULL, 'Available', 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1200&q=80', 'Clubhouse, Gym, Pool, Sea View, Parking, Security', '3 BHK Sea View Apartment in Worli', 'Premium 3 BHK apartment in Worli, Mumbai with sea view and luxury amenities.', NOW(), NOW()),
(2, 'Modern Villa Near Tech Park', 'modern-villa-near-tech-park', 'Independent villa in a gated community with private garden, servant room, smart home provisions and quick access to IT corridors.', 19500000, 'Whitefield', 'Bengaluru', 'Karnataka', '560066', 'Villa', 4, 2400, 3200, 'Unfurnished', 'Ready To Move', NULL, 'Available', 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80', 'Garden, Clubhouse, Parking, Security, Power Backup', '4 BHK Villa in Whitefield', 'Modern villa near Bengaluru tech parks with gated community amenities.', NOW(), NOW()),
(3, 'Commercial Office Space on Main Road', 'commercial-office-space-on-main-road', 'Road-facing office space suitable for startups, clinics, consultants or retail office operations with high visibility.', 12000000, 'Sector 62', 'Noida', 'Uttar Pradesh', '201309', 'Commercial', NULL, 900, 1150, 'Bare Shell', 'Ready To Move', NULL, 'Available', 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1200&q=80', 'Lift, Parking, Power Backup, Main Road, Security', 'Commercial Office Space in Noida', 'Commercial office space in Noida Sector 62 with main-road visibility.', NOW(), NOW());

INSERT INTO leads (customer_name, mobile, email, property_id, assigned_agent_id, lead_source, lead_score, lead_status, message, next_follow_up_at, created_at, updated_at) VALUES
('Demo Customer', '9000000001', 'customer@example.com', 1, 1, 'Website', 80, 'New Lead', 'Interested in site visit this weekend.', DATE_ADD(NOW(), INTERVAL 1 DAY), NOW(), NOW());

INSERT INTO crm_activities (lead_id, agent_id, activity_type, remarks, next_follow_up_at, created_at) VALUES
(1, 1, 'Lead Created', 'Website enquiry captured and assigned to Amit Sharma.', DATE_ADD(NOW(), INTERVAL 1 DAY), NOW());
