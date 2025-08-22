<script setup lang="ts">
    const props = defineProps({
        label: {
            type: String,
            required: true
        }
    });
</script>

<template>
    <button ref="childRef" className="w-full text-left py-1 px-2 font-semibold text-sky-950 hover:bg-[#c2bfb8]  rounded-lg cursor-pointer">
        {{ props.label}}    
    </button>
</template>