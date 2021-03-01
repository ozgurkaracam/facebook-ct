<template>
    <div class="bg-white rounded shadow w-2/3 p-4 ">
        <div class="flex justify-between items-center">
            <div>
                <div class="w-8" v-if="getAuthUser">
                    <img :src="imagepath+getAuthUser.profileimage.data.attributes.image_path" alt="profile image for user" class="w-8 h-8 object-cover rounded-full">
                </div>
            </div>
            <div class="flex-1 mx-4 flex">
                <form @submit.prevent="addPost()" class="flex w-full">
                    <input type="text" name="body" v-model="body" class="w-full pl-4 h-8 bg-gray-200 rounded-full focus:outline-none focus:shadow-outline text-sm" placeholder="Add a post">
                    <button type="submit" class="px-3 py-1 bg-blue-500 text-white ml-2 rounded-full hover:bg-blue-200">SEND!</button>
                </form>
            </div>
            <div>
                <button @click="selectimage" class="flex justify-center items-center rounded-full w-10 h-10 bg-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-current w-5 h-5"><path d="M21.8 4H2.2c-.2 0-.3.2-.3.3v15.3c0 .3.1.4.3.4h19.6c.2 0 .3-.1.3-.3V4.3c0-.1-.1-.3-.3-.3zm-1.6 13.4l-4.4-4.6c0-.1-.1-.1-.2 0l-3.1 2.7-3.9-4.8h-.1s-.1 0-.1.1L3.8 17V6h16.4v11.4zm-4.9-6.8c.9 0 1.6-.7 1.6-1.6 0-.9-.7-1.6-1.6-1.6-.9 0-1.6.7-1.6 1.6.1.9.8 1.6 1.6 1.6z"/></svg>

                </button>
            </div>

        </div>
        <div class="w-full mt-2 text-center">
            <div class="w-2/3 justify-center mx-auto">
                <img :src="selectedimage" alt="" class="w-full object-cover shadow">
                <input ref="postImage" @change="changeImage" type="file" class="invisible" />
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "NewPost",
        data(){
            return{
                body:'',
                selectedimage:'',
                image:null

            }
        },
        computed:{
            ...mapGetters(['imagepath','getAuthUser'])
        },
        methods:{
            addPost(){
                this.$store.dispatch('addPost', {'body':this.body,'image':this.image}).then(res=>{
                    this.$swal({
                        'text':'Post Sended Success!',
                        'title':'Success',
                        'icon':'success'
                    })

                    this.image=null;
                    this.body='';
                    this.selectedimage=''
                })
                .catch(e=>{
                    this.$swal({
                        'text':'Post Sended Error!',
                        'title':'Error',
                        'icon':'error'
                    })
                });

            },
            selectimage(){
                this.$refs.postImage.click()
                console.log(this.$refs)
            },
            changeImage(event){
                const url=URL.createObjectURL(event.target.files[0])
                this.selectedimage=url
                this.image=event.target.files[0]
            }
        },
        mounted() {
            console.log(this.getAuthUser)
        }
    }
</script>

<style scoped>

</style>
