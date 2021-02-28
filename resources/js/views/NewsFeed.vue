<template>
    <div class="flex flex-col items-center py-4">
        <NewPost />
        <Post v-if="posts" v-for="post in posts" :key="post.post_id" :post="post" />
        <div v-if="loadmorestatus" class="mt-5 py-1 px-4 justify-center text-gray-400 cursor-pointer hover:underline" @click="$store.dispatch('loadmore',posts.meta)">
            Load More...
        </div>
    </div>
</template>

<script>
    import NewPost from '../components/NewPost';
    import Post from '../components/Post';
    import {mapGetters} from "vuex";

    export default {
        name: "NewsFeed",

        components: {
            NewPost,
            Post,
        },
        mounted() {
            this.$store.dispatch('fetchAllPosts')
        },
        computed:{
            ...mapGetters(['posts','loadmorestatus'])
        }
    }
</script>

<style scoped>

</style>
