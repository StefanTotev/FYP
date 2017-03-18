document.getElementById('submit').onclick = function callPHP() {
    var f = document.getElementById('form')[0];
    if(f.checkValidity()) {
        $.ajax({
            type: "POST",
            url: "http://localhost/FYP/index.php",
            //dataType: "JSON",
            data: {"email": document.getElementById('email').value,
                "password": document.getElementById('password').value},
            success: function (data) { // on success the request returns the PHP echo as "data"
                //var obj = data; // parse the data if your PHP file returns JSON. if not just use "data"
                //document.cookie = data;
                //console.log(document.cookie);
                data = data.toString().trim();

                if(data != "")
                {
                    var setCookiesDetails = {"name": "userID",
                        "url": "http://developer.chrome.com/extensions/cookies.html",
                        "value": data};
                    chrome.cookies.set(setCookiesDetails);
                    window.location.replace("popup2.html");
                } else {
                    document.getElementById('errorMessage').innerHTML = '<font color="red">Incorrect credentials</font>';
                }

                // do something with your data. Commented out functionality to populate fields ( might be useful )
                // $("#jobnumber").val(obj[0]['value']);
                // $("#jobnumber_mobile").val(obj[0]['value']);
            }
        });
    } else {
        document.getElementById('errorMessage').innerHTML = '<font color="red">Please provide credentials</font>';
    }
}
