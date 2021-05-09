// ______________________________________________Imports______________________________________________
require('./bootstrap');
require('./custom');
window.Vue = require('vue');
import StarRating from 'vue-star-rating'
import moment from 'moment';

// ______________________________________________Filters______________________________________________
Vue.filter('formatDate', function (dt) {
    // return moment(dt).format('MMMM Do YYYY, h:mm a');
    return moment(dt).fromNow(true); //eg. 1 day, 2 hours
})

// ______________________________________________Component global registration______________________________________________
Vue.component('star-rating', StarRating);
Vue.component('reviews', require('./components/frontsite/Reviews.vue').default)


// ______________________________________________Vue Prototyiping and Instantiation and Window Config______________________________________________

export const app = new Vue({
    el: '#app',
});
