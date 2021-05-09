import VueRouter from "vue-router";
import {
    app
} from "./admin"

export default {
    handleHttpErrors(err) {
        if (err.response) {
            if (err.response.status == 401) {
                window.location.href = "/login";
            }
            if (err.response.status == 404) {
                app.$router.push('/admin/*')
            }
            console.log("response Error : " + err.response.status);
        } else if (err.request) {
            console.log(err);
        } else {
            console.log(err);
        }
    },

}
