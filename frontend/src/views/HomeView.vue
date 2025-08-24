<script setup lang="ts">
  import Sidebar from '../components/sidebar.vue'
</script>

<template>
  <main className="w-full h-full grid grid-cols-10">
    <!--Sidebar-->
    <div className="col-start-1 col-span-2 w-full h-full bg-[#d4cfc9]">
      <Sidebar />
    </div>
    <!--Tasks-->
    <div className="col-start-3 col-span-6 w-full h-full">

    </div>
    <!--Task Information Responsive-->
    <div className="col-start-9 col-span-2 w-full h-full bg-[#d4cfc9]">
    
    </div>
  </main>
</template>
