<script setup lang="ts">
    import type { HTMLAttributes } from 'vue';
    import Separator from '@/core/components/separator/Separator.vue';
    import { cn } from '@/core/lib/utils';

    const props = defineProps<{
        class?: HTMLAttributes['class'];
    }>();
</script>

<template>
    <Separator data-sidebar="separator" :class="cn('mx-2 w-auto bg-sidebar-border', props.class)">
        <slot />
    </Separator>
</template>
