import axios from "axios";

const state = {
    user: null,
    isAdmin:null
    
};
const getters = {

};
const actions = {

};
const mutations = {
    setUser(state, data) {
        state.user = data
    },
    setIsAdmin(state, data) {
        state.isAdmin = data
    },
  
};
export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
