/**
 * Vanilla JS Utilities
 * 
 * Provides jQuery-like convenience functions using vanilla JavaScript
 * Lightweight alternative to jQuery for modern browsers
 */

// DOM Ready function
function ready(fn) {
    if (document.readyState !== 'loading') {
        fn();
    } else {
        document.addEventListener('DOMContentLoaded', fn);
    }
}

// Element selection (similar to jQuery $())
function $(selector) {
    if (typeof selector === 'string') {
        const elements = document.querySelectorAll(selector);
        return elements.length === 1 ? elements[0] : Array.from(elements);
    }
    return selector;
}

// AJAX function (replaces jQuery.ajax)
function ajax(options) {
    const defaults = {
        method: 'GET',
        url: '',
        data: null,
        headers: {},
        success: null,
        error: null,
        complete: null
    };
    
    const settings = { ...defaults, ...options };
    
    // Build URL with query params for GET requests
    let url = settings.url;
    if (settings.method === 'GET' && settings.data) {
        const params = new URLSearchParams(settings.data);
        url += '?' + params.toString();
    }
    
    // Prepare fetch options
    const fetchOptions = {
        method: settings.method,
        headers: settings.headers
    };
    
    // Add body for non-GET requests
    if (settings.method !== 'GET' && settings.data) {
        if (settings.data instanceof FormData) {
            fetchOptions.body = settings.data;
        } else if (typeof settings.data === 'object') {
            fetchOptions.body = JSON.stringify(settings.data);
            fetchOptions.headers['Content-Type'] = 'application/json';
        } else {
            fetchOptions.body = settings.data;
        }
    }
    
    // Execute fetch request
    fetch(url, fetchOptions)
        .then(response => {
            if (!response.ok) {
                throw new Error('HTTP error ' + response.status);
            }
            return response.text();
        })
        .then(data => {
            if (settings.success) {
                settings.success(data);
            }
        })
        .catch(error => {
            if (settings.error) {
                settings.error(error);
            }
        })
        .finally(() => {
            if (settings.complete) {
                settings.complete();
            }
        });
}

// Load external script dynamically
function loadScript(url, callback) {
    const script = document.createElement('script');
    script.src = url;
    script.type = 'text/javascript';
    
    if (callback) {
        script.onload = callback;
        script.onerror = () => {
            console.error('Failed to load script:', url);
        };
    }
    
    document.head.appendChild(script);
}

// Load external stylesheet dynamically
function loadStyle(url) {
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = url;
    document.head.appendChild(link);
}

// Event delegation (replaces jQuery .on() for dynamic elements)
function on(element, eventType, selector, handler) {
    element.addEventListener(eventType, function(event) {
        const target = event.target.closest(selector);
        if (target) {
            handler.call(target, event);
        }
    });
}

// Add class to element(s)
function addClass(elements, className) {
    const els = Array.isArray(elements) ? elements : [elements];
    els.forEach(el => el.classList.add(className));
}

// Remove class from element(s)
function removeClass(elements, className) {
    const els = Array.isArray(elements) ? elements : [elements];
    els.forEach(el => el.classList.remove(className));
}

// Toggle class on element(s)
function toggleClass(elements, className) {
    const els = Array.isArray(elements) ? elements : [elements];
    els.forEach(el => el.classList.toggle(className));
}

// Set/Get element attribute
function attr(element, name, value) {
    if (value === undefined) {
        return element.getAttribute(name);
    }
    element.setAttribute(name, value);
}

// Show element(s)
function show(elements) {
    const els = Array.isArray(elements) ? elements : [elements];
    els.forEach(el => el.style.display = '');
}

// Hide element(s)
function hide(elements) {
    const els = Array.isArray(elements) ? elements : [elements];
    els.forEach(el => el.style.display = 'none');
}

// Check if function exists
function isFunction(obj) {
    return typeof obj === 'function';
}

// Export for module systems (if needed)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        ready,
        $,
        ajax,
        loadScript,
        loadStyle,
        on,
        addClass,
        removeClass,
        toggleClass,
        attr,
        show,
        hide,
        isFunction
    };
}
