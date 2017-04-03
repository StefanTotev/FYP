document.getElementById('submit').onclick = function callPHP() {
    var f = document.getElementById('form')[0];
    if(f.checkValidity()) {
        $.ajax({
            type: "POST",
            url: "http://localhost/FYP/index.php",
            data: {"email": document.getElementById('email').value,
                "password": document.getElementById('password').value},
            success: function (data) { // on success the request returns the PHP echo as "data"
                data = data.toString().trim();

                if(data != "")
                {
                    var setCookiesDetails = {"name": "userID",
                        "url": "http://developer.chrome.com/extensions/cookies.html",
                        "value": data};
                    chrome.cookies.set(setCookiesDetails);
                    window.location.replace("start.html");
                } else {
                    document.getElementById('errorMessage').innerHTML = '<font color="red">Incorrect credentials</font>';
                }
            }
        });
    } else {
        document.getElementById('errorMessage').innerHTML = '<font color="red">Please provide credentials</font>';
    }
}

document.getElementById('createUser').onclick = function createUser() {
    window.location.replace("createUser.html");
}