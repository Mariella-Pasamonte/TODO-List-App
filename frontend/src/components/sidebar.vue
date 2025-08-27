<script setup lang="ts">
    import {ref, onMounted, watch} from 'vue'
    import SidebarButton from './sidebar-button.vue'
    import {useClickOutside} from '@/composables/useClickOutside'
    import axios from "axios";
    import type { CategoryType } from '@/types/Category';
    
    const emit = defineEmits<{
        (e: "notify", notif: String, isError: Boolean): void,
        (e: "update:filterCategory", id: number|null): void,
        (e: "update:filterType", type:string): void,
        (e: "srching", type:string):void,
    }>()

    const elRef = ref<HTMLElement | null>(null)
    const props = defineProps<{'searchText':string|''}>()
    const search = ref(props.searchText)
    const isAddCategory = ref(false)
    const filterCategory = ref<number|null>(null)
    const filterType = ref<string|''>('')
    const categoryName = ref('')
    const userId = Number(localStorage.getItem("userId"))
    const categories = ref<CategoryType[]>([])
    const activeButton = ref<string | null>(null)
    const activeCategoryRadio = ref<boolean |false>(false)
    const activeTypeRadio = ref<boolean |false>(false)

    function setCategory(id: number) {
        activeButton.value = `category-${id}`
        filterType.value=''
        filterCategory.value=null
        emit("update:filterCategory", id)
        emit("update:filterType", "") 
    }

    function setType(type: string) {
        activeButton.value = type
        filterType.value=''
        filterCategory.value=null
        emit("update:filterType", type)
        emit("update:filterCategory", null)
    }

    function setRadioCategory(id: number){
        if(activeButton.value){
            activeButton.value=null
            emit("update:filterType", "")
            emit("update:filterCategory", null)
        }
        emit("update:filterCategory", id)
    }

    function setRadioType(type: string){
        if(activeButton.value){
            activeButton.value=null
            emit("update:filterType", "")
            emit("update:filterCategory", null)
        }
        emit("update:filterType", type) 
    }

    useClickOutside(elRef,isAddCategory)

    function clearButtons() {
        activeButton.value = null
        activeCategoryRadio.value=false
        activeTypeRadio.value=false
        filterCategory.value=null
        filterType.value=""
        emit("update:filterCategory", null)
        emit("update:filterType", "")
    }

    const fetchCategories = async () => {
        try {
            // const response = await axios.get(`http://127.0.0.1:8000/api/categories?user_id=${userId}`)
            const response = await axios.get(`https://proactive-perception-production.up.railway.app/api/categories?user_id=${userId}`)
            categories.value = response.data.categories
        } catch (err) {
            console.error('Error fetching categories:', err)
        }
    }

    const addCategory = async () => {
        if(categoryName.value!==''){
            try {
                console.log('Sidebar: User:', userId);
                // const response = await axios.post("http://127.0.0.1:8000/api/addCategory", {
                const response = await axios.post("https://proactive-perception-production.up.railway.app/api/addCategory", {
                    name: categoryName.value,
                    user_id: userId,
                });
                categoryName.value=''
                emit('notify','Category added successfuly',false)
                isAddCategory.value=false
                await fetchCategories()
            } catch (err:any) {
                if (err.response) {
                    emit('notify',err.response.data.message || "Adding Category failed",true)
                } else {
                    emit('notify',"Server not reachable",true)
                }
            }
        }else{
            emit('notify',"Please input category.",true)
        }
    }

    watch(search, (val) => {emit('srching',val)})

    onMounted(fetchCategories);
</script>

<template>
    <div className="h-full w-full py-3 border-r-4 border-[#c0bcb8]">
        <div className="h-full w-full grid grid-rows-12 px-3">
            <div className="row-span-13 w-full flex flex-col">
                <!--Search Bar-->
                <div className="w-full relative border-b-2 border-[#aaa8a4] pb-1">
                    <input v-model="search" type="text" placeholder="Search" className="w-full pl-2 bg-white rounded-sm">
                        <button v-if="search" @click="search=''" className="absolute right-2 font-mono text-gray-400 inline-block cursor-pointer">x</button>
                    </input>
                </div>
                <!--Category-->
                <div className="grid gap-1 w-full border-b-2 pb-1 border-[#aaa8a4]">
                    <div className="flex flex-row w-full justify-between ">
                        <p class="font-extrabold text-sky-950">CATEGORY</p>
                        <button v-if="activeButton||activeCategoryRadio||activeTypeRadio" @click='clearButtons' className=" text-red-600 cursor-pointer text-right">
                            clear
                        </button>
                    </div>
                    <!--List of Categories-->
                    <div 
                        class="w-full overflow-auto"
                        :class="categories.length>3?'h-23':'h-fit'"
                    >
                        <SidebarButton 
                            v-for="category in categories"
                            :label="category.name" 
                            :id="category.id"
                            :active="activeButton==='category-' + category.id" 
                            @set-active="setCategory"
                        />
                    </div>
                    <!--Add Category-->
                    <div ref="elRef" className="w-full grid gap-1">
                        <input v-if='isAddCategory' v-model='categoryName' @keydown.enter="addCategory" className="w-full pl-2 bg-[#c2bfb8] font-semibold text-sky-950 rounded-lg"></input>
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
                            @set-active="()=>setType('Incomplete')"
                        />
                        <SidebarButton 
                            label="Complete"
                            id="Complete"
                            :active="activeButton==='Complete'" 
                            @set-active="()=>setType('Complete')"
                        />
                    </div>
                </div>
                <!--Filter-->
                <div className="w-full border-b-2 pb-1 gap-1 border-[#aaa8a4]">
                    <div class="grid grid-cols-2">
                        <div className="w-full font-extrabold text-sky-950">
                            FILTER
                        </div>
                    </div>
                    <div className="grid grid-cols-2 h-35">
                        <div className="col-start-1 col-span-1 overflow-auto">
                            <div v-for="category in categories" :key="`${category.id}`" >
                                <input 
                                    type="radio" 
                                    :id="'radio-' + category.id"
                                    :value="category.id" 
                                    v-model="filterCategory"
                                    @change="setRadioCategory(category.id)" 
                                    @click="activeCategoryRadio=true"
                                >
                                    <label :for="'radio-'+category.id" className="font-semibold text-sky-950 h-fit">{{ category.name }}</label>
                                </input>
                            </div>
                        </div>
                        <div>
                            <div>
                                <input type="radio" id="typeOne" value="TypeOne" v-model="filterType" @change="setRadioType('Incomplete')" @click="activeTypeRadio=true,activeButton=null" >
                                    <label for="typeOne" className="font-semibold text-sky-950">Incomplete</label>
                                </input>
                            </div>
                            <div>
                                <input type="radio" id="two" value="Two" v-model="filterType" @change="setRadioType('Complete')" @click="activeTypeRadio=true,activeButton=null">
                                    <label for="two" className="font-semibold text-sky-950">Complete</label>
                                </input>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>