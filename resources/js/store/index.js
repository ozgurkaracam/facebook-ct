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

    }
});

export default store;
