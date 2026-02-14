# Migration Guide - Security Hardening Update

This guide helps you migrate from the previous version to the security-hardened version of SF2.

## Overview

This update implements comprehensive security improvements while maintaining backward compatibility where possible. However, some manual steps are required during migration.

## Pre-Migration Checklist

- [ ] **Backup your database** (essential!)
- [ ] **Backup your current installation**
- [ ] **Document your current configuration** (from `Core/Config.php`)
- [ ] **Test the migration in a development environment first**

## Migration Steps

### 1. Update Code

Pull the latest changes from the repository:

```bash
git pull origin main
```

Or download and extract the latest release.

### 2. Configuration Migration

**CRITICAL**: The `Core/Config.php` file is no longer tracked in git.

1. **Save your current configuration**:
   ```bash
   cp Core/Config.php Core/Config.backup.php
   ```

2. **Copy the new sample configuration**:
   ```bash
   cp Core/Config.Sample.php Core/Config.php
   ```

3. **Restore your settings** from `Core/Config.backup.php`:
   - Database credentials
   - Application name
   - Root URL (change to HTTPS!)
   - Mail server settings
   - **Set `_Debug` to `false` for production**

4. **Add new configuration** (required):
   ```php
   // CORS whitelist - replace with your actual domains
   define('_CORSOrigins', [
       'https://yourdomain.com',
       'https://app.yourdomain.com'
   ]);
   ```

5. **Set proper file permissions**:
   ```bash
   chmod 600 Core/Config.php  # Restrict access
   ```

### 3. Database Migration (UTF-8mb4)

**IMPORTANT**: Backup your database before running these commands!

The framework now uses UTF-8mb4 for full Unicode support. Migrate your existing database:

```sql
-- Connect to MySQL
mysql -u root -p

-- Select your database
USE your_database_name;

-- Check current charset
SELECT DEFAULT_CHARACTER_SET_NAME, DEFAULT_COLLATION_NAME
FROM information_schema.SCHEMATA 
WHERE SCHEMA_NAME = 'your_database_name';

-- Backup: Export before changing
-- mysqldump -u root -p your_database_name > backup_before_utf8mb4.sql

-- Convert database
ALTER DATABASE your_database_name 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Convert all tables (run for each table)
ALTER TABLE table_name 
CONVERT TO CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- To get a list of all tables:
SELECT TABLE_NAME 
FROM information_schema.TABLES 
WHERE TABLE_SCHEMA = 'your_database_name';

-- Or use this script to generate ALTER commands for all tables:
SELECT CONCAT('ALTER TABLE ', TABLE_NAME, 
              ' CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;')
FROM information_schema.TABLES 
WHERE TABLE_SCHEMA = 'your_database_name' 
  AND TABLE_TYPE = 'BASE TABLE';
```

### 4. Create Logs Directory

Create the logs directory with proper permissions:

```bash
mkdir -p Logs
chmod 755 Logs
```

The `.htaccess` and `.gitkeep` files should already be in place.

### 5. SSL/HTTPS Setup (Production Only)

If not already using HTTPS, set it up now:

