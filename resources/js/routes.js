import Dashboard from './components/pages/Dashboard.vue';
import Users from './components/pages/users/Users.vue';
import UserCreate from './components/pages/users/UserCreate.vue';
import UserEdit from './components/pages/users/UserEdit.vue';
import Notfound from './components/pages/Notfound.vue';
import Roles from './components/pages/roles/Roles.vue';
import Books from './components/pages/books/Books.vue';
import BookCreate from './components/pages/books/BookCreate.vue';
import BookEdit from './components/pages/Books/BookEdit.vue';
import Genres from './components/pages/genres/Genres.vue';
import Orders from './components/pages/orders/Orders.vue';
import OrderInvoice from './components/pages/orders/OrderInvoice.vue';
import store from './store';
import {
    app
} from './admin';


const routes = [{
        path: '/admin',
        component: Dashboard,
        name: 'dashboard',
        beforeEnter: checkAuthAndAdmin

    },
    {
        path: '/admin/users',
        component: Users,
        name: 'users',
        beforeEnter: checkAuthAndAdmin

    },
    {
        path: '/admin/users/create',
        component: UserCreate,
        name: 'users.create',
        beforeEnter: checkAuthAndAdmin
    },
    {
        path: '/admin/users/:id/edit',
        component: UserEdit,
        name: 'users.edit',
        beforeEnter: checkAuthAndAdmin


    },
    {
        path: '/admin/roles',
        component: Roles,
        name: 'roles',
        beforeEnter: checkAuthAndAdmin

    },

    {
        path: '/admin/books',
        component: Books,
        name: 'books',
        beforeEnter: checkAuthAndAdmin

    },
    {
        path: '/admin/books/create',
        component: BookCreate,
        name: 'books.create',
        beforeEnter: checkAuthAndAdmin
    },
    {
        path: '/admin/books/:id/edit',
        component: BookEdit,
        name: 'books.edit',
        beforeEnter: checkAuthAndAdmin


    },
    {
        path: '/admin/genres',
        component: Genres,
        name: 'genres',
        beforeEnter: checkAuthAndAdmin

    },
    {
        path: '/admin/orders',
        component: Orders,
        name: 'orders',
        beforeEnter: checkAuthAndAdmin

    },
    {
        path: '/admin/orders/:id/invoice',
        component: OrderInvoice,
        name: 'orders.invoice',
        beforeEnter: checkAuthAndAdmin

    },
    {
        path: '/admin/*',
        component: Notfound
    },



];

function checkAuthAndAdmin(to, from, next) {
    if (app) {
        app.$Progress.start();
    }
    if (!store.state.auth.user || !store.state.auth.isAdmin) {
        if (app) {
            app.$Progress.fail();
        }
        window.location.href = "/login";
    } else {

        next()
    }
}
export default routes;
