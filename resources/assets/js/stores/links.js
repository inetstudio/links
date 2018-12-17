window.Admin.vue.stores['links'] = new Vuex.Store({
    state: {
        emptyLink: {
            model: {
                type: null,
                linkable_id: 0,
                linkable_type: '',
                additional_info: {
                    suggestion: '',
                    title: '',
                    path: '',
                    target: [],
                    cssClass: ''
                },
                created_at: null,
                updated_at: null,
                deleted_at: null
            },
            errors: {},
            isModified: false,
            hash: ''
        },
        link: {},
        mode: ''
    },
    mutations: {
        setLink (state, link) {
            let emptyLink = JSON.parse(JSON.stringify(state.emptyLink));
            emptyLink.model.id = UUID.generate();

            let resultLink = _.merge(emptyLink, link);
            resultLink.hash = window.hash(resultLink.model);

            state.link = resultLink;
        },
        setMode (state, mode) {
            state.mode = mode;
        },
    }
});
