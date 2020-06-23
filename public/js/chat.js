"use strict";

(function() {
    window.addEventListener("DOMContentLoaded", async event => {

        // importing cache-busted Chat module
        const moduleList  = ["Chat", "ChatThreadList"];
        const moduleBuilders = {};
        const modules = {};
        for (let moduleEntry of moduleList) {
            let moduleEntryVersionFetch = await fetch(`./js/modules/moduleVersion.php?module=${moduleEntry}.js`);
            let moduleEntryVersion = await moduleEntryVersionFetch.text();
            moduleBuilders[moduleEntry] = (await import(`./modules/${moduleEntry}.js?t=${moduleEntryVersion}`)).default;
            modules[moduleEntry] = moduleBuilders[moduleEntry](modules);
        }
        for (let moduleEntry of moduleList) {
            modules[moduleEntry] = moduleBuilders[moduleEntry](modules);
        }

        let chat = new modules.Chat();
    });
})();