var activeTab = null, currentDate, currentTab = null, previousDate, previousWebsite = null,
    diff, days, hrs, min, sec, realCookie = null, periodicalTimeout = null;
previousDate = new Date();

chrome.tabs.onCreated.addListener(function (tab) {
    chrome.tabs.getSelected(null,function(tab) {
        var tablink = tab.url;
        if(tablink == 'chrome://newtab/') {
            chrome.tabs.update({url: "http://localhost/FYP/Stefcho/index.html"});
        }
    });
});

chrome.extension.onRequest.addListener(function (request, sender, sendResponse) {
    currentTab = sender.tab.id;
    if(sender.tab.id == activeTab && request != previousWebsite) {
        currentDate = new Date();
        showDiff(sender.tab.id, previousWebsite, request, currentDate, previousDate, "increment");
        previousDate = currentDate;
        previousWebsite = request;
    }
})

/*chrome.webNavigation.onCompleted.addListener(function (details) {
    alert("Here!!");
    currentTab = details.tabId;
    var newUrl = url_domain(details.url);
    if(details.tabId == activeTab && newUrl != previousWebsite) {
        currentDate = new Date();
        showDiff(details.tabId, previousWebsite, newUrl, currentDate, previousDate, "increment");
        previousDate = currentDate;
        previousWebsite = newUrl;
    }
})

function url_domain(data) {
    var a = document.createElement('a');
    a.href = data;
    return a.hostname;
}*/

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
        url: "http://localhost/FYP/addTime.php",
        data: {"userID": cookie.value,
            "prevWebsite": request,
            "currWebsite": website,
            "time": time,
            "type": type},
        success: function (data) { // on success the request returns the PHP echo as "data"
            data = data.toString().trim();
            if(data == "pass") {
            } else if (data == "block") {
                displayNotification("Warning!", "You will no longer have access to this website until the end of the day!", "redTick.png", 100);
                chrome.tabs.update({url: "http://localhost/FYP/Stefcho/index.html"});
            } else if (data == "done") {
                displayNotification("Congratulations!", "You have achieved your daily target for this website! Keep up the good work!", "greenTick.png", 100);
            } else {
                var returnVal = data.split(" ");
                if(typeof returnVal[0] != "undefined") {
                    if (returnVal[0] == "neg5min") {
                        displayNotification("Warning!", "You have less than 5 more minutes to browse this website!", "redTick.png", 90);
                    } else if (returnVal[0] == "pos5min") {
                        displayNotification("Almost there!", "Less than 5 minutes to go!", "greenTick.png", 90);
                    } else if (returnVal[0] == "neg10min") {
                        displayNotification("Warning!", "You have less than 10 more minutes! Consider visiting a productive website!", "redTick.png", 80);
                    } else if (returnVal[0] == "pos10min") {
                        displayNotification("Keep it up!", "You have less than 10 minutes until you reach your daily goal for this website!", "greenTick.png", 80);
                    } else if (returnVal[0] == "neg20min") {
                        displayNotification("Warning!", "You have less than 20 more minutes on this website! Why not visit one of the listed productive websites?", "redTick.png", 70);
                    } else if (returnVal[0] == "pos20min") {
                        displayNotification("Keep it up!", "You have less than 20 minutes until you reach your daily goal for this website!", "greenTick.png", 70);
                    } else if (returnVal[0] == "negHalf") {
                        displayNotification("Warning!", "You have used more than half of your time for this website! Consider visiting one of the listed productive websites!", "redTick.png", 50);
                    } else if (returnVal[0] == "posHalf") {
                        displayNotification("You're doing a great job!", "You are more than halfway through your daily goal for this website!", "greenTick.png", 50);
                    }
                }
            }
            periodicalTimeout = setTimeout(periodicalSend, 20000);
        }
    });
}

function displayNotification(title1, message1, iconUrl1, progress1) {
    var options;
    if(title1 == "Warning!") {
        options = {
            type: "basic",
            title: title1,
            message: message1,
            iconUrl: iconUrl1,
            buttons: [{
                title: "See statistics for current websites"
            }]
        };
    } else {
        options = {
            type: "progress",
            title: title1,
            message: message1,
            iconUrl: iconUrl1,
            progress: progress1
        };
    }
    chrome.notifications.create("", options, callback);
}

chrome.notifications.onButtonClicked.addListener(function(notifId, btnIdx) {
    var createProperties = {
        url: "http://localhost/FYP/Stefcho/index.html",
        active: true
    };
    chrome.tabs.create(createProperties);
});

function callback() {
}