import { createStore } from 'vuex'
import User from './modules/user'
import Profile from './modules/profile'
import Post from './modules/post'
import Comment from './modules/comment'
const store=createStore({
    modules:{
        User,
        Profile,
        Post,
        Comment

    },
    getters:{
        sitename(){

        },
        imagepath(){
            return 'http://localhost:8000/images/'
        }
    }
});

export default store;
