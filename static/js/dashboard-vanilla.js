// Global variables
let simplemde = null;
let loaded_dropdownlist = false;
let loaded_simplemde = false;
let loaded_uploader = false;
let loaded_datatables = false;
let loaded_persianDatepicker = false;

// Call MarkDown Editor
function call_simplemde() {
    if (!loaded_simplemde) {
        loaded_simplemde = true;
    }
    
    const bodyElement = document.getElementsByName("body")[0];
    if (bodyElement) {
        simplemde = new SimpleMDE({
            element: bodyElement,
            spellChecker: false,
        });
    }
}

// Call file uploader
function call_uploader() {
    if (!loaded_uploader) {
        loaded_uploader = true;
    }

    const fileInputs = document.querySelectorAll('[type="file"]');
    if (fileInputs.length > 0 && typeof window.ezdz !== 'undefined') {
        fileInputs.forEach(input => {
            if (input.ezdz) {
                input.ezdz();
            }
        });
    }
}

// Call persianDatepicker
function call_persiandatepicker() {
    if (!loaded_persianDatepicker) {
        loaded_persianDatepicker = true;
    }

    const dateInputs = document.querySelectorAll("input[type=date]");
    dateInputs.forEach(input => {
        input.setAttribute('id', 'persianDate');
        input.setAttribute('type', 'text');
    });

    const persianDateInput = document.getElementById('persianDate');
    if (persianDateInput && typeof persianDateInput.persianDatepicker === 'function') {
        persianDateInput.persianDatepicker({
            months: ["فروردین", "اردیبهشت", "خرداد", "تیر", "مرداد", "شهریور", "مهر", "آبان", "آذر", "دی", "بهمن", "اسفند"],
            dowTitle: ["شنبه", "یکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنج شنبه", "جمعه"],
            shortDowTitle: ["ش", "ی", "د", "س", "چ", "پ", "ج"],
            showGregorianDate: true,
            persianNumbers: true,
            formatDate: "YYYY/MM/DD",
            selectedBefore: false,
            selectedDate: null,
            startDate: null,
            endDate: null,
            prevArrow: '\u25c4',
            nextArrow: '\u25ba',
            theme: 'default',
            alwaysShow: false,
            selectableYears: null,
            selectableMonths: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            cellWidth: 40,
            cellHeight: 30,
            fontSize: 15,
            isRTL: false,
            calendarPosition: {
                x: 0,
                y: 0,
            },
            onShow: function () { },
            onHide: function () { },
            onSelect: function () { }
        });
    }
}

// Call dropdown list
function call_dropdownlist() {
    if (!loaded_dropdownlist) {
        loaded_dropdownlist = true;
    }

    const selectElements = document.querySelectorAll('select');
    if (selectElements.length > 0 && typeof window.select2 !== 'undefined') {
        selectElements.forEach(select => {
            if (select.select2) {
                select.select2();
            }
        });
    }
}

// Parse URL fragment
function parseFragment() {
    const hash = window.location.hash.substr(1);
    let fragmentidentifier = hash;
    let parameter_1 = null;
    
    if (hash.indexOf('#') !== -1) {
        fragmentidentifier = hash.substr(0, hash.indexOf('#'));
        parameter_1 = hash.substr(hash.indexOf('#') + 1) || -1;
    }
    
    return { fragmentidentifier, parameter_1 };
}

// Set view function
function setgui(name, params = null) {
    // Set window title
    document.title = name;
    simplemde = null;

    // Get content container
    const contentElement = document.querySelector('.content');
    if (!contentElement) {
        console.error('Content element not found');
        return;
    }

    // Load partial HTML
    fetch(baseurl + 'gui/view/' + name + '.htm')
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to load view: ' + response.status);
            }
            return response.text();
        })
        .then(html => {
            contentElement.innerHTML = html;
            
            // Load and execute associated JavaScript
            return fetch(baseurl + 'gui/js/' + name + '.js');
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to load script: ' + response.status);
            }
            return response.text();
        })
        .then(script => {
            // Execute the script
            const scriptElement = document.createElement('script');
            scriptElement.textContent = script;
            document.body.appendChild(scriptElement);
            
            // Call constructor function if it exists
            if (typeof window[name] === 'function') {
                window[name](params);
            }
            
            // Reset plugin flags and call plugins
            loaded_dropdownlist = false;
            loaded_simplemde = false;
            loaded_uploader = false;
            loaded_datatables = false;
            loaded_persianDatepicker = false;

            call_uploader();
            call_simplemde();
            call_dropdownlist();
            call_persiandatepicker();
        })
        .catch(error => {
            console.error('Error loading view:', error);
            contentElement.innerHTML = '<div class="alert alert-danger">Failed to load content</div>';
        });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Parse initial fragment
    const { fragmentidentifier, parameter_1 } = parseFragment();
    setgui(fragmentidentifier, parameter_1);

    // Load File Uploader
    loadStyle(baseurl + "static/css/ezdz.css");
    loadScript(baseurl + "static/js/ezdz.js", call_uploader);

    // Load MarkDown Editor
    loadStyle(baseurl + "static/css/simplemde.css");
    loadScript(baseurl + "static/js/simplemde.js", call_simplemde);

    // Make Date Inputs to Persian
    loadScript(baseurl + "static/js/persianDatepicker.js", call_persiandatepicker);

    // Load Data Tables
    loadStyle(baseurl + "static/css/datatables.css");
    loadScript(baseurl + "static/js/datatables.js");

    // Load dropdown list
    loadStyle(baseurl + "static/css/select2.css");
    loadScript(baseurl + "static/js/select2.js", call_dropdownlist);

    // Handle hash change events
    window.addEventListener('hashchange', function(e) {
        const { fragmentidentifier, parameter_1 } = parseFragment();
        setgui(fragmentidentifier, parameter_1);
    });
});
