var getCookiesDetails = {"url": "http://developer.chrome.com/extensions/cookies.html",
    "name": "userID"}
var userID;

chrome.cookies.get(getCookiesDetails, function (cookie) {
    console.log(cookie);
    if(cookie == null) {
        var data = {};
        $.ajax({
            type: "POST",
            url: "http://52.56.238.131/checkLogin.php",
            data: data,
            success: function (data) { // on success the request returns the PHP echo as "data"
                data = data.toString().trim();
                console.log(data);
                if(data == "fail") {
                    window.location.replace("popup.html");
                } else {
                    var setCookiesDetails = {"name": "userID",
                        "url": "http://developer.chrome.com/extensions/cookies.html",
                        "value": data};
                    chrome.cookies.set(setCookiesDetails);
                    checkForPage(data);
                }
            }
        });
    } else {
        userID = cookie;
        checkForPage(userID.value);
    }
});

var checkForPage = function(id) {
    chrome.tabs.getSelected(null, function (tab) {

        var url = new URL(tab.url);
        var domain = url.hostname;

        var data = {"userID": id,
            "website": domain};

        $.ajax({
            type: "POST",
            url: "http://52.56.238.131/getWebsite.php",
            data: data,
            success: function (data) { // on success the request returns the PHP echo as "data"
                data = data.toString().trim();
                console.log(data);
                if(data == "false") {
                    window.location.replace("popup2.html");
                } else {
                    window.location.replace("removeWebsite.html");
                }
            }
        });
    });
}