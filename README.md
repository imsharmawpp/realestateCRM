# Real Estate CRM System

A Hostinger-compatible PHP/MySQL real estate portal and CRM for Indian real estate businesses. The project now includes a runnable MVP application plus the full planning documentation suite.

## What You Can Test Now

- Public home page with featured properties and search.
- Public property listing and property detail pages.
- Enquiry capture that creates CRM leads.
- Property reservation/booking placeholder flow.
- Admin login and dashboard.
- Admin property CRUD with image URL/upload support.
- Admin lead pipeline with assignment, status updates and CRM activity timeline.
- Admin agent management.
- Admin booking tracking.
- JSON endpoints for properties and leads.

## Hostinger Quick Start

1. Upload the repository contents to your Hostinger `public_html` folder.
2. In Hostinger hPanel, create a MySQL database and database user.
3. Import `database/schema.sql` using phpMyAdmin.
4. Import `database/seed.sql` using phpMyAdmin.
5. Copy `.env.example` to `.env` and enter your Hostinger database credentials.
6. Update `APP_URL` in `.env` to your domain.
7. Make sure `public/uploads`, `storage/logs`, and `storage/cache` are writable.
8. Visit your domain and log in at `/admin/login`.

Demo admin credentials after importing the seed file:

```text
Email: admin@example.com
Password: Admin@12345
```

## Technical Stack

- **Frontend:** HTML5, CSS3, Bootstrap 5, JavaScript
- **Backend:** PHP 8.2+ with PDO MySQL
- **Database:** MySQL 8 / MariaDB-compatible InnoDB schema
- **Hosting:** Hostinger Shared Hosting or compatible Apache/PHP hosting
- **Integrations Ready:** WhatsApp click-to-chat, SMTP configuration, Razorpay configuration placeholders

## Important Production Notes

- Change the seeded admin password immediately after first login.
- Do not commit a real `.env` file with production credentials.
- Configure HTTPS before collecting customer details.
- Razorpay, SMTP and WhatsApp Business API are prepared as configuration areas, but provider-specific production credentials and webhook code should be added before accepting real payments or sending automated messages.

## Documentation Index

1. [Project Overview](01_Project_Overview.md)
2. [Business Requirements](02_Business_Requirements.md)
3. [User Roles and Permissions](03_User_Roles_and_Permissions.md)
4. [Frontend Architecture](04_Frontend_Architecture.md)
5. [Backend Architecture](05_Backend_Architecture.md)
6. [Database Schema](06_Database_Schema.md)
7. [Property Management Module](07_Property_Management_Module.md)
8. [CRM Module](08_CRM_Module.md)
9. [Agent Management Module](09_Agent_Management_Module.md)
10. [Lead Management Module](10_Lead_Management_Module.md)
11. [WhatsApp Integration](11_WhatsApp_Integration.md)
12. [Email Automation Module](12_Email_Automation_Module.md)
13. [Customer Portal](13_Customer_Portal.md)
14. [Agent Portal](14_Agent_Portal.md)
15. [Admin Dashboard](15_Admin_Dashboard.md)
16. [Property Booking System](16_Property_Booking_System.md)
17. [Payment Integration](17_Payment_Integration.md)
18. [SEO Module](18_SEO_Module.md)
19. [API Documentation](19_API_Documentation.md)
20. [Security Architecture](20_Security_Architecture.md)
21. [Hostinger Deployment](21_Hostinger_Deployment.md)
22. [UI/UX Guidelines](22_UI_UX_Guidelines.md)
23. [Testing Plan](23_Testing_Plan.md)
24. [Future Enhancements](24_Future_Enhancements.md)
