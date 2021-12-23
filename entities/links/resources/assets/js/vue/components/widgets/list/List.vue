<template>
  <div>
    <template v-if="isReady">
      <slot name="additionalFields" v-bind:item="item" />

      <base-input-text
        label = "Заголовок"
        name = "title"
        v-bind:value.sync = "item.model.params.title"
      />

      <div class="form-group row">
        <label class="col-sm-2 col-form-label font-bold">Ссылки</label>
        <div class="col-sm-10">
          <div class="links_package_links">
            <a href="#" class="btn btn-xs btn-primary btn-xs" @click.prevent="addLink">Добавить</a>
            <ul class="links-list m-t small-list">
              <list-item
                v-for="link in links"
                :key="link.item.model.id"
                v-bind:itemProp="link.item"
                v-on:remove="removeLink"
                v-on:update="updateLink"
              />
            </ul>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<script>
  import hash from 'object-hash';
  import itemForm from './Form.vue';
  import Swal from 'sweetalert2';
  import stateMixin from '~admin-panel/mixins/state';
  import widgetMixin from '~widgets-package_widgets/mixins/widget';

  export default {
    name: 'links-package_links_widgets_list',
    components: {
      'list-item': () => import('./Item.vue')
    },
    data() {
      return {
        links: [],
        options: {
          listStyles: []
        },
        events: {
          itemLoaded: function (component) {
            component.startLoading();

            if (component.item.model.params.ids.length === 0) {
              component.stopLoading();
              component.ready();

              return;
            }

            let linksUrl = route('back.links.get').toString();
            let data = {
              params: {
                ids: component.item.model.params.ids
              }
            };

            axios
              .get(linksUrl, data)
              .then(response => {
                let links = [];
                let data = response.data;

                data.forEach(function (linkData) {
                  links.push({
                    item: {
                      hash: hash(linkData.model),
                      isModified: false,
                      model: linkData.model,
                    }
                  });
                });

                component.links = links;

                component.stopLoading();
                component.ready();
              });
          }
        }
      }
    },
    methods: {
      getDefaultModelData() {
        return {
          widget_name: 'links-package_links_widgets_list',
          category: 'links.list',
          view: 'inetstudio.links-package.links::front.partials.content.links_list_widget',
          params: {
            ids: [],
            title: ''
          }
        };
      },
      addLink() {
        let component = this;

        component.$modal.show(
            itemForm,
            {
              save: function(payload) {
                component.links.push(payload);
              }
            },
            {
              adaptive: true,
              height: 'auto',
              minWidth: 800
            }
        );
      },
      removeLink(payload) {
        let component = this;

        Swal.fire({
          title: "Вы уверены?",
          icon: "warning",
          showCancelButton: true,
          cancelButtonText: "Отмена",
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Да, удалить"
        }).then((result) => {
          if (result.value) {
            component.links = _.remove(component.links, function(link) {
              return link.item.model.id !== payload.item.model.id;
            });
          }
        });
      },
      updateLink(payload) {
        let component = this;

        let index = _.findIndex(component.links, function (link) {
          return link.item.model.id === payload.item.model.id;
        });

        let clonedLink = _.cloneDeep(payload);

        if (index > -1) {
          component.$set(component.links, index, clonedLink);
        } else {
          component.links.push(clonedLink);
        }
      },
      save() {
        let component = this;

        if (component.links.length === 0 && ! component.item.isModified) {
            component.$emit('close');

            return;
        }

        let requests = component.getSaveLinksRequests();

        component.startLoading();

        axios.all(requests)
            .then(axios.spread(function() {
              for (let i = 0; i < arguments.length; i++) {
                let postData = JSON.parse(arguments[i].config.data);

                let index = _.findIndex(component.links, function (link) {
                  return link.item.model.id === postData.id;
                });

                let newData = {
                  item: {
                    hash: hash(arguments[i].data),
                    isModified: false,
                    model: arguments[i].data,
                  }
                };

                component.$set(component.links, index, newData);
              }

              component.item.model.params.ids = _.map(component.links, function (link) {
                return link.item.model.id;
              });

              component.stopLoading();

              component.saveItem(function () {
                component.$emit('saved');
              });
            }));
      },
      getSaveLinksRequests() {
        let component = this;

        let requests = [];

        component.links.forEach(function(link) {
          if (! link.item.isModified) {
            return;
          }

          let url = (typeof link.item.model.id !== 'string')
              ? route('back.links.update', link.item.model.id).toString()
              : route('back.links.store').toString();

          let data = _.cloneDeep(link.item.model);

          if (typeof link.item.model.id !== 'string') {
            data._method = 'PUT';
          }

          requests.push(axios.post(url, data));
        });

        return requests;
      }
    },
    mixins: [
      stateMixin,
      widgetMixin
    ]
  }
</script>

<style scoped>

</style>
