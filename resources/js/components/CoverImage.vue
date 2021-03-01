<template>
        <img :src="image.imagepath" ref="userImage" :class="image.class" alt="">
</template>

<script>
import Dropzone from 'dropzone'
import {mapGetters} from "vuex";
export default {
    name: "CoverImage",
    data: function () {
        return {
            dropzone:null,
        }
    },
    props:['image'],
    computed:{
        ...mapGetters(['imagepath','getAuthUser','getUser']),
        options(){
            return{
                paramName:'image',
                params:{
                    type:this.image.type,
                    image:'image',
                    width:this.image.width,
                    height:this.image.height
                },
                maxFilesize:3,
                acceptedFiles:'image/*',
                success: (e,res)=>{
                    console.log(res);
                    this.$store.dispatch('fetchAuthUser')
                    this.$store.dispatch('getUser',this.getUser.user_id)
                },
                headers:{
                    'X-CSRF-TOKEN' : document.querySelector("head > meta:nth-child(3)").content
                }
            }
        }
    },
    mounted() {
        if(this.getAuthUser.user_id===this.getUser.user_id){
            this.options.url='/api/users/'+this.getAuthUser.user_id+'/images';
            this.dropzone=new Dropzone(this.$refs.userImage,this.options)
        }
    }
}
</script>

<style scoped>

</style>
