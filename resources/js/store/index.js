import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import roles from './modules/roles';
import books from './modules/books';
import genres from './modules/genres';
import orders from './modules/orders';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        roles,
        books,
        genres,
        orders
    }
})
