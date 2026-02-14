# Security Documentation

This document describes the security measures implemented in the SF2 framework.

## Table of Contents

1. [Configuration Security](#configuration-security)
2. [Authentication & Authorization](#authentication--authorization)
3. [Input Validation & Output Escaping](#input-validation--output-escaping)
4. [Database Security](#database-security)
5. [Session Management](#session-management)
6. [Security Headers](#security-headers)
7. [CORS Policy](#cors-policy)
8. [HTTPS Enforcement](#https-enforcement)
9. [Rate Limiting](#rate-limiting)
10. [CSRF Protection](#csrf-protection)
11. [Logging & Monitoring](#logging--monitoring)
12. [Production Deployment Checklist](#production-deployment-checklist)

---

## Configuration Security

### Sensitive Configuration Files

The `Core/Config.php` file contains sensitive information (database credentials, API keys) and is:
- **Excluded from version control** via `.gitignore`
- **Must be created manually** on each deployment from `Core/Config.Sample.php`

### Setup Instructions

1. Copy the sample configuration:
   ```bash
   cp Core/Config.Sample.php Core/Config.php
   ```

2. Edit `Core/Config.php` with your production values:
   - Set `_Debug` to `false` in production
   - Use strong, unique database passwords
   - Configure allowed CORS origins
   - Use HTTPS URLs for `_Root`

### Environment Variables (Recommended)

Instead of hardcoding sensitive values, use environment variables:

```php
// Database configuration via environment variables
define('_DatabaseServer', getenv('DB_HOST') ?: 'localhost');
define('_DatabaseUsername', getenv('DB_USER') ?: 'root');
define('_DatabasePassword', getenv('DB_PASSWORD') ?: '');
define('_DatabaseName', getenv('DB_NAME') ?: 'SF2');

// Application configuration
define('_Debug', getenv('SF_DEBUG') === 'true' ? true : false);
define('_Root', getenv('SF_ROOT_URL') ?: 'https://localhost/SF/');
```

---

## Authentication & Authorization

### Rate Limiting

Brute force protection is implemented via `Core/RateLimit.php`:
- **5 failed attempts** allowed per IP address
- **15-minute lockout** after exceeding limit
- Uses APCu if available, falls back to file-based storage
- All authentication attempts are logged

### HTTP Basic Authentication

Primary authentication method for admin users:
- Credentials stored in `.htpasswd` using APR1-MD5 hashing
- Rate limiting prevents brute force attacks
- Failed attempts are logged to `Logs/auth.log`

### Session-Based Authentication

For cookie-based authentication:
- Sessions use secure cookie parameters (Secure, HttpOnly, SameSite)
- Session ID regenerated on successful login (prevents session fixation)
- 30-minute inactivity timeout
- Automatic session cleanup

---

## Input Validation & Output Escaping

### Input Validation

Use the `Validator` class (`Libs/Validator.php`) for all user inputs:

```php
// Sanitize string input
$username = Validator::SanitizeString($_POST['username']);

// Validate email
if (!Validator::ValidateEmail($_POST['email'])) {
    throw new Exception('Invalid email address');
}

// Validate integer
$id = Validator::ValidateInteger($_POST['id']);
if ($id === false) {
    throw new Exception('Invalid ID');
}

// Sanitize filename (prevent directory traversal)
$filename = Validator::SanitizeFilename($_FILES['upload']['name']);
```

### Output Escaping

**Always escape output** in view files to prevent XSS:

```php
<!-- WRONG: Direct output -->
<h1><?php echo $Data['Title'] ?></h1>

<!-- CORRECT: Escaped output -->
<h1><?php echo Validator::EscapeOutput($Data['Title']) ?></h1>

<!-- OR using htmlspecialchars directly -->
<h1><?php echo htmlspecialchars($Data['Title'], ENT_QUOTES, 'UTF-8') ?></h1>
```

---

## Database Security

### Character Encoding

All database connections use **UTF-8mb4** encoding:
- Full Unicode support (including emojis)
- Prevents encoding-related vulnerabilities
- Set in `Core/Model.php` lines 36 and 47

### Migration from latin1

If you have an existing database using `latin1`:

```sql
-- Backup your database first!

-- Convert database
ALTER DATABASE your_database_name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Convert tables (repeat for each table)
ALTER TABLE your_table_name CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Prepared Statements

The framework uses **PDO prepared statements** to prevent SQL injection:
- All queries in `Core/Model.php` use parameterized queries
- Values are bound with proper types (PDO::PARAM_INT for integers)
- Never concatenate user input into SQL queries

### SQL Injection Fix

Fixed critical bug in `Libs/ORM.php` line 219:
```php
// BEFORE (vulnerable - result not assigned):
str_replace("'", "\'", $value);

// AFTER (fixed):
$value = str_replace("'", "\'", $value);
```

---

## Session Management

### Secure Session Configuration

Sessions are configured with security best practices:

```php
session_set_cookie_params([
    'lifetime' => 0,           // Session cookie
    'path' => '/',
    'domain' => '',
    'secure' => true,          // HTTPS only
    'httponly' => true,        // No JavaScript access
    'samesite' => 'Strict'     // CSRF protection
]);
```

### Session Fixation Prevention

Session ID is regenerated on successful authentication:
```php
session_regenerate_id(true);
```

### Session Timeout

Sessions expire after 30 minutes of inactivity. Timeout is checked on each request in `Core/Controller.php`.

---

## Security Headers

All security headers are managed by `Core/SecurityHeaders.php`:

### Content Security Policy (CSP)
Restricts resource loading to prevent XSS attacks:
```
Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'...
```

### Other Headers
- **X-Frame-Options: DENY** - Prevents clickjacking
- **X-Content-Type-Options: nosniff** - Prevents MIME type sniffing
- **X-XSS-Protection: 1; mode=block** - Enables browser XSS protection
- **Referrer-Policy: strict-origin-when-cross-origin** - Controls referrer information

---

## CORS Policy

### Configuration

CORS origins are configured in `Core/Config.php`:

```php
// Wildcard (development only - not recommended for production)
define('_CORSOrigins', []);

// Production: Whitelist specific origins
define('_CORSOrigins', [
    'https://example.com',
    'https://app.example.com'
]);
```

### How It Works

1. If `_CORSOrigins` is empty, allows all origins (wildcard `*`)
2. If configured, only whitelisted origins are allowed
3. Credentials are enabled for whitelisted origins
4. Preflight requests (OPTIONS) are handled automatically

---

## HTTPS Enforcement

### Automatic Redirection

When `_Debug` is `false`, HTTP requests are automatically redirected to HTTPS:

```php
// In index.php
if (!_Debug && (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off')) {
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
    exit();
}
```

### Cookie Security

All cookies are set with `Secure` flag when HTTPS is detected, preventing transmission over HTTP.

---

## Rate Limiting

### Implementation

Rate limiting protects authentication endpoints from brute force attacks:

```php
$rateLimiter = new RateLimit();

// Check if rate limited (throws exception if exceeded)
$rateLimiter->CheckRateLimit();

// Record failed attempt
$rateLimiter->RecordFailedAttempt();

// Reset on successful login
$rateLimiter->ResetAttempts();
```

### Configuration

- **Maximum attempts**: 5 per IP address
- **Lockout duration**: 15 minutes (900 seconds)
- **Storage**: APCu (if available) or file-based fallback

### Customization

To change limits, edit `Core/RateLimit.php`:

```php
private $maxAttempts = 5;      // Change number of attempts
private $lockoutTime = 900;    // Change lockout time (seconds)
```

---

## CSRF Protection

### Setup

CSRF protection is available via `Core/CSRF.php`. Include it in forms:

```php
<!-- In your form -->
<form method="POST" action="/submit">
    <?php echo CSRF::GetTokenField(); ?>
    <!-- Other form fields -->
</form>
```

### Validation

Validate CSRF token in your controller:

```php
// Validate token (throws exception if invalid)
CSRF::ValidateRequest();

// Or validate manually
$token = $_POST['csrf_token'];
if (!CSRF::ValidateToken($token)) {
    throw new Exception('Invalid CSRF token');
}
```

### AJAX Requests

For AJAX, include the token in the page header:

```php
<!-- In your layout -->
<head>
    <?php echo CSRF::GetTokenMeta(); ?>
</head>
```

Then send it in AJAX requests:

```javascript
// Get token from meta tag
const token = document.querySelector('meta[name="csrf-token"]').content;

// Send in request header
fetch('/api/endpoint', {
    method: 'POST',
    headers: {
        'X-CSRF-Token': token,
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
});
```

---

## Logging & Monitoring

### Log Files

Logs are stored in the `Logs/` directory:
- `app.log` - General application logs
- `auth.log` - Authentication attempts
- `security.log` - Security events
- `queries.log` - Database queries (debug mode only)

### Log Levels

```php
Logger::Info('Informational message');
Logger::Warning('Warning message');
Logger::Error('Error message');
Logger::Critical('Critical error message');

// Specific loggers
Logger::AuthAttempt($username, $success);
Logger::SecurityEvent('Suspicious activity detected');
Logger::QueryLog($query, $executionTime); // Debug mode only
```

### Log Protection

- Logs are protected by `.htaccess` (HTTP access denied)
- Log directory is not web-accessible
- Sensitive data should not be logged in production

### Log Rotation

Implement log rotation to prevent disk space issues:

```bash
# Example logrotate configuration
/path/to/SF/Logs/*.log {
    weekly
    rotate 4
    compress
    delaycompress
    notifempty
    create 0644 www-data www-data
}
```

---

## Production Deployment Checklist

### Before Deployment

- [ ] **Copy and configure** `Core/Config.php` from `Core/Config.Sample.php`
- [ ] **Set `_Debug` to `false`** in production
- [ ] **Use strong database passwords** (minimum 20 characters, random)
- [ ] **Configure CORS whitelist** (never use empty array in production)
- [ ] **Use HTTPS** for all URLs and enforce with redirect
- [ ] **Set up environment variables** for sensitive configuration
- [ ] **Create `Logs/` directory** with proper permissions (755)
- [ ] **Verify `.htaccess`** is protecting log files
- [ ] **Test rate limiting** is functioning
- [ ] **Enable session security** settings
- [ ] **Set up log rotation** to prevent disk space issues

### After Deployment

- [ ] **Test authentication** with correct and incorrect credentials
- [ ] **Verify HTTPS redirect** works correctly
- [ ] **Check security headers** are present (use browser dev tools)
- [ ] **Test CORS policy** with allowed and disallowed origins
- [ ] **Verify rate limiting** triggers after 5 failed attempts
- [ ] **Check logs** are being written correctly
- [ ] **Test session timeout** (wait 30 minutes of inactivity)
- [ ] **Verify CSRF protection** (if implemented)
- [ ] **Run security scan** (CodeQL, OWASP ZAP, etc.)

### Security Monitoring

- Monitor `Logs/auth.log` for suspicious authentication attempts
- Monitor `Logs/security.log` for security events
- Set up alerts for critical errors in `Logs/app.log`
- Regularly review access logs for unusual patterns
- Keep PHP and database software updated
- Regularly backup databases (encrypted backups)

### Performance Optimization

- Enable APCu for better rate limiting performance
- Use database query caching where appropriate
- Minimize queries in debug mode to reduce log file size
- Consider using a CDN for static assets
- Implement HTTP caching headers for static resources

---

## Reporting Security Issues

If you discover a security vulnerability, please email the maintainers directly rather than opening a public issue. Security issues should be disclosed responsibly to protect users.

---

## Additional Resources

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [PHP Security Guide](https://www.php.net/manual/en/security.php)
- [MySQL Security Best Practices](https://dev.mysql.com/doc/refman/8.0/en/security.html)
- [Content Security Policy Reference](https://content-security-policy.com/)

---

**Last Updated**: 2026-02-14
**Framework Version**: SF2
