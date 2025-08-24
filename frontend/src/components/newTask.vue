<script setup lang="ts"> 
    import {ref} from 'vue'
    
    const taskName = ref('')
    const taskDescription = ref('')
    const categorySelected = ref('')
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
                        <select v-model="categorySelected" id="category" className="w-full pl-2 text-sky-950 bg-white rounded-sm">
                            <option disabled value="">Please select one</option>
                            <option>Work</option>
                        </select>
                    </div>
                </div>
            </div>
            <!--Buttons-->
            <div className="grid grid-cols-4 gap-2">
                <button className="col-start-2 text-white bg-red-600 hover:bg-[#c20e0e] py-1 font-bold rounded-2xl">Cancel</button>
                <button className="col-start-3 text-[#ffffff] bg-sky-800 py-1 font-bold rounded-2xl">Add</button>
            </div>
        </div>
    </header>
</template>