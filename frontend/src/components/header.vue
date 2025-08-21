<script setup lang="ts">
    import { RouterLink} from 'vue-router'
    import { useRouter } from 'vue-router' 
    
    const router = useRouter()

    function route(address:string){
        router.push(address)
    }
</script>

<template>
    <header className="h-fit w-full py-3 bg-sky-800 ">
        <div className="h-full w-full flex flex-row justify-between px-5">
            <div className="h-full content-center">
                <div className="p-1.5 bg-[#d8e0e6] rounded-full">
                    TD
                </div>
            </div>
            <nav className="h-full grid grid-cols-4 gap-x-1 content-center">
                <button  @click="route('/')" className="px-6 py-1 font-bold text-sky-950 rounded-full bg-[#d8e0e6] cursor-pointer">
                    <RouterLink to="/">Home</RouterLink>
                </button>
                <button @click="route('/about')" className="px-5 py-1 font-bold text-sky-950 rounded-full bg-[#d8e0e6] cursor-pointer">
                    <RouterLink to="/about">About</RouterLink>
                </button>
                <button @click="route('/signup')" className="px-4 py-1 rounded-full font-bold text-white bg-orange-500 cursor-pointer">
                    <RouterLink to="/signup">Sign up</RouterLink>
                </button>
                <button @click="route('/login')" className="px-5 py-0.5 rounded-full font-bold text-[#d8e0e6] border-2 border-[#d8e0e6] hover:bg-[#d8e0e6] hover:text-sky-950 cursor-pointer">
                    <RouterLink to="/login">Login</RouterLink>
                </button>
            </nav>
        </div>
    </header>
</template>