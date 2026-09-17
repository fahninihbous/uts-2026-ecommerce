<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

/* ================= CONFIGURATION ================= */
const API_URL = 'http://localhost:8000/api'
const router = useRouter()

// =========================
// STATE DATA DARI BACKEND
// =========================
const user = ref({
  name: '',
  email: '',
  phone: '',
  address: ''
})

const loading = ref(true)

// =========================
// FETCH DATA FROM LARAVEL
// =========================
const fetchUserData = async () => {
  const token = localStorage.getItem('token')
  
  if (!token) {
    router.push('/login')
    return
  }

  axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
  loading.value = true

  try {
    const profileResponse = await axios.get(`${API_URL}/profile`)
    if (profileResponse.data.status === true && profileResponse.data.data) {
      const data = profileResponse.data.data
      user.value = {
        name: data.name || 'No Name',
        email: data.email || '',
        phone: data.phone || '-',
        address: data.address || '-'
      }
    }
  } catch (error) {
    console.error('Gagal mengambil data user dari server:', error)
    if (error.response && (error.response.status === 401 || error.response.status === 419)) {
      localStorage.removeItem('token')
      router.push('/login')
    }
  } finally {
    loading.value = false
  }
}

// =========================
// NAVIGATION & LOGOUT
// =========================
const goHome = () => router.push('/home')
const goShop = () => router.push('/shop')
const goProfile = () => router.push('/edit-profile')

const logout = async () => {
  const token = localStorage.getItem('token')
  
  try {
    if (token) {
      await axios.post(`${API_URL}/logout`, {}, {
        headers: { Authorization: `Bearer ${token}` }
      })
    }
  } catch (error) {
    console.error('Logout backend error:', error)
  } finally {
    localStorage.removeItem('token')
    delete axios.defaults.headers.common['Authorization']
    alert('Logout berhasil!')
    router.push('/home')
  }
}

onMounted(() => {
  fetchUserData()
})
</script>

<template>
  <div class="user-page">
    <!-- =================================
         MAIN CONTENT
    ================================== -->
    <main class="account-content">

      <!-- BACK TO HOME BUTTON -->
      <div class="back-section">
        <button class="back-button" @click="goHome">
          ← BACK TO HOME
        </button>
      </div>

      <!-- PAGE TITLE -->
      <div class="profile-header">
        <p class="eyebrow">ACCOUNT INFORMATION</p>
        <h1>Hello, <span>{{ user.name || 'Loading...' }}</span></h1>
      </div>


      <!-- PROFILE CARD -->
      <div class="profile-card">
        <div class="profile-intro">
          <div class="avatar">
            {{ user.name ? user.name.charAt(0).toUpperCase() : 'U' }}
          </div>
          <div>
            <h2>{{ user.name }}</h2>
            <p>{{ user.email }}</p>
          </div>
        </div>

        <div class="profile-details">
          <div class="detail-row">
            <span>FULL NAME</span>
            <strong>{{ user.name }}</strong>
          </div>
          <div class="detail-row">
            <span>EMAIL</span>
            <strong>{{ user.email }}</strong>
          </div>
          <div class="detail-row">
            <span>PHONE</span>
            <strong>{{ user.phone }}</strong>
          </div>
          <div class="detail-row">
            <span>LOCATION</span>
            <strong>{{ user.address }}</strong>
          </div>
        </div>

        <!-- ACTIONS -->
        <div class="account-actions">
          <button @click="goProfile" class="btn-outline">
            EDIT PERSONAL DETAILS
          </button>
          <button @click="logout" class="btn-dark">
            LOGOUT FROM ACCOUNT
          </button>
        </div>
      </div>

    </main>

  </div>
</template>

<style scoped>
.user-page {
  background-color: #ffffff;
  color: #111111;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
  min-height: 100vh;
  margin: 0;
  padding-bottom: 80px;
}

/* ================= NAVBAR ================= */
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 30px 50px;
  border-bottom: 1px solid #eeeeee;
}

.nav-left, .nav-right {
  display: flex;
  gap: 30px;
}

.navbar a {
  text-decoration: none;
  color: #777777;
  font-size: 11px;
  letter-spacing: 2px;
  font-weight: 500;
  transition: color 0.3s ease;
}

.navbar a:hover,
.navbar a.active {
  color: #111111;
}

.logo {
  background: none;
  border: none;
  font-size: 16px;
  letter-spacing: 4px;
  font-weight: 700;
  color: #111111;
  cursor: pointer;
}

/* ================= CONTENT LAYOUT ================= */
.account-content {
  padding: 40px 50px;
  max-width: 800px;
  margin: 0 auto;
}

.back-section {
  margin-bottom: 30px;
}

.back-button {
  background: none;
  border: none;
  font-size: 10px;
  letter-spacing: 2px;
  font-weight: 600;
  color: #777777;
  cursor: pointer;
  padding: 0;
  transition: color 0.3s ease;
}

.back-button:hover {
  color: #111111;
}

.profile-header {
  margin-bottom: 40px;
}

.eyebrow {
  font-size: 10px;
  letter-spacing: 3px;
  color: #777777;
  margin-bottom: 10px;
}

.profile-header h1 {
  font-size: 36px;
  font-weight: 300;
  line-height: 1.2;
  margin: 0;
}

.profile-header h1 span {
  font-weight: 600;
}

/* ================= PROFILE CARD ================= */
.profile-card {
  background: #fafafa;
  border: 1px solid #eeeeee;
  padding: 40px;
  display: flex;
  flex-direction: column;
  gap: 30px;
}

.profile-intro {
  display: flex;
  align-items: center;
  gap: 20px;
  padding-bottom: 25px;
  border-bottom: 1px solid #eeeeee;
}

.avatar {
  width: 60px;
  height: 60px;
  background: #111111;
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  font-weight: 600;
  border-radius: 50%;
}

.profile-intro h2 {
  font-size: 18px;
  font-weight: 600;
  margin: 0 0 5px 0;
}

.profile-intro p {
  font-size: 12px;
  color: #777777;
  margin: 0;
}

.profile-details {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.detail-row {
  display: flex;
  justify-content: space-between;
  padding-bottom: 12px;
  border-bottom: 1px solid #eeeeee;
}

.detail-row span {
  font-size: 10px;
  letter-spacing: 2px;
  color: #888888;
}

.detail-row strong {
  font-size: 13px;
  font-weight: 500;
  color: #111111;
}

/* ================= ACTIONS ================= */
.account-actions {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 15px;
  margin-top: 10px;
}

.btn-outline {
  background: transparent;
  color: #111111;
  border: 1px solid #111111;
  padding: 16px;
  font-size: 9px;
  letter-spacing: 2px;
  cursor: pointer;
  text-transform: uppercase;
  font-weight: 500;
  transition: all 0.3s ease;
}

.btn-outline:hover {
  background: #111111;
  color: #ffffff;
}

.btn-dark {
  background: #111111;
  color: #ffffff;
  border: 1px solid #111111;
  padding: 16px;
  font-size: 9px;
  letter-spacing: 2px;
  cursor: pointer;
  text-transform: uppercase;
  font-weight: 500;
  transition: all 0.3s ease;
}

.btn-dark:hover {
  background: #ffffff;
  color: #111111;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
  .navbar, .account-content {
    padding-left: 20px;
    padding-right: 20px;
  }

  .account-actions {
    grid-template-columns: 1fr;
  }
}
</style>