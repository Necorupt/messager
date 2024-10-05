import axios from "axios";
import TokenService from "./TokenService";

const prefix = '/api';

const ApiService = {
    setHeader() {
        axios.defaults.headers.common["Authorization"] = `Bearer ${ TokenService.getToken() }`;
    },

    get(path, params = {}) {
        return new Promise((resolve, reject) => {
            axios.get(prefix + path, {params})
                .then(function (response) {
                    resolve(response);
                })
                .catch(function (error) {
                    reject(error);
                });
        });
    },

    post(path, data = {}) {
        return new Promise((resolve, reject) => {
            axios.post(prefix + path, data)
                .then(function (response) {
                    resolve(response);
                })
                .catch(function (error) {
                    reject(error);
                });
        });
    },

    update(path, data) {
        return new Promise((resolve, reject) => {
            axios.post(prefix + path, {...data, ...{_method: 'PUT'}})
                .then(function (response) {
                    resolve(response);
                })
                .catch(function (error) {
                    reject(error);
                });
        });
    },

    delete(path) {
        return new Promise((resolve, reject) => {
            axios.delete(prefix + path)
                .then(function (response) {
                    resolve(response);
                })
                .catch(function (error) {
                    reject(error);
                });
        });
    },
};

export default ApiService;
