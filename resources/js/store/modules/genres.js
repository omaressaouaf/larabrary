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
    genres: [],
    genre: new Form({
        id: '',
        name: '',
        slug: '',

    })


};
const getters = {
    allGenres(state) {
        return state.genres;
    },
    genreObject(state) {
        return state.genre
    }


};
const actions = {

    fetchGenres(context) {
        return new Promise(function (resolve, reject) {
            axios.get('/api/genres')
                .then(res => {
                    context.commit('setGenres', res.data)
                    resolve(res)
                })
                .catch(err => {
                    console.log(err)
                    reject(err)
                })
        })

    },

    deleteGenre(context, id) {
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
                    axios.delete("/api/genres/" + id)
                        .then(res => {
                            context.commit('removeGenre', id)
                            app.$Progress.finish();
                            toast.fire({
                                icon: "success",
                                title: "Genre Deleted successfully",
                            });

                        })
                        .catch(err => {
                            app.$Progress.fail();
                            app.$helpers.handleHttpErrors(err);

                        })
                }
            })


    },
    addGenre(context, genre) {
        app.$Progress.start();
        genre.post("/api/genres")
            .then(res => {
                context.commit('addGenre', res.data.genre)
                app.$Progress.finish();
                toast.fire({
                    icon: "success",
                    title: "Genre Added successfully",
                });

            })
            .catch(err => {
                app.$Progress.fail();
                app.$helpers.handleHttpErrors(err);
            })

    },
    updateGenre(context, genre) {
        return new Promise(function (resolve, reject) {
            app.$Progress.start();
            genre.put("/api/genres/" + genre.id)
                .then(res => {
                    context.commit('updateGenre', res.data.genre)
                    app.$Progress.finish();
                    toast.fire({
                        icon: "success",
                        title: "Genre Updated successfully",
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
    setGenres(state, data) {
        state.genres = data
    },
    removeGenre(state, id) {
        state.genres = state.genres.filter(genre => genre.id !== id)
    },
    addGenre(state, genre) {
        state.genre = new Form({
            id: '',
            name: '',
            slug: '',

        })
        state.genres.unshift(genre)
    },

    updateGenre(state, updtGenre) {
        const index = state.genres.findIndex(genre => genre.id === updtGenre.id)
        state.genres.splice(index, 1, updtGenre)
    }

};
export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
