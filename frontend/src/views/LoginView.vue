<script setup lang="ts">
    import {ref} from 'vue'
    import { RouterLink} from 'vue-router'
    import { useRouter } from 'vue-router' 
    
    const router = useRouter()

    function route(address:string){
        router.push(address)
    }

    const username = ref('')
    const password = ref('')
</script>

<template>
  <div className="grid h-[100%] w-[100%] place-content-center">
    <div className="h-60 w-110">
        <div className="h-[20%] w-full content-center bg-sky-800 rounded-t-2xl">
            <h1 className="text-center font-bold text-2xl text-white">Welcome!</h1>
        </div>
        <div className="grid h-[80%] w-full place-content-around border-b-7 border-x-7 rounded-b-2xl border-[#d3cdc6] p-3 ">
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
                <button  @click="route('/home')" className="px-6 py-1 font-bold text-[#d8e0e6]  rounded-full bg-sky-950 cursor-pointer">
                    <RouterLink to="/">Login</RouterLink>
                </button>
            </div>
        </div>
    </div>
  </div>
</template>