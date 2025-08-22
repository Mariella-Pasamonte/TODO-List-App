<script setup lang="ts">
    import { useRoute, useRouter, RouterLink} from 'vue-router'
    import { computed } from "vue"
    
    const routeName = useRoute()
    const router = useRouter()

    const isHome = computed(() => routeName.name === "home")

    function route(address:string){
        router.push(address)
    }
</script>

<template>
    <header className="h-fit w-full py-3 bg-sky-800">
        <div className="h-full w-full flex flex-row justify-between px-5">
            <div className="h-full content-center">
                <div className="text-2xl font-sans font-bold italic text-white rounded-full place-content-center">
                    TODO
                </div>
            </div>
            <nav 
                class='h-full grid gap-x-1 content-center'
                :class="isHome ? 'grid-cols-3':'grid-cols-4'"
            >
                <button  @click="route('/home')" className="px-6 py-1 font-bold text-sky-950 rounded-full bg-[#d8e0e6] cursor-pointer">
                    <RouterLink to="/home">Home</RouterLink>
                </button>
                <button @click="route('/about')" className="px-5 py-1 font-bold text-sky-950 rounded-full bg-[#d8e0e6] cursor-pointer">
                    <RouterLink to="/about">About</RouterLink>
                </button>
                <div v-if="isHome" className="col-span-1">
                    <button @click="route('/')" className="px-5 py-0.5 rounded-full font-bold text-[#d8e0e6] border-2 border-[#d8e0e6] hover:bg-[#d8e0e6] hover:text-sky-950 cursor-pointer">
                        <RouterLink to="/">Logout</RouterLink>
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