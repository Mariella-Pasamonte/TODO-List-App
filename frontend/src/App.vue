  <script setup lang="ts">
    import { RouterView } from 'vue-router'
    import Header from './components/header.vue'
    import {ref} from 'vue'
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
    import { faXmarkCircle } from '@fortawesome/free-solid-svg-icons';

    const isNotif = ref(false)
    const isErr = ref<Boolean | null>(null)
    const notification = ref<String | null>(null)
    const userId = ref<Number | null>(null)

    function onNotif(notif:String,isError:Boolean) {
      notification.value = notif
      isErr.value = isError
      isNotif.value = true
    } 

    function loginOnNotif(notif:String,isError:Boolean,usrId:Number) {
      notification.value = notif
      isErr.value = isError
      isNotif.value = true
      userId.value = usrId
    } 

    function close(){
      isNotif.value=false
    }
  </script>

  <template >
    <div className="w-screen h-screen bg-[#E8E2DC] ">
      <Header></Header>
      <div className="relative h-[90.6%] w-full">
        <div
          class="absolute right-2 z-[99] transition-all ease-in-out duration-700 delay-300 text-white" 
          :class="isNotif?'top-2 opacity-100':'top-10 opacity-0'"
        >
          <div
            class="h-fit w-fit p-3 rounded-xl flex flex-row place-content-center"
            :class="isErr?'bg-red-500':'bg-green-600'"
          >
              <p className="place-content-center">{{ notification }}</p>
              <button @click="close()" className="flex flex-col justify-center h-6 ml-2 w-fit border-white rounded-full cursor-pointer">
                  <FontAwesomeIcon :icon="faXmarkCircle"/>
              </button>
          </div>
        </div>
        <RouterView @notif="onNotif" @loginNotif="loginOnNotif" UserId="userId"/>
      </div>
    </div>
  </template>