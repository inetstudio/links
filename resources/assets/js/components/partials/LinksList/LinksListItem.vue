<template>
    <tr class="link-tr">
        <td class="link-title">
            <span>{{ link.model.additional_info.title }}</span>
        </td>
        <td width="10%">
            <a href="#" class="btn btn-xs btn-default edit-link m-r-xs" v-on:click.prevent.stop="editLink"><i class="fa fa-pencil"></i></a>
            <a href="#" class="btn btn-xs btn-danger delete-link" v-on:click.prevent.stop="removeLink"><i class="fa fa-times"></i></a>
        </td>
    </tr>
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
        methods: {
            editLink() {
                window.Admin.vue.stores['links'].commit('setMode', 'edit_list_item');
                window.Admin.vue.stores['links'].commit('setLink', JSON.parse(JSON.stringify(this.link)));

                $('#links_list_item_form_modal').modal();
            },
            removeLink() {
                this.$emit('remove', {
                    id: this.link.model.id,
                });
            }
        }
    }
</script>

<style scoped>

</style>