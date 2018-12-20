require('./plugins/tinymce/plugins/links');

require('./stores/links');

require('../../../../widgets/resources/assets/js/mixins/widget');

Vue.component('LinksList', require('./components/partials/LinksList/LinksList.vue').default);
Vue.component('LinksListItem', require('./components/partials/LinksList/LinksListItem.vue').default);
Vue.component('LinksListItemForm', require('./components/partials/LinksList/LinksListItemForm.vue').default);

let links = require('./package/links');
links.init();
