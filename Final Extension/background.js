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
    if(hrs*3600 + min*60 + sec < 300) {
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
            if(data == "pass") {
            } else if (data == "block") {
                displayNotification("Warning!", "You will no longer have access to " + website + " until the end of the day!", "redTick.png", 100);
                chrome.tabs.update({url: "http://52.56.238.131/main.php"});
            } else if (data == "done") {
                displayNotification("Congratulations!", "You have achieved your daily target for " + website + "! Keep up the good work!", "greenTick.png", 100);
            } else {
                var returnVal = data.split(" ");
                if(typeof returnVal[0] != "undefined") {
                    if (returnVal[0] == "neg5min") {
                        displayNotification("Warning!", "You have less than 5 minutes to browse " + website + "!", "redTick.png", 90);
                    } else if (returnVal[0] == "pos5min") {
                        displayNotification("Almost there!", "Less than 5 minutes to go until your daily goal for " + website + "!", "greenTick.png", 90);
                    } else if (returnVal[0] == "neg10min") {
                        displayNotification("Warning!", "You have less than 10 minutes left for " + website + "! Consider visiting a productive website!", "redTick.png", 80);
                    } else if (returnVal[0] == "pos10min") {
                        displayNotification("Keep it up!", "You have less than 10 minutes until you reach your daily goal for " + website + "!", "greenTick.png", 80);
                    } else if (returnVal[0] == "neg20min") {
                        displayNotification("Warning!", "You have less than 20 minutes left for " + website + "! Why not visit a more productive website?", "redTick.png", 70);
                    } else if (returnVal[0] == "pos20min") {
                        displayNotification("Keep it up!", "You have less than 20 minutes until you reach your daily goal for " + website + "!", "greenTick.png", 70);
                    } else if (returnVal[0] == "negHalf") {
                        displayNotification("Warning!", "You have used more than half of your time for " + website + "! Consider visiting one of the previously listed productive websites!", "redTick.png", 50);
                    } else if (returnVal[0] == "posHalf") {
                        displayNotification("You are doing a great job!", "You are halfway through your daily goal for " + website + "!", "greenTick.png", 50);
                    }
                }
            }
            periodicalTimeout = setTimeout(periodicalSend, 20000);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
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
                title: "View positive websites or statisticsee statistics for current websites"
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
        url: "http://52.56.238.131/main.php",
        active: true
    };
    chrome.tabs.create(createProperties);
});

function callback() {
}