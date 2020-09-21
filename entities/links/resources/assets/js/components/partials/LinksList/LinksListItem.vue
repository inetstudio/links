<template>
    <li>
        <div class="row">
            <div class="col-10">
                <span class="label">{{ link.model.linkable_type }}</span>
                <span class="m-l-xs">{{ link.model.additional_info.suggestion || link.model.additional_info.path }}</span>
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
  export default {
    name: 'LinksListItem',
    props: {
      link: {
        type: Object,
        required: true
      }
    },
    computed: {
      url() {
        let path = this.link.model.additional_info.path;

        if (this.link.model.linkable_type === 'links') {
          return path;
        }

        return window.location.protocol + '//' + window.location.hostname + path;
      }
    },
    methods: {
      edit() {
        let component = this;

        window.Admin.vue.helpers.initComponent('links_package_links', 'LinksListItemForm', {});

        window.Admin.vue.stores['links_package_links'].commit('mode', 'edit_list_item');
        window.Admin.vue.stores['links_package_links'].commit('link', component.link);

        window.waitForElement('#links_list_item_form_modal', function () {
          $('#links_list_item_form_modal').modal();
        });
      },
      remove() {
        let component = this;

        component.$emit('remove', {
          id: component.link.model.id
        });
      }
    }
  };
</script>

<style scoped>
</style>
