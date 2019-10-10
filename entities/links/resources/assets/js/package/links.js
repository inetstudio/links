let links = {};

links.init = function () {
    if (! window.Admin.vue.modulesComponents.modules.hasOwnProperty('links')) {
        window.Admin.vue.modulesComponents.modules = Object.assign({}, window.Admin.vue.modulesComponents.modules, {
            links: {
                components: []
            }
        });
    }
};

module.exports = links;
