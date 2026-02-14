# Code Modernization Migration Guide

This guide helps you migrate from the security-hardened version to the modernized PSR-4 compliant version.

## Overview

This update modernizes the SF2 framework with:
- **PSR-4 autoloading** via Composer
- **Namespace support** for all core classes
- **camelCase method naming** following PSR standards
- **Type hints and return types** for PHP 7.4+
- **Vanilla JavaScript** replacing jQuery

## Breaking Changes

### 1. Composer Required

**Before**: Framework worked without any dependency manager
**After**: Composer is required for autoloading

### 2. Method Names Changed

All methods now use camelCase instead of PascalCase:

```php
// OLD (Before)
SecurityHeaders::SetSecurityHeaders();
Logger::Error('message');
$rateLimiter->CheckRateLimit();
CSRF::GetToken();
Validator::SanitizeString($input);
Cryptography::Encrypt($password);

// NEW (After)
use SF\Core\SecurityHeaders;
use SF\Libs\Logger;
use SF\Core\RateLimit;
use SF\Core\CSRF;
use SF\Libs\Validator;
use SF\Libs\Cryptography;

SecurityHeaders::setSecurityHeaders();
Logger::error('message');
$rateLimiter->checkRateLimit();
CSRF::getToken();
Validator::sanitizeString($input);
Cryptography::encrypt($password);
```

### 3. Namespaces Added

All classes now use namespaces:

```php
// OLD (Before)
$validator = new Validator();
$logger = new Logger();

// NEW (After)
use SF\Libs\Validator;
use SF\Libs\Logger;

$validator = new Validator();
$logger = new Logger();
```

### 4. jQuery Removed

Frontend now uses vanilla JavaScript:

```javascript
// OLD (Before - jQuery)
$('.element').hide();
$.ajax({
    url: '/api/endpoint',
    success: function(data) {
        console.log(data);
    }
});

// NEW (After - Vanilla JS)
document.querySelector('.element').style.display = 'none';
fetch('/api/endpoint')
    .then(response => response.json())
    .then(data => console.log(data));

// Or use the provided utilities
hide($('.element'));
ajax({
    url: '/api/endpoint',
    success: (data) => console.log(data)
});
```

## Migration Steps

### Step 1: Install Composer Dependencies

```bash
cd /path/to/sf
composer install
```

This will:
- Install PHP dependencies
- Generate the autoloader in `vendor/`
- Create `composer.lock` file

### Step 2: Update Your Custom Controllers

If you have custom controllers that extend the base Controller class, update them:

```php
// Before
class MyController extends Controller {
    public function MyMethod() {
        $this->CheckLogin('admin');
        // ...
    }
}

// After
namespace SF\Controller;

use SF\Core\Controller;

class MyController extends Controller {
    public function myMethod() {
        $this->checkLogin('admin');
        // ...
    }
}
```

### Step 3: Update Method Calls

Search your codebase for the old method names and update them:

```bash
# Find files that might need updates
grep -r "CheckLogin" Controller/
grep -r "SetSecurityHeaders" .
grep -r "Logger::" .
```

Update each occurrence:
- `CheckLogin` → `checkLogin`
- `CallModel` → `callModel`
- `SetSecurityHeaders` → `setSecurityHeaders`
- `Logger::Error` → `Logger::error`
- `Logger::Info` → `Logger::info`
- And so on...

### Step 4: Update Frontend JavaScript

Replace jQuery usage with vanilla JavaScript:

1. **Remove jQuery script tag** from your HTML:
```html
<!-- Remove this -->
<script src="static/js/jquery.js"></script>

<!-- Add this instead -->
<script src="static/js/vanilla-utils.js"></script>
```

2. **Update dashboard.js**:
```bash
# Backup the old file
cp static/js/dashboard.js static/js/dashboard-jquery-backup.js

# Replace with vanilla version
cp static/js/dashboard-vanilla.js static/js/dashboard.js
```

3. **Update custom JavaScript** files to use vanilla JS or the provided utilities.

### Step 5: Update View Files

If your views reference jQuery, update them:

```html
<!-- Before -->
<script>
$(document).ready(function() {
    $('#myForm').submit(function(e) {
        e.preventDefault();
        // handle submit
    });
});
</script>

<!-- After -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('myForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // handle submit
    });
});
</script>
```

### Step 6: Test Everything

After migration, test:

1. **PHP Side**:
   ```bash
   # Test autoloader
   php -r "require 'vendor/autoload.php'; echo 'Autoloader works!';"
   
   # Test a page
   php -S localhost:8000
   # Visit http://localhost:8000 in browser
   ```

2. **JavaScript Side**:
   - Open browser developer console
   - Check for JavaScript errors
   - Test all interactive features
   - Verify AJAX requests work

3. **Authentication**:
   - Test login functionality
   - Verify rate limiting still works
   - Check session management

## Complete Method Name Mapping

