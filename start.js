var getCookiesDetails = {"url": "http://developer.chrome.com/extensions/cookies.html",
    "name": "userID"}
var userID;
chrome.cookies.get(getCookiesDetails, function (cookie) {
    if(cookie == null) {
        window.location.replace("popup.html");
    } else {
        userID = cookie;
    }
});

chrome.tabs.getSelected(null, function (tab) {

    var url = new URL(tab.url);
    var domain = url.hostname;

    var data = {"userID": userID.value,
        "website": domain};

    $.ajax({
        type: "POST",
        url: "http://52.56.238.131/getWebsite.php",
        data: data,
        success: function (data) { // on success the request returns the PHP echo as "data"
            data = data.toString().trim();
            console.log(data);
            if(data == "true") {
                window.location.replace("removeWebsite.html");
            } else {
                window.location.replace("popup2.html");
            }
        }
    });
});