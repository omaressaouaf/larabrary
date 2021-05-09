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
    books: [],
    book: new Form({
        id: '',
        title: '',
        slug: '',
        description: '',
        price: 0,
        stock: 0,
        user_id: '',
        user: {},
        genres: [],
        images: [],
        newImages: [],

    }),
    genres: [],
    authors: [],
    selectedItems: [],


};
const getters = {
    allBooks(state) {
        return state.books;
    },
    allGenres(state) {
        return state.genres;
    },
    allAuthors(state) {
        return state.authors;
    },
    bookObject(state) {
        return state.book
    },
    selectedItems(state) {
        return state.selectedItems
    },




};
const actions = {
    fetchGenres(context) {
        axios
            .get("/api/genres")
            .then((res) => {
                context.commit('setGenres', res.data)
            })
            .catch((err) => {
                app.$helpers.handleHttpErrors(err);
            });
    },
    fetchAuthors(context) {
        axios
            .get("/api/users/authors")
            .then((res) => {
                context.commit('setAuthors', res.data)
            })
            .catch((err) => {
                app.$helpers.handleHttpErrors(err);
            });
    },
    fetchBooks(context) {
        return new Promise(function (resolve, reject) {
            axios.get('/api/books')
                .then(res => {

                    context.commit('setBooks', res.data)
                    resolve(res)
                })
                .catch(err => {
                    console.log(err)
                    reject(err)
                })
        })

    },
    addBook(context, book) {
        if (book.newImages.length > 5) {

            toast.fire({
                icon: "error",
                title: "Only 5 images allowed",
            });
            return false;
        }
        $('.submitBook').prop('disabled', true);
        app.$Progress.start();
        book.post("/api/books")
            .then(res => {
                context.commit('addBook')
                app.$Progress.finish();
                app.$router.push({
                    'name': 'books'
                })
                toast.fire({
                    icon: "success",
                    title: "Book Added successfully",
                });
                $('.submitBook').prop('disabled', false);

            })
            .catch(err => {
                toast.fire({
                    icon: "error",
                    title: "An Error Occured",
                });
                app.$Progress.fail();
                app.$helpers.handleHttpErrors(err);
                $('.submitBook').prop('disabled', false);
            })

    },
    fetchBook(context, id) {
        return new Promise(function (resolve, reject) {
            axios.get("/api/books/" + id)
                .then(res => {
                    context.commit('setBook', res.data.book)
                    resolve(res)
                })
                .catch(err => {
                    console.log(err)
                    reject(err)
                })
        })
    },
    updateBook(context, book) {
        if (book.newImages.length + book.images.length > 5) {
            toast.fire({
                icon: "error",
                title: "Only 5 images allowed",
            });
            return false;
        }
        $('.submitBook').prop('disabled', true);
        app.$Progress.start();
        book.put('/api/books/' + book.id)
            .then(res => {
                context.commit('addBook')
                app.$Progress.finish();
                app.$router.push({
                    'name': 'books'
                })
                toast.fire({
                    icon: "success",
                    title: "Book Updated successfully",
                });
                $('.submitBook').prop('disabled', false);
            })
            .catch(err => {
                toast.fire({
                    icon: "error",
                    title: "An Error Occured",
                });
                app.$Progress.fail();
                app.$helpers.handleHttpErrors(err);
                $('.submitBook').prop('disabled', false);
            })
    },
    deleteBook(context, id) {
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
                    axios.delete("/api/books/" + id)
                        .then(res => {
                            context.commit('removeBook', id)
                            app.$Progress.finish();
                            toast.fire({
                                icon: "success",
                                title: "Book Deleted successfully",
                            });

                        })
                        .catch(err => {
                            app.$Progress.fail();
                            app.$helpers.handleHttpErrors(err);

                        })
                }
            })


    },
    bulkDeleteBooks(context, selectedItems) {
        return new Promise(function (resolve, reject) {
            if (!selectedItems.length) {
                toast.fire({
                    icon: "error",
                    title: "No Items have been selected",
                });
                resolve('nothing')
                return;
            }
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
                        $('.bulk-btn').prop('disabled', true);
                        $('.bulk-btn').html("<i class='fa fa-spinner  fa-spin'></i> Deleting . Please wait")
                            ;
                        axios
                            .delete("/api/books/bulk/" + selectedItems)
                            .then((res) => {
                                context.commit("bulkRemoveBooks", selectedItems);
                                resolve(res)
                                $('.bulk-btn').prop('disabled', false);
                                $('.bulk-btn').html("<i class='fa fa-trash'></i> Bulk Delete")

                                toast.fire({
                                    icon: "success",
                                    title: "Selected books deleted Successfully",
                                });
                            })
                            .catch((err) => {
                                $('.bulk-btn').prop('disabled', false);
                                $('.bulk-btn').html("<i class='fa fa-trash'></i> Bulk Delete")
                                toast.fire({
                                    icon: "error",
                                    title: "Something went wrong",
                                });
                                reject(err)
                                this.$helpers.handleHttpErrors(err);
                            });
                    }else{
                        resolve('nothing')
                    }
                });
        })
    },



};
const mutations = {
    setGenres(state, data) {
        state.genres = data
    },
    setAuthors(state, data) {
        state.authors = data
    },
    setBooks(state, data) {
        state.books = data
    },
    addBook(state) {
        state.book = new Form({
            id: '',
            title: '',
            slug: '',
            description: '',
            price: 0,
            stock: 0,
            user_id: '',
            user: {},
            genres: [],
            images: [],
            newImages: [],
        })

    },
    setBook(state, data) {

        state.book.fill(new Form({
            id: data.id,
            title: data.title,
            slug: data.slug,
            description: data.description,
            price: data.price,
            stock: data.stock,
            user_id: data.user_id,
            user: data.user,
            genres: data.genres,
            images: data.images,
            newImages: [],
        }));



    },
    removeBook(state, id) {
        state.books = state.books.filter(book => book.id !== id)
    },
    bulkRemoveBooks(state, selectedItems) {

        selectedItems.forEach((id) => {
            state.books = state.books.filter((book) => {
                return (book.id !== id);
            });

        });
    },



};
export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
