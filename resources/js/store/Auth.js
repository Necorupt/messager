import { createStore } from "vuex";
import TokenService from "../services/TokenService";
import ApiService from "../services/ApiService";

const store = createStore({
    state() {
        return {
            token: TokenService.getToken(),
            auth: null,

        };
    },
    mutations: {
        login(state) {

            state.isLoggedIn = true;
        },
        logout(state) {
            state.isLoggedIn = false;
        },
        setToken(state, value) {
            state.token = value;
        },
    },
    actions: {
        async login({ state, commit, dispatch }, form) {

            return new Promise((resolve, reject) => {
                ApiService.get("/sanctum/csrf-cookie")
                    .then((response) => {
                        ApiService.post("/login", form)
                            .then((response) => {
                                let token = response.data.tokens.access_token;

                                TokenService.saveToken(token);
                                ApiService.setHeader();
                                commit("login");
                                commit("setToken", token);
                                resolve(response);
                            })
                            .catch((error) => {
                                reject(error);
                            })
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
        logout(context) {
            context.commit('logout');
        },
    },
    getters: {
        isAuth(state) {
            return state.token;
        },
        auth(state) {
            return state.auth;
        }
    }
});

export default store;