# Backend Architecture

## Architectural Pattern

Use an MVC-style PHP architecture that separates routing, controllers, models, views, configuration, middleware, and reusable services.

## Controllers

- `PropertyController`
- `LeadController`
- `CRMController`
- `BookingController`
- `AgentController`
- `CustomerController`
- `PaymentController`
- `WhatsAppController`
- `EmailController`
- `AuthController`

## Models

- `User`
- `Agent`
- `Property`
- `PropertyImage`
- `Lead`
- `LeadActivity`
- `Booking`
- `Transaction`
- `MessageTemplate`
- `Notification`

## Services

- Authentication service
- Authorization service
- Property search service
- Lead assignment service
- WhatsApp provider service
- Email service
- Razorpay payment service
- File upload service
- Report generation service

## Database

- MySQL 8
- Foreign keys for relational integrity
- Indexed fields for search filters and reporting
- Soft deletes for important business records
- Audit timestamps on critical tables

## Hostinger Compatibility

The backend should avoid long-running daemons and rely on PHP requests, MySQL, queues stored in database tables, and Hostinger cron jobs for scheduled automation.
