export default {

    getAuthUser(state) {
        return state.auth_user;
    },

    isLoggedIn(state) {
        return state.auth_user !== undefined && state.auth_user.user_id !== undefined && state.auth_user.user_id !== null;
    },


}