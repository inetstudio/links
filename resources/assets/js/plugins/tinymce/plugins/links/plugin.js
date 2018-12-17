window.tinymce.PluginManager.add('links', function (editor) {
    function initLinksComponents(componentType, widgetData, linkData) {
        let component = null;

        switch (componentType) {
            case 'list':
                if (typeof window.Admin.vue.modulesComponents.$refs['links_LinksList'] == 'undefined') {
                    window.Admin.vue.modulesComponents.modules.links.components = _.union(window.Admin.vue.modulesComponents.modules.links.components, [
                        {
                            name: 'LinksList',
                            data: widgetData
                        }
                    ]);
                } else {
                    component = window.Admin.vue.modulesComponents.$refs['links_LinksList'][0];

                    component.$data.events.widgetSaved = widgetData.widget.events.widgetSaved;
                    component.$data.model.id = widgetData.model.id;
                }
            case 'link':
                if (typeof window.Admin.vue.modulesComponents.$refs['links_LinksListItemForm'] == 'undefined') {
                    window.Admin.vue.modulesComponents.modules.links.components = _.union(window.Admin.vue.modulesComponents.modules.links.components, [
                        {
                            name: 'LinksListItemForm',
                            data: linkData
                        }
                    ]);
                } else {
                    component = window.Admin.vue.modulesComponents.$refs['links_LinksListItemForm'][0];

                    component.$data.saveTarget = linkData.form.saveTarget;
                    component.$data.events.linkSaved = linkData.form.events.linkSaved;
                }
        }
    }

    let widgetData = {
        widget: {
            events: {
                widgetSaved: function (model) {
                    editor.execCommand('mceReplaceContent', false, '<img class="content-widget" data-type="links.list" data-id="'+model.id+'" alt="Виджет-ссылки" />');
                }
            }
        }
    };

    let linkData = {
        form: {
            saveTarget: '',
            events: {
                linkSaved: function (link) {}
            }
        }
    };

    editor.addButton('add_link', {
        type: 'menubutton',
        title: 'Ссылки',
        icon: 'link',
        menu: [{
            text: 'Список',
            onpostrender: function() {
                let _this = this;

                editor.on('nodechange', function(e) {
                    let html = e.element.outerHTML,
                        isList = /<img class="content-widget".+data-type="links\.list".+>/g.test(html);

                    _this.active(isList);
                })
            },
            onclick: function() {
                let content = editor.selection.getContent();

                let isList = /<img class="content-widget".+data-type="links\.list".+>/g.test(content);

                if (content === '' || isList) {
                    widgetData.model = {
                        id: parseInt($(content).attr('data-id')) || 0
                    };

                    linkData.form.saveTarget = 'store';
                    linkData.form.events.linkSaved = function (link) {
                        window.Admin.vue.stores['links'].commit('setMode', 'save_list_item');
                    };

                    initLinksComponents('list', widgetData, linkData);

                    window.waitForElement('#links_list_modal', function() {
                        $('#links_list_modal').modal();
                    });
                } else {
                    swal({
                        title: "Ошибка",
                        text: "Необходимо выбрать виджет-ссылки",
                        type: "error"
                    });

                    return false;
                }
            }
        }, {
            text: 'Ссылка',
            onpostrender: function() {
                let _this = this;

                editor.on('nodechange', function(e) {
                    let html = e.element.outerHTML,
                        isLink = /<\s*a[^>]*>(.*?)<\s*\/\s*a>/g.test(html);

                    _this.active(isLink);
                })
            },
            onclick: function() {
                let node = editor.selection.getNode(),
                    html = node.outerHTML,
                    content = editor.selection.getContent();

                let $link = $(html);

                linkData.form.link = {
                    model: {
                        id: parseInt($link.attr('data-id')) || 0
                    },
                };
                linkData.form.saveTarget = 'db';

                if ($link.attr('data-type') === 'links.link' && $link.attr('data-id')) {
                    linkData.form.events.linkSaved = function (link) {
                        let target = (typeof link.model.additional_info.target[0] !== 'undefined') ? link.model.additional_info.target[0] : null;

                        editor.dom.setAttrib(node, 'href', link.model.additional_info.path);
                        editor.dom.setAttrib(node, 'class', (link.model.additional_info.cssClass || ''));
                        editor.dom.setAttrib(node, 'target', target);
                    };

                    window.Admin.vue.stores['links'].commit('setMode', 'edit_link');
                    window.Admin.vue.stores['links'].commit('setLink', linkData.form.link);
                } else {
                    linkData.form.events.linkSaved = function (link) {
                        let newTab = (typeof link.model.additional_info.target[0] !== 'undefined' && link.model.additional_info.target[0] === 'blank') ? 'target="_blank"' : '',
                            text = content || link.model.additional_info.title;

                        editor.execCommand('mceReplaceContent', false, '<a href="'+link.model.additional_info.path+'" '+newTab+' data-type="links.link" data-id="'+link.model.id+'" class="'+(link.model.additional_info.cssClass || '')+'">'+text+'</a>');
                    };

                    window.Admin.vue.stores['links'].commit('setMode', 'add_link');
                    window.Admin.vue.stores['links'].commit('setLink', {});
                }

                initLinksComponents('link', {}, linkData);

                window.waitForElement('#links_list_item_form_modal', function() {
                    $('#links_list_item_form_modal').modal();
                });
            }
        }, {
            text: 'Удалить ссылку',
            onclick: function() {
                editor.undoManager.transact(function () {
                    editor.execCommand('unlink');
                });
            }
        }],
        onpostrender: function() {
            let _this = this;

            editor.on('nodechange', function(e) {
                let html = e.element.outerHTML,
                    isList = /<img class="content-widget".+data-type="links\.list".+>/g.test(html),
                    isLink = /<\s*a[^>]*>(.*?)<\s*\/\s*a>/g.test(html);

                _this.active(isList || isLink);
            })
        }
    })
});
