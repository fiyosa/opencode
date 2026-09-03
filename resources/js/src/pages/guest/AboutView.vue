<script setup lang="ts">
</script>

<template>
  <div class="min-h-screen bg-background flex items-center justify-center p-4">
    <div class="text-center max-w-md">
      <h1 class="text-3xl font-semibold text-foreground">About</h1>
      <p class="text-sm text-muted-foreground mt-2">
        GSD Skill is an admin dashboard built with Laravel + Vue 3. This page
        is where you can tell visitors what your project is about, who is
        behind it, and why it exists.
      </p>
      <div class="mt-8 flex items-center justify-center gap-3">
        <router-link
          to="/"
          class="px-5 py-2.5 bg-primary text-on-primary text-sm font-medium rounded-lg hover:bg-primary-hover transition-colors duration-150"
        >
          Back to home
        </router-link>
      </div>
    </div>
  </div>
</template>
