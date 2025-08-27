<script setup lang="ts"> 
    import {ref, onMounted, computed} from 'vue'
    import FlatPickr from 'vue-flatpickr-component'
    import 'flatpickr/dist/flatpickr.css'
    import axios from "axios";
    import type { CategoryType } from '@/types/Category';

    const emit = defineEmits<{
        (e: "close", isClose: boolean): void,
        (e: "refreshTasks"):void,
        (e: "notify", msg: String, isErr:Boolean): void,
    }>()
    const taskName = ref<string|null>(null)
    const taskDescription = ref<string|null>(null)
    const dueDate = ref<string|null>(null)
    const formattedDate = computed(() =>{
        if(!dueDate.value)return ""
        const d= new Date(dueDate.value)
        if (isNaN(d.getTime())) return ""
        
        const year = d.getFullYear()
        const month = String(d.getMonth()+1).padStart(2,"0")
        const day = String(d.getDate()).padStart(2,"0")
        
        return `${year}-${month}-${day}`
    }) 
    const ctgryId = ref<number|null>(null)
    const userId = Number(localStorage.getItem("userId"))
    const categories = ref<CategoryType[]>([])

    const fetchCategories = async () => {
        try {
            // const response = await axios.get(`http://127.0.0.1:8000/api/categories?user_id=${userId}`)
            const response = await axios.get(`https://proactive-perception-production.up.railway.app/api/categories?user_id=${userId}`)
            categories.value = response.data.categories
        } catch (err) {
            console.error('Error fetching categories:', err)
        }
    }

    const addTask = async () => {
        if(taskName.value!==''){
            try{
                // const response = await axios.post("http://127.0.0.1:8000/api/addTask", {
                const response = await axios.post("https://proactive-perception-production.up.railway.app/api/addTask", {
                    name: taskName.value,
                    description: taskDescription.value,
                    isCompleted: 0,
                    dueDate: formattedDate.value,
                    category_id: ctgryId.value,
                    user_id: userId,
                });
                emit('refreshTasks')
                emit('close',false)
                emit('notify',response.data.message,false)
            }catch (err:any){
                if (err.response) {
                    emit('notify',err.response.data.message || "Adding Task failed",true)
                } else {
                    emit('notify',"Server not reachable",true)
                }
            }
        } else{
            emit('notify',"Please input Task name.", true)
        }
    }

    onMounted(
        fetchCategories
    )
</script>

<template>
    <header className="h-full w-full py-3 border-r-4 border-[#c0bcb8]">
        <div className="h-fit w-full grid gap-1 px-3">
            <div className="w-full grid gap-1">
                <!--Task Name-->
                <div className="w-full">
                    <div className="w-full font-extrabold text-sky-950">
                        TASK
                    </div>
                    <div className="w-full font-semibold text-sky-950">
                        <input v-model="taskName" placeholder="Task Name" type="text" className="w-full pl-2 text-sky-950 bg-white rounded-sm"></input>
                    </div>
                </div>
                <div>
                    <div>
                        <label for="dueDate" className="w-full font-extrabold text-sky-950">Due Date:</label>
                        <FlatPickr
                            v-model="dueDate"
                            :config="{ dateFormat: 'M d, Y', allowInput: true }"
                            placeholder="Select due date"
                            id="dueDate"
                            className="ml-2 text-center font-semibold text-sky-950 bg-white"
                        />
                    </div>
                </div>
                <!--Task Description-->
                <div className="w-full">
                    <div className="w-full font-extrabold text-sky-950">
                        DESCRIPTION
                    </div> 
                    <div className="w-full font-semibold text-sky-950">
                        <textarea v-model="taskDescription" placeholder="Insert description..." className="h-60 w-full pl-2 text-sky-950 bg-white rounded-sm"></textarea>
                    </div>
                </div>
                <!--Task Category-->
                <div className="w-full grid gap-1">
                    <div className="flex flex-row w-full font-extrabold text-sky-950">
                        CATEGORY
                    </div> 
                    <div className="h-fit w-full font-semibold text-sky-950">
                        <select v-model="ctgryId" placeholder="Please select one" id="category" :virtualScrollerOptions="{ itemSize: 4 }" className="w-full pl-2 font-semibold text-sky-950 bg-white rounded-sm">
                            <option disabled value="">Please select one</option>
                            <option 
                                v-for="category in categories" 
                                :value="category.id"
                                className="font-semibold overflow-auto" 
                            >
                                {{ category.name }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <!--Buttons-->
            <div className="grid grid-cols-4 gap-2">
                <button @click="emit('close',false)" className="col-start-2 text-white bg-red-600 hover:bg-[#c20e0e] py-1 font-bold rounded-2xl">Cancel</button>
                <button @click="addTask" className="col-start-3 text-[#ffffff] bg-sky-800 py-1 font-bold rounded-2xl">Add</button>
            </div>
        </div>
    </header>
</template>