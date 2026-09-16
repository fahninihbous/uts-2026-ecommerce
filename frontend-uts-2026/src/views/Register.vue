<template>
  <div class="register-page">

    <!-- ================= NAVBAR ================= -->
    <header class="navbar">

      <div class="nav-left">
        <router-link to="/shop" class="nav-link">
          SHOP
        </router-link>

        <router-link to="/about" class="nav-link">
          OUR MISSION
        </router-link>
      </div>


      <!-- LOGO -->
      <router-link to="/home" class="brand">
        PROVIDENTIAL
      </router-link>


      <div class="nav-right">
        <router-link to="/search" class="nav-link">
          SEARCH
        </router-link>

        <router-link to="/cart" class="nav-link">
          CART
        </router-link>

        <router-link to="/login" class="nav-link">
          LOGIN
        </router-link>
      </div>

    </header>


    <!-- ================= REGISTER ================= -->
    <main class="register-container">

      <!-- LEFT -->
      <section class="register-intro">

        <p class="eyebrow">
          JOIN PROVIDENTIAL
        </p>

        <h1>
          Create your<br />
          account.
        </h1>

        <p class="intro-text">
          Become part of Providential and discover timeless
          pieces designed for everyday life.
        </p>

        <div class="intro-line"></div>

        <p class="intro-small">
          SIMPLE. TIMELESS. ESSENTIAL.
        </p>

      </section>


      <!-- RIGHT -->
      <section class="register-form-section">

        <div class="form-header">

          <p class="eyebrow">
            CREATE ACCOUNT
          </p>

          <h2>
            Register
          </h2>

          <p>
            Please fill in your information below.
          </p>

        </div>


        <!-- FORM -->
        <form
          class="register-form"
          @submit.prevent="register"
        >

          <!-- NAME -->
          <div class="form-row">

            <div class="form-group">

              <label>
                FIRST NAME
              </label>

              <input
                v-model="form.firstName"
                type="text"
                placeholder="First name"
                required
              />

            </div>


            <div class="form-group">

              <label>
                LAST NAME
              </label>

              <input
                v-model="form.lastName"
                type="text"
                placeholder="Last name"
                required
              />

            </div>

          </div>


          <!-- EMAIL -->
          <div class="form-group">

            <label>
              EMAIL ADDRESS
            </label>

            <input
              v-model="form.email"
              type="email"
              placeholder="your@email.com"
              required
            />

          </div>


          <!-- PHONE -->
          <div class="form-group">

            <label>
              PHONE NUMBER
            </label>

            <input
              v-model="form.phone"
              type="tel"
              placeholder="08xxxxxxxxxx"
              required
            />

          </div>


          <!-- PASSWORD -->
          <div class="form-group">

            <label>
              PASSWORD
            </label>

            <div class="password-wrapper">

              <input
                v-model="form.password"
                :type="showPassword ? 'text' : 'password'"
                placeholder="Create a password"
                minlength="8"
                required
              />

              <button
                type="button"
                class="show-password"
                @click="showPassword = !showPassword"
              >
                {{ showPassword ? 'HIDE' : 'SHOW' }}
              </button>

            </div>

            <small>
              Minimum 8 characters.
            </small>

          </div>


          <!-- CONFIRM PASSWORD -->
          <div class="form-group">

            <label>
              CONFIRM PASSWORD
            </label>

            <div class="password-wrapper">

              <input
                v-model="form.confirmPassword"
                :type="showConfirmPassword ? 'text' : 'password'"
                placeholder="Confirm your password"
                required
              />

              <button
                type="button"
                class="show-password"
                @click="showConfirmPassword = !showConfirmPassword"
              >
                {{ showConfirmPassword ? 'HIDE' : 'SHOW' }}
              </button>

            </div>

            <small
              v-if="passwordError"
              class="error-message"
            >
              {{ passwordError }}
            </small>

          </div>


          <!-- TERMS -->
          <div class="terms">

            <label class="checkbox-container">

              <input
                v-model="form.agree"
                type="checkbox"
                required
              />

              <span>
                I agree to the
                <a href="#">
                  Terms & Conditions
                </a>
                and
                <a href="#">
                  Privacy Policy
                </a>.
              </span>

            </label>

          </div>


          <!-- REGISTER BUTTON -->
          <button
            type="submit"
            class="register-button"
            :disabled="loading"
          >
            {{ loading ? 'CREATING ACCOUNT...' : 'CREATE ACCOUNT →' }}
          </button>


          <!-- LOGIN -->
          <div class="login-link">

            <span>
              Already have an account?
            </span>

            <router-link to="/login">
              LOGIN
            </router-link>

          </div>

        </form>

      </section>

    </main>


    <!-- ================= BOTTOM ================= -->
    <section class="bottom-section">

      <div>
        <span>PROVIDENTIAL</span>
      </div>

      <p>
        CREATE AN ACCOUNT AND START YOUR JOURNEY.
      </p>

    </section>


    <!-- ================= FOOTER ================= -->
    <footer class="footer">

      <div class="footer-brand">
        PROVIDENTIAL
      </div>

      <div class="footer-links">

        <router-link to="/shop">
          SHOP
        </router-link>

        <router-link to="/about">
          OUR MISSION
        </router-link>

        <router-link to="/user">
          ACCOUNT
        </router-link>

      </div>

      <p>
        © 2026 PROVIDENTIAL. ALL RIGHTS RESERVED.
      </p>

    </footer>

  </div>
