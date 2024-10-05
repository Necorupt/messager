const defailtState = {
    name: '',
    description:'',
    id: null,
}


export default {
    state() {
        return {
            chat: {
                name: '',
            }
        }
    },
    mutations: {
        setCurrentChat(state, value) {
            state.chat = value;
        },
    },
    actions: {
        updateChat(context,value) {
            context.commit('setCurrentChat', value);
        },
        clearCurrentChat(context){
            context.commit('setCurrentChat', defailtState);
        }
    },
    getters: {
        currentChat(state) {
            return state.chat;
        },
    }
}