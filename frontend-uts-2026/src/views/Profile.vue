<script setup>
import { ref } from 'vue'

const isEditing = ref(false)
const showPassword = ref(false)

const profile = ref({
  firstName: 'Naura',
  lastName: 'Zahra',
  email: 'naura@example.com',
  phone: '0812 3456 7890',
  gender: 'Female',
  birthDate: '2008-05-12',
  address: 'Jl. Example No. 123',
  city: 'Bandung',
  province: 'Jawa Barat',
  postalCode: '40123',
})

const originalProfile = ref({ ...profile.value })

const saveProfile = () => {
  isEditing.value = false
  originalProfile.value = { ...profile.value }

  alert('Profile berhasil diperbarui.')
}

const cancelEdit = () => {
  profile.value = { ...originalProfile.value }
  isEditing.value = false
}

const logout = () => {
  alert('Logout berhasil.')
}
</script>

<template>
  <div class="profile-page">

    <!-- =================================
         NAVBAR
    ================================== -->
    <header class="navbar">

      <div class="nav-left">

        <router-link to="/shop">
          SHOP
        </router-link>

        <router-link to="/about">
          OUR MISSION
        </router-link>

      </div>


      <router-link to="/home" class="logo">
        PROVIDENTIAL
      </router-link>


      <div class="nav-right">

        <router-link to="/search">
          SEARCH
        </router-link>

        <router-link to="/cart">
          CART
        </router-link>

        <router-link to="/user" class="active">
          ACCOUNT
        </router-link>

      </div>

    </header>


    <!-- =================================
         PAGE INTRO
    ================================== -->
    <section class="profile-intro">

      <div class="intro-number">
        01 — ACCOUNT
      </div>

      <h1>
        My <em>Profile</em>
      </h1>

      <p>
        Manage your personal information and account details.
      </p>

    </section>


    <!-- =================================
         PROFILE CONTENT
    ================================== -->
    <main class="profile-container">

      <!-- =================================
           LEFT PROFILE CARD
      ================================== -->
      <aside class="profile-sidebar">

        <div class="avatar">
          {{ profile.firstName.charAt(0) }}
        </div>

        <h2>
          {{ profile.firstName }}
          {{ profile.lastName }}
        </h2>

        <p>
          {{ profile.email }}
        </p>

        <div class="member-line"></div>

        <span class="member-label">
          PROVIDENTIAL MEMBER
        </span>

        <span class="member-year">
          SINCE 2026
        </span>


        <!-- ACCOUNT NAVIGATION -->
        <nav class="account-menu">

          <router-link to="/user">
            ACCOUNT OVERVIEW
          </router-link>

          <router-link
            to="/profile"
            class="menu-active"
          >
            PROFILE
          </router-link>

          <router-link to="/orders">
            MY ORDERS
          </router-link>

          <router-link to="/user">
            SETTINGS
          </router-link>

          <button @click="logout">
            LOG OUT
          </button>

        </nav>

      </aside>


      <!-- =================================
           PROFILE FORM
      ================================== -->
      <section class="profile-content">

        <div class="content-header">

          <div>
            <span>PERSONAL INFORMATION</span>

            <h2>
              Account Details
            </h2>
          </div>


          <div
            v-if="!isEditing"
            class="edit-wrapper"
          >

            <button
              class="edit-button"
              @click="isEditing = true"
            >
              EDIT PROFILE
            </button>

          </div>


          <div
            v-else
            class="edit-actions"
          >

            <button
              class="cancel-button"
              @click="cancelEdit"
            >
              CANCEL
            </button>

            <button
              class="save-button"
              @click="saveProfile"
            >
              SAVE CHANGES
            </button>

          </div>

        </div>


        <!-- =================================
             NAME
        ================================== -->
        <div class="form-section">

          <div class="section-title">
            <span>01</span>
            <h3>Identity</h3>
          </div>


          <div class="form-grid">

            <div class="form-group">

              <label>
                FIRST NAME
              </label>

              <input
                v-model="profile.firstName"
                type="text"
                :disabled="!isEditing"
              />

            </div>


            <div class="form-group">

              <label>
                LAST NAME
              </label>

              <input
                v-model="profile.lastName"
                type="text"
                :disabled="!isEditing"
              />

            </div>


            <div class="form-group">

              <label>
                GENDER
              </label>

              <select
                v-model="profile.gender"
                :disabled="!isEditing"
              >

                <option value="Female">
                  Female
                </option>

                <option value="Male">
                  Male
                </option>

              </select>

            </div>


            <div class="form-group">

              <label>
                DATE OF BIRTH
              </label>

              <input
                v-model="profile.birthDate"
                type="date"
                :disabled="!isEditing"
              />

            </div>

          </div>

        </div>


        <!-- =================================
             CONTACT
        ================================== -->
        <div class="form-section">

          <div class="section-title">

            <span>02</span>

            <h3>
              Contact
            </h3>

          </div>


          <div class="form-grid">

            <div class="form-group full">

              <label>
                EMAIL ADDRESS
              </label>

              <input
                v-model="profile.email"
                type="email"
                :disabled="!isEditing"
              />

            </div>


            <div class="form-group full">

              <label>
                PHONE NUMBER
              </label>

              <input
                v-model="profile.phone"
                type="text"
                :disabled="!isEditing"
              />

            </div>

          </div>

        </div>


        <!-- =================================
             ADDRESS
        ================================== -->
        <div class="form-section">

          <div class="section-title">

            <span>03</span>

            <h3>
              Shipping Address
            </h3>

          </div>


          <div class="form-grid">

            <div class="form-group full">

              <label>
                STREET ADDRESS
              </label>

              <input
                v-model="profile.address"
                type="text"
                :disabled="!isEditing"
              />

            </div>


            <div class="form-group">

              <label>
                CITY
              </label>

              <input
                v-model="profile.city"
                type="text"
                :disabled="!isEditing"
              />

            </div>


            <div class="form-group">

              <label>
                PROVINCE
              </label>

              <input
                v-model="profile.province"
                type="text"
                :disabled="!isEditing"
              />

            </div>


            <div class="form-group">

              <label>
                POSTAL CODE
              </label>

              <input
                v-model="profile.postalCode"
                type="text"
                :disabled="!isEditing"
              />

            </div>

          </div>

        </div>


        <!-- =================================
             SECURITY
        ================================== -->
        <div class="form-section security-section">

          <div class="section-title">

            <span>04</span>

            <h3>
              Security
            </h3>

          </div>


          <div class="password-row">

            <div>

              <label>
                PASSWORD
              </label>

              <p>
                Keep your account secure with a strong password.
              </p>

            </div>


            <button
              class="password-button"
              @click="showPassword = !showPassword"
            >
              {{ showPassword ? 'HIDE' : 'CHANGE PASSWORD' }}
            </button>

          </div>


          <div
            v-if="showPassword"
            class="password-box"
          >

            <div class="form-group">

              <label>
                CURRENT PASSWORD
              </label>

              <input
                type="password"
                placeholder="Enter current password"
              />

            </div>


            <div class="form-group">

              <label>
                NEW PASSWORD
              </label>

              <input
                type="password"
                placeholder="Enter new password"
              />

            </div>


            <div class="form-group">

              <label>
                CONFIRM PASSWORD
              </label>

              <input
                type="password"
                placeholder="Confirm new password"
              />

            </div>

          </div>

        </div>

      </section>

    </main>


    <!-- =================================
         FOOTER
    ================================== -->
    <footer class="footer">

      <div class="footer-brand">
        PROVIDENTIAL
      </div>

      <div class="footer-center">
        SIMPLE.
        CONSCIOUS.
        TIMELESS.
      </div>

      <div class="footer-copy">
        © 2026 PROVIDENTIAL
      </div>

    </footer>

  </div>
