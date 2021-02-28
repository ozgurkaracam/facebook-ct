<template>
    <div v-if="loadmorestatus" class="mt-5 py-1 px-4 justify-center text-gray-400 cursor-pointer hover:underline" @click="$store.dispatch('loadmore',posts.meta)">
        Load More...
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "LoadMore",
    props:['posts'],
    computed:{
    ...mapGetters(['loadmorestatus'])
    },
}
</script>

<style scoped>

</style>
