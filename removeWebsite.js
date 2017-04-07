var getCookiesDetails = {"url": "http://developer.chrome.com/extensions/cookies.html",
    "name": "userID"}
var userID;
chrome.cookies.get(getCookiesDetails, function (cookie) {
    userID = cookie;
});

document.getElementById('redirect').onclick = function redirect() {
    var createProperties = {
        url: "http://52.56.238.131/Stefcho/index.html",
        active: true
    };
    chrome.tabs.create(createProperties);
}

document.getElementById('logOut').onclick = function callPHP() {

    $.ajax({
        type: "POST",
        url: "http://52.56.238.131/logout.php",
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

document.getElementById('remove').onclick = function addWebsite() {

    chrome.tabs.getSelected(null, function (tab) {
        var url = new URL(tab.url);
        var domain = url.hostname;

        var data = {"userID": userID.value,
                    "website": domain};
        $.ajax({
            type: "POST",
            url: "http://52.56.238.131/removeWebsite.php",
            data: data,
            success: function (data) { // on success the request returns the PHP echo as "data"
                data = data.toString().trim();
                console.log(data);
                window.location.replace("popup2.html");
            }
        });
    });
}