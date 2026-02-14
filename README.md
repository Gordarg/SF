# SnowFramework
===

![Tag](https://img.shields.io/github/tag-date/Gordarg/SnowFramework.svg)
![Release](https://img.shields.io/github/release/Gordarg/SnowFramework.svg)
![License](https://img.shields.io/github/license/Gordarg/SnowFramework.svg)
[![Donate](https://img.shields.io/badge/give-donation-yellow.svg)](https://zarinp.al/@tayyebi)
![Languages](https://img.shields.io/github/languages/count/Gordarg/SnowFramework.svg
)
![Downloads](https://img.shields.io/github/downloads/Gordarg/SnowFramework/total.svg)
![Issues](https://img.shields.io/github/issues/Gordarg/SnowFramework.svg)
![Pull requests](https://img.shields.io/github/issues-pr/Gordarg/SnowFramework.svg)
![Commit activity](https://img.shields.io/github/commit-activity/w/Gordarg/SnowFramework.svg)
![Gordarg followers](https://img.shields.io/github/followers/Gordarg.svg?style=social)
![Stars](https://img.shields.io/github/stars/Gordarg/SnowFramework.svg?style=social)
![Forks](https://img.shields.io/github/forks/Gordarg/SnowFramework.svg?style=social)
![Watchers](https://img.shields.io/github/watchers/Gordarg/SnowFramework.svg?style=social)

Director: Mohammad R. Tayyebi <smile@tyyi.net>

## 🔒 Security Notice

**IMPORTANT**: This framework has been hardened for production use. Please read [SECURITY.md](SECURITY.md) for complete security documentation and deployment guidelines.

## Overview

SF2 is a minimal, headless PHP framework designed for rapid API development with a focus on simplicity and security. It features:

- **Zero build tools** - No webpack, no transpilers, just PHP
- **Headless architecture** - Perfect for API-first applications
- **Production-ready security** - Rate limiting, CSRF protection, secure sessions, and more
- **Minimal dependencies** - No composer, no heavy frameworks
- **Simple routing** - Hash-based SPA routing with lazy-loaded JavaScript

# Installation & Setup

## 1. Install Apache-MySQL-PHP

```bash
apt install tasksel
tasksel install lamp-server
```

## 2. Configure MySQL

```bash
mysql_secure_installation
```

## 3. Give Apache Permissions

```bash
sudo chgrp -R www-data /var/www/html
sudo chmod -R 755 /var/www/html
```

## 4. Check Apache Installation

```bash
cd /var/www/html
echo "<?php phpinfo(); ?>" > info.php
wget http://localhost/info.php
rm info.php  # Remove after testing
```

## 5. Check PHP Version

**Minimum requirement: PHP 7.0+** (PHP 7.4+ recommended)

```bash
php --version
```

## 6. Create Database

```sql
mysql -u root -p
CREATE DATABASE SF2 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**Important**: Use `utf8mb4` character set for full Unicode support.

## 7. Execute Database Schema

Execute the SQL file from `docs/Download/my.sql` or your schema file:

```bash
mysql -u root -p SF2 < docs/Download/my.sql
```

## 8. Configure the Application

### 🔐 Security Setup (Critical)

1. **Copy configuration file**:
   ```bash
   cp Core/Config.Sample.php Core/Config.php
   ```

2. **Edit `Core/Config.php`** with your settings:
   ```php
   // Set to false in production
   define('_Debug', false);
   
   // Use HTTPS in production
   define('_Root', 'https://yourdomain.com/');
   
   // Database credentials
   define('_DatabaseServer', 'localhost');
   define('_DatabaseUsername', 'your_db_user');
   define('_DatabasePassword', 'your_strong_password');
   define('_DatabaseName', 'SF2');
   
   // CORS whitelist (never use empty array in production)
   define('_CORSOrigins', [
       'https://yourdomain.com',
       'https://app.yourdomain.com'
   ]);
   ```

3. **Set proper file permissions**:
   ```bash
   chmod 600 Core/Config.php  # Restrict access to config
   chmod 755 Logs/            # Logs directory
   ```

4. **Configure base URL** in `static/js/config.js`:
   ```javascript
   const baseurl = 'https://yourdomain.com/';
   ```

### Using Environment Variables (Recommended)

Instead of hardcoding sensitive values in `Core/Config.php`, use environment variables:

```bash
# In your .env file or server configuration
export DB_HOST="localhost"
export DB_USER="your_db_user"
export DB_PASSWORD="your_strong_password"
export DB_NAME="SF2"
export SF_DEBUG="false"
export SF_ROOT_URL="https://yourdomain.com/"
```

The configuration file will automatically use these if set.

## 9. Authentication Setup

### Create .htpasswd File

```bash
# Create password file for first user
htpasswd -c /var/www/html/SF/.htpasswd admin

# Add additional users (without -c flag)
htpasswd /var/www/html/SF/.htpasswd username
```

### Set Permissions

```bash
chmod 644 .htaccess
chmod 644 .htpasswd
```

### Edit .htaccess

Ensure the `.htpasswd` path in `.htaccess` points to the correct location.

## 10. Create Required Directories

```bash
# Create uploads directory
mkdir -p Uploads
chmod 755 Uploads

# Logs directory (should already exist)
chmod 755 Logs
```

## 11. Production Deployment Checklist

Before deploying to production, verify:

- [ ] `_Debug` is set to `false` in `Core/Config.php`
- [ ] Strong, unique database password is used (20+ characters)
- [ ] CORS origins are whitelisted (not empty array)
- [ ] HTTPS is enabled and enforced
- [ ] `.htpasswd` file has strong passwords
- [ ] `Core/Config.php` has restrictive permissions (600 or 640)
- [ ] SSL certificate is valid and up to date
- [ ] `Logs/` directory is not web-accessible (protected by `.htaccess`)
- [ ] Database is using `utf8mb4` character set
- [ ] PHP error display is disabled (`display_errors = Off` in php.ini)
- [ ] All file uploads are validated and sanitized
- [ ] Rate limiting is tested and working
- [ ] Security headers are present (check with browser dev tools)

**See [SECURITY.md](SECURITY.md) for complete production deployment checklist.**

# Security Features

This framework includes production-ready security features:

- ✅ **Rate Limiting** - Prevents brute force attacks (5 attempts, 15-min lockout)
- ✅ **Security Headers** - CSP, X-Frame-Options, X-Content-Type-Options, etc.
- ✅ **HTTPS Enforcement** - Automatic redirect in production
- ✅ **Session Security** - Secure cookies, session regeneration, timeout
- ✅ **Input Validation** - Built-in validator for sanitizing user input
- ✅ **Output Escaping** - Helpers to prevent XSS attacks
- ✅ **CSRF Protection** - Token-based CSRF protection
- ✅ **CORS Whitelist** - Configurable origin whitelist
- ✅ **UTF-8mb4** - Full Unicode support with proper encoding
- ✅ **Audit Logging** - Authentication and security event logging
- ✅ **SQL Injection Protection** - Parameterized queries with PDO

For detailed security documentation, see **[SECURITY.md](SECURITY.md)**.

# Development

## Debug Mode

Enable debug mode during development in `Core/Config.php`:

```php
define('_Debug', true);
```

This enables:
- Error display
- Detailed error messages
- Query logging (when implemented)
- Stack traces

**Never enable debug mode in production!**

## Code Style

- Follow existing code conventions
- Use meaningful variable names
- Add inline comments for complex logic
- Keep functions small and focused
- Document public methods

# **How to Contribute**

0. Install git from [git-scm.com](https://git-scm.com)
1. **Fork** the repository
2. **Clone** the project on your machine
3. Create a feature branch: `git checkout -b feature/your-feature-name`
4. Make your changes
5. Add tests if applicable
6. Commit your changes: `git commit -m "Add feature description"`
7. **Pull** before push: `git pull origin main`
8. Push: `git push origin feature/your-feature-name`
9. Create a **pull request**
10. Describe your changes clearly
11. Your commits will be reviewed and merged

## Security Contributions

If you discover a security vulnerability, please email the maintainers directly rather than opening a public issue.

# Documentation

All related documentation is located at **[docs/](http://gordarg.github.io/SF)**.

Additional documentation:
- [SECURITY.md](SECURITY.md) - Complete security documentation
- [TODO.md](TODO.md) - Planned features and improvements

# License

This project is licensed under the terms specified in [LICENCE](LICENCE).

# Support

- Report bugs via [GitHub Issues](https://github.com/Gordarg/SF/issues)
- Contribute via [Pull Requests](https://github.com/Gordarg/SF/pulls)
- Contact: Mohammad R. Tayyebi <smile@tyyi.net>

---

**Made with ❄️ by the SnowFramework team**

