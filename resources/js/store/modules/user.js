const state={
    authUser:null,
    authUserState:false,
}

const mutations={
    setAuthUser(state,user){
        state.authUser=user
    },
    setState(state){
        state.authUserState=true
    }
}

const actions={
    fetchAuthUser({commit,state}){
        axios.get('/api/authuser')
            .then(res => {
                 commit('setAuthUser',res.data.data)
            }).then(res=> commit('setState'))
    },
}

const getters={
    getAuthUser(state){
        return state.authUser
    },
}

export default {
    mutations,actions,getters,state
}
