<script setup lang="ts">
    import { useRouter } from 'vue-router' 
    import {ref} from 'vue'
    import SidebarButton from './sidebar-button.vue'
    import {useClickOutside} from '@/composables/useClickOutside'
    
    const elRef = ref<HTMLElement | null>(null)
    
    const search = ref('')
    const isAddCategory = ref(false)
    const filterCategory = ref('')
    const filterType = ref('')

    useClickOutside(elRef,isAddCategory)

    const activeButton = ref<string | null>(null)

    function setActive(id: string) {
        activeButton.value = id
    }

    function clearFilter(){
        filterCategory.value=''
        filterType.value=''
    }
    const router = useRouter()

    function route(address:string){
        router.push(address)
    }
</script>

<template>
    <div className="h-full w-full py-3 border-r-4 border-[#c0bcb8]">
        <div className="h-full w-full flex flex-col justify-between px-3">
            <div className="w-full flex flex-col">
                <!--Search Bar-->
                <div className="w-full relative border-b-2 border-[#aaa8a4] pb-1">
                    <input v-model="search" type="text" placeholder="Search" className="w-full pl-2 bg-white rounded-sm">
                        <button v-if="search" @click="search=''" className="absolute right-2 font-mono text-gray-400 inline-block cursor-pointer">x</button>
                    </input>
                </div>
                <!--Category-->
                <div className="grid gap-1 w-full border-b-2 pb-1 border-[#aaa8a4]">
                    <div className="w-full font-extrabold text-sky-950">
                        CATEGORY
                    </div>
                    <!--List of Categories-->
                    <div className="w-full">
                        <SidebarButton 
                            label="Work" 
                            id="Work"
                            :active="activeButton==='Work'" 
                            @set-active="setActive"
                        />
                    </div>
                    <!--Add Category-->
                    <div ref="elRef" className="w-full grid gap-1">
                        <input v-if='isAddCategory' @keydown.enter="isAddCategory=false" className="w-full pl-2 bg-[#c2bfb8] font-semibold text-sky-950 rounded-lg"></input>
                        <button @click="isAddCategory=true" className="w-full font-bold rounded-2xl border-2 text-[#aaa8a4] border-[#aaa8a4] hover:bg-[#c2bfb8] hover:text-[#e4ded8] hover:border-[#d4cfc9] place-content-center">+</button>
                    </div>
                </div>
                <!--Types-->
                <div className="w-full border-b-2 pb-1 gap-1 border-[#aaa8a4]">
                    <div className="w-full font-extrabold text-sky-950">
                        TYPES
                    </div>
                    <div className="w-full grid grid-rows-2 gap-x-1">
                        <SidebarButton 
                            label="Incomplete"
                            id="Incomplete"
                            :active="activeButton==='Incomplete'" 
                            @set-active="setActive"
                        />
                        <SidebarButton 
                            label="Complete"
                            id="Complete"
                            :active="activeButton==='Complete'" 
                            @set-active="setActive"
                        />
                    </div>
                </div>
                <!--Filter-->
                <div className="w-full border-b-2 pb-1 gap-1 border-[#aaa8a4]">
                    <div class="grid grid-cols-2">
                        <div className="w-full font-extrabold text-sky-950">
                            FILTER
                        </div>
                        <button v-if="filterCategory||filterType" @click='clearFilter' className=" text-red-600 cursor-pointer text-right">
                            clear
                        </button>
                    </div>
                    <div className="grid grid-cols-2">
                        <div>
                            <input type="radio" id="one" value="One" v-model="filterCategory" >
                                <label for="one" className="font-semibold text-sky-950">Work</label>
                            </input>
                        </div>
                        <div>
                            <div>
                                <input type="radio" id="typeOne" value="TypeOne" v-model="filterType" >
                                    <label for="typeOne" className="font-semibold text-sky-950">Incomplete</label>
                                </input>
                            </div>
                            <div>
                                <input type="radio" id="two" value="Two" v-model="filterType">
                                    <label for="two" className="font-semibold text-sky-950">Complete</label>
                                </input>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Settings-->
            <div className="w-full">
                <button className="w-full grid grid-cols-8 pl-1 py-1 rounded-lg hover:bg-[#c2bfb8]">
                    <div className="col-start-1 col-span-1">
                        <img src="@/assets/settings.svg" alt="Settings" className="h-7 w-7"/>
                    </div>
                    <div className="col-start-2 col-span-3 place-content-center font-semibold text-sky-950">
                        Settings
                    </div>
                </button>
            </div>
        </div>
    </div>
</template>