</template>


<style scoped>

/* =================================
   GENERAL
================================= */

.profile-page {
  min-height: 100vh;

  background: #fff;
  color: #111;

  font-family:
    'Inter',
    Arial,
    sans-serif;
}


/* =================================
   NAVBAR
================================= */

.navbar {
  height: 78px;

  padding: 0 5%;

  display: grid;
  grid-template-columns: 1fr auto 1fr;

  align-items: center;

  border-bottom: 1px solid #e5e5e5;

  position: sticky;
  top: 0;

  z-index: 100;

  background: rgba(255,255,255,0.97);

  backdrop-filter: blur(10px);
}

.nav-left,
.nav-right {
  display: flex;

  align-items: center;

  gap: 30px;
}

.nav-right {
  justify-content: flex-end;
}

.navbar a {
  color: #111;

  text-decoration: none;

  font-size: 10px;

  letter-spacing: 1.7px;

  transition: opacity 0.3s ease;
}

.navbar a:hover {
  opacity: 0.5;
}

.logo {
  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 21px !important;

  letter-spacing: 3px !important;

  font-weight: 600;
}

.navbar .active {
  border-bottom: 1px solid #111;

  padding-bottom: 6px;
}


/* =================================
   INTRO
================================= */

.profile-intro {
  padding: 100px 8% 80px;

  border-bottom: 1px solid #111;
}

.intro-number {
  margin-bottom: 25px;

  font-size: 9px;

  letter-spacing: 2.5px;

  font-weight: 600;
}

