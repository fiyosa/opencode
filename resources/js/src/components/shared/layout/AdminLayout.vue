<script setup lang="ts">
import { useRouter } from 'vue-router'
import { postLogoutAuth } from '../../../api/auth/postLogoutAuth'

const router = useRouter()

const navItems = [
  { label: 'Dashboard', to: '/admin/dashboard', icon: 'grid' },
  { label: 'Users', to: '/admin/users', icon: 'users' },
]

async function handleLogout() {
  const res = await postLogoutAuth()
  if (res.status < 400) {
    router.push('/login')
  }
}
</script>

<template>
  <div class="min-h-screen bg-background flex">
    <aside class="w-60 bg-sidebar border-r border-border flex flex-col flex-shrink-0">
      <div class="h-14 flex items-center px-5 border-b border-border">
        <span class="text-sm font-semibold text-foreground">GSD Skill</span>
      </div>

      <nav class="flex-1 py-3 px-3 space-y-0.5">
        <router-link
          v-for="item in navItems"
          :key="item.to"
          :to="item.to"
          class="flex items-center gap-2.5 px-3 py-2 text-sm text-sidebar-text rounded-lg hover:bg-sidebar-hover hover:text-foreground transition-colors duration-150"
          active-class="bg-sidebar-active text-sidebar-text-active font-medium"
        >
          <svg v-if="item.icon === 'grid'" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
          </svg>
          <svg v-else-if="item.icon === 'users'" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
          </svg>
          {{ item.label }}
        </router-link>
      </nav>

      <div class="p-3 border-t border-border">
        <button
          @click="handleLogout"
          class="flex items-center gap-2.5 w-full px-3 py-2 text-sm text-sidebar-text rounded-lg hover:bg-sidebar-hover hover:text-destructive transition-colors duration-150 cursor-pointer"
        >
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
          </svg>
          Sign out
        </button>
      </div>
    </aside>

    <main class="flex-1 flex flex-col min-w-0">
      <header class="h-14 bg-card border-b border-border flex items-center px-6">
        <h2 class="text-sm font-medium text-foreground">
          <slot name="header" />
        </h2>
      </header>
      <div class="flex-1 p-6 overflow-auto">
        <slot />
      </div>
    </main>
  </div>
</template>
