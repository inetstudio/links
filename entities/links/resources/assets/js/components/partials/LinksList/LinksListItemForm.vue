<template>
    <div class="modal inmodal fade" id="links_list_item_form_modal" tabindex="-1" role="dialog" aria-hidden="true" ref="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                    <h1 class="modal-title">Ссылка</h1>
                </div>

                <div class="modal-body">
                    <div class="ibox-content" v-bind:class="{ 'sk-loading': options.loading }">
                        <div class="sk-spinner sk-spinner-double-bounce">
                            <div class="sk-double-bounce1"></div>
                            <div class="sk-double-bounce2"></div>
                        </div>

                        <template v-if="! options.loading">
                            <base-dropdown
                                label = "Тип ссылки"
                                v-bind:attributes="{
                                    label: 'text',
                                    placeholder: 'Выберите тип ссылки',
                                    clearable: false,
                                    reduce: option => option.value
                                }"
                                v-bind:options = "options.linksTypes"
                                v-bind:selected="link.model.linkable_type"
                                v-on:update:selected="typeSelect"
                            />

                            <div class="has-warning" v-show="showSuggestions">
                                <base-autocomplete
                                    name = "link_suggestion"
                                    v-bind:attributes = "{
                                        'data-search': '',
                                        'placeholder': 'Введите название страницы',
                                        'autocomplete': 'off'
                                    }"
                                    v-on:select="suggestionSelect"
                                    v-bind:value.sync="link.model.additional_info.suggestion"
                                />
                            </div>

                            <div v-show="showPath">
                                <base-input-text
                                    label = "Ссылка"
                                    name = "link_path"
                                    v-bind:attributes = "{
                                        'disabled': (link.model.linkable_type !== 'links'),
                                    }"
                                    v-bind:value.sync = "link.model.additional_info.path"
                                />
                            </div>
                        </template>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <a href="#" class="btn btn-primary" v-on:click.prevent="saveLink">Сохранить</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'LinksListItemForm',
    data() {
      return {
        options: {
          loading: true,
          linksTypes: []
        },
        link: {}
      }
    },
    computed: {
      showSuggestions() {
        let linkable_type = this.link.model.linkable_type;

        return (linkable_type !== 'links' && linkable_type !== '');
      },
      showPath() {
        return this.link.model.linkable_type !== '';
      }
    },
    watch: {
      'link.model': {
        handler: function(newValue) {
          let component = this;

          component.link.hash = window.hash(newValue);
        },
        deep: true
      },
      'link.model.linkable_type': function (newValue, oldValue) {
        let component = this;

        if (! newValue || (newValue === oldValue)) {
          return;
        }

        let typeIndex = _.findIndex(component.options.linksTypes, function (type) {
          return type.value === newValue;
        });

        let routeName = (typeIndex > -1) ? component.options.linksTypes[typeIndex].attributes['data-suggestions'] : undefined;
        let suggestionsURL = (typeof routeName !== 'undefined') ? String(route(routeName)) : '';

        if (suggestionsURL) {
          $('#link_suggestion').autocomplete().setOptions({
            serviceUrl: suggestionsURL
          });
        }
      }
    },
    methods: {
      initComponent: function() {
        let component = this;

        component.loadLink();

        let url = route('back.admin-panel.config.get', 'links.links_types_new');

        component.options.loading = true;

        axios.post(url).then(response => {
          component.options.linksTypes = response.data;
          component.options.loading = false;
        });
      },
      loadLink() {
        let component = this;

        component.link = _.cloneDeep(window.Admin.vue.stores['links_package_links'].state.link);
      },
      saveLink() {
        let component = this;

        if (component.link.model.additional_info.path === '') {

          $(component.$refs.modal).modal('hide');

          return;
        } else {
          window.Admin.vue.stores['links_package_links'].commit('link', _.cloneDeep(component.link));
          window.Admin.vue.stores['links_package_links'].commit('mode', 'save_list_item');
        }

        $(component.$refs.modal).modal('hide');
      },
      typeSelect(payload) {
        let component = this;

        component.link.model.additional_info.suggestion = '';
        component.link.model.additional_info.path = '';
        component.link.model.linkable_type = payload;
        component.link.model.linkable_id = 0;
      },
      suggestionSelect(payload) {
        let component = this;

        let data = payload.data;

        component.link.model.additional_info.suggestion = data.title || '';
        component.link.model.additional_info.path = data.path || '';
        component.link.model.linkable_id = data.id || 0;
      },
    },
    created: function() {
      this.initComponent();
    },
    mounted() {
      let component = this;

      component.$nextTick(function() {
        $(component.$refs.modal).on('show.bs.modal', function() {
          component.loadLink();
        });
      });
    }
  }
</script>

<style scoped>
</style>