.profile-intro h1 {
  margin: 0;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: clamp(60px, 9vw, 120px);

  line-height: 0.9;

  font-weight: 400;

  letter-spacing: -4px;
}

.profile-intro h1 em {
  font-style: italic;
}

.profile-intro p {
  max-width: 420px;

  margin: 35px 0 0;

  color: #777;

  font-size: 13px;

  line-height: 1.7;
}


/* =================================
   MAIN CONTAINER
================================= */

.profile-container {
  max-width: 1400px;

  margin: 0 auto;

  padding: 80px 8%;

  display: grid;

  grid-template-columns: 260px 1fr;

  gap: 90px;
}


/* =================================
   SIDEBAR
================================= */

.profile-sidebar {
  position: sticky;

  top: 120px;

  align-self: start;
}

.avatar {
  width: 90px;
  height: 90px;

  display: flex;

  align-items: center;
  justify-content: center;

  background: #111;

  color: #fff;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 36px;
}

.profile-sidebar h2 {
  margin: 25px 0 6px;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 25px;

  font-weight: 400;
}

.profile-sidebar > p {
  margin: 0;

  color: #888;

  font-size: 11px;
}

.member-line {
  width: 100%;

  height: 1px;

  background: #ddd;

  margin: 30px 0 20px;
}

.member-label {
  display: block;

  font-size: 8px;

  letter-spacing: 2px;

  font-weight: 600;
}

.member-year {
  display: block;

  margin-top: 7px;

  font-size: 8px;

  letter-spacing: 1.5px;

  color: #999;
}


/* =================================
   ACCOUNT MENU
================================= */

.account-menu {
  margin-top: 45px;

  display: flex;

  flex-direction: column;
}

.account-menu a,
.account-menu button {
  padding: 14px 0;

  border: none;

  border-bottom: 1px solid #eee;

  background: transparent;

  color: #888;

  text-decoration: none;

  text-align: left;

  font-family: inherit;

  font-size: 9px;

  letter-spacing: 1.5px;

  cursor: pointer;

  transition:
    color 0.3s ease,
    padding-left 0.3s ease;
}

.account-menu a:hover,
.account-menu button:hover {
  color: #111;

  padding-left: 6px;
}

.account-menu .menu-active {
  color: #111;

  font-weight: 600;

  padding-left: 6px;
}


/* =================================
   CONTENT
================================= */

.profile-content {
  min-width: 0;
}

.content-header {
  display: flex;

  align-items: flex-end;

  justify-content: space-between;

  gap: 30px;

  padding-bottom: 25px;

  border-bottom: 1px solid #111;

  margin-bottom: 45px;
}

.content-header span {
  display: block;

  margin-bottom: 10px;

  font-size: 9px;

  letter-spacing: 2px;

  color: #888;
}

.content-header h2 {
  margin: 0;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 38px;

  font-weight: 400;
}


/* =================================
   EDIT BUTTONS
================================= */

.edit-button,
.save-button,
.cancel-button,
.password-button {
  padding: 12px 18px;

  border: 1px solid #111;

  background: #111;

  color: #fff;

  font-size: 8px;

  letter-spacing: 1.5px;

  cursor: pointer;

  transition: all 0.3s ease;
}

.edit-button:hover,
.save-button:hover,
.password-button:hover {
  background: #fff;

  color: #111;
}

.edit-actions {
  display: flex;

  gap: 8px;
}

.cancel-button {
  background: #fff;

  color: #111;
}

.cancel-button:hover {
  background: #111;

  color: #fff;
}


/* =================================
   FORM SECTION
================================= */

.form-section {
  padding-bottom: 55px;

  margin-bottom: 55px;

  border-bottom: 1px solid #ddd;
}

.section-title {
  display: flex;

  align-items: center;

  gap: 18px;

  margin-bottom: 35px;
}

.section-title span {
  font-size: 9px;

  letter-spacing: 1.5px;

  color: #999;
}

.section-title h3 {
  margin: 0;

  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 25px;

  font-weight: 400;
}


/* =================================
   FORM GRID
================================= */

.form-grid {
  display: grid;

  grid-template-columns: repeat(2, 1fr);

  gap: 30px 25px;
}

.form-group {
  display: flex;

  flex-direction: column;

  gap: 10px;
}

.form-group.full {
  grid-column: 1 / -1;
}

.form-group label,
.password-row label {
  font-size: 8px;

  letter-spacing: 1.8px;

  color: #777;

  font-weight: 600;
}

.form-group input,
.form-group select {
  width: 100%;

  box-sizing: border-box;

  padding: 14px 0;

  border: none;

  border-bottom: 1px solid #ccc;

  outline: none;

  background: transparent;

  color: #111;

  font-family: inherit;

  font-size: 13px;

  transition: border-color 0.3s ease;
}

