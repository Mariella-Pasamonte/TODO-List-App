<script setup lang="ts">
  import Sidebar from '../components/sidebar.vue'
  import Task from '../components/task.vue'
  import NewTask from '@/components/newTask.vue'
  import TaskListView from '@/components/taskListView.vue'
  import {ref, onMounted,computed} from 'vue'
  import axios from "axios";
  import type {TaskType} from "@/types/Task"

  const isAddTask = ref<boolean|false>(false)
  const isTaskClicked = ref<boolean|false>(false)
  const allTasks = ref<TaskType[]>([])
  const task =ref<TaskType|null>(null)
  const userId = Number(localStorage.getItem("userId"))
  const filterCategory = ref<number | null>(null)
  const filterType = ref<string|"">("")
  const search = ref<string|''>('')

  const isFilter = computed(() => !!filterCategory.value || !!filterType.value)
  const isSearch = computed(() => !!search.value)
  const isAllTasks = !isFilter

  const filteredTasks = computed(() => {
    return allTasks.value.filter(task => {
        if (filterCategory.value && task.category_id !== Number(filterCategory.value)) return false

        if (filterType.value === "Complete" && task.isCompleted===false) return false
        if (filterType.value === "Incomplete" && task.isCompleted===true) return false
        
        return true
    })
  })

  const searchTasks = computed(() => {
    const term = search.value.toLowerCase()
    return allTasks.value.filter(task => 
    task.name.toLowerCase().includes(term))
  })

  const emit = defineEmits(["notif"]);

  function handleNotify(msg:String,isErr:Boolean) {
    emit("notif", msg,isErr);
  }

  function getTaskById(id: number): TaskType|null{
    return allTasks.value.find(task=> task.id===id)||null
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
          allTasks.value = response.data.tasks
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
      <Sidebar :searchText="search" @srching="search=$event" @notify='handleNotify' @update:filterCategory="filterCategory=$event" @update:filterType="filterType=$event"></Sidebar>
    </div>
    <!--Tasks-->
    <div className="col-start-3 col-span-5 px-3 w-full h-full pt-2">
      <h1 className="w-full font-extrabold text-lg text-sky-950 pb-2"> ALL TASKS</h1>
      <button @click="isAddTask=true" className="py-2 w-full font-bold border-t-2 text-[#aaa8a4] border-[#aaa8a4] hover:bg-[#c2bfb8] hover:text-[#e4ded8] hover:border-[#d4cfc9]">+ Add New Task</button>
      <TaskListView v-if="(allTasks.length>0&&isAllTasks)||filteredTasks.length>0||searchTasks.length>0" @tskId="onChildClicked" @notify="handleNotify" @refreshTasks="fetchTasks" :tasks="isFilter ? filteredTasks : isSearch? searchTasks : allTasks" />
      <div v-if="allTasks.length===0||(filteredTasks.length===0&&isFilter===true)"
        class="h-30 grid place-content-center font-bold text-sky-950"
      >
        No tasks available
      </div>
    </div>
    <!--Task Information Responsive-->
    <div ref="taskRef" className="col-start-8 col-span-3 w-full h-full bg-[#d4cfc9]">
      <NewTask @close="closeTask" @notify="handleNotify" @refreshTasks="fetchTasks" v-if="isAddTask"/>
      <Task @refreshTasks="fetchTasks" @close="closeTask" @notify="handleNotify" v-if="isTaskClicked &&task" :tsk="task"/>
    </div>
  </main>
</template>
