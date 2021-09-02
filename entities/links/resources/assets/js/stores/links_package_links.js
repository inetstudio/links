import Vuex from 'vuex';

window.Admin.vue.stores['links_package_links'] = new Vuex.Store({
  state: {
    link: {},
    mode: '',
  },
  getters: {
    emptyLink: state => {
      return {
        model: {
          id: 0,
          linkable_id: 0,
          linkable_type: '',
          additional_info: {
            path: '',
            suggestion: ''
          }
        },
        errors: {},
        hash: ''
      };
    }
  },
  mutations: {
    link (state, link) {
      let linkCopy = _.cloneDeep(link);

      linkCopy.model = (linkCopy.hasOwnProperty('model')) ? linkCopy.model : linkCopy;
      linkCopy.hash = window.hash(linkCopy.model);

      state.link = linkCopy;
    },
    mode (state, mode) {
      state.mode = mode;
    }
  },
  actions: {
    newLink (context) {
      let link = context.getters.emptyLink;
      link.model.id = UUID.generate();

      context.commit('link', link);
    },
    reset (context) {
      context.commit('mode', '');
      context.commit('link', {});
    }
  }
});
