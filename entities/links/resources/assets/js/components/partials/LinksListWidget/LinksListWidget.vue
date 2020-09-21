<template>
    <div id="links_list_modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal inmodal fade" ref="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                    <h1 class="modal-title">Ссылки</h1>
                </div>
                <div class="modal-body">
                    <div class="ibox-content" v-bind:class="{ 'sk-loading': options.loading }">
                        <div class="sk-spinner sk-spinner-double-bounce">
                            <div class="sk-double-bounce1"></div>
                            <div class="sk-double-bounce2"></div>
                        </div>
                        <base-dropdown
                            label = "Оформление"
                            v-bind:attributes="{
                                label: 'text',
                                placeholder: 'Выберите тип оформления',
                                clearable: false,
                                reduce: option => option.value
                            }"
                            v-bind:options="options.listStyles"
                            v-bind:selected.sync="model.params.style"
                        />
                        <a href="#" class="btn btn-xs btn-primary m-b-lg add_link" v-on:click.prevent="addLink">Добавить</a>
                        <table class="table table-hover links-list">
                            <tbody>

                                <links-list-widget-item
                                    v-for="link in links"
                                    :key="link.model.id"
                                    v-bind:link="link"
                                    v-on:remove="removeLink"
                                />

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <a href="#" class="btn btn-primary" v-on:click.prevent="save">Сохранить</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'LinksListWidget',
        data() {
            return {
                model: this.getDefaultModel(),
                links: [],
                options: {
                    loading: true,
                    listStyles: []
                },
                events: {
                    widgetLoaded: function (component) {
                        $('#links_list_style').val(component.model.params.style).trigger('change');

                        let url = route('back.links.get');
                        let data = {
                            params: {
                                ids: component.model.params.ids
                            }
                        };

                        component.options.loading = true;

                        axios.get(url, data).then(response => {
                            component.links = response.data;

                            component.links.forEach(function (link) {
                                link.errors = {};
                                link.isModified = false;
                                link.loaded = true;
                            });
                            component.options.loading = false;
                        });
                    }
                }
            }
        },
        computed: {
            mode() {
                return window.Admin.vue.stores['links'].state.mode;
            }
        },
        watch: {
            mode: function (newMode) {
                if (newMode === 'save_list_item') {
                    this.saveLink();
                }
            }
        },
        methods: {
            getDefaultModel() {
                return _.merge(this.getDefaultWidgetModel(), {
                    view: 'admin.module.links::front.partials.content.links_list_widget',
                    params: {
                        ids: [],
                        style: ''
                    }
                });
            },
            initComponent() {
                let component = this;

                component.model = _.merge(component.model, this.widget.model);

                let url = route('back.admin-panel.config.get', 'links.list_styles');

                axios.post(url).then(response => {
                    component.options.listStyles = response.data;
                    component.options.loading = false;
                });
            },
            addLink() {
                window.Admin.vue.stores['links'].commit('setMode', 'add_list_item');
                window.Admin.vue.stores['links'].commit('setLink', {});

                $('#links_list_item_form_modal').modal();
            },
            removeLink(payload) {
                swal({
                    title: "Вы уверены?",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "Отмена",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Да, удалить"
                }).then((result) => {
                    if (result.value) {
                        this.links = _.remove(this.links, function(link) {
                            return link.model.id !== payload.id;
                        });
                    }
                });
            },
            saveLink() {
                let storeLink = JSON.parse(JSON.stringify(window.Admin.vue.stores['links'].state.link));
                storeLink.hash = window.hash(storeLink.model);

                let index = this.getLinkIndex(storeLink.model.id);

                if (index > -1) {
                    this.$set(this.links, index, storeLink);
                } else {
                    this.links.push(storeLink);
                }
            },
            getSaveLinkRequests() {
                let requests = [];

                this.links.forEach(function(link) {
                    if (! link.isModified) {
                        return;
                    }

                    let url = (typeof link.model.id !== 'string') ? route('back.links.update', link.model.id): route('back.links.store');

                    let data = JSON.parse(JSON.stringify(link.model));
                    if (typeof link.model.id !== 'string') {
                        data._method = 'PUT';
                    }

                    requests.push(axios.post(url, data));
                });

                return requests;
            },
            save() {
                let component = this;

                if (component.links.length === 0) {
                    $(component.$refs.modal).modal('hide');

                    return;
                }

                let requests = this.getSaveLinkRequests();

                this.options.loading = true;

                axios.all(requests).then(axios.spread(function() {
                    for (let i = 0; i < arguments.length; i++) {
                        let postData = JSON.parse(arguments[i].config.data);

                        let index = component.getLinkIndex(postData.id);

                        let newData = {
                            errors: {},
                            isModified: false,
                            model: arguments[i].data
                        };

                        component.$set(component.links, index, newData);
                    }

                    component.model.params.ids = _.map(component.links, function (item) {
                        return item.model.id;
                    });

                    component.options.loading = false;

                    component.saveWidget(function () {
                        $(component.$refs.modal).modal('hide');
                    });
                }));
            },
            getLinkIndex(id) {
                return _.findIndex(this.links, function (link) {
                    return link.model.id === id;
                });
            }
        },
        created: function () {
            this.initComponent();
        },
        mounted() {
            let component = this;

            this.$nextTick(function () {
                $(this.$refs.modal).on('hide.bs.modal', function () {
                    component.links = [];
                    component.model = component.getDefaultModel();

                    $('#links_list_style').val(null).trigger('change');
                });
            });
        },
        mixins: [
            window.Admin.vue.mixins['widget']
        ]
    }
</script>

<style scoped>

</style>
