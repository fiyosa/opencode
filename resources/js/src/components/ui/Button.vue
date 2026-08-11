<script setup lang="ts">
withDefaults(defineProps<{
  variant?: 'primary' | 'secondary' | 'ghost' | 'danger'
  size?: 'sm' | 'md' | 'lg'
}>(), {
  variant: 'primary',
  size: 'md',
})
</script>

<template>
  <button
    class="inline-flex items-center justify-center font-medium rounded-lg transition-colors duration-150 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
    :class="[
      variant === 'primary' && 'bg-primary text-on-primary hover:bg-primary-hover focus:ring-2 focus:ring-ring focus:ring-offset-2',
      variant === 'secondary' && 'border border-border text-foreground hover:bg-muted',
      variant === 'ghost' && 'text-muted-foreground hover:text-foreground hover:bg-muted',
      variant === 'danger' && 'bg-destructive text-white hover:bg-red-700',
      size === 'sm' && 'px-2.5 py-1.5 text-xs',
      size === 'md' && 'px-4 py-2 text-sm',
      size === 'lg' && 'px-6 py-3 text-base',
    ]"
  >
    <slot />
  </button>
</template>
