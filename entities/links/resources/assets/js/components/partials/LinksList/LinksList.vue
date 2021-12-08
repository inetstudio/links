<template>
    <div class="links_package_links">
        <a href="#" class="btn btn-xs btn-primary btn-xs" v-on:click.prevent="add">Добавить</a>
        <ul class="links-list m-t small-list">
            <links-list-item
                v-for="link in links"
                :key="link.model.id"
                v-bind:link="link"
                v-on:remove="remove"
            />
        </ul>
    </div>
</template>

<script>
  import hash from 'object-hash';
  import Swal from 'sweetalert2';

  export default {
    name: 'LinksList',
    props: {
      linksProp: {
        type: Array,
        default: function() {
          return [];
        }
      }
    },
    data() {
      return {
        links: []
      };
    },
    computed: {
      mode() {
        return window.Admin.vue.stores['links_package_links'].state.mode;
      }
    },
    watch: {
      mode: function(newMode, oldMode) {
        let component = this;

        if (newMode === 'save_list_item' && (oldMode === 'add_list_item' || oldMode === 'edit_list_item')) {
          let storeLink = _.cloneDeep(window.Admin.vue.stores['links_package_links'].state.link);

          let existsIndex = _.findIndex(component.links, function(link) {
            return link.model.id !== storeLink.model.id
                && link.model.linkable_id === storeLink.model.linkable_id
                && link.model.linkable_type === storeLink.model.linkable_type;
          });

          if (existsIndex > -1 && oldMode === 'add_list_item') {
            return;
          }

          component.save(storeLink);
        }
      },
      linksProp: {
        immediate: true,
        handler (newValues) {
          let component = this;

          component.links = _.map(_.cloneDeep(newValues), function (link) {
            if (link.hasOwnProperty('model')) {
              link.hash = hash(link.model);

              return link;
            }

            return {
              hash: hash(link),
              model: link
            };
          });
        }
      }
    },
    methods: {
      add() {
        window.Admin.vue.helpers.initComponent('links_package_links', 'LinksListItemForm', {});

        window.Admin.vue.stores['links_package_links'].commit('mode', 'add_list_item');
        window.Admin.vue.stores['links_package_links'].dispatch('newLink');

        window.waitForElement('#links_list_item_form_modal', function() {
          $('#links_list_item_form_modal').modal();
        });
      },
      remove(payload) {
        let component = this;

        Swal.fire({
          title: 'Вы уверены?',
          icon: 'warning',
          showCancelButton: true,
          cancelButtonText: 'Отмена',
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Да, удалить'
        }).then((result) => {
          if (result.value) {
            component.links = _.remove(component.links, function (link) {
              return link.model.id !== payload.id;
            });

            component.$emit('update:links', {
              links: component.links
            });
          }
        });
      },
      save (storeLink) {
        let component = this;

        storeLink.hash = hash(storeLink.model);
        let index = _.findIndex(component.links, function(link) {
          return link.model.id === storeLink.model.id;
        });

        if (index > -1) {
          component.$set(component.links, index, storeLink);
        } else {
          component.links.push(storeLink);
        }

        component.$emit('update:links', {
          links: component.links
        });
      }
    }
  };
</script>

<style scoped>
</style>
