<script setup lang="ts">
  import Sidebar from '../components/sidebar.vue'
  import Task from '../components/task.vue'
  import NewTask from '@/components/newTask.vue'
  import TaskListView from '@/components/taskListView.vue'
  import { useClickOutside } from '@/composables/useClickOutside'
  import {ref} from 'vue'

  const taskRef = ref<HTMLElement | null>(null)
  const isAddTask = ref(false)
  const isTaskClicked = ref(false)

  const emit = defineEmits(["notif"]);

  function handleNotify(msg:String,isErr:Boolean) {
    emit("notif", msg,isErr);
  }

  useClickOutside(taskRef,isAddTask)
  useClickOutside(taskRef,isTaskClicked)

  function onChildClicked(id:String) {
    console.log('Child button id:', id)
    isTaskClicked.value=true
  } 
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
      <TaskListView @tskId="onChildClicked" />
    </div>
    <!--Task Information Responsive-->
    <div ref="taskRef" className="col-start-8 col-span-3 w-full h-full bg-[#d4cfc9]">
      <NewTask ref="addTaskRef" v-if="isAddTask"/>
      <Task ref="taskRef" v-if="isTaskClicked"/>
    </div>
  </main>
</template>
