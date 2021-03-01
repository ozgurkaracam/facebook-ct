<template>
    <div class="bg-white rounded shadow w-2/3 mt-6 overflow-hidden">
        <div class="flex flex-col p-4">
            <div class="flex items-center">
                <div class="w-8">
                    <img :src="imagepath+post.data.attributes.posted_by.data.profileimage.data.attributes.image_path" alt="profile image for user" class="w-8 h-8 object-cover rounded-full">
                </div>
                <div class="ml-6">
                    <div class="text-sm font-bold">{{ post.data.attributes.posted_by.data.attributes.name}}</div>
                    <div class="text-sm text-gray-600">{{ post.data.attributes.post_created_date}}</div>
                </div>
            </div>
            <div class="mt-4">
            <p>{{post.data.attributes.post_body}}</p>
            </div>
        </div>

        <div class="w-full p-3" v-if="post.data.attributes.post_image">
            <img :src="post.data.attributes.post_image" alt="post image" class="object-cover w-full">
        </div>

        <div class="px-4 pt-2 flex justify-between text-gray-700 text-sm">
            <div class="flex">
                <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" class="fill-current w-5 h-5"><path d="M20.8 15.6c.4-.5.6-1.1.6-1.7 0-.6-.3-1.1-.5-1.4.3-.7.4-1.7-.5-2.6-.7-.6-1.8-.9-3.4-.8-1.1.1-2 .3-2.1.3-.2 0-.4.1-.7.1 0-.3 0-.9.5-2.4.6-1.8.6-3.1-.1-4.1-.7-1-1.8-1-2.1-1-.3 0-.6.1-.8.4-.5.5-.4 1.5-.4 2-.4 1.5-2 5.1-3.3 6.1l-.1.1c-.4.4-.6.8-.8 1.2-.2-.1-.5-.2-.8-.2H3.7c-1 0-1.7.8-1.7 1.7v6.8c0 1 .8 1.7 1.7 1.7h2.5c.4 0 .7-.1 1-.3l1 .1c.2 0 2.8.4 5.6.3.5 0 1 .1 1.4.1.7 0 1.4-.1 1.9-.2 1.3-.3 2.2-.8 2.6-1.6.3-.6.3-1.2.3-1.6.8-.8 1-1.6.9-2.2.1-.3 0-.6-.1-.8zM3.7 20.7c-.3 0-.6-.3-.6-.6v-6.8c0-.3.3-.6.6-.6h2.5c.3 0 .6.3.6.6v6.8c0 .3-.3.6-.6.6H3.7zm16.1-5.6c-.2.2-.2.5-.1.7 0 0 .2.3.2.7 0 .5-.2 1-.8 1.4-.2.2-.3.4-.2.6 0 0 .2.6-.1 1.1-.3.5-.9.9-1.8 1.1-.8.2-1.8.2-3 .1h-.1c-2.7.1-5.4-.3-5.4-.3H8v-7.2c0-.2 0-.4-.1-.5.1-.3.3-.9.8-1.4 1.9-1.5 3.7-6.5 3.8-6.7v-.3c-.1-.5 0-1 .1-1.2.2 0 .8.1 1.2.6.4.6.4 1.6-.1 3-.7 2.1-.7 3.2-.2 3.7.3.2.6.3.9.2.3-.1.5-.1.7-.1h.1c1.3-.3 3.6-.5 4.4.3.7.6.2 1.4.1 1.5-.2.2-.1.5.1.7 0 0 .4.4.5 1 0 .3-.2.6-.5 1z"/></svg>
                <p>{{ post.data.attributes.likes_count }} Likes</p>
            </div>

            <div>
                <p class="cursor-pointer hover:underline" @click="commentbutton=!commentbutton">{{ comments.length }} comments</p>
            </div>
        </div>

        <div class="flex justify-between border-1 border-gray-400 m-4">
            <button @click="$store.dispatch('likepost',post.data.post_id)"  class="flex justify-center py-2 rounded-lg text-sm text-gray-700 w-full hover:bg-gray-200" v-bind:class="{ 'bg-blue-400 text-white' : post.data.attributes.like_status }">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-current w-5 h-5"><path d="M20.8 15.6c.4-.5.6-1.1.6-1.7 0-.6-.3-1.1-.5-1.4.3-.7.4-1.7-.5-2.6-.7-.6-1.8-.9-3.4-.8-1.1.1-2 .3-2.1.3-.2 0-.4.1-.7.1 0-.3 0-.9.5-2.4.6-1.8.6-3.1-.1-4.1-.7-1-1.8-1-2.1-1-.3 0-.6.1-.8.4-.5.5-.4 1.5-.4 2-.4 1.5-2 5.1-3.3 6.1l-.1.1c-.4.4-.6.8-.8 1.2-.2-.1-.5-.2-.8-.2H3.7c-1 0-1.7.8-1.7 1.7v6.8c0 1 .8 1.7 1.7 1.7h2.5c.4 0 .7-.1 1-.3l1 .1c.2 0 2.8.4 5.6.3.5 0 1 .1 1.4.1.7 0 1.4-.1 1.9-.2 1.3-.3 2.2-.8 2.6-1.6.3-.6.3-1.2.3-1.6.8-.8 1-1.6.9-2.2.1-.3 0-.6-.1-.8zM3.7 20.7c-.3 0-.6-.3-.6-.6v-6.8c0-.3.3-.6.6-.6h2.5c.3 0 .6.3.6.6v6.8c0 .3-.3.6-.6.6H3.7zm16.1-5.6c-.2.2-.2.5-.1.7 0 0 .2.3.2.7 0 .5-.2 1-.8 1.4-.2.2-.3.4-.2.6 0 0 .2.6-.1 1.1-.3.5-.9.9-1.8 1.1-.8.2-1.8.2-3 .1h-.1c-2.7.1-5.4-.3-5.4-.3H8v-7.2c0-.2 0-.4-.1-.5.1-.3.3-.9.8-1.4 1.9-1.5 3.7-6.5 3.8-6.7v-.3c-.1-.5 0-1 .1-1.2.2 0 .8.1 1.2.6.4.6.4 1.6-.1 3-.7 2.1-.7 3.2-.2 3.7.3.2.6.3.9.2.3-.1.5-.1.7-.1h.1c1.3-.3 3.6-.5 4.4.3.7.6.2 1.4.1 1.5-.2.2-.1.5.1.7 0 0 .4.4.5 1 0 .3-.2.6-.5 1z"/></svg>
                <p class="ml-2">Like</p>
            </button>
            <button @click="commentbutton=!commentbutton" class="flex justify-center py-2 rounded-lg text-sm text-gray-700 w-full hover:bg-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-current w-5 h-5"><path d="M20.3 2H3.7C2 2 .6 3.4.6 5.2v10.1c0 1.7 1.4 3.1 3.1 3.1V23l6.6-4.6h9.9c1.7 0 3.1-1.4 3.1-3.1V5.2c.1-1.8-1.3-3.2-3-3.2zm1.8 13.3c0 1-.8 1.8-1.8 1.8H9.9L5 20.4V17H3.7c-1 0-1.8-.8-1.8-1.8v-10c0-1 .8-1.8 1.8-1.8h16.5c1 0 1.8.8 1.8 1.8v10.1zM6.7 6.7h10.6V8H6.7V6.7zm0 2.9h10.6v1.3H6.7V9.6zm0 2.8h10.6v1.3H6.7v-1.3z"/></svg>
                <p>Comment</p>
            </button>
        </div>
        <div v-if="commentbutton">
            <div v-for="comment in comments" class="w-full bg-white border-t border-gray-200 px-3 py-2">
                <div class="flex justify-between items-center">
                    <div class="w-min-w">
                        <img :src="imagepath+comment.data.attributes.data.posted_by.data.profileimage.data.attributes.image_path" class="w-8 h-8 rounded-full object-cover" alt="">
                    </div>
                    <div class="ml-2 w-full">
                        <div>
                            <span class="font-bold">{{ comment.data.attributes.data.posted_by.data.attributes.name }}</span>
                        </div>
                        <div>
                            {{ comment.data.attributes.data.comment_body }}
                        </div>
                        <div class="flex text-sm text-gray-400 justify-between">
                            <span>{{ comment.data.attributes.data.created_at }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-3 py-2">
                <div class="flex">
                    <div class="w-min-w">
                        <img :src="imagepath+getAuthUser.profileimage.data.attributes.image_path" class="w-8 h-8 rounded-full object-cover" alt="">
                    </div>
                    <div class="w-full mx-2">
                        <input
                            type="text"
                            placeholder="input your comment.."
                            v-model="body"
                            class="bg-gray-300 rounded-2xl w-full h-8 shadow border-none">
                    </div>
                    <transition name="fade">
                        <div class="w-min-w" v-if="body.length>0">
                            <button @click="sendcomment()" class="rounded-full bg-blue-500 border border-white text-white px-2 py-1">SEND</button>
                        </div>
                    </transition>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "Post",
        props:['post'],
        methods:{
          sendcomment(){
              axios.post('/api/posts/'+this.post.data.post_id+'/comments',{'comment_body':this.body})
              .then(res=>{
                  this.comments.unshift(res.data)
                  this.body=''
                  this.comments_count=this.comments_count+1
              })
          }
        },
        computed:{
            ...mapGetters(['imagepath','getAuthUser','getUser']),
            comments(){
                return this.post.data.comments.data.data
            },
            comments_count(){
                return this.post.data.comments.data.comments_count
            }
        },
        data(){
            return{
                commentbutton:false,
                body:''
            }
        }
    }
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
</style>
