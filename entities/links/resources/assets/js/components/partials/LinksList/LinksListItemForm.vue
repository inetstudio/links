<template>
    <div id="links_list_item_form_modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal inmodal fade" ref="modal">
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
                        <base-dropdown
                            label = "Тип ссылки"
                            name = "link_type"
                            v-bind:attributes = "{
                                'data-placeholder': 'Выберите тип'
                            }"
                            v-bind:options = "options.linksTypes"
                            v-bind:selected.sync="link.model.link_type"
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
                                v-bind:value.sync = "link.model.additional_info.suggestion"
                            />
                        </div>

                        <div class="link-item-data" v-show="link.model.link_type">
                            <div class="link-item-additional">
                                <base-input-text
                                    label = "Заголовок"
                                    name = "link_title"
                                    v-bind:value.sync = "link.model.additional_info.title"
                                />

                                <base-input-text
                                    label = "Ссылка"
                                    name = "link_path"
                                    v-bind:attributes = "{
                                        'disabled': (link.model.link_type !== 'link'),
                                    }"
                                    v-bind:value.sync = "link.model.additional_info.path"
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
                                v-bind:selected.sync = "link.model.additional_info.target"
                            />

                            <base-input-text
                                label = "CSS класс"
                                name = "link_css"
                                v-bind:value.sync = "link.model.additional_info.cssClass"
                            />
                        </div>
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
        props: {
            form: {
                type: Object,
                default() {
                    return {
                        saveTarget: 'store',
                        events: {
                            linkSaved: function() {}
                        }
                    };
                }
            },
        },
        data() {
            return {
                link: {},
                options: {
                    loading: true,
                    linksTypes: []
                },
                saveTarget: this.form.saveTarget,
                events: this.form.events
            }
        },
        computed: {
            showSuggestions() {
                return (this.link.model.link_type && this.link.model.link_type !== 'link');
            }
        },
        watch: {
            'link.model': {
                handler: function (newValue, oldValue) {
                    this.link.isModified = ! (! newValue
                        || typeof newValue.id === 'undefined'
                        || typeof oldValue.id === 'undefined'
                        || this.link.hash === window.hash(newValue));
                },
                deep: true
            },
            'link.model.link_type': function (newValue, oldValue) {
                if (! newValue || (newValue === oldValue)) {
                    return;
                }

                if (!! oldValue) {
                    let currentData = {
                        model: {
                            id: this.link.model.id,
                            link_type: newValue
                        }
                    };

                    this.link = _.merge(JSON.parse(JSON.stringify(window.Admin.vue.stores['links'].state.emptyLink)), currentData);
                }

                let routeName = $('#link_type').select2().find(':selected').attr('data-suggestions'),
                    suggestionsURL = (typeof routeName !== 'undefined') ? String(route(routeName)) : '';

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

                component.link = JSON.parse(JSON.stringify(window.Admin.vue.stores['links'].state.emptyLink));

                let url = route('back.admin-panel.config.get', 'links.links_types');

                component.options.loading = true;

                axios.post(url).then(response => {
                    component.options.linksTypes = response.data;
                    component.options.loading = false;
                });
            },
            loadLink() {
                let component = this;

                this.options.loading = true;
                component.link = JSON.parse(JSON.stringify(window.Admin.vue.stores['links'].state.link));

                switch (component.saveTarget) {
                    case 'store':
                        $('#link_type').val(component.link.model.link_type).trigger('change');

                        this.options.loading = false;

                        break;
                    case 'db':
                        if (typeof component.link.model.id === 'string') {
                            this.options.loading = false;

                            return;
                        }

                        let url = route('back.links.show', component.link.model.id);

                        axios.get(url).then(response => {
                            component.link = {
                                errors: {},
                                isModified: false,
                                model: response.data,
                                hash: window.hash(response.data)
                            };

                            $('#link_type').val(component.link.model.link_type).trigger('change');

                            this.options.loading = false;
                        });
                        break;
                }
            },
            saveLink() {
                let component = this;

                if (component.link.isModified && component.link.model.additional_info.path !== '') {
                    component.options.loading = true;

                    switch (component.saveTarget) {
                        case 'store':
                            window.Admin.vue.stores['links'].commit('setLink', JSON.parse(JSON.stringify(component.link)));
                            component.linkSaved(component.link);

                            break;
                        case 'db':
                            let url = (typeof component.link.model.id !== 'string') ? route('back.links.update', component.link.model.id): route('back.links.store');

                            let data = JSON.parse(JSON.stringify(component.link.model));
                            if (typeof component.link.model.id !== 'string') {
                                data._method = 'PUT';
                            }

                            axios.post(url, data).then(response => {
                                component.link = {
                                    errors: {},
                                    isModified: false,
                                    model: response.data
                                };

                                component.linkSaved(component.link);
                            });

                            break;
                    }
                } else {
                    $(this.$refs.modal).modal('hide');
                }
            },
            linkSaved(link) {
                let component = this;

                component.events.linkSaved(link);
                component.options.loading = false;

                $(component.$refs.modal).modal('hide');
            },
            suggestionSelect(payload) {
                let component = this;

                let data = payload.data;

                component.link.model.additional_info.suggestion = data.title || '';
                component.link.model.additional_info.title = this.link.model.additional_info.suggestion;
                component.link.model.additional_info.path = data.path || '';

                component.link.model.linkable_id = data.id || '';
                component.link.model.linkable_type = data.type || '';
            }
        },
        created: function() {
            this.initComponent();
        },
        mounted() {
            let component = this;

            this.$nextTick(function() {
                $(component.$refs.modal).on('show.bs.modal', function() {
                    component.loadLink();
                });

                $(component.$refs.modal).on('hide.bs.modal', function() {
                    component.link = JSON.parse(JSON.stringify(window.Admin.vue.stores['links'].state.emptyLink));
                    component.state = '';

                    $('#link_type').val(null).trigger('change');
                });
            });
        }
    }
</script>

<style scoped>

</style>
