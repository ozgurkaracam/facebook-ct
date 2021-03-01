
const state={
    posts:[],
    likestatus:false,
    meta:null,
    loadmorestatus:true
}

const mutations={
    setPosts(state,posts){
        state.posts=posts
    },
    addPost(state,post){
        state.posts.unshift(post)
    },
    setmeta(state,meta){
        state.meta=meta
    },
    pushposts(state,posts){
        posts.map(post=>state.posts.push(post))
    }
}

const actions={
    fetchAllPosts({commit}){
        axios.get('/api/posts')
            .then(response =>{
                console.log(response.data.data)
                commit('setPosts',response.data.data)
                commit('setmeta',response.data.meta)
            })
    },
    fetchUserPosts({commit,state},uid){
        axios.get('/api/users/' + uid + '/posts')
            .then(response => {
                state.loadmorestatus=true
                commit('setPosts',response.data.data)
                commit('setmeta',response.data.meta)
            })
    },
    addPost({commit},post){
        var data=new FormData();
        data.append('body',post.body);
        data.append('image',post.image);
        return axios.post('/api/posts',data)
            .then(res=>{
                commit('addPost',res.data)
                console.log(res)
            })
    },
    likepost({commit,state},postid){
        axios.post('/api/likes',{ 'post_id': postid})
            .then(res=>{
                state.posts.map(post=>{
                    if(res.data.data.post_id==post.data.post_id)
                        post.data=res.data.data
                })
            })
    },
    loadmore({state,commit}){
        if(state.meta.current_page<=state.meta.last_page){
            state.meta.current_page=state.meta.current_page+1
            axios.get('/api/posts?page='+state.meta.current_page)
                .then(res=>{
                    console.log(res.data.data)
                    commit('pushposts',res.data.data)
                })
        }
        if(state.meta.current_page==state.meta.last_page){
            state.loadmorestatus=false
        }
    }
}

const getters={
    posts(state){
        return state.posts
    },
    userposts(state){
        return state.posts
    },
    loadmorestatus(state){
        return state.loadmorestatus
    }
}

export default {
    state,mutations,actions,getters
}
