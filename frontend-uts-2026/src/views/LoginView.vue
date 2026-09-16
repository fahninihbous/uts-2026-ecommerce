<script setup>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

/* ================= CONFIGURATION ================= */
const API_URL = 'http://localhost:8000/api'

/* ================= ROUTER ================= */
const router = useRouter()

/* ================= FORM STATE ================= */
const form = reactive({
  email: '',
  password: '',
  remember: false
})

/* ================= UI STATE ================= */
const isLoading = ref(false)

/* ================= LOGIN FUNCTION ================= */
const handleLogin = async () => {
  if (!form.email || !form.password) {
    alert('Email dan password wajib diisi!')
    return
  }

  isLoading.value = true

  try {
    // 1. Kirim data login ke backend Laravel
    const response = await axios.post(`${API_URL}/login`, {
      email: form.email,
      password: form.password
    })

    // Mendapatkan token (mengantisipasi nama key 'token' atau 'access_token' dari backend)
    const token = response.data.token || response.data.access_token

    if (token) {
      alert('Login berhasil!')

      // Simpan token ke localStorage
      localStorage.setItem('token', token)

      // Menyimpan data role ke localStorage
      if (response.data.user && response.data.user.role) {
        localStorage.setItem('role', response.data.user.role)
      } else if (response.data.role) {
        localStorage.setItem('role', response.data.role)
      } else {
        localStorage.setItem('role', 'customer') 
      }

      // Set default header authorization Axios
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`

      // Diarahkan ke halaman home
      router.push('/home')
    } else {
      // Jika status true tapi token tidak ditemukan di response
      alert(response.data.message || 'Login gagal, token tidak valid.')
    }

  } catch (error) {
    console.error('Login Error:', error)
    
    // Menangkap pesan error dari Laravel (misal: 401 Unauthorized / User tidak ditemukan)
    if (error.response && error.response.data) {
      const errorMsg = error.response.data.message || error.response.data.error || 'User tidak ditemukan atau password salah.'
      alert(`Gagal: ${errorMsg}`)
    } else {
      alert('Terjadi kesalahan koneksi ke server.')
    }
  } finally {
    isLoading.value = false
  }
}
</script>

<template>
  <div class="login-wrapper">
    <div class="login-card">
      <div class="brand-header">
        <h1 class="brand-title">PROVIDENTIAL</h1>
        <p class="brand-subtitle">Minimalist Fashion & Apparel</p>
      </div>

      <form @submit.prevent="handleLogin" class="form-container">
        <div class="form-group">
          <label for="email">Email</label>
          <input 
            id="email"
            v-model="form.email"
            type="email" 
            required 
            placeholder="nama@email.com"
            class="input-field"
          />
        </div>

        <div class="form-group">
          <div class="label-row">
            <label for="password">Password</label>
            <router-link to="/forgot-password" class="forgot-link">Forget password?</router-link>
          </div>
          <input 
            id="password"
            v-model="form.password"
            type="password" 
            required 
            placeholder="******"
            class="input-field"
          />
        </div>

        <div class="checkbox-group">
          <input 
            id="remember" 
            v-model="form.remember"
            type="checkbox" 
            class="checkbox-input"
          />
          <label for="remember">Remember me on this device</label>
        </div>

        <button 
          type="submit" 
          :disabled="isLoading"
          class="submit-btn"
        >
          <span v-if="!isLoading">Sign in</span>
          <span v-else>Processing...</span>
        </button>
      </form>

      <div class="divider">
        <span>Or sign in with</span>
      </div>

      <p class="footer-text">
        Don't have an account? 
        <router-link to="/register" class="register-link">Register now</router-link>
      </p>

    </div>
  </div>
</template>

<style scoped>
.login-wrapper {
  width: 100vw;
  min-height: 100vh;
  background-color: #f3f4f6;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0;
  padding: 0;
}

.login-card {
  width: 100%;
  max-width: 400px;
  background-color: #ffffff;
  border-radius: 16px;
  padding: 2rem;
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15);
  border: 1px solid #e5e7eb;
}

.brand-header {
  text-align: center;
  margin-bottom: 2rem;
}

.brand-title {
  font-size: 1.75rem;
  font-weight: 700;
  color: #111827;
  letter-spacing: 2px;
  margin: 0;
}

.brand-subtitle {
  font-size: 0.7rem;
  letter-spacing: 1.5px;
  color: #6b7280;
  text-transform: uppercase;
  margin-top: 4px;
}

.form-container {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.35rem;
}

.form-group label {
  font-size: 0.85rem;
  color: #374151;
  font-weight: 500;
}

.label-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.forgot-link {
  font-size: 0.75rem;
  color: #6b7280;
  text-decoration: none;
}

.input-field {
  width: 100%;
  padding: 0.75rem 1rem;
  border-radius: 10px;
  background-color: #f9fafb;
  border: 1px solid #d1d5db;
  color: #111827;
  outline: none;
  box-sizing: border-box;
  transition: all 0.2s ease;
}

.input-field:focus {
  background-color: #ffffff;
  border-color: #9ca3af;
  box-shadow: 0 0 0 3px rgba(156, 163, 175, 0.25);
}

.checkbox-group {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.85rem;
  color: #4b5563;
}

.checkbox-input {
  accent-color: #4b5563;
  width: 16px;
  height: 16px;
  cursor: pointer;
}

.submit-btn {
  width: 100%;
  padding: 0.85rem;
  background-color: #111827;
  color: #ffffff;
  border: none;
  border-radius: 10px;
  font-weight: 600;
  font-size: 0.95rem;
  cursor: pointer;
  transition: background-color 0.2s ease, transform 0.1s ease;
}

.submit-btn:hover {
  background-color: #374151;
}

.submit-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.divider {
  position: relative;
  text-align: center;
  margin: 1.5rem 0;
}

.divider::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 0;
  width: 100%;
  height: 1px;
  background-color: #e5e7eb;
}

.divider span {
  position: relative;
  background-color: #ffffff;
  padding: 0 0.5rem;
  font-size: 0.75rem;
  color: #9ca3af;
  text-transform: uppercase;
}

.footer-text {
  text-align: center;
  font-size: 0.85rem;
  color: #4b5563;
  margin-top: 1rem;
}

.register-link {
  color: #111827;
  font-weight: 600;
  text-decoration: none;
}
</style>