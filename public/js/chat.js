"use strict";

(function() {
    window.addEventListener("DOMContentLoaded", async event => {

        // importing cache-busted Chat module
        const moduleList  = ["Chat", "ChatThreadMap", "ChatMessage", "ChatThread"];
        const moduleBuilders = {};
        const modules = {};
        let moduleLoader = [];
        for (let moduleEntry of moduleList) {
            moduleLoader.push((async () => {
                let moduleEntryVersionFetch = await fetch(`./js/modules/moduleVersion.php?module=${moduleEntry}.js`);
                let moduleEntryVersion = await moduleEntryVersionFetch.text();
                moduleBuilders[moduleEntry] = (await import(`./modules/${moduleEntry}.js?t=${moduleEntryVersion}`)).default;
                modules[moduleEntry] = moduleBuilders[moduleEntry](modules);
            })());
        }
        await Promise.all(moduleLoader);
        moduleLoader = [];
        for (let moduleEntry of moduleList) {
            moduleLoader.push((async () => {
                modules[moduleEntry] = moduleBuilders[moduleEntry](modules);
            })());
        }
        for (let moduleEntry of moduleList) {
            modules[moduleEntry] = moduleBuilders[moduleEntry](modules);
        }
        // run 3 times to allow all classes to import their modules

        let chat = new modules.Chat();
        await chat.init();
    });
})();