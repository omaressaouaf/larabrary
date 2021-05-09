// ______________________________________________Imports______________________________________________
require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router';
import routes from './routes';
import store from './store';
import helpers from './helpers.js';
import VueProgressBar from 'vue-progressbar';
import moment from 'moment';
import {
    Form,
    HasError,
    AlertError
} from 'vForm';
import swal from 'sweetalert2/src/sweetalert2.js'
import Multiselect from 'vue-multiselect'
import VueGoogleCharts from 'vue-google-charts'
import VueOnlineProp from "vue-online-prop"


// ______________________________________________State Commit Mutations for The authenticated user______________________________________________
store.commit('auth/setUser', window.user);
store.commit('auth/setIsAdmin', window.isAdmin);

// ______________________________________________Filters______________________________________________
Vue.filter('formatDate', function (dt) {
    return moment(dt).format('MMMM Do YYYY, h:mm a');
})
Vue.filter('timeAgo', function (dt) {
    return moment(dt).fromNow();
})

// ______________________________________________Component global registration______________________________________________
Vue.component('app', require('./components/App.vue').default);
Vue.component('navbar', require('./components/sections/Navbar.vue').default);
Vue.component('sidebar', require('./components/sections/Sidebar.vue').default);
Vue.component('dashboard', require('./components/pages/Dashboard.vue').default);
// Vue.component('users', require('./components/pages/users/Users.vue').default);
// Vue.component('user-create', require('./components/pages/users/UserCreate.vue').default);
// Vue.component('user-edit', require('./components/pages/users/UserEdit.vue').default);
// Vue.component('roles', require('./components/pages/roles/Roles.vue').default);
Vue.component('notfound', require('./components/pages/Notfound.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('multiselect', Multiselect)
Vue.component('clip-loader', require('vue-spinner/src/ClipLoader.vue').default);
Vue.component('scale-loader', require('vue-spinner/src/ScaleLoader.vue').default);
Vue.component('search', require('./components/sections/Search.vue').default);
Vue.component('notifications', require('./components/sections/Notifications.vue').default)
Vue.component('Offline', require('./components/sections/Offline.vue').default)






// ______________________________________________Vue Prototyiping and Instantiation and Window Config______________________________________________
window.Form = Form; //setting the vForm into the window
Vue.component(HasError.name, HasError) //vForm Config
Vue.component(AlertError.name, AlertError)

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '100px'
})
Vue.use(VueRouter)

Vue.prototype.$helpers = helpers;
window.swal = swal; // setting the sweet alert into the window
const toast = swal.mixin({ // toast and sweet alert config
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', swal.stopTimer)
        toast.addEventListener('mouseleave', swal.resumeTimer)
    }
})
window.toast = toast; // setting the toast into the window
Vue.use(VueGoogleCharts)
Vue.use(VueOnlineProp)
const router = new VueRouter({
    mode: "history",
    routes
})

router.afterEach((to, from) => {
    if (app) {
        if (!navigator.onLine) {
            app.$Progress.fail();
        }
    }
})
export const app = new Vue({
    el: '#app',
    store,
    router
});


