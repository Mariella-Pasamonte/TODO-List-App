<script setup lang="ts">
    import {ref} from 'vue'
    import { RouterLink} from 'vue-router'
    import { useRouter } from 'vue-router' 
    
    const router = useRouter()

    function route(address:string){
        router.push(address)
    }

    const firstName = ref('')
    const lastName = ref('')
    const username = ref('')
    const email = ref('')
    const password = ref('')
    const confPassword = ref('')
</script>

<template>
  <div className="grid h-full w-full place-content-center">
    <div className="h-80 w-110">
        <div className="h-[18%] w-full content-center bg-sky-800 rounded-t-2xl">
            <h1 className="text-center font-bold text-2xl text-white"></h1>
        </div>
        <div className="grid h-[82%] w-full place-content-between border-b-7 border-x-7 rounded-b-2xl border-[#d3cdc6] p-3 ">
            <div className="h-fit w-full grid grid-rows-6 gap-2">
                <div className="grid grid-cols-6 gap-4 ">
                  <p className="col-span-3 font-semibold">First Name</p>
                  <p className="col-span-3 col-start-4 font-semibold">Last Name</p>
                </div>
                <div className="grid grid-cols-6 gap-4">
                    <input v-model="firstName" type="text" className="w-45 pl-2 col-span-3 col-start-1 bg-white rounded-md"></input>
                    <input v-model="lastName" type="text" className="w-45 pl-2 col-span-3 col-start-4 bg-white rounded-md"></input>
                </div>
                <div className="grid grid-cols-5   gap-4">
                    <p className="col-span-1 text-left font-semibold">Username</p>
                    <input v-model="username" type="text" className="w-76.5 pl-2 col-start-2 bg-white rounded-md"></input>
                </div>
                <div className="grid grid-cols-5 gap-4">
                    <p className="col-span-1 text-right font-semibold">Email</p>
                    <input v-model="email" type="text" className="w-76.5 pl-2 col-start-2 bg-white rounded-md"></input>
                </div>
                <div className="grid grid-cols-6 gap-4 ">
                  <p className="col-span-3 font-semibold">Password</p>
                  <p className="col-span-3 col-start-4 font-semibold">Confirm Password</p>
                </div>
                <div className="grid grid-cols-6 gap-4">
                    <input v-model="password" type="password" className="w-45 pl-2 col-span-3 col-start-1 bg-white rounded-md"></input>
                    <input v-model="confPassword" type="password" className="w-45 pl-2 col-span-3 col-start-4 bg-white rounded-md"></input>
                </div>
            </div>
            <div className="h-fit w-full flex justify-center">
                <button  @click="route('/')" className="px-4 py-1 rounded-full font-bold text-white bg-orange-500 cursor-pointer">
                    <RouterLink to="/">Sign up</RouterLink>
                </button>
            </div>
        </div>
    </div>
  </div>
</template>