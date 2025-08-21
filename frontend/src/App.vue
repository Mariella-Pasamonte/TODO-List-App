  <script setup lang="ts">
    import { RouterView } from 'vue-router'
    import Header from './components/header.vue'
  </script>


  <template >
    <div className="w-screen h-screen bg-[#E8E2DC] ">
      <Header></Header>
      <div>
        <RouterView />
      </div>
    </div>
  </template>

