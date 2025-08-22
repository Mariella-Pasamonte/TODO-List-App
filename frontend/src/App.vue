  <script setup lang="ts">
    import { RouterView } from 'vue-router'
    import Header from './components/header.vue'
  </script>


  <template >
    <div className="w-screen h-screen bg-[#E8E2DC] ">
      <Header></Header>
      <div className="h-[90%] w-full">
        <RouterView />
      </div>
    </div>
  </template>

