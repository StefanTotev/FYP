var activeTab = null, currentDate, currentTab = null, previousDate, previousWebsite = null,
    diff, days, hrs, min, sec, realCookie = null, periodicalTimeout = null;
previousDate = new Date();

var getCookiesDetails = {"url": "http://developer.chrome.com/extensions/cookies.html",
    "name": "userID"}

chrome.cookies.get(getCookiesDetails, function (cookie) {
    if(cookie == null) {
        var options = {
            type: "basic",
            title: "Log in!",
            message: "Please log into the Habituo extension",
            iconUrl: "attention.png",
        };
        chrome.notifications.create("", options, callback);
    }
});

chrome.tabs.getSelected(null, function (tab) {
    var url = new URL(tab.url);
    previousWebsite = url.hostname;
});
periodicalSend();

chrome.extension.onRequest.addListener(function (request, sender, sendResponse) {
    currentTab = sender.tab.id;
    if(sender.tab.id == activeTab && request != previousWebsite) {
        currentDate = new Date();
        showDiff(sender.tab.id, previousWebsite, request, currentDate, previousDate, "increment");
        previousDate = currentDate;
        previousWebsite = request;
    }
})

chrome.tabs.onActivated.addListener(function (activeInfo) {
    activeTab = activeInfo.tabId;
    chrome.tabs.sendMessage(activeTab, {action: "getURL"}, function(response) {
    });
})

function periodicalSend() {
    currentDate = new Date();
    showDiff(currentTab, previousWebsite, previousWebsite, currentDate, previousDate, "noincrement");
    previousDate = currentDate;
}

function showDiff(tabId, prevWebsite, currWebsite, currentDate, previousDate, type){

    diff = (currentDate - previousDate)/1000;
    diff = Math.abs(Math.floor(diff));

    days = Math.floor(diff/(24*60*60));
    sec = diff - days * 24*60*60;

    hrs = Math.floor(sec/(60*60));
    sec = sec - hrs * 60*60;

    min = Math.floor(sec/(60));
    sec = sec - min * 60;

    var time = hrs + ":" + min + ":" + sec;
    if(realCookie == null) {
        var getCookiesDetails = {"url": "http://developer.chrome.com/extensions/cookies.html",
            "name": "userID"}
        chrome.cookies.get(getCookiesDetails, function (cookie) {
            realCookie = cookie;
            addTime(tabId,realCookie, prevWebsite, currWebsite, time, type);
        });
    } else {
        addTime(tabId, realCookie, prevWebsite, currWebsite, time, type);
    }
}

function addTime(tabId, cookie, request, website, time, type) {
    clearTimeout(periodicalTimeout);
    $.ajax({
        type: "POST",
        url: "http://52.56.238.131/addTime.php",
        data: {"userID": cookie.value,
            "prevWebsite": request,
            "currWebsite": website,
            "time": time,
            "type": type},
        success: function (data) { // on success the request returns the PHP echo as "data"
            data = data.toString().trim();
            periodicalTimeout = setTimeout(periodicalSend, 20000);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            periodicalTimeout = setTimeout(periodicalSend, 20000);
        }
    });
}

function callback() {
}