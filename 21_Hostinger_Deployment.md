# Hostinger Deployment

## Current Deployment Status

The repository contains a runnable PHP/MySQL MVP that can be uploaded to Hostinger for testing. It includes the root `index.php` front controller, `.htaccess` routing, public assets, PHP views, CRM workflows, MySQL schema, demo seed data and environment configuration template.

## Requirements

- PHP 8.2+
- MySQL 8 or compatible MariaDB
- Apache with `.htaccess` rewrite support
- SSL certificate
- File upload permissions for `public/uploads`
- Writable `storage/logs` and `storage/cache` folders

## Upload Steps

1. Download or clone this repository.
2. Upload all files and folders to Hostinger `public_html`.
3. Confirm that `.htaccess` was uploaded; some file managers hide dotfiles. This file protects `.env`, `app`, `config`, `database`, and `storage` from public access.
4. In hPanel, create a MySQL database and user.
5. Open phpMyAdmin and import `database/schema.sql`.
6. Import `database/seed.sql`.
7. Copy `.env.example` to `.env`.
8. Add your Hostinger database host, database name, username and password to `.env`.
9. Set `APP_URL` to your domain, for example `https://example.com`.
10. Make `public/uploads`, `storage/logs`, and `storage/cache` writable if uploads fail.
11. Visit `/admin/login`.
12. Log in using the seeded admin account and immediately change it for production use.

## Demo Admin Account

```text
Email: admin@example.com
Password: Admin@12345
```

## Smoke Test Checklist

- Home page loads.
- `/properties` lists demo properties.
- A property detail page opens.
- Property enquiry form creates a CRM lead.
- `/admin/login` accepts the demo admin account.
- Admin dashboard shows metrics.
- Admin can create and edit a property.
- Admin can open a lead and add a CRM activity.
- Admin can create and edit an agent.
- Booking button creates a pending booking.

## Recommended Cron Jobs

The MVP does not require cron to load, but these cron jobs are recommended when automation queues are expanded:

- Lead follow-up reminders
- WhatsApp message queue processing
- Email queue processing
- Booking expiry checks
- Sitemap generation
- Daily backup trigger, if supported

## Production Checklist

- Change demo admin credentials.
- Enable SSL.
- Set `APP_DEBUG=false`.
- Keep `.env` private.
- Configure SMTP credentials before sending production emails.
- Configure WhatsApp provider credentials before template automation.
- Configure Razorpay keys and webhook verification before accepting real payments.
- Review file upload limits in Hostinger PHP settings.
- Export a database backup after initial setup.
