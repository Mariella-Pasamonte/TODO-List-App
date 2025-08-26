<script setup lang="ts">
  import Sidebar from '../components/sidebar.vue'
  import Task from '../components/task.vue'
  import NewTask from '@/components/newTask.vue'
  import TaskListView from '@/components/taskListView.vue'
  import { useClickOutside } from '@/composables/useClickOutside'
  import {ref, onMounted} from 'vue'
  import axios from "axios";
  import type {TaskType} from "@/types/Task"

  const taskRef = ref<HTMLElement | null>(null)
  const isAddTask = ref<boolean|false>(false)
  const isTaskClicked = ref<boolean|false>(false)
  const tasks = ref<TaskType[]>([])
  const task =ref<TaskType|null>(null)
  const userId = Number(localStorage.getItem("userId"))

  const emit = defineEmits(["notif"]);

  function handleNotify(msg:String,isErr:Boolean) {
    emit("notif", msg,isErr);
  }
  
  useClickOutside(taskRef,isTaskClicked)

  function getTaskById(id: number): TaskType|null{
    return tasks.value.find(task=> task.id===id)||null
  }

  function onChildClicked(id:number) {
    task.value = getTaskById(id)
    isTaskClicked.value=true
  } 

  function closeTask(isClose:boolean){
    isAddTask.value = isClose
    isTaskClicked.value = isClose
  }

  const fetchTasks = async () => {
      try {
          const response = await axios.get(`http://127.0.0.1:8000/api/getTasks?user_id=${userId}`)
          tasks.value = response.data.tasks
      } catch (err:any) {
          emit('notif',err.response.data.message,true)
      }
  }

  onMounted(fetchTasks)
</script>

<template>
  <main className="w-full h-full grid grid-cols-10">
    <!--Sidebar-->
    <div className="col-start-1 col-span-2 w-full h-full bg-[#d4cfc9]">
      <Sidebar @notify='handleNotify'></Sidebar>
    </div>
    <!--Tasks-->
    <div className="col-start-3 col-span-5 px-3 w-full h-full pt-2">
      <h1 className="w-full font-extrabold text-lg text-sky-950 pb-2"> ALL TASKS</h1>
      <button @click="isAddTask=true" className="py-2 w-full font-bold border-t-2 text-[#aaa8a4] border-[#aaa8a4] hover:bg-[#c2bfb8] hover:text-[#e4ded8] hover:border-[#d4cfc9]">+ Add New Task</button>
      <TaskListView v-if="tasks.length>0" @tskId="onChildClicked" @notify="handleNotify" :tasks="tasks" />
    </div>
    <!--Task Information Responsive-->
    <div ref="taskRef" className="col-start-8 col-span-3 w-full h-full bg-[#d4cfc9]">
      <NewTask @close="closeTask" @notify="handleNotify" @refreshTasks="fetchTasks" ref="addTaskRef" v-if="isAddTask"/>
      <Task @refreshTasks="fetchTasks" @close="closeTask" @notify="handleNotify" ref="taskRef" v-if="isTaskClicked &&task" :tsk="task"/>
    </div>
  </main>
</template>
