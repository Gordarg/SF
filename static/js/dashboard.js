// Call MarkDown Editor
function call_simplemde() {
    
    if (!loaded_simplemde)
        loaded_simplemde = true;
    // else return;
    
    new SimpleMDE({
        element: document.getElementsByName("body")[0],
        spellChecker: false,
    });
};

// Call file uploader
function call_uploader() {
    if (!loaded_uploader)
        loaded_uploader = true;
    // else return;

    $('[type="file"]').ezdz();
};

// Call persianDatepicker
function call_persiandatepicker(){
    if (!loaded_persianDatepicker)
        loaded_persianDatepicker = true;
    // else return;

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

// Call dropdown list
function call_dropdownlist() {
    if (!loaded_dropdownlist)
        loaded_dropdownlist = true;
    // else return;

    $('select').select2();
};

// =================================================================

// Change the view
var fragmentidentifier = window.location.hash.substr(1);
setgui(fragmentidentifier);

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

// Recall UI plugins
var loaded_dropdownlist = false, loaded_simplemde = false, loaded_uploader = false, loaded_datatables = false, loaded_persianDatepicker = false;


$(window).on('hashchange', function(e){    
    var fragmentidentifier = window.location.hash.substr(1);
    setgui(fragmentidentifier);

    // $.when(
    //     setgui(fragmentidentifier),
    //     // Deferred
    //     $.Deferred(function(deferred) {
    //         $(deferred.resolve);
    //     })
    // ).done(function(){
    //     console.log(fragmentidentifier)
    // });

});


// =================================================================


// Set view function
function setgui(name, params = null){

    $('.content').load(baseurl + 'gui/view/' + name + '.htm', function() {
        $.getScript(baseurl + 'gui/js/' + name + '.js').done(function(script, textstatus) {
            // Construct
            if (jQuery.isFunction(window[name]))
                window[name](params);
            
            // Call plugins
            loaded_dropdownlist = false, loaded_simplemde = false, loaded_uploader = false, loaded_datatables = false, loaded_persianDatepicker = false;

            call_uploader();
            call_simplemde();
            call_dropdownlist();
            call_persiandatepicker();
        });
    });
}