1. **Obtain SSL certificate** (free from Let's Encrypt):
   ```bash
   sudo apt install certbot python3-certbot-apache
   sudo certbot --apache -d yourdomain.com
   ```

2. **Update Apache configuration** to force HTTPS:
   ```apache
   <VirtualHost *:80>
       ServerName yourdomain.com
       Redirect permanent / https://yourdomain.com/
   </VirtualHost>
   ```

3. **Update `Core/Config.php`**:
   ```php
   define('_Root', 'https://yourdomain.com/');
   ```

4. **Update `static/js/config.js`**:
   ```javascript
   const baseurl = 'https://yourdomain.com/';
   ```

### 6. Update .htaccess (If Modified)

If you've customized your `.htaccess` file, ensure it includes:

```apache
# For HTTP Basic Authentication to work properly
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
```

### 7. File Manager Removal

The file manager has been removed for security reasons. If you were using it:

1. **Backup uploaded files**:
   ```bash
   cp -r Uploads/ Uploads.backup/
   ```

2. **Alternative**: Use FTP/SFTP or implement a secure custom file manager if needed

### 8. Update Session Handling

The framework now uses secure session management. No action required unless you have custom session code.

**Note**: Users will need to log in again after the update due to session changes.

### 9. Test the Migration

After updating, test the following:

```bash
# 1. Test PHP syntax
php -l index.php

# 2. Test configuration
php -r "
include 'Core/Config.php';
echo 'Config loaded successfully!' . PHP_EOL;
echo 'Debug mode: ' . (_Debug ? 'ON' : 'OFF') . PHP_EOL;
echo 'Database: ' . _DatabaseName . PHP_EOL;
"

# 3. Check file permissions
ls -la Core/Config.php
ls -la Logs/
```

### 10. Browser Testing

1. Visit your site in a browser
2. Check that HTTPS redirect works (if applicable)
3. Test authentication:
   - Try logging in with correct credentials
   - Try 5+ failed login attempts to test rate limiting
   - Verify successful login works
4. Check browser console for JavaScript errors
5. Test admin panel functionality

### 11. Security Verification

Verify security headers are present:

```bash
# Check security headers
curl -I https://yourdomain.com/

# Should include:
# - Content-Security-Policy
# - X-Frame-Options
# - X-Content-Type-Options
# - X-XSS-Protection
# - Referrer-Policy
```

Or use browser Developer Tools → Network → Headers

## Post-Migration

### Environment Variables (Optional but Recommended)

For better security, use environment variables instead of hardcoded values:

1. **Create environment file** (outside web root):
   ```bash
   sudo nano /etc/sf2-env.conf
   ```

2. **Add variables**:
   ```bash
   export DB_HOST="localhost"
   export DB_USER="sf2_user"
   export DB_PASSWORD="your_secure_password"
   export DB_NAME="sf2"
   export SF_DEBUG="false"
   export SF_ROOT_URL="https://yourdomain.com/"
   ```

3. **Load in Apache** (add to virtual host):
   ```apache
   SetEnv DB_HOST localhost
   SetEnv DB_USER sf2_user
   SetEnv DB_PASSWORD your_secure_password
   ```

### Monitor Logs

After migration, monitor logs for issues:

```bash
# Watch application logs
tail -f Logs/app.log

# Watch authentication logs
tail -f Logs/auth.log

# Watch security logs
tail -f Logs/security.log

# Apache error logs
tail -f /var/log/apache2/error.log
```

### Update Documentation

Update any custom documentation to reflect:
- New configuration process
- HTTPS requirement
- CORS configuration
- Removed file manager

## Troubleshooting

### Config File Not Found

**Error**: "Configuration file not found. Please copy Core/Config.Sample.php to Core/Config.php"

**Solution**:
```bash
cp Core/Config.Sample.php Core/Config.php
# Then edit Core/Config.php with your settings
```

### Database Connection Failed

**Error**: "Database connection failed"

**Solution**:
1. Check database credentials in `Core/Config.php`
2. Ensure MySQL is running: `sudo systemctl status mysql`
3. Check database exists: `mysql -u root -p -e "SHOW DATABASES;"`
4. Verify utf8mb4 support: `mysql -u root -p -e "SHOW CHARACTER SET LIKE 'utf8mb4';"`

### Rate Limiting Issues

**Error**: "Too many failed login attempts"

**Solution**:
1. Wait 15 minutes for lockout to expire
2. Or clear rate limit data:
   ```bash
   # If using file storage
   rm /tmp/sf_rate_limit.json
   
   # If using APCu
   sudo service apache2 restart
   ```

### HTTPS Redirect Loop

**Error**: Browser shows "Too many redirects"

**Solution**:
1. Check if your reverse proxy/load balancer is handling SSL
2. Add to `index.php` before HTTPS check:
   ```php
   // If behind load balancer/proxy
   if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && 
       $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
       $_SERVER['HTTPS'] = 'on';
   }
   ```

### CORS Issues

**Error**: "CORS policy: No 'Access-Control-Allow-Origin' header"

**Solution**:
1. Add your domain to CORS whitelist in `Core/Config.php`:
   ```php
   define('_CORSOrigins', ['https://yourdomain.com']);
   ```
2. Clear browser cache
3. Test with: `curl -H "Origin: https://yourdomain.com" -I https://yourapi.com/`

### Character Encoding Issues

**Problem**: Existing data shows garbled characters after utf8mb4 migration

**Solution**:
1. Data may have been incorrectly stored as latin1
2. Try this SQL to convert:
   ```sql
   -- For each text column:
   UPDATE table_name 
   SET column_name = CONVERT(CAST(CONVERT(column_name USING latin1) AS BINARY) USING utf8mb4);
   ```
3. If data is corrupted, restore from backup and retry migration carefully

## Rollback Plan

If you need to rollback:

1. **Restore code**:
   ```bash
   git checkout previous_version_tag
   ```

2. **Restore database**:
   ```bash
   mysql -u root -p database_name < backup_before_migration.sql
   ```

3. **Restore configuration**:
   ```bash
   cp Core/Config.backup.php Core/Config.php
   ```

## Support

If you encounter issues during migration:

1. Check the logs: `Logs/app.log`, `Logs/auth.log`
2. Review `SECURITY.md` for configuration details
3. Open an issue on GitHub with:
   - Migration step where issue occurred
   - Error messages from logs
   - PHP and MySQL versions
   - Server environment details

## Summary

This migration adds critical security features while maintaining the framework's simplicity. The main changes are:

- ✅ Configuration file now ignored by git (manual setup required)
- ✅ Database uses utf8mb4 (one-time migration needed)
- ✅ HTTPS enforcement in production (SSL setup required)
- ✅ CORS whitelist configuration (domains must be specified)
- ✅ File manager removed (alternative solution may be needed)

**Total estimated migration time**: 30-60 minutes

**Difficulty**: Intermediate (database migration requires SQL knowledge)

---

**Last Updated**: 2026-02-14
**Applies to**: SF2 Security Hardening Update
