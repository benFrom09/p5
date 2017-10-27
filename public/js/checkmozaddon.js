(function() {
    window.postMessage({
        checkIfScreenCapturingEnabled: true
    }, "*");

    window.addEventListener("message", function(event) {
        if (event.source !== window) return;

        var addonMessage = event.data;

        if (!addonMessage || typeof addonMessage.isScreenCapturingEnabled === 'undefined') return;

        if (addonMessage.isScreenCapturingEnabled === true) {
            alert(JSON.stringify(addonMessage.domains) + '\n are enabled for screen capturing.');
        } else {
            alert(JSON.stringify(addonMessage.domains) + '\n are NOT enabled for screen capturing.');
        }
    }, false);
})();