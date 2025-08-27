<script setup lang="ts">
    import TaskItem from './taskItem.vue';
    import {ref} from 'vue'
    import { useClickOutside } from '@/composables/useClickOutside';
    import axios from "axios";
    import type {TaskType} from "@/types/Task"

    const emit = defineEmits<{
        (e: "tskId", id:number):void,
        (e: "refreshTasks"):void,
        (e: "notify", msg: String, isErr:Boolean): void,
    }>()
    const elRef = ref<HTMLElement | null>(null)
    const activeButton = ref<String | null>(null)
    const isActive = ref<boolean|false>(false)

    const props = defineProps<{
        tasks:TaskType[],
    }>();

    function handleClick(id:number) {
        isActive.value=true
        emit('tskId',id)
    }

    useClickOutside(elRef,isActive)

    async function changeComplete(id:Number, isCom:Boolean){
        try {
            // const response = await axios.patch(`http://127.0.0.1:8000/api/task/${id}/complete`, {
            const response = await axios.patch(`https://proactive-perception-production.up.railway.app/api/task/${id}/complete`, {
                isCompleted: isCom,
            },{
                headers: {
                    "Content-Type":"application/json",
                }
            });
            emit('notify',response.data.message,false)
            emit('refreshTasks')
        } catch (err:any) {
            emit('notify',err.response.data.message,true)
        }
    }

    function setActive(id: String) {
      activeButton.value = id
    }

    const dateToString=(date?:Date)=>{
        return date? new Date(date).toLocaleDateString("en-US",{
            month: "short",
            day: "2-digit",
            year: "numeric",
        })
        : "";
    }

    const isOverdue = (dueDate?: Date) => {
        if (!dueDate) return false;
        const now = new Date();
        return new Date(dueDate) < now;
    };
</script>

<template>
    <div ref="elRef" className="w-full h-[85%] overflow-auto">
        <div v-for="task in props.tasks" className="w-full grid grid-cols-10 border-t-2 border-[#c2bfb8]">
            <div v-if="task&&task.id" className="col-span-9 mr-2">
                <TaskItem 
                    key="task.id"
                    @click="handleClick(task.id)"
                    :label="`${task.name}`" 
                    :id="`tsk-${task.id}`"
                    :date="dateToString(task.dueDate)"
                    :isDueDate="isOverdue(task.dueDate)"
                    :category="task.category" 
                    :active="activeButton===`tsk-${task.id}`&&isActive" 
                    @set-active="setActive"
                >
                </TaskItem>
            </div>
            <div v-if="task&&task.id" className="col-span-1">
                <label class="inline-flex h-full items-center cursor-pointer">
                    <input @click="changeComplete(task.id,!task.isCompleted)" type="checkbox" :checked="task.isCompleted" class="sr-only peer">
                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>
                </label>
            </div> 
        </div>
    </div>
</template>