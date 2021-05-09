import axios from "axios";
import {
    app
} from '../../admin';
import {
    Form,
    HasError,
    AlertError
} from 'vForm';
window.Form = Form;

const state = {
    orders: [],
    orderDetails: [],
    order: new Form({
        billing_address: '',
        billing_card_holder_name: '',
        billing_city: '',
        billing_country: '',
        billing_discount: '',
        billing_discount_code: '',
        billing_email: '',
        billing_full_name: '',
        billing_phone: '',
        billing_state: '',
        billing_subtotal: '',
        billing_tax: '',
        billing_total: '',
        billing_zip: '',
        id: '',
        payment_mode: '',
        status: '',
        user_id: '',

    })

};
const getters = {
    allOrders(state) {
        return state.orders;
    },
    allOrderDetails() {
        return state.orderDetails
    },
    orderObject() {
        return state.order
    }




};
const actions = {

    fetchOrders(context) {
        return new Promise(function (resolve, reject) {
            axios.get('/api/orders')
                .then(res => {
                    context.commit('setOrders', res.data)
                    resolve(res)
                })
                .catch(err => {
                    console.log(err)
                    reject(err)
                })
        })

    },
    fetchOrderDetails(context, id) {
        return new Promise(function (resolve, reject) {
            axios.get('/api/orders/' + id)
                .then(res => {
                    context.commit('setOrderDetails', res.data)
                    resolve(res)
                })
                .catch(err => {
                    reject(err)
                })
        })
    },
    deleteOrder(context, id) {
        swal
            .fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            })
            .then((confirm) => {
                if (confirm.isConfirmed) {
                    app.$Progress.start();
                    axios.delete("/api/orders/" + id)
                        .then(res => {
                            context.commit('removeOrder', id)
                            app.$Progress.finish();
                            toast.fire({
                                icon: "success",
                                title: "Order Deleted successfully",
                            });

                        })
                        .catch(err => {
                            app.$Progress.fail();
                            app.$helpers.handleHttpErrors(err);

                        })
                }
            })


    },
    fetchOrderFromTableForStatus(context, order) {
        context.commit('setOrderStatus', order)
    },

    updateOrder(context, order) {
        order.put('/api/orders/' + order.id)
            .then(res => {
                context.commit('updateOrder', order)
                toast.fire({
                    icon: "success",
                    title: "Order status updated successfully",
                })
            })
            .catch(err => {
                app.$helpers.handleHttpErrors(err);
            })

    }



};
const mutations = {

    setOrders(state, data) {
        state.orders = data
    },
    setOrderDetails(state, data) {
        state.orderDetails = data.orderDetails
        state.order.fill( data.order)
    },
    removeOrder(state, id) {
        state.orders = state.orders.filter(order => order.id !== id)
    },
    setOrderStatus(state, data) {
        state.order.fill(new Form({
            id: data.id,
            status: data.status,
            billing_address: '',
            billing_card_holder_name: '',
            billing_city: '',
            billing_country: '',
            billing_discount: '',
            billing_discount_code: '',
            billing_email: '',
            billing_full_name: '',
            billing_phone: '',
            billing_state: '',
            billing_subtotal: '',
            billing_tax: '',
            billing_total: '',
            billing_zip: '',
            payment_mode: '',
            user_id: '',
        }))
    },
    updateOrder(state, updtOrder) {
        const index = state.orders.findIndex(order => order.id === updtOrder.id)
        state.orders[index].status = updtOrder.status
    }


};
export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
