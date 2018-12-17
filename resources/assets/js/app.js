require('./plugins/tinymce/plugins/links');

require('./stores/links');

Vue.component('LinksList', function (resolve) {
    require(['./components/partials/LinksList/LinksList.vue'], resolve);
});
Vue.component('LinksListItem', function (resolve) {
    require(['./components/partials/LinksList/LinksListItem.vue'], resolve);
});
Vue.component('LinksListItemForm', function (resolve) {
    require(['./components/partials/LinksList/LinksListItemForm.vue'], resolve);
});

let links = require('./package/links');
links.init();
