<script setup lang="ts">
    import {ref} from 'vue'
    import { useRouter } from 'vue-router'
    import axios from "axios";
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
    import { faXmarkCircle } from '@fortawesome/free-solid-svg-icons';
    
    const router = useRouter()

    function route(address:string){
        router.push(address)
    }

    const username = ref('')
    const password = ref('')

    const error = ref("");
    const success = ref("");

    const isSuccess = ref(false);
    const isError = ref(false);

    const login = async () => {
        error.value = "";
        success.value = "";

        try {
            const response = await axios.post("http://127.0.0.1:8000/api/login", {
                username: username.value,
                password: password.value,
            });

            success.value = response.data.message;
            console.log("User:", response.data.user);
            isSuccess.value=true
            route('/home');
        } catch (err:any) {
            if (err.response) {
                error.value = err.response.data.message || "Login failed";
            } else {
                error.value = "Server not reachable";
            }
            isError.value=true
        }
    }

    function close(){
        isError.value=false
        isSuccess.value=false
    }
</script>

<template>
  <div className="relative grid h-[100%] w-[100%] place-content-center">
    <div
        class="absolute flex flex-row h-fit w-fit right-2 transition-all ease-in-out duration-700 delay-300 rounded-xl p-3 bg-red-500 text-white place-content-center"
        :class="isError?'top-2 opacity-100':'top-10 opacity-0'"
    >
        <p className="place-content-center">{{ error }}</p>
        <button @click="close()" className="flex flex-col justify-center h-6 ml-2 w-fit border-white rounded-full">
            <FontAwesomeIcon :icon="faXmarkCircle"/>
        </button>
    </div>
    <div
        class="absolute w-fit right-2 transition-all ease-in duration-300 delay-150 grid rounded-xl p-3 bg-green-600 text-white place-content-center"
        :class="isSuccess?'top-2 opacity-100':'top-10 opacity-0'"
    >
        <p className="place-content-center">{{ success }}</p>
        <button @click="close()" className="flex flex-col justify-center h-6 ml-2 w-fit border-white rounded-full">
            <FontAwesomeIcon :icon="faXmarkCircle"/>
        </button>
    </div>
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