### SecurityHeaders
- `SetSecurityHeaders()` → `setSecurityHeaders()`
- `SetCORSHeaders()` → `setCorsHeaders()`

### RateLimit
- `CheckRateLimit()` → `checkRateLimit()`
- `RecordFailedAttempt()` → `recordFailedAttempt()`
- `ResetAttempts()` → `resetAttempts()`
- `GetClientIdentifier()` → `getClientIdentifier()` (private)
- `GetAttempts()` → `getAttempts()` (private)
- `SetAttempts()` → `setAttempts()` (private)

### CSRF
- `GenerateToken()` → `generateToken()`
- `GetToken()` → `getToken()`
- `ValidateToken()` → `validateToken()`
- `ValidateRequest()` → `validateRequest()`
- `GetTokenField()` → `getTokenField()`
- `GetTokenMeta()` → `getTokenMeta()`

### Logger
- `Info()` → `info()`
- `Warning()` → `warning()`
- `Error()` → `error()`
- `Critical()` → `critical()`
- `AuthAttempt()` → `authAttempt()`
- `SecurityEvent()` → `securityEvent()`
- `QueryLog()` → `queryLog()`

### Validator
- `SanitizeString()` → `sanitizeString()`
- `SanitizeHTML()` → `sanitizeHtml()`
- `EscapeOutput()` → `escapeOutput()`
- `ValidateEmail()` → `validateEmail()`
- `ValidateInteger()` → `validateInteger()`
- `ValidateURL()` → `validateUrl()`
- `SanitizeFilename()` → `sanitizeFilename()`
- `ValidateLength()` → `validateLength()`
- `SanitizeArray()` → `sanitizeArray()`
- `ValidateCSRFToken()` → `validateCsrfToken()`

### Cryptography
- `Encrypt()` → `encrypt()`
- `Hash()` → `hash()` (if exists)
- `Decrypt()` → `decrypt()` (if exists)

## Vanilla JavaScript Utilities

The framework now includes `vanilla-utils.js` with jQuery-like convenience functions:

```javascript
// DOM Ready
ready(function() {
    // Your code
});

// Element selection
const element = $('.my-class');  // Returns element or array
const elements = $('.multiple'); // Returns array if multiple

// AJAX
ajax({
    method: 'POST',
    url: '/api/endpoint',
    data: { key: 'value' },
    success: (data) => console.log(data),
    error: (error) => console.error(error)
});

// Dynamic script/style loading
loadScript('path/to/script.js', callback);
loadStyle('path/to/style.css');

// Class manipulation
addClass(element, 'active');
removeClass(element, 'active');
toggleClass(element, 'active');

// Show/Hide
show(element);
hide(element);

// Attributes
attr(element, 'data-id', '123');
const id = attr(element, 'data-id');
```

## Troubleshooting

### "Class not found" errors

**Problem**: `Fatal error: Class 'SF\Core\SecurityHeaders' not found`

**Solution**:
```bash
composer dump-autoload
```

### jQuery plugin errors

**Problem**: `$ is not defined` or plugins don't work

**Solution**: Some third-party plugins may still require jQuery. For these:
1. Keep jQuery for those specific plugins only
2. Or find vanilla JS alternatives
3. Or wrap the plugin initialization in a compatibility layer

### Type errors

**Problem**: `TypeError: Argument 1 must be of type string`

**Solution**: The new type hints are strict. Ensure you're passing correct types:
```php
// Wrong
Logger::error(123);  // Type error!

// Correct
Logger::error((string)123);  // or
Logger::error('Error: ' . $errorCode);
```

## Rollback Plan

If you need to rollback to the non-modernized version:

```bash
# Rollback code
git checkout f3ab8d6  # Last commit before modernization

# Remove vendor directory
rm -rf vendor/

# Restore old JavaScript
git checkout f3ab8d6 -- static/js/dashboard.js
```

## Performance Impact

**Positive impacts**:
- ✅ Faster class loading with Composer's optimized autoloader
- ✅ Reduced HTTP requests (no jQuery = ~30KB saved)
- ✅ Better caching with native ES6 modules

**Neutral**:
- Minimal overhead from namespace resolution
- Type checking adds negligible runtime cost

## Support

For issues during migration:
1. Check `composer.log` for autoloader issues
2. Enable debug mode to see detailed errors
3. Check browser console for JavaScript errors
4. Review the complete code diff: `git diff f3ab8d6..HEAD`

## Summary

This modernization brings the framework up to current PHP standards while maintaining its minimalist philosophy. The main changes are:

- ✅ **PSR-4 autoloading** - Industry standard
- ✅ **Type safety** - Catch errors early
- ✅ **Better IDE support** - Autocomplete and type hints
- ✅ **Vanilla JS** - No jQuery dependency
- ✅ **Modern code** - PHP 7.4+ features

**Total migration time**: 2-4 hours for a typical project

---

**Version**: 2.0.0  
**Date**: 2026-02-14
