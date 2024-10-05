import { createStore } from "vuex";
import auth from "./modules/auth";
import currentChat from "./modules/currentChat";

export default createStore({
    modules:{
        auth,
        currentChat
    },
})