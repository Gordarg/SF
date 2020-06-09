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

// callbacks

function call_simplemde() {
    // Load MarkDown Editor
    new SimpleMDE({
        element: document.getElementsByName("body")[0],
        spellChecker: false,
    });
};

function call_uploader() {
    // Load the file uploader
    $('[type="file"]').ezdz();
};

function call_persiandatepicker(){
    // Make Date Inputs to Persian
    $("input[type=date]").attr('id', 'persianDate');
    $("input[type=date]").attr('type', 'text');
    $("input[id=persianDate]").persianDatepicker({
        months: ["فروردین", "اردیبهشت", "خرداد", "تیر", "مرداد", "شهریور", "مهر", "آبان", "آذر", "دی", "بهمن", "اسفند"],
        dowTitle: ["شنبه", "یکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنج شنبه", "جمعه"],
        shortDowTitle: ["ش", "ی", "د", "س", "چ", "پ", "ج"],
        showGregorianDate: true,
        persianNumbers: !0,
        formatDate: "YYYY/MM/DD",
        selectedBefore: !1,
        selectedDate: null,
        startDate: null,
        endDate: null,
        prevArrow: '\u25c4',
        nextArrow: '\u25ba',
        theme: 'default',
        alwaysShow: !1,
        selectableYears: null,
        selectableMonths: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
        cellWidth: 40, // by px
        cellHeight: 30, // by px
        fontSize: 15, // by px                
        isRTL: !1,
        calendarPosition: {
            x: 0,
            y: 0,
        },
        onShow: function () { },
        onHide: function () { },
        onSelect: function () { 
            // alert($(target).attr("data-gdate"));
            }
    });
};


// Page load events
$(document).ready(function() {
    var fragmentidentifier = window.location.hash.substr(1);
    setgui(fragmentidentifier);
});
$(window).on('hashchange', function(e){
    var fragmentidentifier = window.location.hash.substr(1);
    setgui(fragmentidentifier);
});

// Function to change the view
function setgui(name, params = null){

    $('.content').html('');

    $('.content').load(baseurl + 'gui/view/' + name + '.htm', function() {
        $.getScript(baseurl + 'gui/js/' + name + '.js', function() {
            // Construct
            if (jQuery.isFunction(window[name]))
                window[name](params);
            
            // Recall UI plugins
            call_simplemde();
            call_uploader();
            call_persiandatepicker();
        });
    });
}