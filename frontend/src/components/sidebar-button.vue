<script setup lang="ts">
    import { ref } from "vue"

    const isActive = ref(false)

    function toggleActive() {
        isActive.value = !isActive.value
    }   

    const props = defineProps({
        label: {
            type: String,
            required: true
        },
        id: {
            type: String,
            required: true
        }, 
        active: Boolean
    });
    
    const emit = defineEmits<{
        (e: "set-active", id: String): void
    }>()
</script>

<template>
    <button @click="emit('set-active', props.id)"
    :id="props.id"
    class="w-full text-left py-1 px-2 font-semibold text-sky-950  rounded-lg cursor-pointer"
    :class="props.active?'bg-[#c2bfb8]':'hover:bg-[#c2bfb8]'">
        {{ props.label}}    
    </button>
</template>