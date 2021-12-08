import {links} from './package/links';

require('./plugins/tinymce/plugins/links');

require('./stores/links');
require('./stores/links_package_links');

require('../../../../../../widgets/entities/widgets/resources/assets/js/mixins/widget');

window.Vue.component('LinksList', () => import('./components/partials/LinksList/LinksList.vue'));
window.Vue.component('LinksListItem', () => import('./components/partials/LinksList/LinksListItem.vue'));
window.Vue.component('LinksListItemForm', () => import('./components/partials/LinksList/LinksListItemForm.vue'));

window.Vue.component('LinksListWidget', () => import('./components/partials/LinksListWidget/LinksListWidget.vue'));
window.Vue.component('LinksListWidgetItem', () => import('./components/partials/LinksListWidget/LinksListWidgetItem.vue'));
window.Vue.component('LinksListWidgetItemForm', () => import('./components/partials/LinksListWidget/LinksListWidgetItemForm.vue'));


window.Vue.component('links-package_links_widgets_list', () => import('./vue/components/widgets/list/List.vue'));

links.init();
