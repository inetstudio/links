<template>
  <div class="wrapper wrapper-content">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox">
          <div class="ibox-title text-center">
            <h3>Ссылка</h3>
            <div class="ibox-tools">
              <a class="close-link" @click.prevent="$emit('close')">
                <i class="fa fa-times"></i>
              </a>
            </div>
          </div>
          <div class="ibox-content" v-bind:class="{'sk-loading': isLoading}">
            <div class="sk-spinner sk-spinner-double-bounce">
              <div class="sk-double-bounce1"></div>
              <div class="sk-double-bounce2"></div>
            </div>

            <template v-if="isReady">
              <base-dropdown
                label = "Тип ссылки"
                v-bind:attributes="{
                  label: 'text',
                  placeholder: 'Выберите тип ссылки',
                  clearable: false,
                  reduce: option => option.value
                }"
                v-bind:options = "options.linksTypes"
                v-bind:selected.sync="item.model.link_type"
              />

              <div class="suggestions has-warning" v-show="showSuggestions">
                <base-autocomplete
                  name = "link_suggestion"
                  v-bind:attributes = "{
                    'data-search': '',
                    'placeholder': 'Введите название страницы',
                    'autocomplete': 'off'
                  }"
                  v-on:select="suggestionSelect"
                  v-bind:value.sync = "item.model.additional_info.suggestion"
                />
              </div>

              <div class="link-item-data" v-show="item.model.link_type">
                <div class="link-item-additional">
                  <base-input-text
                    label = "Заголовок"
                    name = "link_title"
                    v-bind:value.sync = "item.model.additional_info.title"
                  />

                  <base-input-text
                    label = "Ссылка"
                    name = "link_path"
                    v-bind:attributes = "{
                      'disabled': (item.model.link_type !== 'link'),
                    }"
                    v-bind:value.sync = "item.model.additional_info.path"
                  />
                </div>

                <base-checkboxes
                  label = "Открывать в новой вкладке"
                  name = "link_target"
                  v-bind:checkboxes = "[
                    {
                      value: '_blank',
                      label: 'Да'
                    }
                  ]"
                  v-bind:selected.sync = "item.model.additional_info.target"
                />

                <base-input-text
                  label = "CSS класс"
                  name = "link_css"
                  v-bind:value.sync = "item.model.additional_info.cssClass"
                />
              </div>
            </template>

          </div>
          <div class="ibox-footer">
            <div class="modal-buttons">
              <a href="#" class="btn btn-default" @click.prevent="$emit('close')">Закрыть</a>
              <a href="#" class="btn btn-primary" @click.prevent="saveItem">Сохранить</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import itemMixin from '~admin-panel/mixins/item';
  import stateMixin from '~admin-panel/mixins/state';
  import {v4 as uuidv4} from 'uuid';

  export default {
    name: 'links-package_links_widgets_list_item_form',
    props: {
      itemProp: {
        type: Object,
        default() {
          return {};
        }
      },
      save: {
        type: Function,
        default() {}
      }
    },
    data() {
      return {
        options: {
            linksTypes: []
        }
      }
    },
    computed: {
      showSuggestions() {
        let component = this;

        return (component.item.model.link_type && component.item.model.link_type !== 'link');
      }
    },
    watch: {
      'item.model.link_type': function (newValue, oldValue) {
        let component = this;

        if (! newValue || (newValue === oldValue)) {
          return;
        }

        if (!! oldValue) {
          let currentData = {
              model: {
                id: component.item.model.id,
                link_type: newValue
              }
          };

          component.item = _.merge(component.getItemModel(), currentData);
        }

        let typeIndex = _.findIndex(component.options.linksTypes, (type) => {
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
      getDefaultModelData() {
        return {
          id: uuidv4(),
          link_type: null,
          linkable_id: null,
          linkable_type: null,
          additional_info: {
            suggestion: '',
            title: '',
            path: '',
            target: [],
            cssClass: ''
          }
        };
      },
      loadItem() {
        let component = this;

        let url = route('back.links.show', component.itemIdProp);

        axios.get(url).then(response => {
          let item = {
            model: response.data,
            hash: hash(response.data)
          };

          return _.merge(component.getItemModel(), item);
        });
      },
      suggestionSelect(payload) {
        let component = this;

        let data = payload.data;

        component.item.model.additional_info.suggestion = data.title || '';
        component.item.model.additional_info.title = data.title || '';
        component.item.model.additional_info.path = data.path || '';

        component.item.model.linkable_id = data.id || null;
        component.item.model.linkable_type = data.type || null;
      },
      saveItem() {
        let component = this;

        if (component.item.model.additional_info.path !== '') {
          component.save({
            item: component.item
          });
        }

        component.$emit('close')
      },
    },
    created: function() {
      let component = this;

      let item = _.cloneDeep(component.itemProp);

      component.setModel((_.isEmpty(item)) ? component.getDefaultModelData() : item);
    },
    mounted() {
      let component = this;

      let url = route('back.admin-panel.config.get', 'links.links_types').toString();

      component.startLoading();

      axios.post(url).then(response => {
        component.options.linksTypes = (! _.isArray(response.data)) ? [] : response.data;

        if (_.isEmpty(component.options.linksTypes)) {
          component.options.linksTypes.push({
            text: 'Ссылка',
            value: 'link',
            attributes: []
          });
        }

        component.stopLoading();
        component.ready();
      });
    },
    mixins: [
      itemMixin,
      stateMixin
    ]
  }
</script>

<style scoped>
  .ibox-title {
    border: none;
  }
  .modal-buttons {
    float: right;
  }
</style>
