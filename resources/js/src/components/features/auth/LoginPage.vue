<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { postLoginAuth } from '../../../api/auth/postLoginAuth'

const router = useRouter()

const email = ref('')
const password = ref('')
const errors = ref<Record<string, string[]>>({})
const isPending = ref(false)

async function handleLogin() {
  errors.value = {}
  isPending.value = true
  const res = await postLoginAuth({ payload: { email: email.value, password: password.value } })
  isPending.value = false
  if (res.status === 422) {
    errors.value = res.data?.errors || {}
  } else if (res.status >= 400) {
    errors.value = { email: ['Invalid credentials'] }
  } else {
    router.push('/admin/dashboard')
  }
}
</script>

<template>
  <div class="min-h-screen bg-background flex items-center justify-center p-4">
    <div class="w-full max-w-sm">
      <div class="text-center mb-8">
        <h1 class="text-2xl font-semibold text-foreground">GSD Skill</h1>
        <p class="text-sm text-muted-foreground mt-1">Sign in to your account</p>
      </div>

      <div class="bg-card border border-border rounded-xl p-6">
        <form @submit.prevent="handleLogin" class="space-y-5">
          <div>
            <label for="email" class="block text-sm font-medium text-foreground mb-1.5">
              Email
            </label>
            <input
              id="email"
              v-model="email"
              type="email"
              autocomplete="email"
              class="block w-full px-3 py-2.5 bg-background border border-border rounded-lg text-sm text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:border-ring transition-colors duration-150"
              :class="{ 'border-destructive focus:ring-destructive focus:border-destructive': errors.email }"
              placeholder="you@example.com"
            />
            <p v-if="errors.email" class="mt-1.5 text-xs text-destructive">
              {{ errors.email[0] }}
            </p>
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-foreground mb-1.5">
              Password
            </label>
            <input
              id="password"
              v-model="password"
              type="password"
              autocomplete="current-password"
              class="block w-full px-3 py-2.5 bg-background border border-border rounded-lg text-sm text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:border-ring transition-colors duration-150"
              :class="{ 'border-destructive focus:ring-destructive focus:border-destructive': errors.password }"
              placeholder="Enter your password"
            />
            <p v-if="errors.password" class="mt-1.5 text-xs text-destructive">
              {{ errors.password[0] }}
            </p>
          </div>

          <button
            type="submit"
            :disabled="isPending"
            class="w-full py-2.5 px-4 bg-primary text-on-primary text-sm font-medium rounded-lg hover:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-150 cursor-pointer"
          >
            <span v-if="isPending" class="inline-flex items-center gap-2">
              <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24" fill="none">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
              </svg>
              Signing in...
            </span>
            <span v-else>Sign in</span>
          </button>
        </form>
      </div>

      <p class="text-center text-xs text-muted-foreground mt-6">
        GSD Skill &mdash; Admin Dashboard
      </p>
    </div>
  </div>
</template>
