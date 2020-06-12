function Posts(){ // Constructor class
    
    $.get(baseurl + 'api/v1/posts', function(data, status){ 

        data.forEach(obj => {
            $("tbody").append('<tr>'
                + '<th scope="row">'
                + '<a href="' + baseurl + "Admin/Interpreter#Post#" + obj['Id'] + '">Edit</a>'
                + '</th>'
                + '<td>' + obj["Title"] + '</td>'
                + '<td>' + obj["Submit"] + '</td>'
                + '<td>' + obj["Username"] + '</td>'
                + '<td>' + obj["Status"] + '</td>'
                + '<td><img width="100" height="50" src="'+baseurl + 'Post/Download/'+obj['Language']+'/'+obj['MasterId']+'" /></td></tr>'
                + "</tr>"
            );
        });
    });
}