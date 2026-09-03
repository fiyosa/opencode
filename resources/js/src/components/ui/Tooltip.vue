<script setup lang="ts">
import { ref } from 'vue'

const props = withDefaults(defineProps<{
  text: string
  position?: 'top' | 'bottom' | 'left' | 'right'
}>(), {
  position: 'top',
})

const visible = ref(false)

function show() { visible.value = true }
function hide() { visible.value = false }
</script>

<template>
  <div class="relative inline-flex" @mouseenter="show" @mouseleave="hide" @focusin="show" @focusout="hide">
    <slot />
    <transition
      enter-active-class="transition-opacity duration-150"
      leave-active-class="transition-opacity duration-150"
      enter-from-class="opacity-0"
      leave-to-class="opacity-0"
    >
      <div
        v-if="visible"
        class="absolute z-50 px-2 py-1 text-xs text-on-primary bg-foreground rounded shadow-sm whitespace-nowrap pointer-events-none"
        :class="[
          position === 'top' && 'bottom-full left-1/2 -translate-x-1/2 mb-1.5',
          position === 'bottom' && 'top-full left-1/2 -translate-x-1/2 mt-1.5',
          position === 'left' && 'right-full top-1/2 -translate-y-1/2 mr-1.5',
          position === 'right' && 'left-full top-1/2 -translate-y-1/2 ml-1.5',
        ]"
      >
        {{ text }}
      </div>
    </transition>
  </div>
</template>
