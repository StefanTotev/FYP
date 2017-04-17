var getCookiesDetails = {"url": "http://developer.chrome.com/extensions/cookies.html",
    "name": "userID"}
chrome.cookies.get(getCookiesDetails, function (cookie) {
    if(cookie == null) {
        window.location.replace("popup.html");
    }
});