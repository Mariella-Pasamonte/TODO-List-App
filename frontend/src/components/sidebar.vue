<script setup lang="ts">
    import { RouterLink} from 'vue-router'
    import { useRouter } from 'vue-router' 
    import {ref} from 'vue'
    
    const search = ref('')

    const router = useRouter()

    function route(address:string){
        router.push(address)
    }
</script>

<template>
    <header className="h-full w-full py-3 border-r-4 border-[#c0bcb8]">
        <div className="h-full w-full flex flex-col justify-between px-3">
            <div className="w-full flex flex-col">
                <!--Search Bar-->
                <div className="w-full relative border-b-2 border-[#aaa8a4] pb-1">
                    <input v-model="search" type="text" placeholder="Search" className="w-full pl-2 bg-white rounded-sm">
                        <button v-if="search" @click="search=''" className="absolute right-2 font-mono text-gray-400 inline-block cursor-pointer">x</button>
                    </input>
                </div>
                <!--Category-->
                <div className="w-full border-b-2 pb-1 border-[#aaa8a4]">
                    <div className="w-full font-extrabold text-sky-950">
                        CATEGORY
                    </div>
                    <div className="w-full">
                        <button className="w-full font-bold rounded-2xl border-2 text-[#aaa8a4] border-[#aaa8a4] hover:bg-[#c2bfb8] hover:text-[#e4ded8] hover:border-[#d4cfc9] place-content-center">+</button>
                    </div>
                </div>
                <!--Types-->
                <div className="">
                    <div className="w-full font-extrabold text-sky-950">
                        TYPES
                    </div>
                    <div className="h-full grid grid-rows-2 gap-x-1">
                        <button className="w-full text-left px-2 font-semibold text-sky-950 hover:bg-[#c2bfb8]  rounded-lg cursor-pointer">
                            Incomplete
                        </button>
                        <button className="w-full text-left px-2 font-semibold text-sky-950 hover:bg-[#c2bfb8] rounded-lg cursor-pointer">
                            Complete
                        </button>
                    </div>
                </div>
            </div>
            <!--Profile-->
            <div className="grid grid-cols-4">
                <div className="col-start-1 col-span-1">
                    <div className="h-12 w-12 place-content-center p-1.5 text-center bg-[#d8e0e6] rounded-full">
                        TD
                    </div>
                </div>
                <div className="col-start-2 col-span-3 place-content-center">
                    {First Name} {Last Name}
                </div>
            </div>
        </div>
    </header>
</template>