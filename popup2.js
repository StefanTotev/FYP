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

document.getElementById('add').onclick = function addWebsite() {

    var timeRegex = /^([01]\d|2[0-3]):([0-5]\d)$/;
    var time = $("#time").val();
    var match = timeRegex.test(time);
    if(match == true) {

        chrome.tabs.getSelected(null, function (tab) {
            var url = new URL(tab.url);
            var domain = url.hostname;

            var data = {"userID": userID.value,
                        "website": domain,
                        "time": time};
            $.ajax({
                type: "POST",
                url: "http://localhost/FYP/addWebsite.php",
                data: data,
                success: function (data) { // on success the request returns the PHP echo as "data"
                    data = data.toString().trim();
                    console.log(data);
                }
            });
        });
    } else {
        document.getElementById('errorMessage').innerHTML = '<font color="red">Incorrect Format. Please use hh:mm</font>';
    }
}

/*var h1 = document.getElementsByTagName('h1')[0],
    start = document.getElementById('start'),
    stop = document.getElementById('stop'),
    seconds = 0, minutes = 0, hours = 0, started = false, t;


/* Start button
start.onclick = function() {
    if(started = false) {
        chrome.extension.getBackgroundPage().timer();
    }
    started = true;
}

/* Stop button
stop.onclick = function() {
    chrome.extension.getBackgroundPage().stopTimer();
    started = false;
}

chrome.extension.onMessage.addListener(function (request, sender, sendResponse) {
    console.log(request.seconds);
    seconds = request.seconds;
    minutes = request.minutes;
    hours = request.hours;
    h1.textContent = (hours ? (hours > 9 ? hours : "0" + hours) : "00") + ":" + (minutes ? (minutes > 9 ? minutes : "0" + minutes) : "00") + ":" + (seconds > 9 ? seconds : "0" + seconds);
})*/