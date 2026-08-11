<script setup lang="ts">
withDefaults(defineProps<{
  padding?: 'none' | 'sm' | 'md' | 'lg'
}>(), {
  padding: 'md',
})
</script>

<template>
  <div
    class="bg-card border border-border rounded-xl"
    :class="[
      padding === 'none' && '',
      padding === 'sm' && 'p-4',
      padding === 'md' && 'p-5',
      padding === 'lg' && 'p-6',
    ]"
  >
    <slot />
  </div>
</template>
