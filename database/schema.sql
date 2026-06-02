-- Hostinger-compatible MySQL schema for Real Estate CRM.
-- Import this file first, then import database/seed.sql.

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS automation_logs;
DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS crm_activities;
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS leads;
DROP TABLE IF EXISTS property_media;
DROP TABLE IF EXISTS properties;
DROP TABLE IF EXISTS agents;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(160) NOT NULL UNIQUE,
    mobile VARCHAR(30) NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('super_admin','admin','manager','agent','customer') NOT NULL DEFAULT 'customer',
    status ENUM('active','inactive','blocked') NOT NULL DEFAULT 'active',
    email_verified_at DATETIME NULL,
    mobile_verified_at DATETIME NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    INDEX idx_users_role_status (role, status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE agents (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    agent_name VARCHAR(120) NOT NULL,
    mobile VARCHAR(30) NOT NULL,
    email VARCHAR(160) NULL,
    license_number VARCHAR(80) NULL,
    commission_rate DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    service_city VARCHAR(120) NULL,
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    CONSTRAINT fk_agents_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_agents_city_status (service_city, status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE properties (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    agent_id BIGINT UNSIGNED NULL,
    title VARCHAR(220) NOT NULL,
    slug VARCHAR(240) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    price DECIMAL(14,2) NOT NULL DEFAULT 0.00,
    location VARCHAR(180) NOT NULL,
    city VARCHAR(120) NOT NULL,
    state VARCHAR(120) NOT NULL,
    pincode VARCHAR(12) NULL,
    property_type VARCHAR(80) NOT NULL,
    bhk INT NULL,
    carpet_area DECIMAL(10,2) NULL,
    built_up_area DECIMAL(10,2) NULL,
    furnishing_status VARCHAR(80) NULL,
    construction_status VARCHAR(80) NULL,
    possession_date DATE NULL,
    status ENUM('Available','Reserved','Sold','Rented','Inactive') NOT NULL DEFAULT 'Available',
    featured_image VARCHAR(500) NULL,
    amenities TEXT NULL,
    meta_title VARCHAR(220) NULL,
    meta_description VARCHAR(320) NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    CONSTRAINT fk_properties_agent FOREIGN KEY (agent_id) REFERENCES agents(id) ON DELETE SET NULL,
    INDEX idx_properties_search (city, property_type, bhk, status),
    INDEX idx_properties_price (price)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE property_media (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    property_id BIGINT UNSIGNED NOT NULL,
    media_type ENUM('image','video','floor_plan','brochure') NOT NULL DEFAULT 'image',
    file_path VARCHAR(500) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL,
    CONSTRAINT fk_property_media_property FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE leads (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(140) NOT NULL,
    mobile VARCHAR(30) NOT NULL,
    email VARCHAR(160) NULL,
    property_id BIGINT UNSIGNED NULL,
    assigned_agent_id BIGINT UNSIGNED NULL,
    lead_source VARCHAR(80) NOT NULL DEFAULT 'Website',
    lead_score INT NOT NULL DEFAULT 0,
    lead_status ENUM('New Lead','Contacted','Follow Up','Site Visit','Negotiation','Booked','Closed','Lost') NOT NULL DEFAULT 'New Lead',
    message TEXT NULL,
    next_follow_up_at DATETIME NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    CONSTRAINT fk_leads_property FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE SET NULL,
    CONSTRAINT fk_leads_agent FOREIGN KEY (assigned_agent_id) REFERENCES agents(id) ON DELETE SET NULL,
    INDEX idx_leads_status_followup (lead_status, next_follow_up_at),
    INDEX idx_leads_mobile (mobile),
    INDEX idx_leads_source (lead_source)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE bookings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    property_id BIGINT UNSIGNED NOT NULL,
    customer_id BIGINT UNSIGNED NULL,
    agent_id BIGINT UNSIGNED NULL,
    customer_name VARCHAR(140) NOT NULL,
    mobile VARCHAR(30) NOT NULL,
    booking_amount DECIMAL(14,2) NOT NULL DEFAULT 0.00,
    total_amount DECIMAL(14,2) NOT NULL DEFAULT 0.00,
    payment_status ENUM('Pending','Paid','Failed','Refunded') NOT NULL DEFAULT 'Pending',
    booking_status ENUM('Draft','Pending Payment','Confirmed','Cancelled','Refunded','Completed') NOT NULL DEFAULT 'Pending Payment',
    agreement_file VARCHAR(500) NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    CONSTRAINT fk_bookings_property FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE,
    CONSTRAINT fk_bookings_customer FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT fk_bookings_agent FOREIGN KEY (agent_id) REFERENCES agents(id) ON DELETE SET NULL,
    INDEX idx_bookings_status (booking_status, payment_status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE transactions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    booking_id BIGINT UNSIGNED NOT NULL,
    payment_gateway VARCHAR(80) NOT NULL DEFAULT 'Razorpay',
    gateway_order_id VARCHAR(160) NULL,
    gateway_payment_id VARCHAR(160) NULL,
    amount DECIMAL(14,2) NOT NULL,
    currency CHAR(3) NOT NULL DEFAULT 'INR',
    payment_status ENUM('created','authorized','captured','failed','refunded') NOT NULL DEFAULT 'created',
    invoice_number VARCHAR(80) NULL,
    paid_at DATETIME NULL,
    created_at DATETIME NOT NULL,
    CONSTRAINT fk_transactions_booking FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
    INDEX idx_transactions_gateway (gateway_order_id, gateway_payment_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE crm_activities (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    lead_id BIGINT UNSIGNED NOT NULL,
    agent_id BIGINT UNSIGNED NULL,
    activity_type VARCHAR(80) NOT NULL,
    remarks TEXT NOT NULL,
    next_follow_up_at DATETIME NULL,
    created_at DATETIME NOT NULL,
    CONSTRAINT fk_crm_activities_lead FOREIGN KEY (lead_id) REFERENCES leads(id) ON DELETE CASCADE,
    CONSTRAINT fk_crm_activities_agent FOREIGN KEY (agent_id) REFERENCES agents(id) ON DELETE SET NULL,
    INDEX idx_crm_activities_lead_created (lead_id, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE automation_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    lead_id BIGINT UNSIGNED NULL,
    booking_id BIGINT UNSIGNED NULL,
    channel ENUM('whatsapp','email','sms') NOT NULL,
    template_name VARCHAR(120) NULL,
    recipient VARCHAR(160) NOT NULL,
    status ENUM('queued','sent','failed') NOT NULL DEFAULT 'queued',
    provider_response TEXT NULL,
    sent_at DATETIME NULL,
    created_at DATETIME NOT NULL,
    CONSTRAINT fk_automation_logs_lead FOREIGN KEY (lead_id) REFERENCES leads(id) ON DELETE SET NULL,
    CONSTRAINT fk_automation_logs_booking FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE SET NULL,
    INDEX idx_automation_logs_status (channel, status, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
