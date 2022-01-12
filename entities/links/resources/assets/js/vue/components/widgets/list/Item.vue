<template>
  <li>
    <div class="row">
      <div class="col-10">
        <span class="label">{{ itemProp.model.link_type }}</span>
        <span class="m-l-xs">{{ itemProp.model.additional_info.suggestion || itemProp.model.additional_info.path }}</span>
      </div>
      <div class="col-2">
        <div class="btn-group float-right">
          <a class="btn btn-xs btn-default m-xxs" :href="url" target="_blank"><i class="fa fa-eye"></i></a>
          <a href="#" class="btn btn-xs btn-default m-xxs" v-on:click.prevent.stop="edit"><i class="fa fa-pencil-alt"></i></a>
          <a href="#" class="btn btn-xs btn-danger m-xxs" v-on:click.prevent.stop="remove"><i class="fa fa-times"></i></a>
        </div>
      </div>
    </div>
  </li>
</template>

<script>
    import itemForm from './Form';

    export default {
      name: 'links-package_links_widgets_list_item',
      props: {
        itemProp: {
          type: Object,
          required: true
        }
      },
      computed: {
        url() {
          let component = this;

          let path = component.itemProp.model.additional_info.path;

          if (component.itemProp.model.link_type === 'link') {
            return path;
          }

          return window.location.protocol + '//' + window.location.hostname + path;
        }
      },
      methods: {
        edit() {
          let component = this;

          component.$modal.show(
              itemForm,
              {
                itemProp: component.itemProp,
                save: function(payload) {
                  component.$emit('update', payload)
                }
              },
              {
                height: 'auto',
                scrollable: true,
                minWidth: 800
              }
          );
        },
        remove() {
          let component = this;

          component.$emit('remove', {
              item: component.itemProp,
          });
        }
      }
    }
</script>

<style scoped>

</style>