.form-group input:focus,
.form-group select:focus {
  border-bottom-color: #111;
}

.form-group input:disabled,
.form-group select:disabled {
  color: #444;

  opacity: 1;

  cursor: default;
}


/* =================================
   SECURITY
================================= */

.security-section {
  margin-bottom: 0;

  border-bottom: none;
}

.password-row {
  display: flex;

  align-items: center;

  justify-content: space-between;

  gap: 30px;

  padding: 25px 0;

  border-top: 1px solid #ddd;

  border-bottom: 1px solid #ddd;
}

.password-row label {
  display: block;

  margin-bottom: 8px;

  color: #111;
}

.password-row p {
  margin: 0;

  color: #888;

  font-size: 11px;
}

.password-button {
  background: #fff;

  color: #111;

  white-space: nowrap;
}

.password-button:hover {
  background: #111;

  color: #fff;
}

.password-box {
  display: grid;

  grid-template-columns: repeat(3, 1fr);

  gap: 25px;

  padding: 30px 0;
}


/* =================================
   FOOTER
================================= */

.footer {
  min-height: 180px;

  padding: 50px 8% 35px;

  border-top: 1px solid #111;

  display: grid;

  grid-template-columns: 1fr 1fr 1fr;

  align-items: end;
}

.footer-brand {
  font-family:
    'Playfair Display',
    Georgia,
    serif;

  font-size: 22px;

  letter-spacing: 3px;
}

.footer-center {
  text-align: center;

  font-size: 8px;

  letter-spacing: 2px;

  color: #777;
}

.footer-copy {
  text-align: right;

  font-size: 8px;

  letter-spacing: 1px;

  color: #999;
}


/* =================================
   TABLET
================================= */

@media (max-width: 900px) {

  .navbar {
    grid-template-columns: 1fr auto;
  }

  .nav-left {
    display: none;
  }

  .logo {
    justify-self: start;
  }

  .profile-container {
    grid-template-columns: 1fr;

    gap: 50px;
  }

  .profile-sidebar {
    position: static;

    display: grid;

    grid-template-columns: auto 1fr;

    column-gap: 20px;
  }

  .profile-sidebar h2 {
    margin-top: 5px;
  }

  .profile-sidebar > p {
    grid-column: 2;
  }

  .member-line,
  .member-label,
  .member-year {
    display: none;
  }

  .account-menu {
    grid-column: 1 / -1;

    margin-top: 30px;

    display: grid;

    grid-template-columns: repeat(4, 1fr);
  }

  .account-menu button {
    display: none;
  }

  .account-menu a {
    text-align: center;

    padding: 14px 5px;
  }

  .account-menu a:hover,
  .account-menu .menu-active {
    padding-left: 5px;
  }

}


/* =================================
   MOBILE
================================= */

@media (max-width: 600px) {

  .navbar {
    height: 65px;

    padding: 0 20px;
  }

  .logo {
    font-size: 16px !important;

    letter-spacing: 2px !important;
  }

  .nav-right {
    gap: 12px;
  }

  .nav-right a:first-child {
    display: none;
  }

  .navbar a {
    font-size: 8px;
  }

  .profile-intro {
    padding: 70px 25px 55px;
  }

  .profile-intro h1 {
    font-size: 65px;

    letter-spacing: -3px;
  }

  .profile-container {
    padding: 50px 25px;
  }

  .profile-sidebar {
    grid-template-columns: 70px 1fr;
  }

  .avatar {
    width: 70px;
    height: 70px;

    font-size: 28px;
  }

  .profile-sidebar h2 {
    font-size: 21px;
  }

  .account-menu {
    grid-template-columns: repeat(2, 1fr);

    margin-top: 25px;
  }

  .content-header {
    align-items: flex-start;

    flex-direction: column;
  }

  .content-header h2 {
    font-size: 30px;
  }

  .edit-wrapper,
  .edit-actions {
    width: 100%;
  }

  .edit-button,
  .save-button,
  .cancel-button {
    width: 100%;
  }

  .edit-actions {
    display: grid;

    grid-template-columns: 1fr 1fr;
  }

  .form-grid {
    grid-template-columns: 1fr;
  }

  .form-group.full {
    grid-column: auto;
  }

  .password-row {
    align-items: flex-start;

    flex-direction: column;
  }

  .password-button {
    width: 100%;
  }

  .password-box {
    grid-template-columns: 1fr;
  }

  .footer {
    display: flex;

    flex-direction: column;

    align-items: flex-start;

    gap: 25px;
  }

  .footer-center {
    text-align: left;
  }

  .footer-copy {
    text-align: left;
  }

}

</style>