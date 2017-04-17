chrome.extension.sendRequest(window.location.hostname);

chrome.extension.onMessage.addListener(function(msg, sender, sendResponse) {
    if (msg.action == 'getURL') {
        chrome.extension.sendRequest(window.location.hostname);
    }
});