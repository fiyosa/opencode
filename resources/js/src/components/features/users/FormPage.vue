<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import AdminLayout from '../../shared/layout/AdminLayout.vue'
import { getUser } from '../../../api/users/getUser'
import { postUser } from '../../../api/users/postUser'
import { putUser } from '../../../api/users/putUser'

const router = useRouter()
const route = useRoute()
const userId = route.params.id ? Number(route.params.id) : 0
const isEdit = userId > 0

const name = ref('')
const email = ref('')
const password = ref('')
const passwordConfirmation = ref('')
const errors = ref<Record<string, string[]>>({})
const creating = ref(false)
const updating = ref(false)
const saving = computed(() => creating.value || updating.value)

onMounted(async () => {
  if (!isEdit) return
  const res = await getUser(userId)
  if (res.status < 400) {
    name.value = res.data?.data?.name ?? ''
    email.value = res.data?.data?.email ?? ''
  }
})

async function handleSubmit() {
  errors.value = {}
  if (isEdit) {
    updating.value = true
  } else {
    creating.value = true
  }

  const res = isEdit
    ? await putUser(userId, {
        payload: {
          name: name.value,
          email: email.value,
          ...(password.value
            ? { password: password.value, password_confirmation: passwordConfirmation.value }
            : {}),
        },
      })
    : await postUser({
        payload: {
          name: name.value,
          email: email.value,
          password: password.value,
          password_confirmation: passwordConfirmation.value,
        },
      })

  creating.value = false
  updating.value = false

  if (res.status >= 400) {
    if (res.status === 422) {
      errors.value = res.data?.errors || {}
    }
    return
  }
  router.push('/admin/users')
}
</script>

<template>
  <AdminLayout>
    <template #header>{{ isEdit ? 'Edit User' : 'Create User' }}</template>

    <div class="max-w-lg">
      <div class="bg-card border border-border rounded-xl p-6">
        <form @submit.prevent="handleSubmit" class="space-y-5">
          <div>
            <label class="block text-sm font-medium text-foreground mb-1.5">Name</label>
            <input
              v-model="name"
              type="text"
              class="block w-full px-3 py-2.5 bg-background border border-border rounded-lg text-sm text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:border-ring transition-colors duration-150"
              :class="{ 'border-destructive': errors.name }"
            />
            <p v-if="errors.name" class="mt-1.5 text-xs text-destructive">{{ errors.name[0] }}</p>
          </div>

          <div>
            <label class="block text-sm font-medium text-foreground mb-1.5">Email</label>
            <input
              v-model="email"
              type="email"
              class="block w-full px-3 py-2.5 bg-background border border-border rounded-lg text-sm text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:border-ring transition-colors duration-150"
              :class="{ 'border-destructive': errors.email }"
            />
            <p v-if="errors.email" class="mt-1.5 text-xs text-destructive">{{ errors.email[0] }}</p>
          </div>

          <div>
            <label class="block text-sm font-medium text-foreground mb-1.5">
              {{ isEdit ? 'New Password (leave blank to keep)' : 'Password' }}
            </label>
            <input
              v-model="password"
              type="password"
              class="block w-full px-3 py-2.5 bg-background border border-border rounded-lg text-sm text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:border-ring transition-colors duration-150"
              :class="{ 'border-destructive': errors.password }"
            />
            <p v-if="errors.password" class="mt-1.5 text-xs text-destructive">{{ errors.password[0] }}</p>
          </div>

          <div>
            <label class="block text-sm font-medium text-foreground mb-1.5">Confirm Password</label>
            <input
              v-model="passwordConfirmation"
              type="password"
              class="block w-full px-3 py-2.5 bg-background border border-border rounded-lg text-sm text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:border-ring transition-colors duration-150"
            />
          </div>

          <div class="flex items-center gap-3 pt-1">
            <button
              type="submit"
              :disabled="saving"
              class="px-4 py-2.5 bg-primary text-on-primary text-sm font-medium rounded-lg hover:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-150 cursor-pointer"
            >
              {{ saving ? 'Saving...' : 'Save' }}
            </button>
            <router-link
              to="/admin/users"
              class="px-4 py-2.5 text-sm font-medium text-muted-foreground hover:text-foreground transition-colors duration-150"
            >
              Cancel
            </router-link>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>
