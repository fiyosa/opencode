<script setup lang="ts">
import AdminLayout from '../../components/shared/layout/AdminLayout.vue'

const stats = [
  { label: 'Total Users', value: '—', icon: 'users', color: 'primary' },
  { label: 'Active Sessions', value: '—', icon: 'activity', color: 'accent' },
  { label: 'Roles', value: '—', icon: 'shield', color: 'secondary' },
]
</script>

<template>
  <AdminLayout>
    <template #header>Dashboard</template>

    <div class="space-y-6">
      <div>
        <h1 class="text-lg font-semibold text-foreground">Overview</h1>
        <p class="text-sm text-muted-foreground mt-0.5">
          Welcome to the admin dashboard
        </p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div
          v-for="stat in stats"
          :key="stat.label"
          class="bg-card border border-border rounded-xl p-5"
        >
          <div class="flex items-center justify-between">
            <p class="text-sm text-muted-foreground">{{ stat.label }}</p>
            <svg
              v-if="stat.icon === 'users'"
              class="w-5 h-5 text-primary"
              fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
            >
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
            </svg>
            <svg
              v-else-if="stat.icon === 'activity'"
              class="w-5 h-5 text-accent"
              fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
            >
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
            </svg>
            <svg
              v-else-if="stat.icon === 'shield'"
              class="w-5 h-5 text-secondary"
              fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
            >
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
            </svg>
          </div>
          <p class="text-2xl font-semibold text-foreground mt-3">{{ stat.value }}</p>
        </div>
      </div>

      <div class="bg-card border border-border rounded-xl p-6">
        <h2 class="text-sm font-medium text-foreground mb-1">Getting Started</h2>
        <p class="text-sm text-muted-foreground">
          Use the sidebar to navigate to Users to manage your application users,
          roles, and permissions.
        </p>
      </div>
    </div>
  </AdminLayout>
</template>
