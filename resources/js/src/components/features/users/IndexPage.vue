<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import AdminLayout from '../../shared/layout/AdminLayout.vue'
import { getUsers, type User } from '../../../api/users/getUsers'
import { deleteUser } from '../../../api/users/deleteUser'

const router = useRouter()
const users = ref<User[]>([])
const isLoading = ref(true)

onMounted(async () => {
  const res = await getUsers()
  if (res.status < 400) {
    users.value = res.data?.data ?? []
  }
  isLoading.value = false
})

function goToCreate() {
  router.push('/admin/users/create')
}

function goToEdit(id: number) {
  router.push('/admin/users/' + id + '/edit')
}

async function handleDelete(id: number) {
  if (!confirm('Are you sure you want to delete this user?')) return
  const res = await deleteUser({ params: { user_id: id } })
  if (res.status >= 400) return
  const list = await getUsers()
  if (list.status < 400) {
    users.value = list.data?.data ?? []
  }
}
</script>

<template>
  <AdminLayout>
    <template #header>Users</template>

    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-lg font-semibold text-foreground">Users</h1>
          <p class="text-sm text-muted-foreground mt-0.5">Manage system users</p>
        </div>
        <button
          @click="goToCreate"
          class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary text-on-primary text-sm font-medium rounded-lg hover:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 transition-colors duration-150 cursor-pointer"
        >
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
          </svg>
          Add User
        </button>
      </div>

      <div v-if="isLoading" class="bg-card border border-border rounded-xl p-8 text-center text-sm text-muted-foreground">
        Loading users...
      </div>

      <div v-else-if="!users.length" class="bg-card border border-border rounded-xl p-8 text-center text-sm text-muted-foreground">
        No users found.
      </div>

      <div v-else class="bg-card border border-border rounded-xl overflow-hidden">
        <table class="w-full text-sm">
          <thead>
            <tr class="border-b border-border">
              <th class="text-left px-5 py-3 font-medium text-muted-foreground">Name</th>
              <th class="text-left px-5 py-3 font-medium text-muted-foreground">Email</th>
              <th class="text-left px-5 py-3 font-medium text-muted-foreground">Created</th>
              <th class="text-right px-5 py-3 font-medium text-muted-foreground">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="user in users"
              :key="user.id"
              class="border-b border-border last:border-b-0 hover:bg-muted transition-colors duration-100"
            >
              <td class="px-5 py-3.5 text-foreground font-medium">{{ user.name }}</td>
              <td class="px-5 py-3.5 text-muted-foreground">{{ user.email }}</td>
              <td class="px-5 py-3.5 text-muted-foreground">{{ user.created_at }}</td>
              <td class="px-5 py-3.5 text-right">
                <div class="inline-flex items-center gap-1">
                  <button
                    @click="goToEdit(user.id)"
                    class="px-2.5 py-1.5 text-xs font-medium text-primary hover:bg-primary-light rounded-md transition-colors duration-150 cursor-pointer"
                  >
                    Edit
                  </button>
                  <button
                    @click="handleDelete(user.id)"
                    class="px-2.5 py-1.5 text-xs font-medium text-destructive hover:bg-red-50 rounded-md transition-colors duration-150 cursor-pointer"
                  >
                    Delete
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdminLayout>
</template>
