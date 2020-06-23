"use strict";

(function() {
    window.addEventListener("DOMContentLoaded", async event => {

        // importing cache-busted Chat module
        const moduleList  = ["Chat", "ChatThreadList"];
        const modules = {};
        for (let moduleEntry of moduleList) {
            let moduleEntryVersionFetch = await fetch(`./js/modules/moduleVersion.php?module=${moduleEntry}`);
            let moduleEntryVersion = await moduleEntryVersionFetch.text();
            modules[moduleEntry] = (await import(`./modules/${moduleEntry}.js?t=${moduleEntryVersion}`)).default;
        }

        let Chat = modules["Chat"](modules);
        let chat = new Chat();
        console.log(chat);
    });
})();