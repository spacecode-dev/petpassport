import store from "../index";

export default {
    state: {
        show: false,
        storage: {
            path: location.origin + '/storage'
        },
        scroll: {
            settings: {
                suppressScrollX: true,
                swipeEasing: true,
                wheelSpeed: 2
            }
        },
        comments: {
            scroll: {
                settings: {
                    suppressScrollX: true,
                    swipeEasing: true,
                    wheelSpeed: 2
                }
            },
        },
        filemanager: {
            showModal: false,
            selectedFiles: [],
            scroll: {
                show: true,
                settings: {
                    suppressScrollX: true,
                    swipeEasing: true,
                    wheelSpeed: 2
                }
            },
        },
        sidebar: {
            show: true,
            scroll: {
                show: true,
                settings: {
                    suppressScrollX: true,
                    swipeEasing: true,
                    wheelSpeed: 2
                }
            },
        },
        search: {
            show: false,
        },
        lang: {
            selected: 'Ru'
        },
        partner: {
            gender: null,
            age: 16,
            country: null,
            city: null
        }
    },
    actions: {
        SHOW_TOGGLE: ({ commit }, credential) => {
            return new Promise(() => {
                commit('SHOW_TOGGLE', credential);
            });
        },
        SIDEBAR_TOGGLE: ({ commit }, credential) => {
            return new Promise(() => {
                commit('SIDEBAR_TOGGLE');
            });
        },
        MODAL_FILEMANAGER_TOGGLE: ({ commit }, credential) => {
            return new Promise(() => {
                commit('MODAL_FILEMANAGER_TOGGLE');
            });
        },
        MODAL_FILEMANAGER_CLEAR_SELECTED: ({ commit }, credential) => {
            return new Promise(() => {
                commit('MODAL_FILEMANAGER_CLEAR_SELECTED');
            });
        },
        MODAL_FILEMANAGER_PUT_SELECTED: ({ commit }, credential) => {
            return new Promise(() => {
                commit('MODAL_FILEMANAGER_PUT_SELECTED', credential);
            });
        },
        SEARCH_TOGGLE: ({ commit }, credentials) => {
            return new Promise(() => {
                commit('SEARCH_TOGGLE');
            });
        },
    },
    mutations: {
        SHOW_TOGGLE: (state, value) => {
            state.show = value;
        },
        MODAL_FILEMANAGER_TOGGLE: (state) => {
            state.filemanager.showModal = !state.filemanager.showModal;
        },
        MODAL_FILEMANAGER_CLEAR_SELECTED: (state) => {
            state.filemanager.selectedFiles = [];
        },
        MODAL_FILEMANAGER_PUT_SELECTED: (state, files) => {
            state.filemanager.selectedFiles = files;
        },
        SIDEBAR_TOGGLE: (state) => {
            state.sidebar.show = !state.sidebar.show;
        },
        SEARCH_TOGGLE: (state) => {
            state.search.show = !state.search.show;
        }
    }
}
