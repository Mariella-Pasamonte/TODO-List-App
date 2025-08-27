<script setup lang="ts">
    import { useRoute, useRouter, RouterLink} from 'vue-router'
    import { computed } from "vue"
    
    const routeName = useRoute()
    const router = useRouter()

    const isHome = computed(() => routeName.name === "home")

    function route(address:string){
        router.push(address)
    }

    function loggingOut(){
        route("/")
        localStorage.clear();
    }
</script>

<template>
    <header className="h-fit w-full py-3 bg-sky-800">
        <div className="h-full w-full flex flex-row justify-between px-5">
            <div className="flex flex-row gap-1 h-full content-center">
                <div className="text-2xl font-sans font-bold italic text-white rounded-full place-content-center">
                    TODO
                </div>
                <div class="grid text-md place-content-end text-white font-semibold italic">
                    v1
                </div>
            </div>
            <nav 
                class='h-full grid gap-x-1 content-center'
                :class="isHome ? 'grid-cols-1':'grid-cols-2'"
            >
                <div v-if="isHome" className="col-span-1">
                    <button @click="loggingOut" className="px-5 py-0.5 rounded-full font-bold text-[#d8e0e6] border-2 border-[#d8e0e6] hover:bg-[#d8e0e6] hover:text-sky-950 cursor-pointer">
                        Logout
                    </button>
                </div>
                <div v-else className="grid grid-cols-2 col-span-2 gap-x-1">
                    <button @click="route('/signup')" className="px-4 py-1 rounded-full font-bold text-white bg-orange-500 cursor-pointer">
                        <RouterLink to="/signup">Sign up</RouterLink>
                    </button>
                    <button @click="route('/')" className="px-5 py-0.5 rounded-full font-bold text-[#d8e0e6] border-2 border-[#d8e0e6] hover:bg-[#d8e0e6] hover:text-sky-950 cursor-pointer">
                        <RouterLink to="/">Login</RouterLink>
                    </button>
                </div>
            </nav>
        </div>
    </header>
</template>