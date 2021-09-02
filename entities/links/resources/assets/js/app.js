import Vue from 'vue';
import {links} from './package/links';

require('./plugins/tinymce/plugins/links');

require('./stores/links');
require('./stores/links_package_links');

require('../../../../../../widgets/entities/widgets/resources/assets/js/mixins/widget');

Vue.component('LinksList', require('./components/partials/LinksList/LinksList.vue').default);
Vue.component('LinksListItem', require('./components/partials/LinksList/LinksListItem.vue').default);
Vue.component('LinksListItemForm', require('./components/partials/LinksList/LinksListItemForm.vue').default);

Vue.component('LinksListWidget', require('./components/partials/LinksListWidget/LinksListWidget.vue').default);
Vue.component('LinksListWidgetItem', require('./components/partials/LinksListWidget/LinksListWidgetItem.vue').default);
Vue.component('LinksListWidgetItemForm', require('./components/partials/LinksListWidget/LinksListWidgetItemForm.vue').default);

links.init();
