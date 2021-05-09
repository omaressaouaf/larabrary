import axios from "axios";
import {
    app
} from '../../admin';
import {
    Form,
    HasError,
    AlertError
} from 'vForm';
window.Form = Form; //setting the vForm into the window

const state = {
    roles: [],
    role: new Form({
        id: '',
        name: '',
        description: '',

    }),
    


};
const getters = {
    allRoles(state) {
        return state.roles;
    },
    roleObject(state) {
        return state.role
    }


};
const actions = {

    // searchRoles(context, query) {
    //     var searchTimeout;
    //     axios
    //         .get("/api/roles/search?query=" + query)
    //         .then((res) => {
    //             // if (res.data.roles.length) {

    //             if (searchTimeout) {
    //                 clearTimeout(searchTimeout);
    //             }

    //             searchTimeout = setTimeout(function () {
    //                 // $('#error').html('')
    //                 context.commit('setRoles', res.data.roles)

    //             }, 2000);

    //             // } 
    //             // else {
    //             //     $('#error').html('nothing')

    //             // }
    //         })
    //         .catch((err) => {
    //             console.log(err);
    //         });
    // },
    fetchRoles(context) {
        return new Promise(function (resolve, reject) {
            axios.get('/api/roles')
                .then(res => {
                    context.commit('setRoles', res.data)
                    resolve(res)
                })
                .catch(err => {
                    console.log(err)
                    reject(err)
                })
        })

    },

    deleteRole(context, id) {
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
                    axios.delete("/api/roles/" + id)
                        .then(res => {
                            context.commit('removeRole', id)
                            app.$Progress.finish();
                            toast.fire({
                                icon: "success",
                                title: "Role Deleted successfully",
                            });

                        })
                        .catch(err => {
                            app.$Progress.fail();
                            app.$helpers.handleHttpErrors(err);

                        })
                }
            })


    },
    addRole(context, role) {
        app.$Progress.start();
        role.post("/api/roles")
            .then(res => {
                context.commit('addRole', res.data.role)
                app.$Progress.finish();
                toast.fire({
                    icon: "success",
                    title: "Role Added successfully",
                });
            })
            .catch(err => {
                app.$Progress.fail();
                app.$helpers.handleHttpErrors(err);
            })

    },
    updateRole(context, role) {
        return new Promise(function (resolve, reject) {
            app.$Progress.start();
            role.put("/api/roles/" + role.id)
                .then(res => {
                    context.commit('updateRole', res.data.role)
                    app.$Progress.finish();
                    toast.fire({
                        icon: "success",
                        title: "Role Updated successfully",
                    });
                    resolve(res)

                })
                .catch(err => {
                    app.$Progress.fail();
                    app.$helpers.handleHttpErrors(err);
                    reject(err)
                })
        })

    },
};
const mutations = {
    setRoles(state, data) {
        state.roles = data
    },
    removeRole(state, id) {
        state.roles = state.roles.filter(role => role.id !== id)
    },
    addRole(state, role) {
        state.role = new Form({
            id: '',
            name: '',
            description: '',

        })

        state.roles.unshift(role)
    },

    updateRole(state, updtRole) {
        const index = state.roles.findIndex(role => role.id === updtRole.id)
        state.roles.splice(index, 1, updtRole)
    }

};
export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
