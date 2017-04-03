var getCookiesDetails = {"url": "http://developer.chrome.com/extensions/cookies.html",
    "name": "userID"}
var userID;
chrome.cookies.get(getCookiesDetails, function (cookie) {
    userID = cookie;
});

document.getElementById('logOut').onclick = function callPHP() {

    $.ajax({
        type: "POST",
        url: "http://localhost/FYP/logout.php",
        data: {"userID": userID.value},
        success: function (data) { // on success the request returns the PHP echo as "data"
            data = data.toString().trim();
            console.log(data);
            var removeCookieDetails = {"name": "userID",
                "url": "http://developer.chrome.com/extensions/cookies.html"};
            chrome.cookies.remove(removeCookieDetails);
            window.location.replace("popup.html");
        }
    });
}

document.getElementById('addPositive').onclick = function addPositiveWebsite() {
    addWebsite("positive");
}

document.getElementById('addNegative').onclick = function addNegativeWebsite() {
    addWebsite("negative");
}

function addWebsite(type) {
    var timeRegex = /^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$/;
    var time = $("#time").val();
    var match = timeRegex.test(time);
    if(match == true) {

        chrome.tabs.getSelected(null, function (tab) {
            var url = new URL(tab.url);
            var domain = url.hostname;

            if(domain != 'localhost') {
                var data = {"userID": userID.value,
                    "website": domain,
                    "time": time,
                    "type": type};
                $.ajax({
                    type: "POST",
                    url: "http://localhost/FYP/addWebsite.php",
                    data: data,
                    success: function (data) { // on success the request returns the PHP echo as "data"
                        data = data.toString().trim();
                        console.log(data);
                        window.location.replace("removeWebsite.html");
                    }
                });
            } else {
                document.getElementById('errorMessage').innerHTML = '<font color="red">This website cannot be tracked</font>';
            }
        });
    } else {
        document.getElementById('errorMessage').innerHTML = '<font color="red">Incorrect Format. Please use hh:mm:ss (e.g. 01:40:00)</font>';
    }
}