<script setup lang="ts">
    import {ref, defineEmits} from 'vue'
    import { useRouter } from 'vue-router' 
    import axios from "axios";
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
    import { faCircleExclamation } from '@fortawesome/free-solid-svg-icons';
    
    const router = useRouter()

    function route(address:string){
        router.push(address)
    }

    const emit = defineEmits<{
        (e: "notif", notif: String, isError: Boolean): void
    }>()
    const firstName = ref('')
    const lastName = ref('')
    const username = ref('')
    const email = ref('')
    const password = ref('')
    const confPassword = ref('')
    const isEmpty=ref(false)

    const signup = async () => {
        if(firstName.value!==''||lastName.value!==''||username.value!==''||email.value!==''||password.value!==''||confPassword.value!==''){
            if(password.value===confPassword.value){
                console.log("Password is the same.");
                try {
                    const response = await axios.post("http://127.0.0.1:8000/api/signup", {
                        firstname: firstName.value,
                        lastname: lastName.value,
                        username: username.value,
                        email: email.value,
                        password: password.value,
                    });

                    emit('notif','Sign up successful',false)
                    console.log("User:", response.data.user);
                    route('/');
                } catch (err:any) {
                    if (err.response) {
                        emit('notif',err.response.data.errors.username[0] || "Login failed",true)
                    } else {
                        emit('notif',"Server not reachable",true)
                    }
                }
            } else{
                emit('notif',"Check to confirm password",true)
            }
        }else{
            emit('notif',"Fill out the fields",true)
            isEmpty.value=true
        }
    }
</script>

<template>
  <div className="grid h-full w-full place-content-center">
    <div className="h-80 w-110">
        <div className="h-[18%] w-full content-center bg-sky-800 rounded-t-2xl">
            <h1 className="text-center font-bold text-2xl text-white"></h1>
        </div>
        <form @submit.prevent="signup" className="grid h-[82%] w-full place-content-between border-b-7 border-x-7 rounded-b-2xl border-[#d3cdc6] p-3 ">
            <div className="h-fit w-full grid grid-rows-6 gap-2">
                <div className="grid grid-cols-2 h-fit ">
                    <div className="cols-start-1 col-span-1 flex flex-row">
                        <p className="font-semibold w-fit ">First Name</p>
                        <div v-if="isEmpty&&firstName===''" className="w-fit h-fit ml-1 text-red-500" >
                            <FontAwesomeIcon :icon="faCircleExclamation"/>
                        </div>
                    </div>
                    <div className="cols-start-2 pl-2 col-span-1 flex flex-row">
                        <p class="font-semibold w-fit">Last Name</p>
                        <div v-if="isEmpty&&lastName===''" className="w-fit h-fit ml-1 text-red-500" >
                            <FontAwesomeIcon :icon="faCircleExclamation"/>
                        </div>
                    </div>
                </div>
                <div className="grid grid-cols-6 gap-4">
                    <input v-model="firstName" type="text" className="w-45 pl-2 col-span-3 col-start-1 bg-white rounded-md"></input>
                    <input v-model="lastName" type="text" className="w-45 pl-2 col-span-3 col-start-4 bg-white rounded-md"></input>
                </div>
                <div 
                    class="flex flex-row"
                    :class="isEmpty&&username===''?'gap-1':'gap-3'"
                >
                    <div className='col-span-1 flex flex-row'>
                        <p className=" text-left font-semibold">Username</p>
                        <div v-if="isEmpty&&username===''" className="ml-1 text-red-500" >
                            <FontAwesomeIcon :icon="faCircleExclamation"/>
                        </div>
                    </div>
                    <input 
                        v-model="username" 
                        type="text" 
                        class="pl-2 col-start-3 bg-white rounded-md"
                        :class="isEmpty&&username===''?'w-72':'w-76.5'"
                    >
                    </input>
                </div>
                <div className="grid grid-cols-5 gap-4">
                    <div className="flex flex-row place-content-end">
                        <p className="col-span-1 text-right font-semibold">Email</p>
                        <div v-if="isEmpty&&email===''" className="ml-1 text-red-500" >
                            <FontAwesomeIcon :icon="faCircleExclamation"/>
                        </div>
                    </div>
                    <input v-model="email" type="text" className="w-76.5 pl-2 col-start-2 bg-white rounded-md"></input>
                </div>
                <div className="grid grid-cols-2 gap-4 ">
                    <div className="cols-start-1 flex flex-row">
                        <p className="col-span-3 font-semibold">Password</p>
                        <div v-if="isEmpty&&password===''" className="ml-1 text-red-500" >
                            <FontAwesomeIcon :icon="faCircleExclamation"/>
                        </div>
                    </div>
                    <div class="flex flex-row">
                        <p className="col-start-2 font-semibold">Confirm Password</p>
                         <div v-if="isEmpty&&confPassword===''" className="ml-1 text-red-500" >
                            <FontAwesomeIcon :icon="faCircleExclamation"/>
                        </div>
                    </div>
                </div>
                <div className="grid grid-cols-6 gap-4">
                    <input v-model="password" type="password" className="w-45 pl-2 col-span-3 col-start-1 bg-white rounded-md"></input>
                    <input v-model="confPassword" type="password" className="w-45 pl-2 col-span-3 col-start-4 bg-white rounded-md"></input>
                </div>
            </div>
            <div className="h-fit w-full flex justify-center">
                <button  type="submit" className="px-4 py-1 rounded-full font-bold text-white bg-orange-500 cursor-pointer">
                    Sign up
                </button>
            </div>
        </form>
    </div>
  </div>
</template>