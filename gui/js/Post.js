$("form#post").on('submit', function (event) {

    event.preventDefault();
    
    // Initialize
    var data = new FormData();
    // Form data
    var formdata = $("form#post").serializeArray();
    $.each(formdata, function (key, input) {
        data.append(input.name, input.value);
    });
    // File data
    var filedata = $('input[name="content"]')[0].files;
    for (var i = 0; i < filedata.length; i++) {
        data.append("content[]", filedata[i]);
    }

    //  Log multipart data
    console.log(data);
    
    // Post to server
    $.ajax({
        url: baseurl + 'api/v1/posts',
        method: "POST",
        processData: false,
        contentType: false,
        data: data,
        success: function (data) {
            console.log(data)
        },
        error: function (e) {
            console.log(e)
        }
    });

    // Clear form
    $(event.target).trigger("reset");

        
});
