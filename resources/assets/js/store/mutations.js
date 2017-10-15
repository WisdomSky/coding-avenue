

export default {

    login (state, user) {
        state.auth_user = user;
    },

    flushUser (state) {
        state.auth_user = {};
    },

    requestLogout(state) {
        state.request_logout = true;
    },



}