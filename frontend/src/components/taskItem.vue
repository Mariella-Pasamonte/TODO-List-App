<script setup lang="ts"> 
    import {ref} from 'vue'
    
    const isActive = ref(false)

    function toggleActive() {
        isActive.value = !isActive.value
    }   

    const props = defineProps({
        label: {
            type: String,
            required: true
        },
        id:{
            type: String,
            required: true
        },
        date:{
            type: String,
        },
        category:{
            type: String,
        },
        active: Boolean
    });
    
    const emit = defineEmits<{
        (e: "set-active", id: String): void
    }>()
</script>

<template>
    <button @click="emit('set-active', props.id)"
    class="flex flex-row justify-between w-full text-left py-2 px-4 font-semibold border-t-2 border-[#c2bfb8] text-sky-950 cursor-pointer"
    :class="props.active?'bg-[#c2bfb8]':'hover:bg-[#c2bfb8]'">
        <div className="flex flex-col justify-center">
            {{ props.label}}
        </div>
        <div className="flex flex-col justify-center text-red-700">
            {{ props.date }}
        </div>
        <div className="flex flex-col justify-center">
            {{ props.category }}
        </div>
        <div className="flex flex-col justify-center">
            <slot name="completeButton"/>  
        </div> 
    </button>
</template>