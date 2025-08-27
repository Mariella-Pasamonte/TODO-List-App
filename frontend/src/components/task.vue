<script setup lang="ts"> 
    import {ref, onMounted, computed} from 'vue';
    import FlatPickr from 'vue-flatpickr-component'
    import 'flatpickr/dist/flatpickr.css'
    import axios from "axios";
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
    import type { CategoryType } from '@/types/Category';
    import type { TaskType } from '@/types/Task';
    import { faTrash } from '@fortawesome/free-solid-svg-icons';
    
    const emit = defineEmits<{
        (e: "refreshTasks"):void,
        (e: "close", isErr:boolean):void,
        (e: "notify", msg: String, isErr:Boolean): void,
        (e: "delete", id: number): void,
    }>()
    const props = defineProps<{
        tsk:TaskType,
    }>();

    console.log("tsk:",props.tsk)
    const taskName = ref<string>(props.tsk.name)
    const taskDescription = ref<string>(props.tsk.description||"")
    const dueDate =  ref<string>(
        props.tsk.dueDate? new Date(props.tsk.dueDate).toLocaleDateString("en-US",{
            month: "short",
            day: "2-digit",
            year: "numeric",
        })
        : ""
    )
    const formattedDate = computed(() =>{
        if(!dueDate.value)return ""
        const d= new Date(dueDate.value)
        if (isNaN(d.getTime())) return ""
        
        const year = d.getFullYear()
        const month = String(d.getMonth()+1).padStart(2,"0")
        const day = String(d.getDate()).padStart(2,"0")
        
        return `${year}-${month}-${day}`
    }) 
    const ctgryId = ref<number>(props.tsk.category_id??0) 
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

    const editTask = async () =>{
        if(taskName.value!==''){
            try{
                // const response = await axios.put(`http://127.0.0.1:8000/api/editTask/${props.tsk.id}`, {
                const response = await axios.put(`https://proactive-perception-production.up.railway.app/api/editTask/${props.tsk.id}`, {
                    name: taskName.value,
                    description: taskDescription.value,
                    dueDate: formattedDate.value,
                    category_id: ctgryId.value,
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

    onMounted(fetchCategories)
</script>

<template>
    <header class="h-full w-full py-3 border-r-4 border-[#c0bcb8]">
        <div class="h-fit w-full grid gap-1 px-3">
            <div class="w-full grid gap-1">
                <!--Task Name-->
                <div class="w-full">
                    <div class="flex justify-between h-7 mb-1 w-full font-extrabold text-sky-950">
                        <p className="place-content-center">TASK</p>
                        <div className="text-red-600 place-content-center">
                            <button @click="emit('delete',props.tsk.id)" class=" cursor-pointer">
                                <FontAwesomeIcon class="fa-lg" :icon="faTrash"/>
                            </button>
                        </div>
                    </div>
                    <div class="w-full font-semibold text-sky-950">
                        <input v-model="taskName" placeholder="Task Name" type="text" class="w-full pl-2 text-sky-950 bg-white rounded-sm"></input>
                    </div>
                </div>
                <!--Task Due Date-->
                <div class>
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
                <div class="w-full">
                    <div class="w-full font-extrabold text-sky-950">
                        DESCRIPTION
                    </div> 
                    <div class="w-full font-semibold text-sky-950">
                        <textarea v-model="taskDescription" placeholder="Insert description..." class="h-60 w-full pl-2 text-sky-950 bg-white rounded-sm"></textarea>
                    </div>
                </div>
                <!--Task Category-->
                <div class="w-full grid gap-1">
                    <div class="flex flex-row w-full font-extrabold text-sky-950">
                        CATEGORY
                    </div> 
                    <div class="h-fit w-full font-semibold text-sky-950">
                        <select v-model="ctgryId" placeholder="Please select one" id="category" :virtualScrollerOptions="{ itemSize: 4 }" className="w-full pl-2 font-semibold text-sky-950 bg-white rounded-sm">
                            <option disabled :value="0">Please select one</option>
                            <option 
                                v-for="category in categories" 
                                :key="`${category.id}`"
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
            <div class="grid grid-cols-4 gap-2">
                <button @click="emit('close',false)" class="col-start-2 text-white bg-red-600 hover:bg-[#c20e0e] py-1 font-bold rounded-2xl cursor-pointer">Cancel</button>
                <button @click="editTask" class="col-start-3 text-[#ffffff] bg-yellow-500 hover:bg-amber-500 py-1 font-bold rounded-2xl cursor-pointer">Save</button>
            </div>
        </div>
    </header>
</template>