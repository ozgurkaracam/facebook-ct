const state={
    user:null,
    userState:false,
    addFriendButtonText:'Add Friend!',
    friendship:null,
    profileposts:[]
}

const mutations={
    setuser(state,user){
        state.user=user
        if(state.user.user_id!=user.user_id)
            state.friendship=user.attributes.friendship.data
    },
    setButtonText(state,text){
        state.addFriendButtonText=text
    },
    setFriendShip(state,friendship){
        state.friendship=friendship
    }
}

const actions={
    getUser({commit},id){
        axios.get('/api/users/' + id)
            .then(res => {
                commit('setuser',res.data.data)
            })
    },
    addFriend({commit,state},id){
        axios.post('/api/users/addfriend',{ 'friend_id' : state.user.user_id})
            .then(res=> commit('setFriendShip',res.data.data.attributes.friendship.data))
    },
    acceptFriend({commit,state}){
        axios.post('/api/users/acceptfriend',{'friend_id': state.user.user_id})
            .then(res=>commit('setFriendShip',res.data.data))
    },
    deleteFriend({commit,state}){
        axios.post('/api/users/deletefriend',{'friend_id': state.user.user_id})
            .then(
                res=>{
                    commit('setFriendShip',null)
                    commit('setButtonText','Add A Friend!')
                }
            )
    }
}

const getters={
    getUser(state){
        return state.user
    },
    addFriendButtonText(state,getters,rootStore){
      if(state.friendship==null)
          return 'Add A Friend!'
        else if(state.friendship.attributes.status==0 && state.friendship.attributes.user_id==getters.getAuthUser.user_id)
            return 'Pending Request..'
        else if(state.friendship.attributes.status==0 && state.friendship.attributes.user_id==state.user.user_id)
          return 'Accept!'
        else if(state.friendship.attributes.status==1)
            return 'You Are A Friend!'
        else
            return state.addFriendButtonText
    }
}

export default {
    mutations,actions,getters,state
}
