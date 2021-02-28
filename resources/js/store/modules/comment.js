const state={
    comments:[]
}
const mutations={
    setComments(state,comment){
        state.comments=comment
    }
}
const actions={
    fetchPostComments({commit},postid){
        axios.get('/api/posts/'+postid+'/comments')
            .then(res=> commit('setComments',res.data.data))
    }
}
const getters={
    comments(state){
        return state.comments
    }
}

export  default  {
    state,mutations,actions,getters
}
