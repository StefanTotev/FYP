var activeTab = null, currentDate, previousDate, diff, days, hrs, min, sec;
previousDate = new Date();
alert(previousDate);

chrome.tabs.onCreated.addListener(function (tab) {
    chrome.tabs.getSelected(null,function(tab) {
        var tablink = tab.url;
        if(tablink == 'chrome://newtab/') {
            chrome.tabs.update({url: "http://google.com/"});
        }
    });
});

chrome.extension.onRequest.addListener(function (request, sender, sendResponse) {
    if(sender.tab.id == activeTab) {
        currentDate = new Date();
        showDiff(request, currentDate, previousDate);
        previousDate = currentDate;
    }
})

chrome.tabs.onActivated.addListener(function (activeInfo) {
    activeTab = activeInfo.tabId;
    chrome.tabs.sendMessage(activeTab, {action: "getURL"}, function(response) {
    });
})

function showDiff(request, currentDate, previousDate){

    diff = (currentDate - previousDate)/1000;
    diff = Math.abs(Math.floor(diff));

    days = Math.floor(diff/(24*60*60));
    sec = diff - days * 24*60*60;

    hrs = Math.floor(sec/(60*60));
    sec = sec - hrs * 60*60;

    min = Math.floor(sec/(60));
    sec = sec - min * 60;

    alert(request + " " + hrs + " " + min + ":" + sec);
}
/*var seconds = 0, minutes = 0, hours = 0, t;

function add() {
    seconds++;
    if (seconds >= 60) {
        seconds = 0;
        minutes++;
        if (minutes >= 60) {
            minutes = 0;
            hours++;
        }
    }
    chrome.extension.sendMessage({"seconds": seconds,
                                  "minutes": minutes,
                                  "hours": hours});
    timer();
}

function timer() {
    t = setTimeout(add, 1000);
}

function stopTimer() {
    clearTimeout(t);
}*/