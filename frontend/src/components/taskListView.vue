<script setup lang="ts">
    import TaskItem from './taskItem.vue';
    import {ref} from 'vue'
    import { useClickOutside } from '@/composables/useClickOutside';

    const emit = defineEmits(['tskId'])
    const elRef = ref<HTMLElement | null>(null)
    const activeButton = ref<String | null>(null)
    const isActive = ref(false)
    const complete = ref(true)
    const tskId = ref<String | null>(null)
    defineExpose({tskId})

    function handleClick(id:String) {
        isActive.value=true
        tskId.value=id
        emit('tskId',id)
    }
    useClickOutside(elRef,isActive)

    function setActive(id: String) {
      activeButton.value = id
    }

</script>

<template>
    <div ref="elRef" className="w-full h-fit">
        <div className="w-full">
            <TaskItem 
                @click="handleClick('tsk-1')"
                label="Do work" 
                id="tsk-1"
                date="August 25, 2025" 
                category="Work"
                :active="activeButton==='tsk-1'&&isActive" 
                @set-active="setActive"
            >
                <template #completeButton>
                    <label class="inline-flex items-center cursor-pointer">
                        <input @click="complete =!complete" type="checkbox" value="complete" class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>
                    </label>
                </template> 
            </TaskItem>
        </div>
        <div className="w-full">
            <TaskItem
                @click="handleClick('tsk-2')" 
                label="Do work" 
                id="tsk-2"
                date="August 25, 2025" 
                category="Work"
                :active="activeButton==='tsk-2'&&isActive" 
                @set-active="setActive"
            >
                <template #completeButton>
                    <label class="inline-flex items-center cursor-pointer">
                        <input @click="complete =!complete" type="checkbox" value="complete" class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>
                    </label>
                </template> 
            </TaskItem>
        </div>
    </div>
</template>