</template>


<script setup>
import { reactive, ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

/* ================= CONFIGURATION ================= */
const API_URL = 'http://localhost:8000/api'

/* ================= ROUTER ================= */
const router = useRouter()

/* ================= FORM ================= */
const form = reactive({
  firstName: '',
  lastName: '',
  email: '',
  phone: '', // Dipertahankan di UI, tetapi diabaikan saat kirim ke backend sesuai validasi Anda
  password: '',
  confirmPassword: '',
  agree: false
})

/* ================= STATE ================= */
const showPassword = ref(false)
const showConfirmPassword = ref(false)
const loading = ref(false)

/* ================= PASSWORD ERROR ================= */
const passwordError = computed(() => {
  if (form.confirmPassword && form.password !== form.confirmPassword) {
    return 'Passwords do not match.'
  }
  return ''
})

/* ================= REGISTER ================= */
const register = async () => {
  if (form.password !== form.confirmPassword) {
    alert('Password dan Confirm Password tidak sama.')
    return
  }

  if (form.password.length < 8) {
    alert('Password minimal 8 karakter.')
    return
  }

  if (!form.agree) {
    alert('Silakan setujui Terms & Conditions terlebih dahulu.')
    return
  }

  loading.value = true

  try {
    // MENYESUAIKAN DENGAN VALIDASI BACKEND ANDA
    // Hanya mengirim name, email, dan password saja agar tidak memicu error validasi backend.
    const payload = {
      name: `${form.firstName} ${form.lastName}`.trim(),
      email: form.email,
      password: form.password
    }

    const response = await axios.post(`${API_URL}/register`, payload)

    // Mengecek flag status true bawaan response json dari AuthController Anda
    if (response.data.status === true) {
      alert('Registrasi berhasil! Silakan login dengan akun Anda.')
      router.push('/login')
    } else {
      alert(response.data.message || 'Registrasi gagal.')
    }

  } catch (error) {
    console.error('Registration Error:', error)
    // Menangkap pesan $e->getMessage() yang dikirim catch backend Anda
    if (error.response && error.response.data) {
      alert(`Gagal: ${error.response.data.message}`)
    } else {
      alert('Terjadi kesalahan koneksi jaringan ke server.')
    }
  } finally {
    loading.value = false
  }
}
</script>


<style scoped>
/* ================= GENERAL & NAVBAR ================= */
.register-page {
  min-height: 100vh;
  background: #ffffff;
  color: #111111;
  font-family: 'Inter', Arial, sans-serif;
}

.navbar {
  height: 82px;
  padding: 0 50px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-bottom: 1px solid #dddddd;
  position: sticky;
  top: 0;
  z-index: 100;
  background: rgba(255, 255, 255, 0.96);
  backdrop-filter: blur(10px);
}

.nav-left, .nav-right {
  display: flex;
  align-items: center;
  gap: 28px;
}

.nav-link {
  color: #111111;
  text-decoration: none;
  font-size: 10px;
  letter-spacing: 1.8px;
  transition: opacity 0.3s ease;
}

.nav-link:hover { opacity: 0.5; }

.brand, .bottom-section span, .footer-brand {
  font-family: 'Playfair Display', Georgia, serif;
  color: #111111;
  text-decoration: none;
}

.brand { font-size: 23px; letter-spacing: 5px; }

/* ================= LAYOUT CONTAINER ================= */
.register-container {
  min-height: calc(100vh - 82px);
  display: grid;
  grid-template-columns: 1fr 1fr;
}

.register-intro {
  background: #111111;
  color: #ffffff;
  padding: 90px 70px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.eyebrow {
  font-size: 10px;
  letter-spacing: 3px;
  margin-bottom: 25px;
}

.register-intro .eyebrow { color: #999999; }

.register-intro h1 {
  margin: 0;
  font-family: 'Playfair Display', Georgia, serif;
  font-size: clamp(55px, 6vw, 90px);
  font-weight: 400;
  line-height: 0.92;
  letter-spacing: -2px;
}

.intro-text {
  max-width: 430px;
  margin-top: 35px;
  color: #aaaaaa;
  font-size: 13px;
  line-height: 1.9;
}

.intro-line {
  width: 70px;
  height: 1px;
  background: #555555;
  margin: 55px 0 20px 0;
}

.intro-small {
  margin: 0;
  color: #777777;
  font-size: 9px;
  letter-spacing: 2px;
}

/* ================= RIGHT FORM SECTION ================= */
.register-form-section {
  padding: 80px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.form-header { margin-bottom: 40px; }
.form-header .eyebrow { margin-bottom: 15px; }

.form-header h2 {
  margin: 0 0 15px;
  font-family: 'Playfair Display', Georgia, serif;
  font-size: 48px;
  font-weight: 400;
}

.form-header p:last-child { margin: 0; color: #888888; font-size: 12px; }
.register-form { width: 100%; max-width: 600px; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.form-group { margin-bottom: 25px; }

.form-group label {
  display: block;
  margin-bottom: 9px;
  font-size: 9px;
  letter-spacing: 1.5px;
  color: #555555;
}

.form-group input {
  width: 100%;
  box-sizing: border-box;
  border: none;
  border-bottom: 1px solid #cccccc;
  outline: none;
  background: transparent;
  padding: 13px 0;
  color: #111111;
  font: inherit;
  font-size: 13px;
  transition: border-color 0.3s ease;
}

.form-group input:focus { border-color: #111111; }
.form-group input::placeholder { color: #aaaaaa; }
.form-group small { display: block; margin-top: 7px; color: #999999; font-size: 9px; }

/* PASSWORD & INTERACTION */
.password-wrapper { position: relative; }
.password-wrapper input { padding-right: 55px; }

.show-password {
  position: absolute;
  right: 0;
  bottom: 12px;
  border: none;
  background: transparent;
  color: #777777;
  font-size: 8px;
  letter-spacing: 1px;
  cursor: pointer;
}

.show-password:hover { color: #111111; }
.error-message { color: #a00000 !important; font-weight: 500; }

/* TERMS & BUTTON */
.terms { margin: 5px 0 25px; }

.checkbox-container {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  color: #777777;
  font-size: 10px;
  line-height: 1.7;
  cursor: pointer;
}

.checkbox-container input { margin-top: 3px; accent-color: #111111; }
.checkbox-container a { color: #111111; text-decoration: underline; }

.register-button {
  width: 100%;
  border: 1px solid #111111;
  background: #111111;
  color: #ffffff;
  padding: 18px;
  font-size: 9px;
  letter-spacing: 2px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.register-button:hover { background: #ffffff; color: #111111; }
.register-button:disabled { opacity: 0.5; cursor: not-allowed; }

.login-link {
  margin-top: 25px;
  display: flex;
  justify-content: center;
  gap: 7px;
  font-size: 10px;
  color: #888888;
}

.login-link a {
  color: #111111;
  text-decoration: none;
  letter-spacing: 1px;
  border-bottom: 1px solid #111111;
  padding-bottom: 3px;
}

/* ================= BOTTOM & FOOTER ================= */
.bottom-section {
  min-height: 230px;
  padding: 60px 50px;
  border-top: 1px solid #dddddd;
  border-bottom: 1px solid #dddddd;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
}

.bottom-section span { font-size: 18px; letter-spacing: 4px; }
.bottom-section p { margin-top: 15px; color: #999999; font-size: 8px; letter-spacing: 2px; }

.footer {
  padding: 45px 50px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 30px;
  border-top: 1px solid #dddddd;
}

.footer-brand { font-size: 18px; letter-spacing: 3px; }
.footer-links { display: flex; gap: 25px; }
.footer-links a { color: #111111; text-decoration: none; font-size: 9px; letter-spacing: 1.5px; }
.footer p { margin: 0; color: #999999; font-size: 8px; letter-spacing: 1px; }

/* ================= RESPONSIVE ================= */
@media (max-width: 1000px) {
  .register-container { grid-template-columns: 1fr; }
  .register-intro, .register-form-section { padding: 80px 40px; }
  .register-intro { min-height: 500px; }
}

@media (max-width: 700px) {
  .navbar { height: auto; padding: 20px; flex-wrap: wrap; gap: 18px; }
  .brand { width: 100%; order: -1; text-align: center; font-size: 19px; }
  .nav-left, .nav-right { width: 100%; justify-content: center; gap: 15px; }
  .nav-link { font-size: 8px; }
  .register-intro { min-height: 450px; padding: 65px 25px; }
  .register-intro h1 { font-size: 58px; }
  .register-form-section { padding: 65px 25px; }
  .form-header h2 { font-size: 40px; }
  .form-row { grid-template-columns: 1fr; gap: 0; }
  .bottom-section { padding: 50px 25px; }
  .footer { padding: 35px 20px; flex-direction: column; align-items: flex-start; }
  .footer-links { flex-wrap: wrap; gap: 15px; }
}
</style>