// Load File Uploader
loadStyle(baseurl + "gui/css/ezdz.css");
loadScript(baseurl + "gui/js/ezdz.js");

// Load MarkDown Editor
loadStyle(baseurl + "gui/css/simplemde.css");
loadScript(baseurl + "gui/js/simplemde.js");

// Make Date Inputs to Persian
loadScript(baseurl + "static/js/persianDatePicker.js");

function setgui(name, params = null){

    $('.content').html('');

    $('.content').load(baseurl + 'gui/view/' + name + '.htm', function() {
        $.getScript(baseurl + 'gui/js/' + name + '.js', function() {
            // Construct
            if (jQuery.isFunction(window[name]))
                window[name](params);

            // Load MarkDown Editor
            new SimpleMDE({
                element: document.getElementsByName("body")[0],
                spellChecker: false,
            });
            $('[type="file"]').ezdz();
            
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
            
        });
    });
}

var fragmentidentifier = window.location.hash.substr(1);
setgui(fragmentidentifier);

$(window).on('hashchange', function(e){
    var fragmentidentifier = window.location.hash.substr(1);
    setgui(fragmentidentifier);
});