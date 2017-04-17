document.getElementById('createUser').onclick = function createUser() {
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var repeatPassword = document.getElementById('repeatPassword').value;

    var f = document.getElementById('form')[0];
    if(f.checkValidity() && password == repeatPassword) {
        $.ajax({
            type: "POST",
            url: "http://52.56.238.131/createUser.php",
            data: {"email": email,
                "password": password},
            success: function (data) { // on success the request returns the PHP echo as "data"
                data = data.toString().trim();
                if(data == 'success') {
                    window.location.replace("start.html");
                } else {
                    console.log(data);
                }
            }
        });
    } else {
        document.getElementById('errorMessage').innerHTML = '<font color="red">Please provide credentials</font>';
    }
}