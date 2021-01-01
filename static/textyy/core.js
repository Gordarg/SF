// based on https://codepen.io/trhino/pen/xyLAu

jQuery.fn.extend({

    wysiwyg: function () {
        
        this.each(function(index) {
            // Init
            var selector = "textyy_" + index;
            $(this).after('<div class="textyy" id="' + selector + '"></div>');
            $('#'+selector).append($(this));
            // Make an instance of original editor
            var selector_input = selector+'>'+$(this).prop('tagName');
            editor = $('#'+selector_input);
            // Hide the original editor
            editor.hide();
            editor.addClass('textyy_editor');
            // Menu Items
            editor.before(`
            <div>
                <div>
                <a title="undo" data-role='undo' href='javascript:void(0);' onclick='textyy_action(this);'>واگرد</a>
                <a title="redo" data-role='redo' href='javascript:void(0);' onclick='textyy_action(this);'>تکرار</a>
                </div>
                <div>
                <a title="bold" data-role='bold' href='javascript:void(0);' onclick='textyy_action(this);'><b>برجسته</b></a>
                <a title="italic" data-role='italic' href='javascript:void(0);' onclick='textyy_action(this);'><em>یه‌وری</em></a>
                <a title="underline" data-role='underline' href='javascript:void(0);' onclick='textyy_action(this);'><u>زیر‌خط</u></a>
                <a title="strikeThrough" data-role='strikeThrough' href='javascript:void(0);' onclick='textyy_action(this);'><strike>خطی</strike></a>
                </div>
                <div>
                <a title="justify left" data-role='justifyLeft' href='javascript:void(0);' onclick='textyy_action(this);'>چپ</a>
                <a title="justify center" data-role='justifyCenter' href='javascript:void(0);' onclick='textyy_action(this);'>وسط</a>
                <a title="justify right" data-role='justifyRight' href='javascript:void(0);' onclick='textyy_action(this);'>راست</a>
                <a title="justify full" data-role='justifyFull' href='javascript:void(0);' onclick='textyy_action(this);'>تمام</a>
                </div>
                <div>
                <a title="indent" data-role='indent' href='javascript:void(0);' onclick='textyy_action(this);'>تورفتگی راست</a>
                <a title="outdent" data-role='outdent' href='javascript:void(0);' onclick='textyy_action(this);'>تو رفتگی چپ</a>
                </div>
                <div>
                <a title="insert unordered list" data-role='insertUnorderedList' href='javascript:void(0);' onclick='textyy_action(this);'>لیست</a>
                <a title="insert ordered list" data-role='insertOrderedList' href='javascript:void(0);' onclick='textyy_action(this);'>لیست شمارشی</a>
                </div>
                <div>
                <a title="h3" data-role='h3' href='javascript:void(0);' onclick='textyy_action(this);'>زیر‌تیتر<sup>۳</sup></a>
                <a title="h2" data-role='h2' href='javascript:void(0);' onclick='textyy_action(this);'>سر‌تیتر<sup>۲</sup></a>
                
                <a title="p" data-role='p' href='javascript:void(0);' onclick='textyy_action(this);'>پاراگراف</a>
                </div>
                <div>
                <a title="subscript" data-role='subscript' href='javascript:void(0);' onclick='textyy_action(this);'></a>
                <a title="superscript" data-role='superscript' href='javascript:void(0);' onclick='textyy_action(this);'></a>
                </div>
                <div>
                <a title="image" data-role='image' href='javascript:void(0);' onclick='textyy_action(this);'></a>
                <a title="video" data-role='video' href='javascript:void(0);' onclick='textyy_action(this);'></a>
                </div>
            </div>
            `);
            // Get former value
            var value = '';
            if (editor.prop('tagName') == 'TEXTAREA') {
                value = editor.val();
            } else if (editor.prop('tagName') == 'INPUT') {
                value = editor.val(); // TODO: Check this line
            }
            // New editor's canvas
            $('#'+selector_input).before('<div class="textyy_canvas" contenteditable>' + value  + '</div>');
        });
    }
});

function textyy_action(sender) {
    // Define edit canvas
    selector_parent = $(sender.target).parent().attr('id');
    var canvas = $('#'+selector_parent+ '>.textyy_canvas');

    // do the main action
    var role = $(sender).data('role');
    switch (role) {
        case 'image':
            document.execCommand('insertImage', false,
                prompt("آدرس تصویر:", "data:image/svg;base64,PHN2ZyBpZD0iQ2FwYV8xIiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCA1MTIuMDAxIDUxMi4wMDEiIGhlaWdodD0iNTEyIiB2aWV3Qm94PSIwIDAgNTEyLjAwMSA1MTIuMDAxIiB3aWR0aD0iNTEyIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnPjxwYXRoIGQ9Im01MTIuMDAxIDg0Ljg1My04NC44NTMtODQuODUzLTE3MS4xNDcgMTcxLjE0Ny0xNzEuMTQ4LTE3MS4xNDctODQuODUzIDg0Ljg1MyAxNzEuMTQ4IDE3MS4xNDctMTcxLjE0OCAxNzEuMTQ4IDg0Ljg1MyA4NC44NTMgMTcxLjE0OC0xNzEuMTQ3IDE3MS4xNDcgMTcxLjE0NyA4NC44NTMtODQuODUzLTE3MS4xNDgtMTcxLjE0OHoiLz48L2c+PC9zdmc+")
            );
            break;
        case 'h2':
        case 'h3':
        case 'p':
            document.execCommand('formatBlock', false, role);
            break;
        default:
            document.execCommand(role, false, null);
            break;
    }
}

// On canvas content changed
$('body').on('DOMSubtreeModified', '.textyy_canvas', function(sender){

    // Get input to update
    selector_parent = $(sender.target).parent().attr('id');
    var editor = $('#'+selector_parent+ '>.textyy_editor');

    // Update original editor based on it's type (tagName)
    if (editor.prop('tagName') == 'TEXTAREA') {
        editor.val(sender.target.innerHTML);
    } else if (editor.prop('tagName') == 'INPUT') {
        editor.val(); // TODO: Check this line
    }
});