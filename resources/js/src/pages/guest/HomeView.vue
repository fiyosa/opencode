<script setup lang="ts">
</script>

<template>
  <div class="min-h-screen bg-background flex items-center justify-center p-4">
    <div class="text-center max-w-md">
      <h1 class="text-3xl font-semibold text-foreground">GSD Skill</h1>
      <p class="text-sm text-muted-foreground mt-2">
        Admin dashboard built with Laravel + Vue 3
      </p>
      <div class="mt-8 flex items-center justify-center gap-3">
        <router-link
          to="/about"
          class="px-5 py-2.5 border border-border text-sm font-medium text-foreground rounded-lg hover:bg-muted transition-colors duration-150"
        >
          About
        </router-link>
        <router-link
          to="/login"
          class="px-5 py-2.5 bg-primary text-on-primary text-sm font-medium rounded-lg hover:bg-primary-hover transition-colors duration-150"
        >
          Sign in
        </router-link>
        <router-link
          to="/admin/dashboard"
          class="px-5 py-2.5 border border-border text-sm font-medium text-foreground rounded-lg hover:bg-muted transition-colors duration-150"
        >
          Dashboard
        </router-link>
      </div>
    </div>
  </div>
</template>
