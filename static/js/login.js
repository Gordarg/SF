// Documentation: https://www.peej.co.uk/sandbox/htmlhttpauth/
window.onload = function()
{
    var anchors = document.getElementsByTagName("a");
    for (var foo = 0; foo < anchors.length; foo++) {
        if (anchors[foo].className == "httpauth") {
            createForm(anchors[foo]);
        }
    }
}

function createForm(httpauth)
{
    var container = document.createElement("div");
    container.innerHTML = `
    <div class="text-center">
        <form class="form-signin" method="get"
        onsubmit="login(event)"
        action="` + baseurl + `Authentication/Basic">
        <img class="mb-4" src="` + baseurl + `static/Logo.png" alt="" height="100">
        <h1 class="h3 mb-3 font-weight-normal text-center">ورود به سیستم</h1>
        <label for="username" class="sr-only">نام کاربری</label>
        <input type="text" id="username" name="username" class="form-control" placeholder="نشانی پست الکترونیک" required autofocus>
        <label for="password" class="sr-only">کلمه‌ی عبور</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="کلمه‌ی عبور">
        <div class="checkbox mb-3">
            <label>
            <input type="checkbox" value="remember-me"> مرا به خاطرت نگهدار
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">ورود</button>
        </form>
    </div>
    `;
    var form = container;
    
    httpauth.parentNode.replaceChild(form, httpauth);
}

function getHTTPObject() {
    var xmlhttp = false;
    if (typeof XMLHttpRequest != 'undefined') {
        try {
            xmlhttp = new XMLHttpRequest();
        } catch (e) {
            xmlhttp = false;
        }
    } else {
        /*@cc_on
        @if (@_jscript_version >= 5)
            try {
                xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (E) {
                    xmlhttp = false;
                }
            }
        @end @*/
    }
    return xmlhttp;
}

function login(e)
{
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var http = getHTTPObject();
    var url = baseurl + 'Authentication/Basic';
    http.open("get", url, false, username, password);
    http.send("");
    if (http.status == 200) {
        document.location = url;
    } else {
        alert("Incorrect username and/or password!");
        e.preventDefault();
    }
    return false;
}


function logout()
{
    var http = getHTTPObject();
    var url = baseurl + 'Authentication/Basic';
    http.open("get", url, false, "null", "null");
    http.send("");
    alert("You have been logged out.");
    return false;
}
$('.logout').removeAttr('href');
$('.logout').click( function(e) {e.preventDefault(); 
    logout();
    window.location = baseurl + "Authentication/Login";
    return false;
}
);