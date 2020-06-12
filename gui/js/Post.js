var mode = 'POST';

$('#insert').show();
$('#update').hide();
$('#deletecontent').hide();
$('#delete').hide();

function Post(id) {
    mode = 'PUT';
    $('#id').val(id);

    if (id != null)
    $.get(baseurl + 'api/v1/posts/' + id, function (data, status) {
        // Enable buttons
        $('#insert').hide();
        $('#update').show();
        $('#deletecontent').show();
        $('#delete').show();    
        
        // Set inputs values
        $('#masterid').val(data[0]['MasterId']);
        $('#title').val(data[0]['Title']);
        $('#body').val(data[0]['Body']);
        simplemde.value($('#body').val());
        $('#masterid').val(data[0]['MasterId']);
    });

}

$("form input[type=submit]").click(function() {
    $("input[type=submit]", $(this).parents("form")).removeAttr("clicked");
    $(this).attr("clicked", "true");
});

$("form#post").on('submit', function (event) {
    event.preventDefault();

    // Initialize
    var data = new FormData();
    // Form data
    var formdata = $("form#post").serializeArray();

    // Check if body is edited with editor
    $.each(formdata, function (key, input) {
        if (input.name == "body" && simplemde !== null)
            data.append("body", simplemde.value());
        else
            data.append(input.name, input.value);
    });
    // File data
    var filedata = $('input[name="content"]')[0].files;
    for (var i = 0; i < filedata.length; i++) {
        data.append("content[]", filedata[i]);
    }

    // Which button was clicked
    var command = $("input[type=submit][clicked=true]").val();
    $("input[type=submit][clicked=true]").attr("clicked", "false");
    if (command == "Submit")
        mode = "POST";
    else if (command == "Delete")
        mode = "DELETE";
    else if (command == "Update")
        mode = "PUT";

    // Post to server
    $.ajax({
        url: baseurl + 'api/v1/posts',
        method: mode,
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
    // $(event.target).trigger("reset");

    window.location = baseurl + 'Admin/Interpreter#Posts';


});