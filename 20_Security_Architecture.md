# Security

## Authentication

- Secure login
- Password hashing
- Password reset tokens
- Optional 2FA authentication
- Session timeout

## Authorization

- Role-based access control
- Route-level permission checks
- Object-level checks for assigned leads and properties
- Admin-only configuration access

## Application Protection

- SQL injection protection with prepared statements
- XSS protection with output escaping
- CSRF protection for forms
- Rate limiting for login and lead forms
- Secure file upload validation
- Input validation and sanitization

## Data Protection

- HTTPS-only production deployment
- Environment-based secrets
- No secrets committed to repository
- Database backups
- Audit logs for important changes

## Payment Security

- Razorpay signature verification
- Webhook signature validation
- No card data storage
- Transaction status reconciliation
