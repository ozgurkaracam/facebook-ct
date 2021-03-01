<template>
    <div>
        <div v-if="getUser" class="flex flex-col relative mb-10">
            <div class="relative">

                <div class="w-full h-64 overflow-hidden">
                <CoverImage :image="{
                    imagepath:imagepath+getUser.coverimage.data.attributes.image_path,
                    type:'cover',
                    width:1400,
                    height:400,
                    class:'w-full cursor-pointer object-cover'
                }" />
                </div>
                <div class="absolute bottom-0 -mb-8 left-0 items-center flex justify-between w-full">
                    <div class="flex items-center">
                        <CoverImage :image="{
                        imagepath:imagepath+getUser.profileimage.data.attributes.image_path,
                            type:'profile',
                            width:700,
                         height:700,
                        class:'ml-4 rounded-full w-32 h-32 shadow-lg border-4 cursor-pointer border-white'
                }" />
                        <p class="text-2xl font-bold text-gray-700 ml-4 ">{{getUser.attributes.name}}</p>
                    </div>
                    <div>
                        <div v-if="addFriendButtonText=='Accept!'">
                            <button @click="$store.dispatch('acceptFriend')" class="px-3 py-2 rounded bg-gray-200 mr-5 focus:outline-none">
                                {{ addFriendButtonText }}
                            </button>
                            <button @click="$store.dispatch('deleteFriend')" class="px-3 py-2 rounded bg-red-700 text-white mr-5 focus:outline-none">
                                Ignore
                            </button>
                        </div>
                        <button @click="$store.dispatch('addFriend',getUser.user_id)" class="px-3 py-2 rounded bg-green-600 text-white mr-5 float-right focus:outline-none" v-else-if="getUser.user_id!=getAuthUser.user_id">
                            {{ addFriendButtonText}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col items-center py-4">
            <NewPost v-if="false" />
            <Post v-if="userposts" v-for="post in userposts" :key="post.post_id" :post="post" />
            <p v-if="userposts.length <1"> No Content Posts... </p>
            <LoadMore :posts="userposts" />
        </div>
    </div>
</template>

<script>
import Post from "../../components/Post";
import NewPost from "../../components/NewPost";
import LoadMore from "../../components/LoadMore";
import {mapGetters} from "vuex";
import CoverImage from "../../components/CoverImage";

export default {
    name: "ProfileFeed",
    components: {Post, NewPost, LoadMore, CoverImage},
    data() {
        return {
            user: {},
            posts: [],
            loading:true,
            loadinguser:true
        }
    },
    mounted() {
        this.$store.dispatch('fetchUserPosts',this.$route.params.userid);
        this.$store.dispatch('getUser',this.$route.params.userid)

    },
    computed:{
        ...mapGetters(['userposts','getUser','getAuthUser','addFriendButtonText','imagepath'])
    },
    methods:{
        addfriend(){
            this.$store.dispatch('addFriend',this.getProfileUser.user_id);
        }
    }
}
</script>

<style scoped>

</style>
