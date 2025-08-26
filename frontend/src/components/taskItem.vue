<script setup lang="ts"> 
    import {ref} from 'vue'
    
    const isActive = ref(false)

    function toggleActive() {
        isActive.value = !isActive.value
    }
    
    const props = defineProps<{
        label:string,
        id:string,
        date?:string|null,
        category?:string|null,
        active:boolean
    }>();
    
    const emit = defineEmits<{
        (e: "set-active", id: String): void
    }>()
</script>

<template>
    <button @click="emit('set-active', props.id)"
    class="grid grid-cols-3 gap-2 w-full text-left py-2 px-4 rounded-l-sm font-semibold text-sky-950 cursor-pointer"
    :class="props.active?'bg-[#c2bfb8]':'hover:bg-[#c2bfb8]'">
        <div className="justify-center overflow-hidden">
            <p className="truncate">{{ props.label}}</p>
        </div>
        <div className="justify-center text-red-700">
            <p v-if="props.date" className="truncate text-right">{{ props.date}}</p>
        </div>
        <div className="">
            <p v-if="props.category" className="truncate text-right">{{ props.category}}</p>
        </div>
    </button>
</template>