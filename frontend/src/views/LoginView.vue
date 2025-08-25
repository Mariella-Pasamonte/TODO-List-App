<script setup lang="ts">
    import {ref} from 'vue'
    import { useRouter } from 'vue-router'
    import axios from "axios";
    
    const router = useRouter()

    function route(address:string){
        router.push(address)
    }

    const emit = defineEmits<{
        (e: "loginNotif", notif: String, isError: Boolean, userId: Number): void
    }>()
    const username = ref('')
    const password = ref('')

    const login = async () => {
        if(username.value!==''||password.value!==''){
            try {
                const response = await axios.post("http://127.0.0.1:8000/api/login", {
                    username: username.value,
                    password: password.value,
                });

                emit('loginNotif','Login successful',false,response.data.user)
                console.log("User:", response.data.user);
                route('/home');
            } catch (err:any) {
                if (err.response) {
                    emit('loginNotif',err.response.data.message || "Login failed",true)
                } else {
                    emit('loginNotif',"Server not reachable",true)
                }
            }
        }else{
            emit('notif',"Please fill up all the fields.",true)
        }
    }
</script>

<template>
  <div className="relative grid h-[100%] w-[100%] place-content-center">
    <div className="h-60 w-110">
        <div className="h-[20%] w-full content-center bg-sky-800 rounded-t-2xl">
            <h1 className="text-center font-bold text-2xl text-white">Welcome!</h1>
        </div>
        <form @submit.prevent="login" className="grid h-[80%] w-full place-content-around border-b-7 border-x-7 rounded-b-2xl border-[#d3cdc6] p-3 ">
            <div className="h-fit w-full grid grid-rows-2 gap-2">
                <div className="grid grid-cols-3 gap-4">
                    <p className="col-span-1 text-right font-semibold">Username</p>
                    <input v-model="username" type="text" className="w-60 pl-2 col-start-2 bg-white rounded-md"></input>
                </div>
                <div className="grid grid-cols-3 gap-4">
                    <p className="col-span-1 text-right font-semibold">Password</p>
                    <input v-model="password" type="password" className="w-60 pl-2 col-start-2 bg-white rounded-md"></input>
                </div>
            </div>
            <div className="h-fit w-full flex justify-center">
                <button type="submit" className="px-6 py-1 font-bold text-[#d8e0e6] rounded-full bg-sky-950 cursor-pointer">
                    Login
                </button>
            </div>
        </form>
    </div>
  </div>
</template>