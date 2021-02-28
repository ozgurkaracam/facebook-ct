import {createRouter, createWebHistory} from "vue-router";
import NewsFeed from "../views/NewsFeed";
import ProfileFeed from "../views/Users/ProfileFeed";


var routes=[
    { path: '/', component: NewsFeed, name: 'home' },
    { path: '/users/:userid' , component: ProfileFeed, name:'user'},
]
const router=createRouter({
    routes,
    history: createWebHistory()
})


export default router;
